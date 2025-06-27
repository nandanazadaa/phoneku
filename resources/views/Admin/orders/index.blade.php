@extends('layouts.main')

@section('title', 'Order Management')

@push('styles')
<style>
    /* Inherit and extend styles from the provided product management CSS */
    .form-group label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
    }
    .form-control.is-invalid {
        border-color: #dc3545;
    }
    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #dc3545;
    }
    /* Search and Filter Form Styling */
    .search-filter-group {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
    }
    .search-filter-group .input-group,
    .search-filter-group .form-group {
        flex: 1;
        min-width: 200px; /* Ensure inputs don't get too small */
    }
    /* Status Badge Styling */
    .status-badge {
        padding: 5px 10px;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    .status-dibuat {
        background-color: #ffc107;
        color: #212529;
    }
    .status-dikirimkan {
        background-color: #17a2b8;
        color: #fff;
    }
    .status-telah-sampai {
        background-color: #28a745;
        color: #fff;
    }
    /* Table Styling */
    .table-responsive table {
        width: 100%;
    }
    .table-responsive th,
    .table-responsive td {
        vertical-align: middle;
    }
    .table-responsive .btn-group .btn {
        margin-right: 5px;
    }
    /* Modal Styling */
    .modal-content {
        border-radius: 10px;
    }
    .modal-header {
        border-bottom: 1px solid #dee2e6;
    }
    .modal-footer {
        border-top: 1px solid #dee2e6;
    }
</style>
@endpush

@section('content')
<div class="panel-header bg-light-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="pb-2 fw-bold">Order Management</h2>
                <h5 class="op-7 mb-2">Manage orders placed by your customers!</h5>
            </div>
        </div>
    </div>
</div>

<div class="page-inner mt--5">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title">All Orders</h4>
                <form class="ml-auto search-filter-group" action="{{ route('admin.orders.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control form-control-sm" placeholder="Search by order code or customer name..." value="{{ request('q') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary btn-sm" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="">All Statuses</option>
                            <option value="dibuat" {{ request('status') == 'dibuat' ? 'selected' : '' }}>Pesanan Dibuat</option>
                            <option value="dikirimkan" {{ request('status') == 'dikirimkan' ? 'selected' : '' }}>Dikirimkan</option>
                            <option value="telah sampai" {{ request('status') == 'telah sampai' ? 'selected' : '' }}>Telah Sampai</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Order Code</th>
                            <th>Customer Name</th>
                            <th>Order Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders ?? [] as $index => $order)
                            <tr>
                                <td>{{ $orders->firstItem() + $index }}</td>
                                <td>{{ $order->order_code }}</td>
                                <td>{{ $order->user ? $order->user->name : 'N/A' }}</td>
                                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td>
                                    <span class="status-badge status-{{ str_replace(' ', '-', $order->order_status) }}">
                                        {{ str_replace('telah sampai', 'Telah Sampai', ucfirst($order->order_status)) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#updateStatusModal{{ $order->id }}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteOrderModal{{ $order->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Update Status Modal -->
                                    <div class="modal fade" id="updateStatusModal{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="updateStatusModalLabel{{ $order->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="updateStatusModalLabel{{ $order->id }}">Update Status for Order #{{ $order->order_code }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="form-group">
                                                            <label for="order_status_{{ $order->id }}">Order Status</label>
                                                            <select class="form-control @error('order_status') is-invalid @enderror" id="order_status_{{ $order->id }}" name="order_status" required>
                                                                <option value="dibuat" {{ $order->order_status == 'dibuat' ? 'selected' : '' }}>Pesanan Dibuat</option>
                                                                <option value="dikirimkan" {{ $order->order_status == 'dikirimkan' ? 'selected' : '' }}>Dikirimkan</option>
                                                                <option value="telah sampai" {{ $order->order_status == 'telah sampai' ? 'selected' : '' }}>Telah Sampai</option>
                                                            </select>
                                                            @error('order_status')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">Update Status</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Order Modal -->
                                    <div class="modal fade" id="deleteOrderModal{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteOrderModalLabel{{ $order->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteOrderModalLabel{{ $order->id }}">Confirm Delete</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete order <strong>#{{ $order->order_code }}</strong> for <strong>{{ $order->user ? $order->user->name : 'N/A' }}</strong>?</p>
                                                    <p class="text-danger">This action cannot be undone.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $orders->appends(['q' => request('q'), 'status' => request('status')])->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Ensure modals are initialized correctly
    $('.modal').on('shown.bs.modal', function () {
        $(this).find('[autofocus]').focus();
    });
});
</script>
@endpush