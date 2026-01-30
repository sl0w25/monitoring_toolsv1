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
            grid-template-columns: 1fr 1fr 1fr 1fr;
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
            <p stly="margin-top: 20px;"><i><small>In celebration of the <b>Department of Social Welfare and Development’s (DSWD) 75th Founding Anniversary,</b> the <b>Disaster Response Management Division (DRMD)</b> will spearhead a <b>Fun Run Activity on 25 February 2026 (Wednesday), 4:00 AM</b> at the <b>Diosdado Macapagal Government Center, Maimpis, City of San Fernando, Pampanga.</b><br><br>

                This activity aims to promote health, wellness, camaraderie, and solidarity among the staff of <b>DSWD Field Office III – Central Luzon</b> while commemorating this milestone anniversary.<br><br>

                Participation Guidelines<br><br>

                All interested staff are encouraged to join and actively participate. Participants are required to: Prepare their own <b>Personnel Locator Slip (PLS)</b> or <b>Request for Authority  to Travel (RFA)</b> documents. Accomplish and sign a <b>Health Consent Form</b> . Proper running attire and hydration are advised. </i></p>
            </small>
            </section>

        <section class="card">
            <h2 class="section-title">Registration</h2>
            <form>
                <div class="form-grid">
                    <div>
                        <label>First Name</label>
                        <input type="text" placeholder="Juan" required>
                    </div>
                    <div>
                        <label>Middle Name</label>
                        <input type="text" placeholder="Andress" required>
                    </div>
                    <div>
                        <label>Last Name</label>
                        <input type="text" placeholder="Dela Cruz" required>
                    </div>
                    <div>
                        <label>Ext. Name</label>
                        <input type="text" placeholder="JR." >
                    </div>
                    <div class="full-width">
                        <label>Division/Office</label>
                        <select id="division" required>
                            <option value="" disabled selected>-- SELECT --</option>

                            <option value="ADMINISTRATIVE DIVISION">ADMINISTRATIVE DIVISION</option>
                            <option value="HUMAN RESOURCE AND MANAGEMENT DIVISION">HUMAN RESOURCE AND MANAGEMENT DIVISION</option>
                            <option value="FINANCE MANAGEMENT DIVISION">FINANCE MANAGEMENT DIVISION</option>
                            <option value="DISASTER RESPONSE AND MANAGEMENT DIVISION">DISASTER RESPONSE AND MANAGEMENT DIVISION</option>
                            <option value="POLICY AND PLANS DIVISION">POLICY AND PLANS DIVISION</option>
                            <option value="PROTECTIVE SERVICES DIVISION">PROTECTIVE SERVICES DIVISION</option>
                            <option value="PROMOTIVE SERVICES DIVISION">PROMOTIVE SERVICES DIVISION</option>
                            <option value="PANTAWID PAMILYANG PILIPINO PROGRAM">PANTAWID PAMILYANG PILIPINO PROGRAM</option>
                            <option value="INNOVATIONS DIVISION">INNOVATIONS DIVISION</option>
                            <option value="OFFICE OF THE FIELD DIRECTOR">OFFICE OF THE FIELD DIRECTOR</option>
                            <option value="SWAD OFFICES">SWAD OFFICES</option>
                            <option value="CRCF's">CRCF's</option>
                        </select>
                    </div>

                    <div class="full-width">
                        <label>Section/Unit/Program/Center</label>
                        <select id="section" required>
                            <option value="" disabled selected>-- SELECT --</option>
                        </select>
                    </div>

                    <div class="full-width">
                        <label>Contact Number</label>
                        <input type="text" placeholder="Your Contact Number" required>
                    </div>

                    <div class="full-width">
                        <label>Sex</label>

                        <div style="display: flex; gap: 16px;">
                            <label style="display: flex; align-items: center; gap: 6px;">
                                <input type="radio" name="sex" value="Male" required>
                                Male
                            </label>

                            <label style="display: flex; align-items: center; gap: 6px;">
                                <input type="radio" name="sex" value="Female">
                                Female
                            </label>
                        </div>
                    </div>


                    <div class="full-width">
                        <label>In Case of Emergency <small style="color: rgb(219, 86, 86)">(contact person)</small></label>
                        <input type="text" placeholder="Full Name" required>
                    </div>

                    <div class="full-width">
                        <label>In Case of Emergency <small style="color: rgb(219, 86, 86)">(contact number)</small></label>
                        <input type="text" placeholder="Contact Number" required>
                    </div>

                    <div class="full-width2">
                        <label style="display: block; margin-bottom: 8px;">Race Category</label>

                        <div style="display: flex; flex-direction: column; gap: 10px; align-items: flex-start;">
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; white-space: nowrap;">
                                <input type="radio" name="category_race" value="5km_20_35" required>
                                5 km – 20 to 35 years old
                            </label>

                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; white-space: nowrap;">
                                <input type="radio" name="category_race" value="5km_36_above">
                                5 km – 36 years old and above
                            </label>

                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; white-space: nowrap;">
                                <input type="radio" name="category_race" value="3km_20_35">
                                3 km – 20 to 35 years old
                            </label>

                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; white-space: nowrap;">
                                <input type="radio" name="category_race" value="3km_36_above">
                                3 km – 36 years old and above
                            </label>
                        </div>
                    </div>

                    <div class="full-width2">
                        <label>Health Consent Form</label>
                        <input type="file" placeholder="Dela Cruz, Juan A." required>
                    </div>

                    <div class="full-width2">
                        <div style="margin-top: 20px; margin-bottom: 20px;">
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                                <input type="checkbox" name="data_privacy" id="dataPrivacyCheck" required
                                    style="width: 18px; height: 18px; border: 1px solid #ddd; border-radius: 4px; cursor: pointer;">
                                <span style="font-size: 0.95rem; color: #555;">
                                    I have read and agree to the
                                    <a href="#" id="openPrivacyModal" style="color: #003366; text-decoration: underline;">Data Privacy Notice</a>.
                                </span>
                            </label>
                        </div>
                    </div>


                    <!-- MODAL -->
                    <div id="privacyModal" style="
                            display: none;
                            position: fixed;
                            top: 0; left: 0; right: 0; bottom: 0;
                            background: rgba(0,0,0,0.6);
                            justify-content: center;
                            align-items: center;
                            z-index: 9999;
                        ">
                        <div style="
                                background: #fff;
                                max-width: 600px;
                                width: 90%;
                                padding: 30px;
                                border-radius: 8px;
                                position: relative;
                                box-shadow: 0 10px 25px rgba(0,0,0,0.3);
                                max-height: 80vh;
                                overflow-y: auto;
                            ">
                            <h2 style="margin-top: 0; color: #003366;">Data Privacy Notice</h2>
                            <p style="color: #555; line-height: 1.5;">
                                The DSWD FO III complies with the Data Privacy Act of 2012 and is committed in protecting your privacy. For the purpose of this activity, the HRMDD will collect personal information for the purpose of documentation. Information collected will be stored for as long as necessary. By filling out the form, you are consenting to the collection, use and retention of your personal information.
                            </p>
                            <button id="closePrivacyModal" style="
                                    position: absolute;
                                    top: 10px;
                                    right: 10px;
                                    background: #cc0000;
                                    color: #fff;
                                    border: none;
                                    padding: 6px 12px;
                                    border-radius: 4px;
                                    cursor: pointer;
                                ">
                                Close
                            </button>
                        </div>
                    </div>

                {{-- <div class="full-width">
                    <label>Region</label>
                    <select id="region" required>
                        <option value="">-- SELECT --</option>
                    </select>
                </div>

                <div class="full-width">
                    <label>Province</label>
                    <select id="province" required disabled>
                        <option value="">-- SELECT --</option>
                    </select>
                </div>

                <div class="full-width">
                    <label>Municipality</label>
                    <select id="municipality" required disabled>
                        <option value="">-- SELECT --</option>
                    </select>
                </div>

                <div class="full-width">
                    <label>Barangay</label>
                    <select id="barangay" required disabled>
                        <option value="">-- SELECT --</option>
                    </select>
                </div> --}}
                </div>
                <button type="submit" class="btn-submit">REGISTER</button>
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
                    <tr><td>04:00 AM</td><td><strong>Attendance</strong> - Bren Z. Guiao Convention Center</td></tr>
                    <tr><td>10:00 AM</td><td><strong>Awarding of the Winner</strong> - Bren Z. Guiao Convention Center</td></tr>
                    <tr><td>05:00 PM</td><td><strong>Closing</strong> - Sports Complex</td></tr>
                </tbody>
            </table>
        </section>

    </div>

    <footer>
        <p><strong>DEPARTMENT OF SOCIAL WELFARE AND DEVELOPMENT FIELD OFFICE III</strong><br>
        Government Center, Maimpis, City of San Fernando, Pampanga, 2000, Philippines<br>
        © 1951 - 2026</p>
    </footer>

