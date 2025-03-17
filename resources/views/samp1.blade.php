<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Attendance System</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');

        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(to bottom, rgba(255,255,255,0.15) 0%, rgba(0,0,0,0.15) 100%), radial-gradient(at top center, rgba(255,255,255,0.40) 0%, rgba(0,0,0,0.40) 120%) #989898;
            background-blend-mode: multiply,multiply;
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 91.5vh;
        }

        .attendance-container {
            height: 90%;
            width: 90%;
            border-radius: 20px;
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.8);
        }

        .attendance-container > div {
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
            border-radius: 10px;
            padding: 30px;
        }

        .attendance-container > div:last-child {
            width: 64%;
            margin-left: auto;
        }
    </style>
</head>
<body>
 
    <div class="main">
        
        <div class="attendance-container row">
            <div class="qr-container col-4">
                <div class="scanner-con">
                    <h5 class="text-center">Scan your QR Code here</h5>
                    <video id="interactive" class="viewport" width="100%"></video>
                </div>

                  <div class="qr-detected-container" style="display: none;">
                      <h4 class="text-center">Student QR Detected!</h4>
                      <form method="POST" action="{{ route('scan.qr') }}">
                          @csrf
                          <input type="hidden" id="qr_number" name="qr_number">
                      </form>
                  </div>
              </div>

            <div class="attendance-list">
                <h4>List of Paid Beneficiaries</h4>
                <div class="table-container table-responsive">
                    <table class="table text-center table-sm" id="attendanceTable">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Course & Section</th>
                                <th scope="col">Time In</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances as $attendance)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $attendance->student->name }}</td>
                                    <td>{{ $attendance->student->course_section }}</td>
                                    <td>{{ $attendance->time_in }}</td>
                                    <td>
                                        <!-- <button class="btn btn-danger btn-sm" onclick="deleteAttendance({{ $attendance->id }})">Remove</button> -->
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No attendance records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    

    <!-- Bootstrap JS -->
    <script src="{{ asset('js/jquery.slim.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <!-- Instascan JS -->
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <script>
       let scanner;

function startScanner() {
    scanner = new Instascan.Scanner({ video: document.getElementById('interactive') });

    scanner.addListener('scan', function (content) {
        // Set the scanned content to the hidden input
        $("#qr_number").val(content);
        console.log('QR Code Detected:', content);

        // Automatically submit the form
        document.querySelector(".qr-detected-container").submit();
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
</html>
