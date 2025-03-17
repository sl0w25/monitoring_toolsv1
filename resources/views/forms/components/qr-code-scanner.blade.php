<div>
    <div id="reader" style="width: 300px; height: 300px;"></div>
    <input type="text" wire:model="{{ $getStatePath() }}" id="qr-result" readonly>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const scanner = new Html5Qrcode("reader");
            scanner.start(
                { facingMode: "environment" }, // Use the back camera
                { fps: 10, qrbox: { width: 250, height: 250 } },
                (decodedText) => {
                    document.getElementById('qr-result').value = decodedText;
                    @this.set('{{ $getStatePath() }}', decodedText); // Send to Livewire
                    scanner.stop();
                },
                (errorMessage) => {
                    console.log(errorMessage);
                }
            ).catch(err => console.log(err));
        });
    </script>
</div>