</body>
</html>

<script>
document.addEventListener('DOMContentLoaded', () => {

    const divisionSelect = document.getElementById('division')
    const sectionSelect  = document.getElementById('section')
    const openModal = document.getElementById('openPrivacyModal');
    const closeModal = document.getElementById('closePrivacyModal');
    const modal = document.getElementById('privacyModal');
    // const regionSelect = document.getElementById('region')
    // const provinceSelect = document.getElementById('province')
    // const municipalitySelect = document.getElementById('municipality')
    // const barangaySelect = document.getElementById('barangay')

    const API = 'https://psgc.gitlab.io/api'

    const sectionOptions = {
        "ADMINISTRATIVE DIVISION": [
            "OFFICE OF THE DIVISION CHIEF",
            "PROCUREMENT AND BAC SECTION",
            "PROPERTY AND SUPPLY SECTION",
            "RECORDS AND ARCHIVES MANAGEMENT SECTION",
            "BUILDING AND GROUND SECTION",
            "GENERAL SERVICES SECTION"
        ],
        "HUMAN RESOURCE AND MANAGEMENT DIVISION": [
            "OFFICE OF THE DIVISION CHIEF",
            "LEARNING AND DEVELOPMENT SECTION",
            "HUMAN RESOURCE WELFARE SECTION",
            "PERSONNEL SECTION",
            "CLINIC",
            "HRPPMS"
        ],
        "FINANCE MANAGEMENT DIVISION": [
            "OFFICE OF THE DIVISION CHIEF",
            "ACCOUNTING SECTION",
            "ACCOUNTING LIQUIDATION",
            "BUDGET SECTION",
            "BUDGET REVIEWER",
            "CASH SECTION",
            "CASH RELEASING",
            "COMMISSION ON AUDIT (COA)",
            "HYBRID"
        ],
        "DISASTER RESPONSE AND MANAGEMENT DIVISION": [
            "OFFICE OF THE DIVISION CHIEF",
            "DISASTER RESPONSE AND REHABILITATION SECTION",
            "DISASTER RESPONSE AND INFORMATION MANAGEMENT SECTION",
            "REGIONAL RESOURCE OPERATION SECTION"
        ],
        "POLICY AND PLANS DIVISION": [
            "OFFICE OF THE DIVISION CHIEF",
            "REGIONAL INFORMATION AND COMMUNICATION MANAGEMENT SECTION",
            "NATIONAL HOUSEHOLD TARGETING SYSTEM",
            "STANDARDS SECTION",
            "RESEARCH AND DEVELOPMENT SECTION"
        ],
        "PROTECTIVE SERVICES DIVISION": [
            "OFFICE OF THE DIVISION CHIEF",
            "COMMUNITY BASED SECTION",
            "CRISIS INTERVENTION SECTION",
            "SUPPLEMENTAL FEEDING PROGRAM",
            "SOCIAL PENSION",
            "MINORS TRAVELLING ABROAD",
            "CENTER BASED SERVICES SECTION"
        ],
        "PROMOTIVE SERVICES DIVISION": [
            "OFFICE OF THE DIVISION CHIEF",
            "SUSTAINABLE LIVELIHOOD PROGRAM",
            "KALAHI"
        ],
        "PANTAWID PAMILYANG PILIPINO PROGRAM": [
            "OFFICE OF THE DIVISION CHIEF",
            "RPMO",
            "ICT PANTAWID"
        ],
        "INNOVATIONS DIVISION": [
            "OFFICE OF THE DIVISION CHIEF",
            "STU",
            "TBTP",
            "PAG-ABOT",
            "EPAHP"
        ],
        "OFFICE OF THE FIELD DIRECTOR": [
            "OFFICE OF THE REGIONAL DIRECTOR",
            "OFFICE OF THE ASSISTANT REGIONAL DIRECTOR FOR ADMINISTRATION",
            "OFFICE OF THE ASSISTANT REGIONAL DIRECTOR FOR OPERATIONS",
            "TAAORSS"
        ],
        "SWAD OFFICES": [
            "SWAD - AURORA",
            "SWAD - BATAAN",
            "SWAD - BULACAN",
            "SWAD - NUEVA ECIJA",
            "SWAD - TARLAC",
            "SWAD - PAMPANGA",
            "SWAD - ZAMBALES"
        ],
        "CRCF's": [
            "AMORV",
            "HAVEN",
            "RHFG",
            "RRCY",
            "RSCC",
            "THFW",
            "TLC"
        ]
    }

    /* ---------------- Division → Section ---------------- */

    resetSelect(sectionSelect)

    divisionSelect.addEventListener('change', () => {
        resetSelect(sectionSelect)

        const division = divisionSelect.value

        if (sectionOptions[division]) {
            sectionSelect.disabled = false

            sectionOptions[division].forEach(section => {
                const option = document.createElement('option')
                option.value = section
                option.textContent = section
                sectionSelect.appendChild(option)
            })
        }
    })

    openModal.addEventListener('click', (e) => {
        e.preventDefault();
        modal.style.display = 'flex';
    });

    closeModal.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // Optional: close modal when clicking outside content
    modal.addEventListener('click', (e) => {
        if (e.target === modal) modal.style.display = 'none';
    });

    // /* ---------------- Region → Province → Municipality → Barangay ---------------- */

    // fetch(`${API}/regions/`)
    //     .then(res => res.json())
    //     .then(data => {
    //         data.forEach(region => {
    //             regionSelect.appendChild(
    //                 new Option(region.name, region.code)
    //             )
    //         })
    //     })

    // regionSelect.addEventListener('change', () => {
    //     resetSelect(provinceSelect)
    //     resetSelect(municipalitySelect)
    //     resetSelect(barangaySelect)

    //     fetch(`${API}/regions/${regionSelect.value}/provinces/`)
    //         .then(res => res.json())
    //         .then(data => {
    //             provinceSelect.disabled = false
    //             data.forEach(p => {
    //                 provinceSelect.appendChild(
    //                     new Option(p.name, p.code)
    //                 )
    //             })
    //         })
    // })

    // provinceSelect.addEventListener('change', () => {
    //     resetSelect(municipalitySelect)
    //     resetSelect(barangaySelect)

    //     fetch(`${API}/provinces/${provinceSelect.value}/cities-municipalities/`)
    //         .then(res => res.json())
    //         .then(data => {
    //             municipalitySelect.disabled = false
    //             data.forEach(m => {
    //                 municipalitySelect.appendChild(
    //                     new Option(m.name, m.code)
    //                 )
    //             })
    //         })
    // })

    // municipalitySelect.addEventListener('change', () => {
    //     resetSelect(barangaySelect)

    //     fetch(`${API}/cities-municipalities/${municipalitySelect.value}/barangays/`)
    //         .then(res => res.json())
    //         .then(data => {
    //             barangaySelect.disabled = false
    //             data.forEach(b => {
    //                 barangaySelect.appendChild(
    //                     new Option(b.name, b.code)
    //                 )
    //             })
    //         })
    // })

    /* ---------------- Helper ---------------- */

    function resetSelect(select) {
        select.innerHTML = '<option value="">-- SELECT --</option>'
        select.disabled = true
    }

})
</script>

