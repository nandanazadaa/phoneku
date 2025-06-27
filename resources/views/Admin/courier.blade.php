@extends('layouts.main')

@section('title', 'Management Kurir - Atlantis Lite')

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
        .btn-warning {
            background-color: #f59e0b;
            border-color: #f59e0b;
        }
        .btn-warning:hover {
            background-color: #d97706;
            border-color: #d97706;
        }
        .btn-danger {
            background-color: #ef4444;
            border-color: #ef4444;
        }
        .btn-danger:hover {
            background-color: #dc2626;
            border-color: #dc2626;
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
                <h2 class="text-white pb-2 fw-bold">Management Kurir</h2>
                <h5 class="text-white op-7 mb-2">Kelola metode pengiriman! Terakhir diperbarui: {{ now()->format('H:i A, d F Y') }} WIB</h5>
            </div>
            <div class="ml-md-auto py-2 py-md-0">
                <button class="btn btn-success btn-round" data-toggle="modal" data-target="#addCourierModal">
                    <i class="fa fa-plus"></i> Tambah Kurir
                </button>
            </div>
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <div class="card full-height">
                <div class="card-body">
                    <div class="card-title">Daftar Metode Kurir</div>
                    <div class="card-category">Tambah, ubah, atau hapus metode pengiriman</div>
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
                    <div class="table-responsive mt-4">
                        <table id="courierTable" class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kurir</th>
                                    <th>Jenis Layanan</th>
                                    <th>Biaya Pengiriman</th>
                                    <th>Tanggal Ditambahkan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($couriers ?? [] as $index => $courier)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ ucfirst($courier->courier) }}</td>
                                        <td>{{ ucfirst($courier->service_type) }}</td>
                                        <td>Rp {{ number_format($courier->shipping_cost, 0, ',', '.') }}</td>
                                        <td>{{ $courier->created_at->format('d-m-Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editCourierModal{{ $courier->id }}">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteCourierModal{{ $courier->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Edit Courier Modal -->
                                    <div class="modal fade" id="editCourierModal{{ $courier->id }}" tabindex="-1" role="dialog" aria-labelledby="editCourierModalLabel{{ $courier->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editCourierModalLabel{{ $courier->id }}">Ubah Kurir: {{ ucfirst($courier->courier) }} - {{ ucfirst($courier->service_type) }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('admin.courier.update', $courier->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="form-group">
                                                            <label for="courier_{{ $courier->id }}">Kurir</label>
                                                            <select class="form-control" id="courier_{{ $courier->id }}" name="courier" required>
                                                                <option value="jne" {{ $courier->courier == 'jne' ? 'selected' : '' }}>JNE</option>
                                                                <option value="pos" {{ $courier->courier == 'pos' ? 'selected' : '' }}>POS Indonesia</option>
                                                                <option value="tiki" {{ $courier->courier == 'tiki' ? 'selected' : '' }}>TIKI</option>
                                                                <option value="ninja" {{ $courier->courier == 'ninja' ? 'selected' : '' }}>Ninja Express</option>
                                                                <option value="j&t" {{ $courier->courier == 'j&t' ? 'selected' : '' }}>J&T Express</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="service_type_{{ $courier->id }}">Jenis Layanan</label>
                                                            <select class="form-control" id="service_type_{{ $courier->id }}" name="service_type" required>
                                                                <option value="regular" {{ $courier->service_type == 'regular' ? 'selected' : '' }}>Regular</option>
                                                                <option value="express" {{ $courier->service_type == 'express' ? 'selected' : '' }}>Express</option>
                                                                <option value="economy" {{ $courier->service_type == 'economy' ? 'selected' : '' }}>Economy</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="shipping_cost_{{ $courier->id }}">Biaya Pengiriman (Rp)</label>
                                                            <input type="number" class="form-control" id="shipping_cost_{{ $courier->id }}" name="shipping_cost" value="{{ $courier->shipping_cost }}" required min="0" step="1000">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Delete Courier Modal -->
                                    <div class="modal fade" id="deleteCourierModal{{ $courier->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteCourierModalLabel{{ $courier->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteCourierModalLabel{{ $courier->id }}">Konfirmasi Hapus</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah Anda yakin ingin menghapus kurir <strong>{{ ucfirst($courier->courier) }} - {{ ucfirst($courier->service_type) }}</strong>?</p>
                                                    <p class="text-danger">Aksi ini tidak dapat dibatalkan. Biaya saat ini: Rp {{ number_format($courier->shipping_cost, 0, ',', '.') }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <form action="{{ route('admin.courier.destroy', $courier->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada metode kurir.</td>
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

<!-- Add Courier Modal -->
<div class="modal fade" id="addCourierModal" tabindex="-1" role="dialog" aria-labelledby="addCourierModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCourierModalLabel">Tambah Kurir Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.courier.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="courier">Kurir</label>
                        <select class="form-control" id="courier" name="courier" required>
                            <option value="jne">JNE</option>
                            <option value="pos">POS Indonesia</option>
                            <option value="tiki">TIKI</option>
                            <option value="ninja">Ninja Express</option>
                            <option value="j&t">J&T Express</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="service_type">Jenis Layanan</label>
                        <select class="form-control" id="service_type" name="service_type" required>
                            <option value="regular">Regular</option>
                            <option value="express">Express</option>
                            <option value="economy">Economy</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="shipping_cost">Biaya Pengiriman (Rp)</label>
                        <input type="number" class="form-control" id="shipping_cost" name="shipping_cost" value="{{ old('shipping_cost') }}" required min="0" step="1000">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah Kurir</button>
                    </div>
                </form>
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
            $('#courierTable').DataTable({
                "pageLength": 10,
                "lengthMenu": [5, 10, 25, 50],
                "order": [[1, "asc"]],
                "language": {
                    "search": "Cari kurir atau layanan:",
                    "lengthMenu": "Tampilkan _MENU_ entri",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ kurir",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 kurir",
                    "infoFiltered": "(difilter dari _MAX_ total kurir)"
                },
                "columnDefs": [
                    { "orderable": false, "targets": [0, 5] } // Disable sorting on # and Actions columns
                ]
            });

            // Handle modal close
            $('.modal .close, .modal [data-dismiss="modal"]').on('click', function() {
                $(this).closest('.modal').modal('hide');
            });
        });
    </script>
@endpush