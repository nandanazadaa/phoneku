<div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm flex flex-col md:flex-row items-start md:items-center p-4 gap-4">
    <div class="text-blue-500 text-2xl md:text-3xl">
        <i class="fas fa-map-marker-alt"></i>
    </div>
    <div class="flex-1">
        <div class="flex flex-wrap items-center gap-2 mb-1">
            <span class="font-semibold text-gray-800 text-base md:text-lg">{{ $user->profile->recipient_name ?? $user->name }}</span>
            <span class="text-gray-500 text-xs md:text-sm">({{ $user->profile->label ?? 'Alamat Utama' }})</span>
        </div>
        <div class="text-gray-700 text-sm md:text-base">{{ $user->profile->address ?? '-' }}</div>
        <div class="text-gray-700 text-xs md:text-sm mt-1">Telp: {{ $user->profile->phone ?? '-' }}</div>
    </div>
    <button type="button" class="px-4 py-2 border border-blue-500 text-blue-500 rounded-md hover:bg-blue-50 transition font-medium mt-3 md:mt-0" onclick="document.getElementById('addressModal').style.display='block'">Ubah</button>
</div> 