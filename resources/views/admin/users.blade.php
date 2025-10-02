@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
<div class="middle">
    <div class="box">
        <span class="box-title">Total Users: </span>
        <span class="box-count">{{ $users->total() }}</span>
    </div>
    <div class="box">
        <span class="box-title">This Month: </span>
        <span class="box-count">{{ $users->where('created_at', '>=', now()->startOfMonth())->count() }}</span>
    </div>
    <div class="box">
        <span class="box-title">Active Users: </span>
        <span class="box-count">{{ $users->whereNotNull('email_verified_at')->count() }}</span>
    </div>
</div>

<div class="bottom">
    <table class="admin_table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Email Verified</th>
                <th>Joined Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td id="id">{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td id="status">
                    @if($user->email_verified_at)
                        <span style="color: var(--green);">✓ Verified</span>
                    @else
                        <span style="color: var(--red);">✗ Not Verified</span>
                    @endif
                </td>
                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <div class="action_btn">
                        @if($user->id !== Auth::id())
                            <a href="#" onclick="viewUser({{ $user->id }})" title="View Details">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="#" onclick="confirmDelete({{ $user->id }})" id="delete" title="Delete User">
                                <i class="fa fa-trash"></i>
                            </a>
                        @else
                            <span style="color: var(--gray);">Current User</span>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">No users found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div style="margin-top: 20px; text-align: center;">
        {{ $users->links() }}
    </div>
</div>

<!-- User Details Modal -->
<div id="userModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>User Details</h2>
        <div id="userDetails"></div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function viewUser(userId) {
    // In a real application, you'd fetch user details via AJAX
    document.getElementById('userDetails').innerHTML = '<p>Loading user details...</p>';
    document.getElementById('userModal').style.display = 'block';
    
    // Simulate AJAX call
    setTimeout(() => {
        document.getElementById('userDetails').innerHTML = `
            <p><strong>User ID:</strong> ${userId}</p>
            <p><strong>Status:</strong> Active</p>
            <p><strong>Last Login:</strong> Recently</p>
            <p><strong>Total Orders:</strong> Loading...</p>
        `;
    }, 500);
}

function confirmDelete(userId) {
    if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
        // Show loading
        const deleteBtn = document.querySelector(`a[onclick="confirmDelete(${userId})"]`);
        const originalText = deleteBtn.innerHTML;
        deleteBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
        
        // Send DELETE request
        fetch(`/admin/users/${userId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the row from table
                const row = deleteBtn.closest('tr');
                row.style.opacity = '0.5';
                setTimeout(() => {
                    row.remove();
                    alert(data.message);
                }, 300);
            } else {
                alert('Error: ' + data.message);
                deleteBtn.innerHTML = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the user.');
            deleteBtn.innerHTML = originalText;
        });
    }
}

function closeModal() {
    document.getElementById('userModal').style.display = 'none';
}

// Close modal when clicking outside of it
window.onclick = function(event) {
    const modal = document.getElementById('userModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>
@endpush