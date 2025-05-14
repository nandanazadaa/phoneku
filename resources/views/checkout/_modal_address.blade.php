<div id="addressModal" class="modal fixed inset-0 flex items-center justify-center z-50" style="display:none;">
    <div class="absolute inset-0 bg-black bg-opacity-50" onclick="document.getElementById('addressModal').style.display='none'"></div>
    <div class="modal-content relative bg-white rounded-lg shadow-lg w-full max-w-md mx-auto p-6 z-10 animate-fadeIn">
        <button type="button" class="absolute top-3 right-3 text-gray-400 hover:text-blue-500 text-2xl font-bold focus:outline-none" onclick="document.getElementById('addressModal').style.display='none'">&times;</button>
        <h2 class="text-xl font-bold mb-4">Edit Alamat</h2>
        
        @if (session('debug_info'))
        <div class="mb-4 p-4 bg-yellow-100 border border-yellow-300 rounded">
            <h3 class="font-bold text-yellow-800">Debug Info:</h3>
            <pre class="text-xs mt-2 overflow-auto">{{ print_r(session('debug_info'), true) }}</pre>
        </div>
        @endif
        
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-gray-700 mb-2">Nama</label>
                <input type="text" name="name" id="name" class="w-full border rounded p-2" value="{{ $user->name }}" required>
            </div>
            <div class="mb-4">
                <label for="label" class="block text-gray-700 mb-2">Label Alamat (Rumah/Kantor/dll)</label>
                <input type="text" name="label" id="label" class="w-full border rounded p-2" value="{{ $user->profile->label ?? 'Rumah' }}" required>
            </div>
            <div class="mb-4">
                <label for="recipient_name" class="block text-gray-700 mb-2">Nama Penerima</label>
                <input type="text" name="recipient_name" id="recipient_name" class="w-full border rounded p-2" value="{{ $user->profile->recipient_name ?? $user->name }}" required>
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-gray-700 mb-2">Nomor Telepon</label>
                <input type="text" name="phone" id="phone" class="w-full border rounded p-2" value="{{ $user->profile->phone ?? '' }}" required>
            </div>
            <div class="mb-4">
                <label for="address" class="block text-gray-700 mb-2">Alamat Lengkap</label>
                <textarea name="address" id="address" class="w-full border rounded p-2" rows="3" required>{{ $user->profile->address ?? '' }}</textarea>
                <button type="button" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600" onclick="openMapModal()">Pilih Lokasi di Peta</button>
                <input type="hidden" name="latitude" id="latitude" value="{{ $user->profile->latitude ?? '' }}">
                <input type="hidden" name="longitude" id="longitude" value="{{ $user->profile->longitude ?? '' }}">
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="document.getElementById('addressModal').style.display='none'" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 font-semibold">Simpan</button>
            </div>
        </form>
        <!-- Modal Map -->
        <div id="mapModal" class="fixed inset-0 flex items-center justify-center z-50" style="display:none;">
            <div class="absolute inset-0 bg-black bg-opacity-50" onclick="closeMapModal()"></div>
            <div class="relative bg-white rounded-lg shadow-lg w-full max-w-lg mx-auto p-4 z-10 animate-fadeIn">
                <h3 class="text-lg font-bold mb-2">Pilih Lokasi di Peta</h3>
                <div class="mb-3 flex gap-2">
                    <input type="text" id="searchLocation" class="flex-1 border rounded p-2" placeholder="Cari alamat atau tempat...">
                    <button type="button" onclick="searchLocationOnMap()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Cari</button>
                </div>
                <div id="map" style="height:300px; border-radius:0.5rem;"></div>
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" onclick="closeMapModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Batal</button>
                    <button type="button" onclick="useSelectedLocation()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 font-semibold">Gunakan Lokasi Ini</button>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
let leafletMap, marker;
function openMapModal() {
    document.getElementById('mapModal').style.display = 'flex';
    setTimeout(() => {
        if (!leafletMap) {
            leafletMap = L.map('map').setView([-7.797068, 110.370529], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(leafletMap);
            marker = L.marker([-7.797068, 110.370529], {draggable:true}).addTo(leafletMap);
            leafletMap.on('click', function(e) { marker.setLatLng(e.latlng); });
        }
        leafletMap.invalidateSize();
        // Coba ambil lokasi GPS
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(pos) {
                const latlng = [pos.coords.latitude, pos.coords.longitude];
                leafletMap.setView(latlng, 16);
                marker.setLatLng(latlng);
            });
        }
    }, 200);
}
function closeMapModal() {
    document.getElementById('mapModal').style.display = 'none';
}
function useSelectedLocation() {
    const latlng = marker.getLatLng();
    document.getElementById('latitude').value = latlng.lat;
    document.getElementById('longitude').value = latlng.lng;
    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latlng.lat}&lon=${latlng.lng}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('address').value = data.display_name;
            closeMapModal();
        });
}
function searchLocationOnMap() {
    const query = document.getElementById('searchLocation').value.trim();
    if (!query) return;
    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
        .then(res => res.json())
        .then(data => {
            if (data && data.length > 0) {
                const lat = parseFloat(data[0].lat);
                const lon = parseFloat(data[0].lon);
                leafletMap.setView([lat, lon], 16);
                marker.setLatLng([lat, lon]);
            } else {
                alert('Lokasi tidak ditemukan!');
            }
        });
}
</script>
<style>
@keyframes fadeIn { from { opacity: 0; transform: scale(0.98);} to { opacity: 1; transform: scale(1);} }
.animate-fadeIn { animation: fadeIn 0.2s; }
</style> 