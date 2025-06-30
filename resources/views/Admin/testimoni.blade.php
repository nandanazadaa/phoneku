@extends('layouts.main')

@section('title', 'Moderasi Testimoni - Atlantis Lite')

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
    </style>
@endpush

@section('content')
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Moderasi Testimoni</h2>
                <h5 class="text-white op-7 mb-2">Daftar testimoni/ulasan dari customer</h5>
            </div>
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <div class="card full-height">
                <div class="card-body">
                    <div class="card-title">Testimoni Customer</div>
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
                        <table id="testimoniTable" class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Customer</th>
                                    <th>Produk</th>
                                    <th>Isi Testimoni</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($testimonials as $testi)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $testi->user->name ?? '-' }}</td>
                                        <td>{{ $testi->product->name ?? '-' }}</td>
                                        <td>{{ $testi->content }}</td>
                                        <td>
                                            @if($testi->is_approved)
                                                <span class="badge badge-success">Disetujui</span>
                                            @else
                                                <span class="badge badge-warning">Menunggu</span>
                                            @endif
                                        </td>
                                        <td>{{ $testi->created_at->format('d-m-Y H:i') }}</td>
                                        <td>
                                            @if(!$testi->is_approved)
                                                <button class="btn btn-sm btn-primary mr-1" data-toggle="modal" data-target="#approveModal{{ $testi->id }}">Approve</button>
                                                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#rejectModal{{ $testi->id }}">Tolak</button>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <!-- Approve Testimoni Modal -->
                                    <div class="modal fade" id="approveModal{{ $testi->id }}" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel{{ $testi->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="approveModalLabel{{ $testi->id }}">Approve Testimoni</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin.testimoni.approve', $testi->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menyetujui testimoni dari <strong>{{ $testi->user->name ?? '-' }}</strong> untuk produk <strong>{{ $testi->product->name ?? '-' }}</strong>?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Ya, Setujui</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Reject Testimoni Modal -->
                                    <div class="modal fade" id="rejectModal{{ $testi->id }}" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel{{ $testi->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="rejectModalLabel{{ $testi->id }}">Tolak Testimoni</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin.testimoni.reject', $testi->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menolak testimoni dari <strong>{{ $testi->user->name ?? '-' }}</strong> untuk produk <strong>{{ $testi->product->name ?? '-' }}</strong>?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">Ya, Tolak</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Belum ada testimoni.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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
            $('#testimoniTable').DataTable({
                "pageLength": 10,
                "lengthMenu": [5, 10, 25, 50],
                "order": [[5, "desc"]], // Sort by Tanggal descending by default
                "language": {
                    "search": "Search testimoni:",
                    "lengthMenu": "Show _MENU_ entries",
                    "info": "Showing _START_ to _END_ of _TOTAL_ testimoni",
                    "infoEmpty": "Showing 0 to 0 of 0 testimoni",
                    "infoFiltered": "(filtered from _MAX_ total testimoni)"
                },
                "columnDefs": [
                    { "orderable": false, "targets": 6 } // Disable sorting on Aksi column
                ]
            });

            // Handle modal close
            $('.modal .close, .modal [data-dismiss="modal"]').on('click', function() {
                $(this).closest('.modal').modal('hide');
            });
        });
    </script>
@endpush