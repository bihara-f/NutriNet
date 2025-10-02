@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="middle">
    <div class="box">
        <span class="box-title">Total Users: </span>
        <span class="box-count">{{ $stats['total_users'] }}</span>
    </div>
    <div class="box">
        <span class="box-title">Total Packages: </span>
        <span class="box-count">{{ $stats['total_packages'] }}</span>
    </div>
    <div class="box">
        <span class="box-title">Total Revenue: </span>
        <span class="box-count">LKR {{ number_format($stats['total_revenue'], 2) }}</span>
    </div>
</div>

<div class="bottom">
    <div style="display: flex; justify-content: space-between; flex-wrap: wrap;">
        <div style="width: calc(50% - 25px); margin-bottom: 20px;">
            <table class="admin_table">
                <caption style="font-size: 18px; font-weight: bold; padding: 10px 0; text-transform: uppercase;">Recent Orders</caption>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stats['recent_orders'] as $order)
                    <tr>
                        <td id="id">{{ $order->id }}</td>
                        <td>{{ $order->full_name ?? ($order->user ? $order->user->name : 'N/A') }}</td>
                        <td>LKR {{ $order->package ? number_format($order->package->package_price, 2) : '0.00' }}</td>
                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                        <td id="status">{{ ucfirst($order->status ?? 'completed') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center;">No orders found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <a href="{{ route('admin.orders') }}" class="btn btn-primary" style="margin-top: 15px; display: block; text-align: center;">View All Orders</a>
        </div>

        <div style="width: calc(50% - 25px); margin-bottom: 20px;">
            <table class="admin_table">
                <caption style="font-size: 18px; font-weight: bold; padding: 10px 0; text-transform: uppercase;">Recent Users</caption>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stats['recent_users'] as $user)
                    <tr>
                        <td id="id">{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">No users found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <a href="{{ route('admin.users') }}" class="btn btn-primary" style="margin-top: 15px; display: block; text-align: center;">View All Users</a>
        </div>
    </div>
</div>
@endsection