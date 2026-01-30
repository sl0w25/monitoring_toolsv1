<x-filament-panels::page>

<div class="flex justify-center items-center h-[91.5vh]">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 w-11/12 h-[90%] bg-opacity-80 p-10 rounded-2xl shadow-lg">
        <div class="col-span-1 flex flex-col items-center shadow-md rounded-lg p-6">
            <h5 class="text-center text-lg font-semibold mb-4">QR Code Scan here</h5>

            <!-- Scanner container -->
            <div id="interactive1" class="w-full rounded-md" style="position: relative;"></div>

            <div id="error-container" class="text-red-600 font-semibold hidden mt-4"></div>
            <div id="success-container" class="text-green-600 font-semibold hidden mt-4"></div>

            <div class="qr-detected-container hidden mt-4">
                <form method="POST" action="{{ route('scan.qr') }}">
                    @csrf
                    <h4 class="text-center text-xl font-bold mb-4">Student QR Detected!</h4>
                    <input type="hidden" id="detected-qr-code" name="qr_number">
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Html5 QR Code library -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    function startScanner() {
        const errorContainer = document.getElementById('error-container');
        const successContainer = document.getElementById('success-container');

        const qrCodeSuccessCallback = (decodedText, decodedResult) => {
            console.log('QR Code Scanned:', decodedText);

            errorContainer.classList.add('hidden');
            successContainer.classList.add('hidden');

            const formData = new FormData();
            formData.append('qr_number', decodedText);

            fetch("{{ route('hired-qr') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: formData,
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw new Error(err.error || 'Unexpected error'); });
                }
                return response.json();
            })
            .then(data => {
                console.log('Attendance Response:', data);
                if (data.error) {
                    errorContainer.classList.remove('hidden');
                    errorContainer.innerHTML = data.error;
                } else {
                    successContainer.classList.remove('hidden');
                    successContainer.innerHTML = data.message;
                }
            })
            .catch(error => {
                console.log('Error:', error.message);
                errorContainer.classList.remove('hidden');
                errorContainer.innerHTML = error.message;
            });
        };

        // Scanner config
        const config = { fps: 10, qrbox: 250 };
        const html5QrcodeScanner = new Html5Qrcode("interactive1");

        html5QrcodeScanner.start(
            { facingMode: "environment" }, // back camera
            config,
            qrCodeSuccessCallback
        ).catch(err => {
            console.error("Camera start failed:", err);
            alert("Camera access error: " + err);
        });
    }

    document.addEventListener('DOMContentLoaded', startScanner);
</script>

</x-filament-panels::page>
