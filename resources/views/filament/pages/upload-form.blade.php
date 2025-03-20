<x-filament-panels::page>

             {{ $this->form }}

</x-filament-panels::page>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        console.log("SweetAlert Listener Loaded"); // Debugging

        Livewire.on("swal", (event) => {
            console.log("SweetAlert Event Received:", event); // Debugging
            Swal.fire({
                title: event.title || "Notification",
                text: event.text || "",
                icon: event.icon || "info",
                confirmButtonText: "OK"
            });
        });
    });
</script>
