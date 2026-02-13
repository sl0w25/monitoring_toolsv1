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
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            background-color: var(--light-gray);
            color: #333;
            line-height: 1.6;
        }

        input {
            font-family: "Roboto", Arial, sans-serif;
            font-size: 16px;
            font-weight: 400;
            color: #222;
        }

        .gradient-text {
        background: linear-gradient(90deg, #bf953f, #fcf6ba, #b38728, #fbf5b7);
        background-size: 300% 300%;

        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;

        background-clip: text;
        color: transparent;

        animation: gradientMove 5s ease infinite;
    }

    /* Animate Gradient */
    @keyframes gradientMove {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }


        /* Top Government Bar */
.gov-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #222;
    color: white;
    padding: 8px 10%;
    font-size: 11px;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.gov-bar .attendance-link {
    display: flex;
    align-items: center;
    gap: 5px;           /* space between logo and text */
    color: white;
    text-decoration: none;
    font-weight: 600;
}

.gov-bar .attendance-logo {
    width: 40px;        /* set desired width */
    height: auto;       /* keep aspect ratio */
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
                /* background: white; */
                border-radius: 50%;
                margin: 0 auto 20px;

                border: 4px solid var(--gold-solid);

                /* Base Glow */
                filter: drop-shadow(0 0 12px rgba(212,175,55,0.6))
        drop-shadow(0 0 28px rgba(212,175,55,0.4));


                display: flex;
                align-items: center;
                justify-content: center;

                overflow: hidden;
                position: relative;

                /* Soft Pulse */
                animation: glowPulse 3s ease-in-out infinite;
            }

            /* Light Sweep Overlay */
            .anniversary-logo::before {
                content: "";
                position: absolute;
                inset: -50%;
                opacity: 0.7;

                background: linear-gradient(
                    120deg,
                    transparent 35%,
                    rgba(255,255,255,0.9) 45%,
                    rgba(255,255,255,0.4) 50%,
                    transparent 60%
                );

                transform: rotate(0deg);
                animation: shineSweep 4s linear infinite;

                pointer-events: none;
            }

            /* Diamond Sparkle Layer */
            .anniversary-logo::after {
                content: "";
                position: absolute;
                inset: 0;

                background:
                    radial-gradient(circle at 20% 30%, rgba(255,255,255,0.8), transparent 40%),
                    radial-gradient(circle at 70% 60%, rgba(255,255,255,0.6), transparent 45%),
                    radial-gradient(circle at 40% 80%, rgba(255,255,255,0.5), transparent 50%);

                mix-blend-mode: screen;
                opacity: 0.2;

                animation: sparkleMove 3s ease-in-out infinite;

                pointer-events: none;
            }


            /* Glow Pulse Animation */
            @keyframes glowPulse {
                0%, 100% {
                    box-shadow:
                        0 0 25px rgba(212, 175, 55, 0.5),
                        0 0 45px rgba(212, 175, 55, 0.3);
                }

                50% {
                    box-shadow:
                        0 0 40px rgba(212, 175, 55, 0.8),
                        0 0 70px rgba(212, 175, 55, 0.6);
                }
            }

            /* Rotating Shine */
            @keyframes shineRotate {
                from {
                    transform: rotate(0deg);
                }
                to {
                    transform: rotate(360deg);
                }
            }

            /* 3D Container */
            .logo-3d {
                width: 200px;
                aspect-ratio: 1 / 1;

                margin: auto;

                perspective: 1000px; /* 3D depth */

                display: flex;
                justify-content: center;
                align-items: center;
            }

            /* Image */
            .logo-3d img {
                width: 100%;
                height: auto;

                transform-style: preserve-3d;

                animation: floatRotate 6s ease-in-out infinite;

                filter: drop-shadow(0 15px 25px rgba(0,0,0,0.5));
            }

            /* Animation */
            @keyframes floatRotate {
                0% {
                    transform:
                        rotateX(0deg)
                        rotateY(0deg)
                        translateY(0px);
                }

                25% {
                    transform:
                        rotateX(12deg)
                        rotateY(18deg)
                        translateY(-8px);
                }

                50% {
                    transform:
                        rotateX(0deg)
                        rotateY(36deg)
                        translateY(-12px);
                }

                75% {
                    transform:
                        rotateX(-10deg)
                        rotateY(18deg)
                        translateY(-8px);
                }

                100% {
                    transform:
                        rotateX(0deg)
                        rotateY(0deg)
                        translateY(0px);
                }
            }


            /* .anniversary-logo:hover {
                animation-duration: 1.5s;
                transform: scale(1.05);
            } */

            /* Light Sweep Motion */
            @keyframes shineSweep {
                0% {
                    transform: translateX(-100%) rotate(25deg);
                }

                100% {
                    transform: translateX(100%) rotate(25deg);
                }
            }

            /* Sparkle Movement */
            @keyframes sparkleMove {
                0%, 100% {
                    opacity: 0.4;
                    transform: scale(1);
                }

                50% {
                    opacity: 0.9;
                    transform: scale(1.05);
                }
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
            /* color: var(--gold-solid); */
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
            opacity: 0;
            transform: translateX(60px);
            animation: cardSlideIn 0.9s ease-out forwards;
        }


            /* Optional stagger effect */
            .card:nth-child(1) { animation-delay: 0.2s; }
            .card:nth-child(2) { animation-delay: 0.4s; }
            .card:nth-child(3) { animation-delay: 0.6s; }
            .card:nth-child(4) { animation-delay: 0.8s; }

            /* Keyframes */
            @keyframes cardSlideIn {
                from {
                    opacity: 0;
                    transform: translateX(60px);
                }

                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

        .section-title {
            color: var(--dswd-blue);
            text-align: center;
            border-bottom: 2px solid var(--gold-solid);
            display: inline-block;
            margin-bottom: 30px;
            width: 100%;
            padding-bottom: 10px;
            padding-top: 1px;
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

        select, ::picker(select) {
            appearance: base-select;
            width: 450px;
            overflow: hidden;
        }

        ::picker(select) {
            border: 0;
            margin: .1rem 0;
            box-shadow: 0 0 5px rgba(0,0,0, .15);
        }

        option {
            font-family: 'Times New Roman', serif;
            font-size: 15px;
            padding: 5px;
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
            .qr-box {
                flex-shrink: 0;
                transform: scale(4);
                transform-origin: top right;
                        }


            /* LOADING SPINNER */
            .loader {
                width: 50px;
                height: 50px;
                border: 6px solid #ddd;
                border-top: 6px solid #003366;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }

            .qr-container svg {
                width: 200px;   /* set desired width */
                height: 200px;  /* set desired height */
            }

            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }



                    /* Header Container */
            .animated-header {
                text-align: center;
                padding: 90px 5px;
            }

            /* Base Animation Setup */
            .fade-in,
            .slide-down,
            .fade-up {
                opacity: 0;
                animation-fill-mode: forwards;
            }

            /* Logo Fade In */
            .fade-in {
                animation: fadeIn 1s ease-in-out forwards;
            }

            /* Title Slide Down */
            .slide-down {
                animation: slideDown 1s ease-out forwards;
                animation-delay: 0.3s;
            }

            /* Tagline Fade Up */
            .fade-up {
                animation: fadeUp 1s ease-out forwards;
                animation-delay: 0.6s;
            }

            /* Keyframes */

            @keyframes fadeIn {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }

            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes fadeUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Gradient Base */
.gradient-text {
    background: linear-gradient(
        90deg,
        #b38728,
        #fcf6ba,
        #fff6cc,
        #b38728
    );

    background-size: 300% 300%;

    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;

    background-clip: text;
    color: transparent;
}

/* Shining Animation */
.shine-text {
    position: relative;

    animation: textShine 4s linear infinite,
               textGlow 2.5s ease-in-out infinite;
}

/* Moving Light */
@keyframes textShine {
    0% {
        background-position: 0% 50%;
    }

    100% {
        background-position: 300% 50%;
    }
}

/* Soft Glow Pulse */
@keyframes textGlow {
    0%, 100% {
        filter: drop-shadow(0 0 3px rgba(212,175,55,0.4))
                drop-shadow(0 0 6px rgba(212,175,55,0.2));
    }

    50% {
        filter: drop-shadow(0 0 6px rgba(212,175,55,0.8))
                drop-shadow(0 0 12px rgba(212,175,55,0.5));
    }
}

        .map-crop {
            width: 100%;
            height: 450px;      /* Visible area (crop height) */
            overflow: hidden;  /* Hides excess */
            position: relative;
            border-radius: 12px; /* Optional */
        }

        .map-crop iframe {
            width: 100%;
            height: 500px;     /* Bigger than container */
            border: 0;

            /* Move iframe up/down/left/right */
            transform: translateY(-80px);
        }






        /* ===================== */
        /* RESPONSIVE */
        @media (max-width: 1138px) {
            .main-container { padding: 0 15px; }
            h1 { font-size: 2.5rem; }
            .theme-tagline { font-size: 1.5rem; }
        }


        /* TABLET & MOBILE */
        @media (max-width: 1046px) {
                .qr-box {
                   margin-top: 200px; display: flex; gap: 20px; text-align: center; grid-column: span 1; flex-shrink: 0;
                transform: scale(4);
                transform-origin: top right;
                }
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

    }


    </style>

    @yield('styles')
</head>
<body>

<div class="gov-bar">
    <span class="gov-text">Department of Social Welfare and Development Field Office 3</span>
    <a href="/attendance" class="attendance-link">
        <img src="{{ asset('storage/images/dark_dromic.png') }}" alt="Logo" class="attendance-logo">
        POWERED BY DRIMS
    </a>
</div>





    <header class="animated-header">
        <div class="logo-3d fade-in">
            @yield('header-logo')
        </div>

        <h1 class="slide-down">
            @yield('header-title', 'DSWD 75TH ANNIVERSARY')
        </h1>

        <p class="theme-tagline fade-up gradient-text">
            @yield('header-tagline', '75 Years of Maagap at Mapagkalingang Serbisyo')
        </p>
    </header>


    <div class="main-container">
        @yield('content')
    </div>

    <footer>
        <p><strong>DEPARTMENT OF SOCIAL WELFARE AND DEVELOPMENT FIELD OFFICE 3</strong><br>
        Government Center, Maimpis, City of San Fernando, Pampanga, 2000, Philippines<br>
        © 2026</p>
    </footer>
</body>

</html>
