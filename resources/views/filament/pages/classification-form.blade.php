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
    @elseif(!$formVisible)
        <div class="space-y-6" id="qr-dv" wire:key="qr-scanner">
            <video id="interactive" class="w-100 rounded-md"></video>
        </div>
    @endif
</x-filament-panels::page>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script>
    let scanner;

    function startScanner() {

        scanner = new Instascan.Scanner({ video: document.getElementById('interactive') });

        scanner.addListener('scan', function (content) {
            console.log('QR Code Scanned:', content);

            if (scanner) {
                scanner.stop();
            }

            document.getElementById('interactive').style.display = 'none';

            fetch("{{ route('hired-qr') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ qr_number: content })
            })
            .then(response => response.json())
            .then(data => {
                console.log("Parsed JSON response:", data);

                if (data.error) {
                    Swal.fire({
                        title: 'Error!',
                        text: data.error,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });

                    document.getElementById('interactive').style.display = 'block';
                    startScanner();


                } else if(data.success) {
                    Swal.fire({
                        title: 'Record Found!',
                        html: `Beneficiary: ${data.data.name}<br>Address: ${data.data.province},\n${data.data.municipality},\n${data.data.barangay}`,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });

                    Livewire.on('setSearchQuery', (data) => {
                        console.log("Livewire event received:", data);
                    });

                    console.log("Dispatching Livewire event: setSearchQuery with QR:", content);
                    console.log(Livewire);

                    // Livewire.dispatch("saveImage", { imageCapture: imageData });
                    Livewire.dispatch("fillTheForm", { qr_number: content });

                }
            })
            .catch(error => {
                console.error("Error parsing JSON:", error);
                Swal.fire({
                    title: 'Server Error!',
                    text: 'Something went wrong.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });

                startScanner();
            });
        });

        Instascan.Camera.getCameras()
            .then(function (cameras) {
                if (cameras.length > 0) {
                    let backCamera = cameras.find(camera => camera.name.toLowerCase().includes('back')) || cameras[0];
                    scanner.start(backCamera);
                } else {
                    console.error('No cameras found.');
                    Swal.fire({
                        title: 'No Camera Found!',
                        text: 'Please ensure your camera is connected.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(function (err) {
                console.error('Camera access error:', err);
                Swal.fire({
                    title: 'Camera Error!',
                    text: 'Unable to access camera: ' + err,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
    }

    document.addEventListener('DOMContentLoaded', startScanner);
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        console.log("Event listeners loaded...");

        Livewire.on("swal", (event) => {
            console.log("SweetAlert Event Received:", event);
            Swal.fire({
                title: event.title || "Notification",
                text: event.text || "",
                icon: event.icon || "info",
                confirmButtonText: "OK"
            });
        });


    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        Livewire.on("reloadPage", () => {
            console.log("🔄 Reloading page...");
            setTimeout(() => {
                location.reload();
            }, 500);
        });
    });
</script>






