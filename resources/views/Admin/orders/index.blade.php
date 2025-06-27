@extends('layouts.main')

@section('title', 'Order Management - Atlantis Lite')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <style>
        .table th, .table td {
            vertical-align: middle;
            padding: 12px;
        }
        .modal-content {
            border-radius: 10px;
        }
        .btn-primary {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        .btn-primary:hover {
            background-color: #2563eb;
            border-color: #2563eb;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .search-container {
            margin-bottom: 20px;
        }
        .dataTables_wrapper .dataTables_filter {
            float: right;
            margin-bottom: 15px;
        }
        .dataTables_wrapper .dataTables_length {
            float: left;
            margin-bottom: 15px;
        }
        .table-responsive {
            overflow-x: auto;
        }
        /* Custom status badges to match existing style */
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
    </style>
@endpush

@section('content')
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Order Management</h2>
                <h5 class="text-white op-7 mb-2">Manage orders placed by your customers!</h5>
            </div>
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <div class="card full-height">
                <div class="card-body">
                    <div class="card-title">All Orders</div>
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table id="orderTable" class="table table-hover table-striped">
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
                                @forelse($orders as $index => $order)
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
    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info mx-1">
        <i class="fa fa-eye"></i>
    </a>
    <button type="button" class="btn btn-sm btn-warning mx-1" data-toggle="modal" data-target="#updateStatusModal{{ $order->id }}">
        <i class="fa fa-edit"></i>
    </button>
    <button type="button" class="btn btn-sm btn-danger mx-1" data-toggle="modal" data-target="#deleteOrderModal{{ $order->id }}">
        <i class="fa fa-trash"></i>
    </button>
</div>


                                            <!-- Update Status Modal -->
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
                    <!-- Remove @method('PATCH') since the route uses POST -->
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
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#orderTable').DataTable({
                "pageLength": 10,
                "lengthMenu": [5, 10, 25, 50],
                "order": [[3, "desc"]], // Sort by Order Date descending by default
                "language": {
                    "search": "Search orders:",
                    "lengthMenu": "Show _MENU_ entries",
                    "info": "Showing _START_ to _END_ of _TOTAL_ orders",
                    "infoEmpty": "Showing 0 to 0 of 0 orders",
                    "infoFiltered": "(filtered from _MAX_ total orders)"
                },
                "columnDefs": [
                    { "orderable": false, "targets": 6 } // Disable sorting on Actions column
                ]
            });

            // Handle modal close
            $('.modal .close, .modal [data-dismiss="modal"]').on('click', function() {
                $(this).closest('.modal').modal('hide');
            });

            // Ensure modals are initialized correctly
            $('.modal').on('shown.bs.modal', function () {
                $(this).find('[autofocus]').focus();
            });
        });
    </script>
@endpush