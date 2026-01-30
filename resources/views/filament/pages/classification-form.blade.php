<x-filament-panels::page>
    @if($formVisible)
        <div class="mt-4 p-4 border rounded-lg" wire:key="encode-form">
            {{ $this->form }}
        </div>

        <x-filament::section collapsible wire:key="privacy-section">
            <x-slot name="heading">DATA PRIVACY DECLARATION</x-slot>
            All data and information indicated herein shall be used for identification purposes for the implementation of disaster risk reduction and management (DRRM) programs, projects, and activities, and its disclosure shall be in compliance with Republic Act 10173 (Data Privacy Act of 2012).
        </x-filament::section>

        <x-filament-panels::form.actions :actions="$this->getFormActions()" />
    @else
        <div class="space-y-6" id="qr-dv" wire:key="qr-scanner">
            <!-- html5-qrcode will inject camera feed here -->
            <div id="interactive" class="w-full rounded-md"></div>
        </div>
    @endif
</x-filament-panels::page>

<!-- Dependencies -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
    let html5QrcodeScanner;

    function startScanner() {
        const containerId = "interactive";
        const container = document.getElementById(containerId);
        if (!container) return;

        const qrCodeSuccessCallback = (decodedText, decodedResult) => {
            console.log("QR Code Scanned:", decodedText);

            // stop scanning temporarily
            html5QrcodeScanner.stop().catch(err => console.error("Stop failed:", err));

            fetch("{{ route('hired-qr') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ qr_number: decodedText })
            })
            .then(response => response.json())
            .then(data => {
                console.log("Server response:", data);

                if (data.error) {
                    Swal.fire({
                        title: "Error!",
                        text: data.error,
                        icon: "error",
                        confirmButtonText: "OK"
                    }).then(() => startScanner());
                } else if(data.success) {
                    Swal.fire({
                        title: "Record Found!",
                        html: `Beneficiary: ${data.data.name}<br>Address: ${data.data.province}, ${data.data.municipality}, ${data.data.barangay}`,
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        // Dispatch Livewire event to fill the form
                        Livewire.dispatch("fillTheForm", { qr_number: decodedText });
                        startScanner();
                    });
                }
            })
            .catch(err => {
                console.error("Fetch error:", err);
                Swal.fire({
                    title: "Server Error!",
                    text: "Something went wrong.",
                    icon: "error",
                    confirmButtonText: "OK"
                }).then(() => startScanner());
            });
        };

        const config = { fps: 10, qrbox: 250 };
        html5QrcodeScanner = new Html5Qrcode(containerId);

        html5QrcodeScanner.start(
            { facingMode: "environment" },
            config,
            qrCodeSuccessCallback
        ).catch(err => {
            console.error("Camera start failed:", err);
            Swal.fire({
                title: "Camera Error",
                text: "Unable to access camera: " + err,
                icon: "error",
                confirmButtonText: "OK"
            });
        });
    }

    document.addEventListener("DOMContentLoaded", () => {
        startScanner();

        // Livewire SweetAlert listener
        Livewire.on("swal", event => {
            Swal.fire({
                title: event.title || "Notification",
                text: event.text || "",
                icon: event.icon || "info",
                confirmButtonText: "OK"
            });
        });

        // Livewire reload page listener
        Livewire.on("reloadPage", () => {
            setTimeout(() => location.reload(), 500);
        });
    });
</script>
