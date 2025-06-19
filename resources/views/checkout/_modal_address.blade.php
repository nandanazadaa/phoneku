<div id="modalAddress" class="modal fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="absolute inset-0 bg-black bg-opacity-50" onclick="closeModal()"></div>
    <div class="modal-content relative bg-white rounded-lg shadow-lg w-full max-w-lg mx-auto p-6 z-10 animate-fadeIn">
        <button type="button" id="closeButton" class="absolute top-3 right-3 text-gray-400 hover:text-blue-500 text-2xl font-bold focus:outline-none" onclick="closeModal()">
            ×
        </button>
        <h2 class="text-xl font-bold mb-6 text-gray-800">Edit Alamat</h2>

        @if (session('debug_info'))
            <div class="mb-6 p-4 bg-yellow-100 border border-yellow-300 rounded">
                <h3 class="font-bold text-yellow-800">Debug Info:</h3>
                <pre class="text-xs mt-2 overflow-auto">{{ print_r(session('debug_info'), true) }}</pre>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" id="addressForm" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="label" class="block text-sm font-medium text-gray-700 mb-2">Label Alamat</label>
                <input type="text" name="label" id="label" class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ $user->profile->label ?? 'Rumah' }}" required>
            </div>
            <div class="mb-4">
                <label for="recipient_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Penerima</label>
                <input type="text" name="recipient_name" id="recipient_name" class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ $user->profile->recipient_name ?? $user->username }}" required>
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                <input type="text" name="phone" id="phone" class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ $user->profile->phone ?? '' }}" required>
            </div>
            <div class="mb-4">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                <textarea name="address" id="address" class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" rows="3" required>{{ $user->profile->address ?? '' }}</textarea>
            </div>
            <div class="mb-4">
                <div class="flex gap-2 mb-2">
                    <input type="text" id="searchLocation" class="flex-1 border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Cari alamat atau tempat...">
                    <button type="button" onclick="searchLocationOnMap()" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 font-medium">Cari</button>
                </div>
                <div id="map" style="height: 250px; border-radius: 0.5rem;"></div>
            </div>
            <div class="flex justify-end gap-4 mt-6">
                <button type="button" id="cancelButton" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium" onclick="closeModal()">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 font-semibold">Simpan</button>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    let leafletMap, marker;

    // Initialize map and event listeners when DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        const gantiButton = document.querySelector('[data-toggle="modal"][data-target="#modalAddress"]:not([disabled])');
        if (gantiButton) {
            gantiButton.addEventListener('click', function() {
                document.getElementById('modalAddress').classList.remove('hidden');
                initializeMap();
            });
        }

        // Ensure close and cancel buttons work
        const closeButton = document.getElementById('closeButton');
        const cancelButton = document.getElementById('cancelButton');
        if (closeButton) closeButton.addEventListener('click', closeModal);
        if (cancelButton) cancelButton.addEventListener('click', closeModal);

        // Handle form submission
        const form = document.getElementById('addressForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Optional: Add loading state or prevent multiple submissions
                // Penutupan modal akan ditangani oleh redirect dari server
            });
        }
    });

    function initializeMap() {
        if (!leafletMap) {
            leafletMap = L.map('map').setView([-7.797068, 110.370529], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(leafletMap);
            marker = L.marker([-7.797068, 110.370529], { draggable: true }).addTo(leafletMap);
            leafletMap.on('click', function(e) {
                marker.setLatLng(e.latlng);
                updateAddress(e.latlng);
            });
            marker.on('dragend', function(e) {
                updateAddress(e.target.getLatLng());
            });
        }
        leafletMap.invalidateSize();
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(pos) {
                const latlng = [pos.coords.latitude, pos.coords.longitude];
                leafletMap.setView(latlng, 16);
                marker.setLatLng(latlng);
                updateAddress({ lat: pos.coords.latitude, lng: pos.coords.longitude });
            }, function(error) {
                console.error('Geolocation error:', error);
            });
        }
    }

    function closeModal() {
        const modal = document.getElementById('modalAddress');
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    function updateAddress(latlng) {
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latlng.lat}&lon=${latlng.lng}&zoom=18&addressdetails=1`, {
            headers: { 'User-Agent': 'PhoneKu/1.0 (your-email@example.com)' }
        })
            .then(res => res.json())
            .then(data => {
                if (data && data.display_name) {
                    document.getElementById('address').value = data.display_name;
                } else {
                    document.getElementById('address').value = 'Alamat tidak ditemukan';
                }
            })
            .catch(error => {
                console.error('Error fetching address:', error);
                document.getElementById('address').value = 'Gagal memuat alamat';
            });
    }

    function searchLocationOnMap() {
        const query = document.getElementById('searchLocation').value.trim();
        if (!query) return;
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&addressdetails=1`, {
            headers: { 'User-Agent': 'PhoneKu/1.0 (your-email@example.com)' }
        })
            .then(res => res.json())
            .then(data => {
                if (data && data.length > 0) {
                    const lat = parseFloat(data[0].lat);
                    const lon = parseFloat(data[0].lon);
                    leafletMap.setView([lat, lon], 16);
                    marker.setLatLng([lat, lon]);
                    updateAddress({ lat, lon });
                } else {
                    alert('Lokasi tidak ditemukan!');
                }
            })
            .catch(error => {
                console.error('Error searching location:', error);
                alert('Gagal mencari lokasi!');
            });
    }
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.98); }
        to { opacity: 1; transform: scale(1); }
    }
    .animate-fadeIn { animation: fadeIn 0.2s ease-out; }
    .modal { display: none; }
    .modal.hidden { display: none; }
    .modal-content { max-height: 90vh; overflow-y: auto; max-width: 90vw; width: 600px; }
</style>