<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DSWD Attendance Monitoring System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', sans-serif; background-color: #f4f7fa; }
        .bg-dswd-blue { background-color: #0038a8; }
        .text-dswd-blue { color: #0038a8; }
        .bg-dswd-red { background-color: #ce1126; }
        .diamond-clip { clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%); }

        /* FIXED SCANNER SIZE LOGIC */
        .scanner-container {
            position: relative;
            border: 4px solid #0038a8;
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 56, 168, 0.2);
            aspect-ratio: 1 / 1; /* Keeps it perfectly square */
            background: #000;
        }

        #interactive {
            width: 100% !important;
            height: 100% !important;
        }

        #interactive video {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important; /* Forces video to fill the square */
            transform: scaleX(-1); /* Mirrors the video */
        }

        /* Scanning HUD */
        .hud-line {
            position: absolute;
            width: 100%;
            height: 3px;
            background: #ce1126;
            box-shadow: 0 0 15px #ce1126;
            animation: scan-move 3s infinite ease-in-out;
            z-index: 20;
            pointer-events: none;
        }
        @keyframes scan-move { 0%, 100% { top: 10%; } 50% { top: 90%; } }

        .table-container { border-top: 6px solid #0038a8; }
        .attendance-logo {
                display: inline-block;
                height: 20px; /* Adjust height as needed */
                width: auto;
                vertical-align: middle;
                margin-right: 6px;
               // filter: grayscale(100%); /* Optional: makes it look more formal/subtle */
                opacity: 0.8;
            }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <nav class="bg-white border-b-2 border-slate-200 px-8 py-3">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-4">
                <img src="{{ asset('storage/images/dswd.png') }}" alt="DSWD Logo" class="h-14">
                <div class="h-10 w-px bg-slate-300"></div>
                <div>
                    <h1 class="text-lg font-black text-dswd-blue leading-none tracking-tighter">Fun Run | 75th Founding Anniversary</h1>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest"></p>
                </div>
            </div>
            <div class="text-right flex items-center gap-4">
                <div class="hidden md:block text-right">
                    <p id="date-display" class="text-xs font-bold text-slate-700"></p>
                    <p id="time-display" class="text-sm font-black text-dswd-blue leading-none mt-1"></p>
                </div>

                    <img src="{{ asset('storage/images/anniv_logo.png') }}" alt="DSWD Logo" class="h-14">

            </div>
        </div>
    </nav>

    <main class="flex-grow container mx-auto p-6 grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white p-6 rounded-[2rem] shadow-xl border border-slate-100">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-black text-slate-800 uppercase tracking-tight">Scanner Portal</h2>
                    <span class="flex items-center gap-1 text-[10px] font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span> ONLINE
                    </span>
                </div>

                <div class="scanner-container">
                    <div id="interactive"></div>
                    <div class="hud-line"></div>
                </div>

                <div class="mt-6 space-y-3 text-center">
                    <div id="success-container" class="hidden p-4 bg-blue-50 text-dswd-blue border border-blue-200 rounded-2xl font-bold animate-pulse text-sm"></div>
                    <div id="error-container" class="hidden p-4 bg-red-50 text-dswd-red border border-red-200 rounded-2xl font-bold text-sm"></div>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em]">QR Detection Active</p>
                </div>
            </div>

            <div class="bg-dswd-blue rounded-[2rem] p-6 text-white shadow-lg relative overflow-hidden">
                <p class="text-xs font-bold opacity-80 uppercase tracking-widest">Total Checked-In</p>
                <p id="total-count" class="text-4xl font-black mt-1">{{ $attendances->total() }}</p>
                <div class="absolute -right-4 -bottom-4 opacity-10">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/4f/DSWD_Logo.png" class="w-32 grayscale invert">
                     <img src="{{ asset('storage/images/dark_dromic.png') }}" alt="Logo" class="attendance-logo">
                </div>
            </div>
        </div>

        <div class="lg:col-span-8">
            <div class="bg-white rounded-[2rem] shadow-xl overflow-hidden h-full flex flex-col table-container">
                <div class="p-6 bg-slate-50/50 border-b border-slate-100">
                    <h3 class="font-black text-slate-800 uppercase tracking-tight">Attendee</h3>
                </div>

                <div class="overflow-x-auto flex-grow">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                <th class="px-6 py-4">Name</th>
                                <th class="px-6 py-4">Division</th>
                                <th class="px-6 py-4">Time</th>
                                <th class="px-6 py-4 text-center">Category</th>
                            </tr>
                        </thead>
                        <tbody id="attendanceTableBody" class="divide-y divide-slate-50">
                            @foreach ($attendances as $attendance)
                            <tr class="hover:bg-blue-50/30 transition-colors">
                                <td class="px-6 py-5">
                                    <div class="font-bold text-slate-800">{{ $attendance->first_name }} {{ $attendance->last_name }}</div>
                                </td>
                                <td class="px-6 py-5 text-xs text-slate-600 font-medium">{{ $attendance->division }}</td>
                                <td class="px-6 py-5 font-mono text-xs text-dswd-blue font-black">{{ $attendance->time_in }}</td>
                                <td class="px-6 py-5 text-center">
                                    <span class="text-[9px] font-bold text-slate-400 uppercase">{{ $attendance->race_category }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-slate-100" id="pagination-links">
                    {{ $attendances->links() }}
                </div>
            </div>
        </div>
    </main>
    <footer class="bg-white border-t-2 border-slate-200 px-8 py-6 text-center mt-auto">
            <div class="max-w-7xl mx-auto">
                <p class="text-xs font-bold text-slate-700 leading-relaxed uppercase tracking-wider">
                    <span class="text-dswd-blue">Department of Social Welfare and Development Field Office 3</span><br>
                    <span class="text-slate-500 font-semibold uppercase">Government Center, Maimpis, City of San Fernando, Pampanga, 2000, Philippines</span><br>

                    <span class="text-[10px] text-slate-400 mt-3 flex items-center justify-center gap-1 italic uppercase">
                        © 2026 •
                        <img src="{{ asset('storage/images/dromic_logo-w.png') }}" alt="DRIMS Logo" class="attendance-logo">
                        Powered by DRIMS
                    </span>
                </p>
            </div>
     </footer>

    <canvas id="qrCaptureCanvas" class="hidden"></canvas>
    <audio id="scanSound" src="{{ asset('storage/sounds/beep.mp3') }}"></audio>
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    <script>
        // Clock
        function updateClock() {
            const now = new Date();
            const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('date-display').innerText = now.toLocaleDateString('en-PH', dateOptions);
            document.getElementById('time-display').innerText = now.toLocaleTimeString('en-PH');
        }
        setInterval(updateClock, 1000);
        updateClock();

        let isScanning = false;

        function refreshTable() {
            fetch("{{ route('attendances.list') }}")
                .then(res => res.json())
                .then(data => {
                    document.getElementById('total-count').innerText = data.attendances.total;
                    const tbody = document.querySelector("#attendanceTableBody");
                    tbody.innerHTML = "";
                    data.attendances.data.forEach(attendance => {
                        const row = document.createElement("tr");
                        row.className = "hover:bg-blue-50/30 transition-colors";
                        row.innerHTML = `
                            <td class="px-6 py-5">
                                <div class="font-bold text-slate-800">${attendance.first_name} ${attendance.last_name}</div>
                                <div class="text-[9px] font-bold text-slate-400 uppercase">${attendance.race_category}</div>
                            </td>
                            <td class="px-6 py-5 text-xs text-slate-600 font-medium">${attendance.division}</td>
                            <td class="px-6 py-5 font-mono text-xs text-dswd-blue font-black">${attendance.time_in || ''}</td>
                            <td class="px-6 py-5 text-center"><span class="inline-block w-2 h-2 bg-green-500 rounded-full"></span></td>
                        `;
                        tbody.appendChild(row);
                    });
                });
        }

        function onScanSuccess(decodedText) {
            if (isScanning) return;
            isScanning = true;

            const scanSound = document.getElementById('scanSound');
            const successBox = document.getElementById('success-container');
            const errorBox = document.getElementById('error-container');

            scanSound.play().catch(() => {});

            const video = document.querySelector("#interactive video");
            const canvas = document.getElementById("qrCaptureCanvas");
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext("2d").drawImage(video, 0, 0, canvas.width, canvas.height);

            const formData = new FormData();
            formData.append('qr_number', decodedText);
            formData.append('imageCapture', canvas.toDataURL("image/png"));

            fetch("{{ route('scan.qr') }}", {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    errorBox.innerHTML = data.error;
                    errorBox.classList.remove('hidden');
                    setTimeout(() => errorBox.classList.add('hidden'), 3000);
                } else {
                    successBox.innerHTML = data.message;
                    successBox.classList.remove('hidden');
                    refreshTable();
                    setTimeout(() => successBox.classList.add('hidden'), 3000);
                }
                setTimeout(() => { isScanning = false; }, 2000);
            })
            .catch(() => { isScanning = false; });
        }

        // Initialize Scanner with simplified config
        const html5QrCode = new Html5Qrcode("interactive");
        const config = { fps: 20, aspectRatio: 1.0 };

        Html5Qrcode.getCameras().then(cameras => {
            if (cameras && cameras.length) {
                // Try rear camera first
                const backCamera = cameras.find(c => c.label.toLowerCase().includes('back') || c.label.toLowerCase().includes('rear'));
                const cameraId = backCamera ? backCamera.id : cameras[0].id;
                html5QrCode.start(cameraId, config, onScanSuccess);
            }
        });
    </script>
</body>
</html>
