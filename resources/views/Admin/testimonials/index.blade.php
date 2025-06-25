@extends('admin.layouts.app')

@section('title', 'Manajemen Testimoni')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Manajemen Testimoni</h1>
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6">{{ session('success') }}</div>
    @endif
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border rounded-lg">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="py-2 px-4 border-b">#</th>
                    <th class="py-2 px-4 border-b">User</th>
                    <th class="py-2 px-4 border-b">Produk</th>
                    <th class="py-2 px-4 border-b">Rating</th>
                    <th class="py-2 px-4 border-b">Pesan</th>
                    <th class="py-2 px-4 border-b">Foto</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($testimonials as $testi)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $testi->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $testi->user->name ?? $testi->name }}<br><span class="text-xs text-gray-500">{{ $testi->city }}</span></td>
                    <td class="py-2 px-4 border-b">{{ $testi->product->name ?? '-' }}</td>
                    <td class="py-2 px-4 border-b">
                        @for($i=1;$i<=5;$i++)
                            <i class="{{ $i <= $testi->rating ? 'fas fa-star text-yellow-400' : 'far fa-star text-gray-300' }}"></i>
                        @endfor
                    </td>
                    <td class="py-2 px-4 border-b max-w-xs">{{ $testi->message }}</td>
                    <td class="py-2 px-4 border-b">
                        @if($testi->photo)
                            <img src="{{ asset('storage/' . $testi->photo) }}" alt="Foto Testimoni" class="w-16 h-16 object-cover rounded">
                        @else
                            -
                        @endif
                    </td>
                    <td class="py-2 px-4 border-b">
                        @if($testi->is_approved)
                            <span class="text-green-600 font-semibold">Disetujui</span>
                        @else
                            <span class="text-orange-600 font-semibold">Menunggu</span>
                        @endif
                    </td>
                    <td class="py-2 px-4 border-b">
                        <div class="flex gap-2">
                            @if(!$testi->is_approved)
                            <form action="{{ route('admin.testimonials.approve', $testi) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Approve</button>
                            </form>
                            @endif
                            <a href="{{ route('admin.testimonials.edit', $testi) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Edit</a>
                            <form action="{{ route('admin.testimonials.destroy', $testi) }}" method="POST" onsubmit="return confirm('Hapus testimoni ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-4 text-gray-500">Belum ada testimoni.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $testimonials->links() }}</div>
</div>
@endsection
