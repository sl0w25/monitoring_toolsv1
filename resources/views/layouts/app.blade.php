<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DSWD 75th Anniversary | Diamond Jubilee')</title>

    <style>
        :root {
            --dswd-blue: #003366;
            --dswd-red: #cc0000;
            --gold-gradient: linear-gradient(45deg, #bf953f, #fcf6ba, #b38728, #fbf5b7, #aa771c);
            --gold-solid: #d4af37;
            --light-gray: #f4f7f6;
        }

        body {
            font-family: 'Georgia', serif;
            margin: 0;
            background-color: var(--light-gray);
            color: #333;
            line-height: 1.6;
        }

        /* Top Government Bar */
        .gov-bar {
            background: #222;
            color: white;
            padding: 8px 10%;
            font-size: 11px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Hero Section */
        header {
            background: linear-gradient(rgba(101, 170, 212, 0.85), rgba(0, 78, 102, 0.85)),
                        url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/storage/images/anniv.jpg'))) }}');
            background-color: var(--dswd-blue);
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
            padding: 80px 20px 120px;
            border-bottom: 6px solid var(--gold-solid);
        }

        .anniversary-logo {
            width: 180px;
            height: 180px;
            background: white;
            border-radius: 50%;
            margin: 0 auto 20px;
            border: 4px solid var(--gold-solid);
            box-shadow: 0 0 25px rgba(212, 175, 55, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .anniversary-logo img { width: 90%; height: auto; }

        h1 {
            font-size: 3rem;
            margin: 10px 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .theme-tagline {
            font-style: italic;
            font-size: 1.8rem;
            color: var(--gold-solid);
            max-width: 700px;
            margin: 0 auto;
        }

        /* Main Content Container */
        .main-container {
            max-width: 1000px;
            margin: -80px auto 50px;
            padding: 0 20px;
        }


        /* Section Cards */
        .card {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 40px;
        }

        .section-title {
            color: var(--dswd-blue);
            text-align: center;
            border-bottom: 2px solid var(--gold-solid);
            display: inline-block;
            margin-bottom: 30px;
            width: 100%;
            padding-bottom: 10px;
        }

        .section-address {
            color: #555;
            text-align: center;
            border-bottom: 2px solid #174655;
            display: inline-block;
            margin-bottom: 5px;
            width: 100%;
            padding-bottom: 10px;
            grid-column: span 4;
        }

        /* Attendance Form */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .full-width { grid-column: span 2; }
        .full-width2 { grid-column: span 4; }

        label {
            font-weight: bold;
            font-size: 0.9rem;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn-submit {
            background: linear-gradient(135deg, #9c2828, #750e0ed3);
            color: white;
            border: none;
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
            transition: background 0.3s;
            border-radius: 20px;
        }


        .privacy-link {
            color: #003366 !important;
            text-decoration: underline !important;
            cursor: pointer !important;
        }

        .privacy-link:hover { opacity: 0.8; }

        .btn-submit:hover {
            background: #a00000;
            background-position: right center;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
        }

        /* Schedule Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th { background: var(--dswd-blue); color: white; padding: 15px; text-align: left; }
        td { padding: 15px; border-bottom: 1px solid #eee; }
        tr:nth-child(even) { background: #fdfdfd; }

        /* Footer */
        footer {
            background: #222;
            color: #aaa;
            text-align: center;
            padding: 40px 20px;
            font-size: 0.8rem;
        }

        .sex-group {
                display: flex;
                flex-direction: row; /* horizontal line */
                gap: 12px;           /* space between options */
                flex-wrap: wrap;      /* wrap to next line if too narrow */
                align-items: center;
            }

            .sex-group label {
                display: flex;
                align-items: center;
                gap: 6px; /* space between radio and text */
            }


        /* ===================== */
        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .main-container { padding: 0 15px; }
            h1 { font-size: 2.5rem; }
            .theme-tagline { font-size: 1.5rem; }
        }

        @media (max-width: 768px) {
            .form-grid { grid-template-columns: 1fr; }
            .full-width { grid-column: span 1; }
            .full-width2 { grid-column: span 1; }
            h1 { font-size: 2rem; }
            .theme-tagline { font-size: 1.2rem; }
            header { padding: 60px 20px 100px; }
            table, th, td { font-size: 0.85rem; }
            .form-grid { grid-template-columns: 1fr;}
            .full-width, .full-width2 { grid-column: span 1; }
            select { width: 100%; font-size: 0.95rem; padding: 10px; }
            label { font-size: 0.9rem; }
        }

        @media (max-width: 480px) {
            header { padding: 50px 15px 80px; }
            .anniversary-logo { width: 140px; height: 140px; }
            h1 { font-size: 1.6rem; }
            .theme-tagline { font-size: 1rem; }
            .card { padding: 20px; }
            input, select, textarea { padding: 10px; font-size: 0.9rem; }
            .btn-submit { padding: 12px 20px; font-size: 1rem; width: 100%;}
            .button-group { flex-direction: column; gap: 15px; }
            .sex-group {
                    display: flex;
                    flex-direction: row; /* horizontal line */
                    gap: 60px;           /* space between options */
                    flex-wrap: wrap;      /* wrap to next line if too narrow */
                    align-items: center;
                }

                .sex-group label {
                    display: flex;
                    align-items: center;
                    gap: 0px; /* space between radio and text */
                }
                 #interactive video {
                    transform: scaleX(-1); /* horizontal flip */
                }

        }

    </style>

    @yield('styles')
</head>
<body>

    <div class="gov-bar">Department of Social Welfare and Development Field Office III</div>

    <header>
        <div class="anniversary-logo">
            @yield('header-logo')
        </div>
        <h1>@yield('header-title', 'DSWD 75TH ANNIVERSARY')</h1>
        <p class="theme-tagline">@yield('header-tagline', '75 Years of Maagap at Mapagkalingang Serbisyo')</p>
    </header>

    <div class="main-container">
        @yield('content')
    </div>

    <footer>
        <p><strong>DEPARTMENT OF SOCIAL WELFARE AND DEVELOPMENT FIELD OFFICE III</strong><br>
        Government Center, Maimpis, City of San Fernando, Pampanga, 2000, Philippines<br>
        © 1951 - 2026 POWERED BY DRIMS</p>
    </footer>

    @yield('scripts')
</body>
</html>
