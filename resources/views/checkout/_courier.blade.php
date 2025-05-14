<div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm">
    <div class="p-4 border-b border-gray-200 bg-gray-50">
        <h2 class="text-lg text-gray-500 font-medium uppercase">Pilih Kurir</h2>
    </div>
    <div class="p-4 flex flex-col gap-3">
        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-blue-50 transition gap-3">
            <input type="radio" name="courier" value="jne" class="mr-2 accent-blue-500" checked>
            <img src="{{ asset('img/kurir/jne.png') }}" alt="JNE" class="w-8 h-8 object-contain mr-2">
            <div class="flex-1">
                <div class="font-medium">JNE Reguler</div>
                <div class="text-xs text-gray-500">2-3 hari • Rp20.000</div>
            </div>
        </label>
        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-blue-50 transition gap-3">
            <input type="radio" name="courier" value="jnt" class="mr-2 accent-blue-500">
            <img src="{{ asset('img/kurir/jnt.png') }}" alt="J&T" class="w-8 h-8 object-contain mr-2">
            <div class="flex-1">
                <div class="font-medium">J&T Express</div>
                <div class="text-xs text-gray-500">1-2 hari • Rp22.000</div>
            </div>
        </label>
        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-blue-50 transition gap-3">
            <input type="radio" name="courier" value="sicepat" class="mr-2 accent-blue-500">
            <img src="{{ asset('img/kurir/sicepat.png') }}" alt="SiCepat" class="w-8 h-8 object-contain mr-2">
            <div class="flex-1">
                <div class="font-medium">SiCepat</div>
                <div class="text-xs text-gray-500">1-3 hari • Rp18.000</div>
            </div>
        </label>
    </div>
</div> 