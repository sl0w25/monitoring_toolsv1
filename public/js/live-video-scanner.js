document.addEventListener('alpine:init', () => {
    Alpine.data('liveVideoScanner', () => ({
        init() {
            const video = document.getElementById('scannerVideo');

            // Access the camera
            navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
                .then((stream) => {
                    video.srcObject = stream;
                })
                .catch((err) => {
                    console.error('Error accessing camera:', err);
                });

            // Implement scanning logic here (optional)
        }
    }));
});