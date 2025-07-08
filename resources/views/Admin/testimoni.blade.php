@extends('layouts.main')

@section('title', 'Testimoni Customer - Atlantis Lite')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<style>
.table th, .table td { vertical-align: middle; padding: 12px; }
.card { border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
.dataTables_wrapper .dataTables_filter { float: right; margin-bottom: 15px; }
.dataTables_wrapper .dataTables_length { float: left; margin-bottom: 15px; }
.table-responsive { overflow-x: auto; }
</style>
@endpush

@section('content')
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div>
            <h2 class="text-white pb-2 fw-bold">Testimoni Customer</h2>
            <h5 class="text-white op-7 mb-2">Semua testimoni dari customer langsung tampil</h5>
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

                    <div class="table-responsive">
                        <table id="testimoniTable" class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Customer</th>
                                    <th>Produk</th>
                                    <th>Isi Testimoni</th>
                                    <th>Rating</th>
                                    <th>Foto</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($testimonials as $testi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $testi->user->name ?? '-' }}</td>
                                    <td>{{ $testi->product->name ?? '-' }}</td>
                                    <td>{{ $testi->message }}</td>

                                    <td>
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $testi->rating)
                                                <span style="color:gold;">&#9733;</span>
                                            @else
                                                <span style="color:lightgray;">&#9734;</span>
                                            @endif
                                        @endfor
                                        <span class="ml-1 text-muted">({{ $testi->rating }})</span>
                                    </td>

                                    <td>
                                        @if ($testi->photo)
                                            <a href="{{ asset('storage/' . $testi->photo) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $testi->photo) }}" alt="Foto" style="max-height:50px; max-width:50px; object-fit:cover; border-radius:5px;">
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td><span class="badge badge-success">Disetujui</span></td>
                                    <td>{{ $testi->created_at->format('d-m-Y H:i') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">Belum ada testimoni.</td>
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
    $('#testimoniTable').DataTable({
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        order: [[7, 'desc']], // urut berdasarkan tanggal
        language: {
            search: "Cari testimoni:",
            lengthMenu: "Tampilkan _MENU_ entri",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ testimoni",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 testimoni",
            infoFiltered: "(disaring dari _MAX_ total testimoni)"
        }
    });
});
</script>
@endpush
