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
        /* Custom styling for length menu */
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 6px 12px;
            background-color: white;
            font-size: 14px;
            min-width: 60px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 8px center;
            background-size: 16px;
            padding-right: 30px;
        }
        .dataTables_wrapper .dataTables_length select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }
        .dataTables_wrapper .dataTables_length label {
            font-size: 14px;
            color: #374151;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        /* Ensure proper spacing and alignment */
        .dataTables_wrapper .dataTables_length {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        /* Custom dropdown arrow styling */
        .dataTables_wrapper .dataTables_length select::-ms-expand {
            display: none;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .status-dibuat {
            background-color: #e3f2fd;
            color: #1976d2;
        }
        .status-diproses {
            background-color: #fff3e0;
            color: #f57c00;
        }
        .status-dikirimkan {
            background-color: #e8f5e8;
            color: #388e3c;
        }
        .status-dalam-pengiriman {
            background-color: #f3e5f5;
            color: #7b1fa2;
        }
        .status-telah-sampai {
            background-color: #e0f2f1;
            color: #00796b;
        }
        .status-selesai {
            background-color: #e8f5e8;
            color: #2e7d32;
        }
        .status-dibatalkan {
            background-color: #ffebee;
            color: #c62828;
        }
        .status-pending {
            background-color: #fff3e0;
            color: #f57c00;
        }
        .status-completed {
            background-color: #e8f5e8;
            color: #2e7d32;
        }
        .status-failed {
            background-color: #ffebee;
            color: #c62828;
        }
        .status-refunded {
            background-color: #f3e5f5;
            color: #7b1fa2;
        }
        .btn-group .btn {
            border-radius: 4px;
        }
        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }
        .form-group label {
            font-weight: 600;
            color: #495057;
        }
        .table th {
            background-color: #f8f9fa;
            border-top: none;
            font-weight: 600;
            color: #495057;
        }
        .card-title {
            font-weight: 600;
            color: #495057;
            margin-bottom: 1.5rem;
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

                    <!-- Filter Section -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <form method="GET" action="{{ route('admin.orders.index') }}" class="form-inline">
                                <div class="form-group mr-3">
                                    <input type="text" name="q" class="form-control" placeholder="Search by order code or customer name..." value="{{ request('q') }}">
                                </div>
                                <div class="form-group mr-3">
                                    <select name="status" class="form-control">
                                        <option value="">All Status</option>
                                        <option value="dibuat" {{ request('status') == 'dibuat' ? 'selected' : '' }}>Pesanan Dibuat</option>
                                        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                                        <option value="dikirimkan" {{ request('status') == 'dikirimkan' ? 'selected' : '' }}>Dikirimkan</option>
                                        <option value="dalam pengiriman" {{ request('status') == 'dalam pengiriman' ? 'selected' : '' }}>Dalam Pengiriman</option>
                                        <option value="telah sampai" {{ request('status') == 'telah sampai' ? 'selected' : '' }}>Telah Sampai</option>
                                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary mr-2">
                                    <i class="fa fa-search mr-1"></i>Search
                                </button>
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                                    <i class="fa fa-refresh mr-1"></i>Reset
                                </a>
                            </form>
                        </div>
                        <div class="col-md-4 text-right">
                            <div class="mb-2">
                                <span class="text-muted">Total Orders: {{ $orders->count() }}</span>
                            </div>
                            <div>
                                <form method="POST" action="{{ route('admin.orders.check-midtrans-status') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm mr-2" title="Check Midtrans Status for Pending Orders">
                                        <i class="fa fa-sync mr-1"></i>Check Midtrans Status
                                    </button>
                                </form>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#manualUpdateModal" title="Manual Update Payment Status">
                                    <i class="fa fa-edit mr-1"></i>Manual Update
                                </button>
                            </div>
                        </div>
                    </div>

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
                                    <th>Items</th>
                                    <th>Order Status</th>
                                    <th>Payment Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $index => $order)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $order->order_code }}</td>
                                        <td>{{ $order->user ? $order->user->name : 'N/A' }}</td>
                                        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                        <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $order->orderItems->count() }} item(s)<br>
                                                @foreach($order->orderItems->take(2) as $item)
                                                    <span class="badge badge-info">{{ $item->product->name ?? 'N/A' }} ({{ $item->quantity }})</span>
                                                @endforeach
                                                @if($order->orderItems->count() > 2)
                                                    <span class="badge badge-secondary">+{{ $order->orderItems->count() - 2 }} more</span>
                                                @endif
                                            </small>
                                        </td>
                                        <td>
                                            <span class="status-badge status-{{ str_replace(' ', '-', $order->order_status) }}">
                                                {{ str_replace('telah sampai', 'Telah Sampai', ucfirst($order->order_status)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="status-badge status-{{ str_replace(' ', '-', $order->payment_status) }}">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info mx-1" title="View Details">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-warning mx-1" data-toggle="modal" data-target="#updateStatusModal{{ $order->id }}" title="Update Status">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger mx-1" data-toggle="modal" data-target="#deleteOrderModal{{ $order->id }}" title="Delete Order">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>

                                            <!-- Update Status Modal -->
                                            <div class="modal fade" id="updateStatusModal{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="updateStatusModalLabel{{ $order->id }}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="updateStatusModalLabel{{ $order->id }}">
                                                                Update Status Order #{{ $order->order_code }}
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="order_status_{{ $order->id }}">Status Pesanan</label>
                                                                    <select class="form-control @error('order_status') is-invalid @enderror" id="order_status_{{ $order->id }}" name="order_status" required>
                                                                        <option value="dibuat" {{ $order->order_status == 'dibuat' ? 'selected' : '' }}>Pesanan Dibuat</option>
                                                                        <option value="diproses" {{ $order->order_status == 'diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                                                                        <option value="dikirimkan" {{ $order->order_status == 'dikirimkan' ? 'selected' : '' }}>Dikirimkan</option>
                                                                        <option value="dalam pengiriman" {{ $order->order_status == 'dalam pengiriman' ? 'selected' : '' }}>Dalam Pengiriman</option>
                                                                        <option value="telah sampai" {{ $order->order_status == 'telah sampai' ? 'selected' : '' }}>Telah Sampai</option>
                                                                        <option value="selesai" {{ $order->order_status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                                                        <option value="dibatalkan" {{ $order->order_status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                                                    </select>
                                                                    @error('order_status')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="payment_status_{{ $order->id }}">Status Pembayaran</label>
                                                                    <select class="form-control" id="payment_status_{{ $order->id }}" name="payment_status">
                                                                        <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                                        <option value="completed" {{ $order->payment_status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                                        <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                                                                        <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="notes_{{ $order->id }}">Catatan (Opsional)</label>
                                                                    <textarea class="form-control" id="notes_{{ $order->id }}" name="notes" rows="3" placeholder="Tambahkan catatan untuk order ini...">{{ $order->notes ?? '' }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="fa fa-save mr-1"></i>Update Status
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete Order Modal -->
                                            <div class="modal fade" id="deleteOrderModal{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteOrderModalLabel{{ $order->id }}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteOrderModalLabel{{ $order->id }}">Konfirmasi Hapus</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Apakah Anda yakin ingin menghapus order <strong>#{{ $order->order_code }}</strong> untuk <strong>{{ $order->user ? $order->user->name : 'N/A' }}</strong>?</p>
                                                            <p class="text-danger">Tindakan ini tidak dapat dibatalkan.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">
                                                                    <i class="fa fa-trash mr-1"></i>Hapus
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No orders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination handled by DataTables --}}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Manual Update Payment Status Modal -->
<div class="modal fade" id="manualUpdateModal" tabindex="-1" role="dialog" aria-labelledby="manualUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="manualUpdateModalLabel">Manual Update Payment Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="#" method="POST" id="manualUpdateForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="order_code">Order Code</label>
                        <input type="text" class="form-control" id="order_code" name="order_code" placeholder="Masukkan Order Code (contoh: ORD-1234567890)" required>
                    </div>

                    <div class="form-group">
                        <label for="payment_status">Payment Status</label>
                        <select class="form-control" id="payment_status" name="payment_status" required>
                            <option value="">Pilih Status</option>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                            <option value="failed">Failed</option>
                            <option value="refunded">Refunded</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="transaction_id">Transaction ID (Opsional)</label>
                        <input type="text" class="form-control" id="transaction_id" name="transaction_id" placeholder="Masukkan Transaction ID dari Midtrans">
                    </div>

                    <div class="alert alert-info">
                        <i class="fa fa-info-circle mr-1"></i>
                        <strong>Petunjuk:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Masukkan Order Code yang ingin diupdate</li>
                            <li>Pilih status pembayaran yang sesuai</li>
                            <li>Transaction ID opsional (untuk referensi)</li>
                            <li>Status order akan otomatis diupdate sesuai payment status</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save mr-1"></i>Update Payment Status
                    </button>
                </div>
            </form>
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
                pageLength: 25,
                lengthMenu: [5, 10, 25, 50], // -1 means "Show all"
                order: [[3, 'desc']], // Sort by Order Date descending by default
                language: {
                    search: "Cari orders:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ orders",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 orders",
                    infoFiltered: "(disaring dari _MAX_ total orders)"
                },
                columnDefs: [
                    { orderable: false, targets: 8 } // Kolom aksi tidak bisa diurutkan
                ],
                // Enable processing indicator
                processing: true,
                // Allow showing all records
                lengthChange: true,
                // Enable pagination
                paging: true,
                // Enable searching
                searching: true,
                // Enable sorting
                ordering: true,
                // Enable info display
                info: true,
                // Optimize for large datasets
                deferRender: true,
                // Enable state saving
                stateSave: true
            });

            // Handle modal close
            $('.modal .close, .modal [data-dismiss="modal"]').on('click', function() {
                $(this).closest('.modal').modal('hide');
            });

            // Ensure modals are initialized correctly
            $('.modal').on('shown.bs.modal', function () {
                $(this).find('[autofocus]').focus();
            });

            // Handle manual update form submission
            $('#manualUpdateForm').on('submit', function(e) {
                e.preventDefault();

                const orderCode = $('#order_code').val();
                const paymentStatus = $('#payment_status').val();
                const transactionId = $('#transaction_id').val();

                if (!orderCode || !paymentStatus) {
                    alert('Order Code dan Payment Status harus diisi!');
                    return;
                }

                // Find order by order code
                $.ajax({
                    url: '/admin/orders/search-by-code',
                    method: 'GET',
                    data: { order_code: orderCode },
                    success: function(response) {
                        if (response.order) {
                            // Update form action and submit
                            $('#manualUpdateForm').attr('action', '/admin/orders/' + response.order.id + '/update-payment-status');

                            // Add order_id to form
                            if (!$('#order_id').length) {
                                $('#manualUpdateForm').append('<input type="hidden" name="order_id" value="' + response.order.id + '">');
                            } else {
                                $('#order_id').val(response.order.id);
                            }

                            // Submit form
                            $('#manualUpdateForm')[0].submit();
                        } else {
                            alert('Order dengan code ' + orderCode + ' tidak ditemukan!');
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat mencari order. Silakan coba lagi.');
                    }
                });
            });
        });
    </script>
@endpush
