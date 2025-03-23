<x-filament-panels::page>
    {{ $this->table }}
</x-filament-panels::page>
<script>
    document.addEventListener('restoreSelections', function(event) {
        let selectedRecords = event.detail.selectedRecords;
        selectedRecords.forEach(id => {
            let checkbox = document.querySelector(`input[type="checkbox"][value="${id}"]`);
            if (checkbox) {
                checkbox.checked = true;
            }
        });
    });
</script>


