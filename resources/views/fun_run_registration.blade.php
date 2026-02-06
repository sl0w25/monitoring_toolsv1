@extends('layouts.app')

@section('title', 'DSWD 75th Anniversary | Fun Run')

@section('header-logo')
    <img src="{{ asset('storage/images/anniv_logo.png') }}" alt="DSWD 75th Logo">
@endsection

@section('content')


    <section class="card">
        <h2 class="section-title">TAKBO PARA SA BAGONG HENERASYON</h2>
        <p stly="margin-top: 20px;"><i><medium>In celebration of the <b>Department of Social Welfare and Development’s (DSWD) 75th Founding Anniversary,</b> the <b>Disaster Response Management Division (DRMD)</b> will spearhead a <b>Fun Run Activity on 25 February 2026 (Wednesday), 4:00 AM</b> at the <b>Diosdado Macapagal Government Center, Maimpis, City of San Fernando, Pampanga.</b><br><br>

                This activity aims to promote health, wellness, camaraderie, and solidarity among the staff of <b>DSWD Field Office III – Central Luzon</b> while commemorating this milestone anniversary.<br><br>

                Participation Guidelines<br><br>

                All interested staff are encouraged to join and actively participate. Participants are required to: Prepare their own <b>Personnel Locator Slip (PLS)</b> or <b>Request for Authority  to Travel (RFA)</b> documents. Accomplish and sign a <b>Health Consent Form</b> . Proper running attire and hydration are advised. </i></p>
            </medium>
    </section>


    <section class="card">
        <h2 class="section-title">Registration</h2>
            <form action="{{ route('fun-run.store') }}"
                method="POST"
                enctype="multipart/form-data"
                id="registrationForm">

            @csrf
            @if($errors->any())
            <div style="background:#f8d7da;padding:12px;border-radius:6px;margin-bottom:15px;color:#721c24;">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
                <div class="form-grid">
                    <div class="full-width2">
                        <label>DSWD ID #</label>
                        <input tpye="text" name="dswd_id" class="dswd-id" value="{{ old('dswd_id') }}" placeholder="03-00000" required>
                    </div>

                    <div>
                        <label>First Name</label>
                        <input type="text" name="first_name" class="only-letters" value="{{ old('first_name') }}" placeholder="Juan" required>

                    </div>
                    <div>
                        <label>Middle Name</label>
                        <input type="text" name="middle_name" class="only-letters" value="{{ old('middle_name') }}" placeholder="Andress" required>
                    </div>
                    <div>
                        <label>Last Name</label>
                        <input type="text" name="last_name" class="only-letters" value="{{ old('last_name') }}" placeholder="Dela Cruz" required>
                    </div>
                    <div>
                        <label>Ext. Name</label>
                        <input type="text" name="ext_name" class="only-letters" value="{{ old('ext_name') }}" placeholder="JR." >
                    </div>
                    <div class="full-width">
                        <label>Division/Office</label>
                        <select id="division" name="division" required>
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
                        <select id="section" name="section" required>
                            <option value="" disabled selected>-- SELECT --</option>
                        </select>
                    </div>

                    <div class="full-width">
                        <label>Contact Number</label>
                        <input type="text" name="contact_number" class="numbers-only" value="{{ old('contact_number') }}" placeholder="Your Contact Number" required>
                    </div>

                    <div class="full-width">
                        <label>Sex</label>

                        <div class="sex-group">
                            <label style="display: flex; align-items: center; gap: 6px;">
                                <input type="radio" name="sex" value="Male" required width="23px">
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
                        <input type="text" class="only-letters" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}"  placeholder="Full Name" required>
                    </div>

                    <div class="full-width">
                        <label>In Case of Emergency <small style="color: rgb(219, 86, 86)">(contact number)</small></label>
                        <input type="text" name="emergency_contact_number" class="numbers-only" value="{{ old('emergency_contact_number') }}" placeholder="Contact Number" required>
                    </div>

                    <div class="full-width2">
                       <label style="display: block; margin-bottom: 8px;">
                            Race Category
                            <span id="openMapModal" class="privacy-link text-blue-800 underline cursor-pointer hover:opacity-80" tabindex="0" role="button">
                                (click here to view the map)
                            </span>
                        </label>


                        <div style="display: flex; flex-direction: column; gap: 12px; width: 100%;">

                        <label style="
                            display: flex;
                            align-items: center;
                            gap: 12px;
                            padding: 14px 16px;
                            border: 0px solid #ddd;
                            border-radius: 10px;
                            cursor: pointer;
                            background: #fff;
                            width: 100%;
                            -webkit-tap-highlight-color: transparent;
                        ">
                            <input type="radio" name="race_category" value="5km_20_35" required
                                style="width:20px;height:20px;">
                            <span>5 km – 20 to 35 years old</span>
                        </label>

                        <label style="
                            display: flex;
                            align-items: center;
                            gap: 12px;
                            padding: 14px 16px;
                            border: 0px solid #ddd;
                            border-radius: 10px;
                            cursor: pointer;
                            background: #fff;
                            width: 100%;
                            -webkit-tap-highlight-color: transparent;
                        ">
                            <input type="radio" name="race_category" value="5km_36_above"
                                style="width:20px;height:20px;">
                            <span>5 km – 36 years old and above</span>
                        </label>

                        <label style="
                            display: flex;
                            align-items: center;
                            gap: 12px;
                            padding: 14px 16px;
                            border: 0px solid #ddd;
                            border-radius: 10px;
                            cursor: pointer;
                            background: #fff;
                            width: 100%;
                            -webkit-tap-highlight-color: transparent;
                        ">
                            <input type="radio" name="race_category" value="3km_20_35"
                                style="width:20px;height:20px;">
                            <span>3 km – 20 to 35 years old</span>
                        </label>

                        <label style="
                            display: flex;
                            align-items: center;
                            gap: 12px;
                            padding: 14px 16px;
                            border: 0px solid #ddd;
                            border-radius: 10px;
                            cursor: pointer;
                            background: #fff;
                            width: 100%;
                            -webkit-tap-highlight-color: transparent;
                        ">
                            <input type="radio" name="race_category" value="3km_36_above"
                                style="width:20px;height:20px;">
                            <span>3 km – 36 years old and above</span>
                        </label>

                    </div>

                    </div>

                    <div class="full-width2">
                        <label>Health Consent Form <a href="{{ route('fun-run.download-waiver') }}" target="_blank" class="privacy-link text-blue-800 underline cursor-pointer hover:opacity-80">(click here to download the form)</a></label>
                        {{-- <input type="file" name="health_consent_form" value="{{ old('health_consent_form') }}" placeholder="Health Consent" required> --}}
                        <p style="font-weight: bold;
                                font-size: 0.9rem;
                                color: #555;
                                display: block;
                                margin-bottom: 5px;">Note: Please provide this form with your signature upon attendance.</p>

                    </div>

                    <div class="full-width2">
                        <div style="margin-top: 20px; margin-bottom: 20px;">

                            <div style="display: flex; align-items: center; gap: 10px;">

                                <input type="checkbox"
                                    name="data_privacy"
                                    id="dataPrivacyCheck"
                                    required
                                    style="width: 18px; height: 18px; border: 1px solid #ddd; border-radius: 4px; cursor: pointer;">

                                <label for="dataPrivacyCheck"
                                    style="font-size: 0.95rem; color: #555; cursor: pointer;">
                                    I have read and agree to the
                                </label>

                                <span id="openPrivacyModal" class="privacy-link text-blue-800 underline cursor-pointer hover:opacity-80" tabindex="0" role="button">
                                    Data Privacy Notice
                                </span>


                            </div>

                        </div>
                    </div>

                    <!-- MAP MODAL -->
                    <div id="mapModal" style="
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
                                max-width: 800px;
                                width: 90%;
                                padding: 20px;
                                border-radius: 8px;
                                position: relative;
                                box-shadow: 0 10px 25px rgba(0,0,0,0.3);
                                max-height: 80vh;
                                overflow-y: auto;
                            ">
                            <h2 style="margin-top: 0; color: #003366;">Race Map</h2>
                            <!-- LEGEND -->
                            <div style="
                                margin: 10px 0 15px;
                                padding: 10px;
                                background: #f5f7fa;
                                border-left: 4px solid #003366;
                                border-radius: 4px;
                                font-size: 14px;
                            ">
                            <strong>Legend:</strong>

                            <ul style="
                                list-style:none;
                                padding:0;
                                margin:0;
                                display:flex;
                                flex-wrap:wrap;
                                gap:15px;
                                align-items:center;
                            ">

                                <li style="display:flex;align-items:center;gap:6px;">
                                    <span style="width:12px;height:10px;background:#b30202;border-radius:50%;display:inline-block;"></span>
                                    Ribbon Station
                                </li>

                                <li style="display:flex;align-items:center;gap:6px;">
                                    <span style="width:12px;height:12px;background:#bbff00;border-radius:50%;display:inline-block;"></span>
                                    Water Station
                                </li>

                                <li style="display:flex;align-items:center;gap:6px;">
                                    <span style="width:12px;height:12px;background:#007bff;border-radius:50%;display:inline-block;"></span>
                                    Race Track
                                </li>

                                <li style="display:flex;align-items:center;gap:6px;">
                                    <span style="font-size:14px;">📍</span>
                                    Start / Finish Area
                                </li>

                            </ul>


                            </div>
                            <iframe
                                src="https://www.google.com/maps/d/u/0/embed?mid=128al8iHvnKKm_qMdMTijzG__NXLz8n0&ehbc=2E312F&noprof=1"
                                width="100%"
                                height="500"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy">
                            </iframe>
                            <button id="closeMapModal" type="button" style="
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
                                The DSWD FO III complies with the Data Privacy Act of 2012 and is committed in protecting your privacy. For the purpose of this activity, the DRMD will collect personal information for the purpose of documentation. Information collected will be stored for as long as necessary. By filling out the form, you are consenting to the collection, use and retention of your personal information.
                            </p>
                            <button id="closePrivacyModal" type="button" style="
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
                    <div class="full-width2">
                        <div style="display: flex; gap: 30px; text-align: center; margin-top: -40px;">
                            <button type="submit" class="btn-submit">Register</button>
                            <a href="/fun-run/qr" class="btn-submit" style="text-decoration: none;">Generate QR Code</a>
                        </div>
                    </div>
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
                <tr><td>04:00 AM</td><td><strong>Attendance - General Assembly</strong> - DSWD Field Office III</td></tr>
                <tr><td>04:00 AM</td><td><strong>Opening Prayer - Welcome Message</strong> - DSWD Field Office III</td></tr>
                <tr><td>04:45 AM</td><td><strong>Zumba - Route Map</strong> - DSWD Field Office III</td></tr>
                <tr><td>05:00 AM</td><td><strong>Fun Run Starts</strong> - DSWD Field Office III</td></tr>
                <tr><td>07:30 AM</td><td><strong>Fun Run Ends - Cool Down Execise</strong> - DSWD Field Office III</td></tr>
                <tr><td>07:30 AM</td><td><strong>Awarding Ceremony</strong> - DSWD Field Office III</td></tr>
            </tbody>
        </table>
    </section>
