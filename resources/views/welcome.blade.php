<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>QR Code Monitoring</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-700 text-gray-800 font-poppins bg-blend-multiply bg-cover bg-fixed" style="background: linear-gradient(to bottom, rgba(255,255,255,0.15) 0%, rgba(0,0,0,0.15) 100%), radial-gradient(at top center, rgba(255,255,255,0.4) 0%, rgba(0,0,0,0.4) 120%) #989898;">
    <div class="flex justify-center items-center h-[91.5vh]">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 w-11/12 h-[90%] bg-white bg-opacity-80 p-10 rounded-2xl shadow-lg">
            <div class="col-span-1 flex flex-col items-center shadow-md rounded-lg p-6 bg-white">
                <h5 class="text-center text-lg font-semibold mb-4">Scan your QR Code here</h5>
                <video id="interactive" class="w-full rounded-md"></video>

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

            <div class="col-span-2 shadow-md rounded-lg p-6 bg-white">
                <h4 class="text-lg font-semibold mb-6">List of Attendees (Beneficiaries)</h4>
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
                                    <td class="px-2 py-1">{{ $loop->iteration }}</td>
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

    <!-- Instascan JS -->
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script>
        let scanner;

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

        function refreshTable(attendances) {
            const tbody = document.querySelector("#attendanceTableBody");
            tbody.innerHTML = "";

            attendances.forEach(attendance => {
                addAttendanceRow(attendance);
            });
        }

        function startScanner() {
            const errorContainer = document.getElementById('error-container');
            const successContainer = document.getElementById('success-container');

            scanner = new Instascan.Scanner({ video: document.getElementById('interactive') });

            scanner.addListener('scan', function (content) {
                console.log('QR Code Scanned:', content);

                errorContainer.classList.add('hidden');
                successContainer.classList.add('hidden');

                const formData = new FormData();
                formData.append('qr_number', content);

                fetch("{{ route('scan.qr') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: formData,
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.error || 'Unexpected error occurred');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Attendance Response:', data);
                    if (data.error) {
                        console.log(data.error);
                        errorContainer.classList.remove('hidden');
                        errorContainer.innerHTML = data.error;
                    } else {
                        successContainer.classList.remove('hidden');
                        successContainer.innerHTML = data.message;
                        refreshTable(data.attendances);
                    }
                })
                .catch(error => {
                    console.log('Error:', error.message);
                    errorContainer.classList.remove('hidden');
                    errorContainer.innerHTML = error.message;
                });
            });

            Instascan.Camera.getCameras()
                .then(function (cameras) {
                    if (cameras.length > 0) {
                        scanner.start(cameras[0]);
                    } else {
                        console.error('No cameras found.');
                        alert('No cameras found.');
                    }
                })
                .catch(function (err) {
                    console.error('Camera access error:', err);
                    alert('Camera access error: ' + err);
                });
        }

        document.addEventListener('DOMContentLoaded', startScanner);
    </script>
</body>
<!-- <footer class="mt-auto text-center">
   <p class="text-bg-light p-2">Copyright &copy; 2022, All Rights reserved</p></span>
   <script src="https://kit.fontawesome.com/0befeeeabe.js" crossorigin="anonymous"></script> -->
</html>
