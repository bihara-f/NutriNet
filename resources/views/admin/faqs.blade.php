@extends('layouts.admin')

@section('title', 'Manage FAQs')

@section('content')
<div class="middle">
    <div class="box">
        <span class="box-title">Total FAQs: </span>
        <span class="box-count">{{ $faqs->total() }}</span>
    </div>
    <div class="box">
        <span class="box-title">Published: </span>
        <span class="box-count">{{ $faqs->count() }}</span>
    </div>
    <div class="box">
        <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary" style="text-decoration: none; color: white;">
            Add New FAQ
        </a>
    </div>
</div>

<div class="bottom">
    <table class="admin_table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Question</th>
                <th>Answer</th>
                <th>Created Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($faqs as $faq)
            <tr>
                <td id="id">{{ $faq->id }}</td>
                <td>{{ Str::limit($faq->question, 50) }}</td>
                <td>{{ Str::limit($faq->answer, 80) }}</td>
                <td>{{ $faq->created_at->format('d/m/Y') }}</td>
                <td>
                    <div class="action_btn">
                        <a href="#" onclick="viewFaq({{ $faq->id }}, '{{ addslashes($faq->question) }}', '{{ addslashes($faq->answer) }}')" title="View FAQ">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.faqs.edit', $faq) }}" id="edit" title="Edit FAQ">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="#" onclick="confirmDelete({{ $faq->id }})" id="delete" title="Delete FAQ">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">No FAQs found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div style="margin-top: 20px; text-align: center;">
        {{ $faqs->links() }}
    </div>
</div>

<!-- View FAQ Modal -->
<div id="faqModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeFaqModal()">&times;</span>
        <h2>FAQ Details</h2>
        <div class="form-group">
            <label><strong>Question:</strong></label>
            <textarea id="modalQuestion" rows="3" readonly></textarea>
        </div>
        <div class="form-group">
            <label><strong>Answer:</strong></label>
            <textarea id="modalAnswer" rows="5" readonly></textarea>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeDeleteModal()">&times;</span>
        <h2>Confirm Delete</h2>
        <p>Are you sure you want to delete this FAQ? This action cannot be undone.</p>
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
function viewFaq(id, question, answer) {
    document.getElementById('modalQuestion').value = question;
    document.getElementById('modalAnswer').value = answer;
    document.getElementById('faqModal').style.display = 'block';
}

function confirmDelete(faqId) {
    document.getElementById('deleteForm').action = `/admin/faqs/${faqId}`;
    document.getElementById('deleteModal').style.display = 'block';
}

function closeFaqModal() {
    document.getElementById('faqModal').style.display = 'none';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

// Close modal when clicking outside of it
window.onclick = function(event) {
    const faqModal = document.getElementById('faqModal');
    const deleteModal = document.getElementById('deleteModal');
    if (event.target == faqModal) {
        faqModal.style.display = 'none';
    }
    if (event.target == deleteModal) {
        deleteModal.style.display = 'none';
    }
}
</script>
@endpush