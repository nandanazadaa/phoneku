@extends('layouts.main')

@section('title', 'Moderasi Testimoni - Atlantis Lite')

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
    <div class="row mt--2">
        <div class="col-md-12">
            <div class="card full-height">
                <div class="card-body">
                    <div class="card-title">Testimoni Customer</div>
                    <div class="card-category">Approve atau tolak testimoni customer</div>
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
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
                                @forelse($testimonials as $testi)
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
                                                <form action="{{ route('admin.testimoni.approve', $testi->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                                </form>
                                                <form action="{{ route('admin.testimoni.reject', $testi->id) }}" method="POST" class="d-inline ml-1">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                                </form>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
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
