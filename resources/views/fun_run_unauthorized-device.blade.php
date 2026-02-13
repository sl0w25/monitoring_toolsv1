<!DOCTYPE html>
<html>
<head>
    <title>Unauthorized Device</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            text-align: center;
            padding-top: 100px;
        }

        .box {
            background: white;
            max-width: 400px;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,.1);
        }

        h1 {
            color: #dc3545;
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 10px;
        }

        a {
            display: inline-block;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .countdown {
            font-weight: bold;
            color: #dc3545;
        }
    </style>
</head>
<body>

<div class="box">
    <h1>Unauthorized Device</h1>

    <p>This device is not registered.</p>

    <p>Please contact the administrator.</p>

    <p>Redirecting to registration in <span class="countdown" id="countdown">5</span> seconds...</p>

    <a href="/">Go Back Now</a>

    <p>{{ request()->cookie('device_token') }}</p>
</div>

<script>
    // Countdown timer
    let seconds = 5;
    const countdownEl = document.getElementById('countdown');

    const timer = setInterval(() => {
        seconds--;
        if (seconds <= 0) {
            clearInterval(timer);
            window.location.href = '/';
        } else {
            countdownEl.textContent = seconds;
        }
    }, 1000);
</script>

</body>
</html>
