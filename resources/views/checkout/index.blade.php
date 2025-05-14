@if (session('debug_info'))
<div class="container mx-auto mt-4 p-4 bg-yellow-100 border border-yellow-300 rounded">
    <h3 class="font-bold text-yellow-800">Debug Info:</h3>
    <pre class="text-xs mt-2 overflow-auto">{{ print_r(session('debug_info'), true) }}</pre>
</div>
@endif 