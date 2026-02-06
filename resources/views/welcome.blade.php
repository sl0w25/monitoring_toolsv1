<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Attendance Log Monitoring</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Parent container must be relative for absolute positioning */
        .video-container {
            position: relative;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        #interactive video {
            transform: scaleX(-1); /* horizontal flip */
        }

        /* Scanner Box Overlay */
        /* .scanner-box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            max-width: 350px;
            height: 100%;
            max-height: 270px;
            border: 3px solid rgb(145, 255, 0);
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.7);
            animation: pulse 2s infinite alternate ease-in-out;
            pointer-events: none; }/* clicks pass through */


        /* Scanner Line Animation */
        /* .scanner-line {
            position: absolute;
            width: 100%;
            height: 3px;
            background: rgb(30, 255, 0);
            top: 0;
            left: 0;
            animation: scan 2s infinite linear;
        } */ */

        @keyframes pulse {
            0% { transform: translate(-50%, -50%) scale(1); }
            100% { transform: translate(-50%, -50%) scale(1.1); }
        }

        @keyframes scan {
            0% { top: 0; }
            100% { top: 100%; }
        }

        /* Responsive Tweaks */
        @media (max-width: 1133px) { .scanner-box { max-width: 270px; max-height: 180px; } }
        @media (max-width: 768px) { .scanner-box { max-width: 270px; max-height: 180px; }}
        @media (max-width: 480px) { .scanner-box { max-width: 220px; max-height: 100px;  }}
    </style>
</head>
<body class="bg-gray-700 text-gray-800 font-poppins bg-blend-multiply bg-cover bg-fixed" style="background: linear-gradient(to bottom, rgba(255,255,255,0.15) 0%, rgba(0,0,0,0.15) 100%), radial-gradient(at top center, rgba(255,255,255,0.4) 0%, rgba(0,0,0,0.4) 120%) #989898;">

