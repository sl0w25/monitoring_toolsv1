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

        /* Scanner Box Overlay */
        .scanner-box {
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
            pointer-events: none; /* clicks pass through */
        }

        /* Scanner Line Animation */
        .scanner-line {
            position: absolute;
            width: 100%;
            height: 3px;
            background: rgb(30, 255, 0);
            top: 0;
            left: 0;
            animation: scan 2s infinite linear;
        }

        @keyframes pulse {
            0% { transform: translate(-50%, -50%) scale(1); }
            100% { transform: translate(-50%, -50%) scale(1.1); }
        }

        @keyframes scan {
            0% { top: 0; }
            100% { top: 100%; }
        }

        /* Responsive Tweaks */
        @media (max-width: 1133px) { .scanner-box { max-width: 260px; max-height: 180px; } }
        @media (max-width: 768px) { .scanner-box { max-width: 270px; max-height: 180px; } }
        @media (max-width: 480px) { .scanner-box { max-width: 170px; max-height: 100px; } }
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
                            <th class="border border-gray-400 px-2 py-1">First Name</th>
                            <th class="border border-gray-400 px-2 py-1">Middle Name</th>
                            <th class="border border-gray-400 px-2 py-1">Last Name</th>
                            <th class="border border-gray-400 px-2 py-1">Ext</th>
                            <th class="border border-gray-400 px-2 py-1">Time In</th>
                        </tr>
                    </thead>
                    <tbody id="attendanceTableBody" class="bg-white">
                        @forelse ($attendances as $attendance)
                            <tr class="border border-gray-300">
                                <td class="px-2 py-1">{{ $attendances->total() - ($attendances->perPage() * ($attendances->currentPage() - 1)) - $loop->index }}</td>
                                <td class="px-2 py-1">{{ $attendance->first_name }}</td>
                                <td class="px-2 py-1">{{ $attendance->middle_name }}</td>
                                <td class="px-2 py-1">{{ $attendance->last_name }}</td>
                                <td class="px-2 py-1">{{ $attendance->ext_name }}</td>
                                <td class="px-2 py-1">{{ $attendance->time_in }}</td>
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
    function addAttendanceRow(attendance) {
        const tbody = document.querySelector("#attendanceTableBody");
        const row = document.createElement("tr");
        row.innerHTML = `
            <td class="px-2 py-1">${attendance.id}</td>
            <td class="px-2 py-1">${attendance.first_name}</td>
            <td class="px-2 py-1">${attendance.middle_name || ""}</td>
            <td class="px-2 py-1">${attendance.last_name}</td>
            <td class="px-2 py-1">${attendance.ext_name || ""}</td>
            <td class="px-2 py-1">${attendance.time_in}</td>
        `;
        tbody.prepend(row);
    }

    function refreshTable() {
        fetch("{{ route('attendances.list') }}")
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector("#attendanceTableBody");
                const existingIds = new Set([...tbody.children].map(row => row.children[0].textContent));
                data.attendances.data.forEach(attendance => {
                    if (!existingIds.has(attendance.id.toString())) {
                        addAttendanceRow(attendance);
                    }
                });
                document.querySelector(".mt-4").innerHTML = data.attendances.links;
            })
            .catch(error => console.error("Error fetching paginated data:", error));
    }

    function startScanner() {
        const errorContainer = document.getElementById('error-container');
        const successContainer = document.getElementById('success-container');
        const scanSound = document.getElementById('scanSound');

        const qrCodeSuccessCallback = (decodedText, decodedResult) => {
            console.log('QR Code Scanned:', decodedText);
            scanSound.play();

            errorContainer.classList.add('hidden');
            successContainer.classList.add('hidden');

            const formData = new FormData();
            formData.append('qr_number', decodedText);

            fetch("{{ route('scan.qr') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    errorContainer.classList.remove('hidden');
                    errorContainer.innerHTML = data.error;
                } else {
                    successContainer.classList.remove('hidden');
                    successContainer.innerHTML = data.message;
                    refreshTable(data.attendances);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                errorContainer.classList.remove('hidden');
                errorContainer.innerHTML = error.message;
            });
        };

        const config = { fps: 10, qrbox: { width: 350, height: 270 } };
        const html5QrcodeScanner = new Html5Qrcode("interactive");

        html5QrcodeScanner.start(
            { facingMode: "environment" },
            config,
            qrCodeSuccessCallback
        ).catch(err => {
            console.error("Camera start failed:", err);
            alert("Camera access error: " + err);
        });
    }

    document.addEventListener('DOMContentLoaded', startScanner);
</script>
</body>
</html>
