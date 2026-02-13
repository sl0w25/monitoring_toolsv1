<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Under Maintenance</title>
    <style>
        /* Reset some defaults */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: 'Arial', sans-serif;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
        }

        .container {
            text-align: center;
            padding: 20px;
        }

        .container h1 {
            font-size: 3rem;
            color: #cc0000;
            margin-bottom: 20px;
        }

        .container p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .loader {
            border: 6px solid #f3f3f3;
            border-top: 6px solid #cc0000;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            margin: 0 auto 20px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg);}
            100% { transform: rotate(360deg);}
        }

        .btn-home {
            display: inline-block;
            padding: 12px 25px;
            background: #003366;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s;
        }

        .btn-home:hover {
            background: #0055aa;
        }

        @media (max-width: 500px) {
            .container h1 {
                font-size: 2.2rem;
            }
            .container p {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="loader"></div>
    {{-- <h1>Fun Run Countdown</h1> --}}

    <h1><div id="countdown" style="font-size: 3rem;
            color: #cc0000;
            margin-bottom: 20px;"></div></h1>

    <a href="/" class="btn-home">Go to Registration Page</a>
</div>
</body>
</html>
<script>
    // Set the target date
    const targetDate = new Date("Feb 25, 2026 04:00:00").getTime();

    // Update countdown every 1 second
    const countdownEl = document.getElementById('countdown');
    const interval = setInterval(function() {
        const now = new Date().getTime();
        const distance = targetDate - now;

        if (distance <= 0) {
            clearInterval(interval);
            countdownEl.innerHTML = "The Fun Run has started!";
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        countdownEl.innerHTML =
            days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
    }, 1000);
</script>