<div class="flex justify-center items-center h-[91.5vh]">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 w-11/12 h-[90%] bg-white bg-opacity-80 p-10 rounded-2xl shadow-lg">

        <!-- QR Scanner Section -->
        <div class="col-span-1 flex flex-col items-center shadow-md rounded-lg p-6 bg-white">
            <h5 class="text-center text-lg font-semibold mb-4">Scan your QR Code here</h5>
            <div class="video-container">
                <!-- Html5-Qrcode will inject the video here -->
                <div id="interactive" class="w-full rounded-md"></div>
                <canvas id="qrCaptureCanvas" class="hidden"></canvas>

                <!-- Overlay -->
                <div id="scannerBox" class="scanner-box">
                    <div class="scanner-line"></div>
                </div>
            </div>

            <div class="qr-detected-container hidden mt-4">
                <form method="POST" action="{{ route('scan.qr') }}">
                    @csrf
                    <h4 class="text-center text-xl font-bold mb-4">Student QR Detected!</h4>
                    <input type="hidden" id="detected-qr-code" name="qr_number">
                </form>
            </div>

            <div id="error-container" class="text-red-600 font-semibold hidden mt-4 py-4"></div>
            <div id="success-container" class="text-green-600 font-semibold hidden mt-4"></div>
        </div>

        <!-- Attendee Table Section -->
        <div class="col-span-2 shadow-md rounded-lg p-6 bg-white">
            <h4 class="text-lg font-semibold mb-6">List of Participants</h4>
            <div class="overflow-x-auto">
                <table class="table-auto w-full text-center text-sm border-collapse border border-gray-300">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="border border-gray-400 px-2 py-1">#</th>
                            <th class="border border-gray-400 px-2 py-1">Full Name</th>
                            <th class="border border-gray-400 px-2 py-1">Division</th>
                            <th class="border border-gray-400 px-2 py-1">Time In</th>
                            <th class="border border-gray-400 px-2 py-1">Category</th>
                        </tr>
                    </thead>
                    <tbody id="attendanceTableBody" class="bg-white">
                        @forelse ($attendances as $attendance)
                            <tr class="border border-gray-300">
                                <td class="px-2 py-1">{{ $attendances->total() - ($attendances->perPage() * ($attendances->currentPage() - 1)) - $loop->index }}</td>
                                <td class="px-2 py-1">{{ $attendance->first_name }}  {{ $attendance->last_name }}</td>
                                <td class="px-2 py-1">{{ $attendance->division }}</td>
                                <td class="px-2 py-1">{{ $attendance->time_in }}</td>
                                <td class="px-2 py-1">{{ $attendance->race_category }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-2 py-1 text-center">No Records</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $attendances->links() }}
            </div>
        </div>
    </div>
</div>

<audio id="scanSound" src="storage/sounds/beep.mp3"></audio>

<!-- HTML5 QR Code Library -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
    let isScanning = false;       // Lock
    let lastScanned = "";        // Last QR
    let scanCooldown = 2000;     // 2 seconds cooldown

    function addAttendanceRow(attendance) {
        const tbody = document.querySelector("#attendanceTableBody");
        const row = document.createElement("tr");

        row.innerHTML = `
            <td class="px-2 py-1">${attendance.id}</td>
            <td class="px-2 py-1">${attendance.first_name || " " || attendance.last_name || " " || attendance.ext}</td>
            <td class="px-2 py-1">${attendance.division}</td>
            <td class="px-2 py-1">${attendance.time_in || ""}</td>
            <td class="px-2 py-1">${attendance.race_category}</td>
        `;

        tbody.prepend(row);
    }


    function refreshTable() {
        fetch("{{ route('attendances.list') }}")
            .then(res => res.json())
            .then(data => {

                const tbody = document.querySelector("#attendanceTableBody");
                tbody.innerHTML = "";

                data.attendances.data.forEach(addAttendanceRow);

                document.querySelector(".mt-4").innerHTML =
                    data.attendances.links;

            })
            .catch(console.error);
    }


 function startScanner() {
    const errorBox = document.getElementById('error-container');
    const successBox = document.getElementById('success-container');
    const scanSound = document.getElementById('scanSound');

    const onScanSuccess = (decodedText) => {
        if (isScanning) return;

        isScanning = true;
        const currentScan = decodedText;

        scanSound.play();
        errorBox.classList.add('hidden');
        successBox.classList.add('hidden');

         // Capture the video frame
        const video = document.querySelector("#interactive video");
        const canvas = document.getElementById("qrCaptureCanvas");
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        const context = canvas.getContext("2d");
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Convert to base64 image (PNG)
        const imageData = canvas.toDataURL("image/png"); // "data:image/png;base64,..."

        const formData = new FormData();
        formData.append('qr_number', currentScan);
        formData.append('imageCapture', imageData);


        fetch("{{ route('scan.qr') }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                errorBox.classList.remove('hidden');
                errorBox.innerHTML = data.error;
                setTimeout(() => { errorBox.classList.add('hidden'); }, 3000);
            } else {
                successBox.classList.remove('hidden');
                successBox.innerHTML = data.message;
                refreshTable();
                setTimeout(() => { successBox.classList.add('hidden'); }, 3000);
            }
            isScanning = false; // unlock for next scan
        })
        .catch(err => {
            console.error(err);
            errorBox.classList.remove('hidden');
            errorBox.innerHTML = "Network error";
            setTimeout(() => { errorBox.classList.add('hidden'); }, 3000);
            isScanning = false;
        });
    };

    const config = { fps: 30, qrbox: 270 };

    const scanner = new Html5Qrcode("interactive");

    // ✅ Get available cameras and prefer rear camera
    Html5Qrcode.getCameras().then(cameras => {
        if (cameras && cameras.length) {
            // Choose rear camera if possible
            let cameraId = cameras[0].id; // fallback to first camera
            for (let cam of cameras) {
                if (cam.label.toLowerCase().includes('back') || cam.label.toLowerCase().includes('rear')) {
                    cameraId = cam.id;
                    break;
                }
            }

            scanner.start(cameraId, config, onScanSuccess)
                .catch(err => {
                    console.error(err);
                    alert("Camera error: " + err);
                });
        } else {
            alert("No camera found");
        }
    }).catch(err => {
        console.error(err);
        alert("Camera error: " + err);
    });
}



document.addEventListener('DOMContentLoaded', startScanner);


function captureImage() {
    const video = document.querySelector("#interactive video");
    const canvas = document.createElement("qrCaptureCanvas");
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext("2d").drawImage(video, 0, 0, canvas.width, canvas.height);

    // Get base64 string
    const imageBase64 = canvas.toDataURL("image/png"); // data:image/png;base64,...
    return imageBase64;
}

</script>

</body>
</html>
