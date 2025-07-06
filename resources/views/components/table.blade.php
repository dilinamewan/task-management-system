@props([
    'headers' => [],
    'searchable' => false,
    'searchPlaceholder' => 'Search...'
])

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    @if($searchable)
        <div class="p-6 border-b border-gray-200">
            <div class="relative max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" 
                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" 
                       placeholder="{{ $searchPlaceholder }}"
                       id="tableSearch">
            </div>
        </div>
    @endif
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            @if(!empty($headers))
                <thead class="bg-gray-50">
                    <tr>
                        @foreach($headers as $header)
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ $header }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
            @endif
            <tbody class="bg-white divide-y divide-gray-200">
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>

@if($searchable)
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('tableSearch');
    const table = searchInput.closest('.bg-white').querySelector('tbody');
    
    searchInput.addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = table.querySelectorAll('tr');
        
        rows.forEach(function(row) {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
});
</script>
@endif
