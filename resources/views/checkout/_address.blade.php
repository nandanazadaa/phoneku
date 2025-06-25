<div class="bg-white p-4 md:p-6 rounded-lg shadow">
    <h2 class="text-lg md:text-xl font-semibold mb-4">Alamat Pengiriman</h2>
    <div id="address-section" class="flex items-start justify-between">
        @if ($user && $user->profile)
            <div class="space-y-2">
                <p class="flex items-center text-sm">
                    <span class="text-gray-400 mr-2">📍</span>
                    <span class="font-medium">{{ $user->profile->label ?? 'Rumah' }}</span> | 
                    <span class="ml-1">{{ $user->profile->recipient_name ?? $user->username }}</span>
                </p>
                <p class="text-sm text-gray-600">
                    {{ $user->profile->address ?? 'Alamat belum diatur' }}<br>
                    Telepon: {{ $user->profile->phone ?? '' }}
                </p>
            </div>
            <button id="gantiButton" class="btn btn-primary mt-0 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm" data-toggle="modal" data-target="#modalAddress">Ganti</button>
        @else
            <p class="text-sm">Alamat belum diatur. Silakan <a href="{{ route('profile') }}" class="text-blue-500 underline">lengkapi profil</a>.</p>
            <button class="btn btn-primary mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm" data-toggle="modal" data-target="#modalAddress" disabled>Ganti</button>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Perbarui alamat setelah form disimpan
        const updatedProfile = @json(session('updated_profile'));
        if (updatedProfile) {
            const addressSection = document.getElementById('address-section');
            if (addressSection) {
                addressSection.innerHTML = `
                    <div class="space-y-2">
                        <p class="flex items-center text-sm">
                            <span class="text-gray-400 mr-2">📍</span>
                            <span class="font-medium">${updatedProfile.label || 'Rumah'}</span> | 
                            <span class="ml-1">${updatedProfile.recipient_name || '{{ $user->username }}'}</span>
                        </p>
                        <p class="text-sm text-gray-600">
                            ${updatedProfile.address || 'Alamat belum diatur'}<br>
                            Telepon: ${updatedProfile.phone || ''}
                        </p>
                    </div>
                    <button id="gantiButton" class="btn btn-primary mt-0 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm" data-toggle="modal" data-target="#modalAddress">Ganti</button>
                `;
            }
        }

        // Re-bind event listener to gantiButton after update
        const gantiButton = document.getElementById('gantiButton');
        if (gantiButton && !gantiButton.dataset.eventBound) {
            gantiButton.addEventListener('click', function() {
                document.getElementById('modalAddress').classList.remove('hidden');
                setTimeout(() => {
                    if (typeof leafletMap !== 'undefined' && leafletMap) {
                        leafletMap.invalidateSize();
                    }
                }, 200);
            });
            gantiButton.dataset.eventBound = 'true';
        }
    });
</script>