<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DSWD 75th Anniversary | Diamond Jubilee</title>
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
            background: linear-gradient(rgba(194, 217, 247, 0.85), rgba(0, 78, 102, 0.85)),
                        url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/storage/images/anniv.jpg'))) }}');
            background-color: var(--dswd-blue);
            color: white;
            text-align: center;
            padding: 100px 20px 150px;
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
            font-size: 1.4rem;
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

        /* Attendance Form */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .full-width { grid-column: span 2; }

        label {
            font-weight: bold;
            font-size: 0.9rem;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn-submit {
            background: var(--dswd-red);
            color: white;
            border: none;
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
            transition: background 0.3s;
        }

        .btn-submit:hover { background: #a00000; }

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

        @media (max-width: 768px) {
            .form-grid { grid-template-columns: 1fr; }
            .full-width { grid-column: span 1; }
            h1 { font-size: 2rem; }
        }
    </style>
</head>
<body>

    <div class="gov-bar">Department of Social Welfare and Development Field Office III</div>

    <header>
        <div class="anniversary-logo">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/storage/images/anniv_logo.png'))) }}" alt="DSWD 75th Logo">
        </div>
        <h1>DIAMOND JUBILEE</h1>
        <p class="theme-tagline">"75 Years of Maagap at Mapagkalingang Serbisyo"</p>
    </header>

    <div class="main-container">

        <section class="card">
            <h2 class="section-title">FUN RUN (DSWD 75TH ANNIVERSARY)</h2>
            <p>In celebration of the Department of Social Welfare and Development’s (DSWD) 75th Founding Anniversary, the Disaster Response Management Division (DRMD) will spearhead a Fun Run Activity on 25 February 2026 (Wednesday), 4:00 AM at the Diosdado Macapagal Government Center, Maimpis, City of San Fernando, Pampanga.

                This activity aims to promote health, wellness, camaraderie, and solidarity among the staff of DSWD Field Office III – Central Luzon while commemorating this milestone anniversary.

                Participation Guidelines

                All interested staff are encouraged to join and actively participate. Participants are required to: Prepare their own Personnel Locator Slip (PLS) or Request for Authority  to Travel (RFA) documents. Accomplish and sign a Health Consent Form . Proper running attire and hydration are advised. </p>
        </section>

        <section class="card">
            <h2 class="section-title">Registration</h2>
            <form>
                <div class="form-grid">
                    <div class="full-width">
                        <label>Complete Name</label>
                        <input type="text" placeholder="Dela Cruz, Juan A." required>
                    </div>
                    <div>
                        <label>Office / Region</label>
                        <select>
                            <option>Central Office</option>
                            <option>Field Office VII</option>
                            <option>Field Office NCR</option>
                        </select>
                    </div>
                    <div>
                        <label>Position</label>
                        <input type="text" placeholder="Social Welfare Officer">
                    </div>
                    <div class="full-width">
                        <label>Special Requirements (Dietary/Accessibility)</label>
                        <input type="text" placeholder="e.g. No seafood / PWD Access">
                    </div>
                </div>
                <button type="submit" class="btn-submit">CONFIRM ATTENDANCE</button>
            </form>
        </section>

        <section class="card">
            <h2 class="section-title">Schedule of Activities</h2>
            <table>
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Activity</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>08:00 AM</td><td><strong>Thanksgiving Mass</strong> - Chapel of Hope</td></tr>
                    <tr><td>10:00 AM</td><td><strong>The Diamond Awards</strong> - Grand Ballroom</td></tr>
                    <tr><td>02:00 PM</td><td><strong>Legacy Exhibit Opening</strong> - Hall of Heritage</td></tr>
                    <tr><td>06:00 PM</td><td><strong>Gala Night</strong> - (Formal Attire Required)</td></tr>
                </tbody>
            </table>
        </section>

    </div>

    <footer>
        <p><strong>DEPARTMENT OF SOCIAL WELFARE AND DEVELOPMENT</strong><br>
        IBP Road, Constitution Hills, Quezon City, Philippines<br>
        © 1951 - 2026 Diamond Jubilee Committee</p>
    </footer>

</body>
</html>


 {{--                       <option value="OFFICE OF THE ARD FOR ADMINISTRATION">OFFICE OF THE ASSISTANT REGIONAL DIRECTOR FOR ADMINISTRATION</option>
                            <option value="OFFICE OF THE ARD FOR OPERATIONS">OFFICE OF THE ASSISTANT REGIONAL DIRECTOR FOR OPERATIONS</option>

                            <option value="SWAD - AURORA">SWAD - AURORA</option>
                            <option value="SWAD - BATAAN">SWAD - BATAAN</option>
                            <option value="SWAD - BULACAN">SWAD - BULACAN</option>
                            <option value="SWAD - NUEVA ECIJA">SWAD - NUEVA ECIJA</option>
                            <option value="SWAD - PAMPANGA">SWAD - PAMPANGA</option>
                            <option value="SWAD - TARLAC">SWAD - TARLAC</option>
                            <option value="SWAD - ZAMBALES">SWAD - ZAMBALES</option>
                            <option value="SWAD - ZAMBALES">RHFG</option>
                            <option value="SWAD - ZAMBALES">RRCY</option>
                            <option value="SWAD - ZAMBALES">RSCC</option>
                            <option value="SWAD - ZAMBALES">AMORV</option>
                            <option value="SWAD - ZAMBALES">TLC</option>
                            <option value="SWAD - ZAMBALES">THFW</option>
                            <option value="SWAD - ZAMBALES">HAVEN</option> --}}
