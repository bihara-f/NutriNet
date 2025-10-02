@extends('layouts.admin')

@section('title', 'Manage Packages')

@section('content')
<div class="middle">
    <div class="box">
        <span class="box-title">Total Packages: </span>
        <span class="box-count">{{ $packages->total() }}</span>
    </div>
    <div class="box">
        <span class="box-title">Active Packages: </span>
        <span class="box-count">{{ $packages->count() }}</span>
    </div>
    <div class="box">
        <a href="{{ route('admin.packages.create') }}" class="btn btn-primary" style="text-decoration: none; color: white;">
            Add New Package
        </a>
    </div>
</div>

<div class="bottom">
    <table class="admin_table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Package Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Created Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($packages as $package)
            <tr>
                <td id="id">{{ $package->id }}</td>
                <td>{{ $package->package_name }}</td>
                <td>LKR {{ number_format($package->package_price, 2) }}</td>
                <td>{{ $package->package_description ? Str::limit($package->package_description, 30) : 'N/A' }}</td>
                <td>{{ $package->created_at->format('d/m/Y') }}</td>
                <td>
                    <div class="action_btn">
                        <a href="{{ route('admin.packages.edit', $package) }}" id="edit" title="Edit Package">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="#" onclick="confirmDelete({{ $package->id }})" id="delete" title="Delete Package">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">No packages found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div style="margin-top: 20px; text-align: center;">
        {{ $packages->links() }}
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeDeleteModal()">&times;</span>
        <h2>Confirm Delete</h2>
        <p>Are you sure you want to delete this package? This action cannot be undone.</p>
        <div class="form-btn">
            <form id="deleteForm" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteModal()" class="btn" style="background-color: var(--gray);">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function confirmDelete(packageId) {
    document.getElementById('deleteForm').action = `/admin/packages/${packageId}`;
    document.getElementById('deleteModal').style.display = 'block';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

// Close modal when clicking outside of it
window.onclick = function(event) {
    const modal = document.getElementById('deleteModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>
@endpush