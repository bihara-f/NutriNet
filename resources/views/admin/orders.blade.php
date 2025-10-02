@extends('layouts.admin')

@section('title', 'Manage Orders')

@section('content')
<div class="middle">
    <div class="box">
        <span class="box-title">Total Orders: </span>
        <span class="box-count">{{ $orders->total() }}</span>
    </div>
    <div class="box">
        <span class="box-title">This Month: </span>
        <span class="box-count">{{ $orders->where('created_at', '>=', now()->startOfMonth())->count() }}</span>
    </div>
    <div class="box">
        <span class="box-title">Total Revenue: </span>
        <span class="box-count">LKR {{ number_format($totalRevenue, 2) }}</span>
    </div>
</div>

<div class="bottom">
    <table class="admin_table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Amount</th>
                <th>Payment Method</th>
                <th>Order Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td id="id">{{ $order->id }}</td>
                <td>{{ $order->full_name ?? ($order->user ? $order->user->name : 'N/A') }}</td>
                <td>{{ $order->email ?? ($order->user ? $order->user->email : 'N/A') }}</td>
                <td>LKR {{ $order->package ? number_format($order->package->package_price, 2) : '0.00' }}</td>
                <td>{{ ucfirst($order->payment_method ?? 'Card') }}</td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <div class="action_btn">
                        <a href="#" onclick="viewOrder({{ $order->id }})" title="View Details">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="#" onclick="confirmDelete({{ $order->id }})" id="delete" title="Delete Order">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">No orders found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div style="margin-top: 20px; text-align: center;">
        {{ $orders->links() }}
    </div>
</div>

<!-- Order Details Modal -->
<div id="orderModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Order Details</h2>
        <div id="orderDetails"></div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function viewOrder(orderId) {
    document.getElementById('orderDetails').innerHTML = '<p>Loading order details...</p>';
    document.getElementById('orderModal').style.display = 'block';
    
    // Simulate AJAX call to fetch order details
    setTimeout(() => {
        document.getElementById('orderDetails').innerHTML = `
            <div class="form-group">
                <label><strong>Order ID:</strong></label>
                <input type="text" value="${orderId}" readonly>
            </div>
            <div class="form-group">
                <label><strong>Status:</strong></label>
                <input type="text" value="Completed" readonly>
            </div>
            <div class="form-group">
                <label><strong>Payment Status:</strong></label>
                <input type="text" value="Paid" readonly>
            </div>
            <div class="form-group">
                <label><strong>Items:</strong></label>
                <textarea rows="3" readonly>Package details will be loaded here...</textarea>
            </div>
        `;
    }, 500);
}

function confirmDelete(orderId) {
    if (confirm('Are you sure you want to delete this order? This action cannot be undone.')) {
        alert('Delete functionality will be implemented with proper backend integration.');
    }
}

function closeModal() {
    document.getElementById('orderModal').style.display = 'none';
}

// Close modal when clicking outside of it
window.onclick = function(event) {
    const modal = document.getElementById('orderModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>
@endpush