@endsection


<script>
document.addEventListener('DOMContentLoaded', function () {

    const divisionSelect = document.getElementById('division');
    const sectionSelect  = document.getElementById('section');

    const openModal  = document.getElementById('openPrivacyModal');
    const closeModal = document.getElementById('closePrivacyModal');
    const modal      = document.getElementById('privacyModal');
    const mapModal = document.getElementById('mapModal');
    const openMap = document.getElementById('openMapModal');
    const closeMap = document.getElementById('closeMapModal');
    const form = document.getElementById('registrationForm');
    const loadingScreen = document.getElementById('loadingScreen');
    const textInputs = document.querySelectorAll('input.only-letters');
    const numberInputs = document.querySelectorAll('input.numbers-only');
    const dswdInputs = document.querySelectorAll('input.dswd-id');
    const oldDivision = "{{ old('division') }}";
    const oldSection  = "{{ old('section') }}";

    textInputs.forEach(input => {
        // Block invalid characters while typing
        input.addEventListener('keypress', function(e) {
            const regex = /^[a-zA-Z\s]$/;
            if (!regex.test(e.key)) {
                e.preventDefault(); // prevent typing anything else
            }
        });

        // Clean pasted input
        input.addEventListener('input', function() {
            this.value = this.value.replace(/[^a-zA-Z\s]/g, ''); // remove anything not letters or spaces
        });
    });

        numberInputs.forEach(input => {
            // Block invalid characters while typing
            input.addEventListener('keypress', function(e) {
                const regex = /^[0-9 +]$/;
                if (!regex.test(e.key) || this.value.length >= 13) {
                    e.preventDefault(); // prevent typing anything else or exceeding 13 chars
                }
            });

            // Clean pasted input & enforce 13-char limit
            input.addEventListener('input', function() {
                this.value = this.value
                    .replace(/[^0-9 +]/g, '') // remove anything not numbers, space, or +
                    .slice(0, 13); // limit to 13 characters
            });
        });


        dswdInputs.forEach(input => {
            input.addEventListener('keypress', function(e) {
                const key = e.key;
                const value = this.value;

                // Block if already 8 chars
                if (value.length >= 8) {
                    e.preventDefault();
                    return;
                }

                // Allow only numbers or -
                const regex = /^[0-9-]$/;
                if (!regex.test(key)) {
                    e.preventDefault();
                    return;
                }

                // Force first two characters to be "03-"
                if (value.length === 0 && key !== '0') e.preventDefault();
                if (value.length === 1 && key !== '3') e.preventDefault();
                if (value.length === 2 && key !== '-') e.preventDefault();
            });

            input.addEventListener('input', function() {
                // Remove invalid chars
                let val = this.value.replace(/[^0-9-]/g, '');

                // Enforce 03- at start
                if (!val.startsWith('03-')) {
                    val = '03-';
                }

                // Limit to 8 chars
                this.value = val.slice(0, 8);
            });
        });


    /* ===============================
       SECTION OPTIONS
    =============================== */

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
    };




    /* ===============================
       HELPERS
    =============================== */

    function resetSelect(select) {
        select.innerHTML = '<option value="">-- SELECT --</option>';
        select.disabled = true;
    }

    function populateSection(division, selected = null) {

        resetSelect(sectionSelect);

        if (!sectionOptions[division]) return;

        sectionSelect.disabled = false;

        sectionOptions[division].forEach(section => {

            const opt = document.createElement('option');

            opt.value = section;
            opt.textContent = section;

            if (section === selected) {
                opt.selected = true;
            }

            sectionSelect.appendChild(opt);
        });
    }


    /* ===============================
       DIVISION → SECTION
    =============================== */

    resetSelect(sectionSelect);

    // Restore after validation error
    if (oldDivision) {
        divisionSelect.value = oldDivision;
        populateSection(oldDivision, oldSection);
    }

    // Change handler
    divisionSelect.addEventListener('change', function () {
        populateSection(this.value);
    });


    /* ===============================
       MODAL HANDLING
    =============================== */

    if (openModal && modal && closeModal) {

        openModal.addEventListener('click', function () {
            modal.style.display = 'flex';
        });

        closeModal.addEventListener('click', function () {
            modal.style.display = 'none';
        });

        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    }

      //map modal

      if (openMap && mapModal && closeMap) {
        openMap.addEventListener('click', function () {
            mapModal.style.display = 'flex';
        });

        closeMap.addEventListener('click', function () {
            mapModal.style.display = 'none';
        });

        mapModal.addEventListener('click', function(e) {
            if (e.target === mapModal) {
                mapModal.style.display = 'none';
            }
        });
    }

        if (form && loadingScreen) {

        form.addEventListener('submit', function () {

            // Show loading screen
            loadingScreen.style.display = 'flex';

            // Disable submit button (prevent double submit)
            const btn = form.querySelector('button[type="submit"]');
            if (btn) {
                btn.disabled = true;
                btn.style.opacity = '0.7';
            }

        });

    }


    /* ===============================
       AUTO-FOCUS FIRST ERROR
    =============================== */

    @if($errors->any())
        const firstError = document.querySelector('.form-grid [name]');
        if (firstError) {
            firstError.focus();
        }
    @endif

});


</script>


