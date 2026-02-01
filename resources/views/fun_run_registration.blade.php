@extends('layouts.app')

@section('title', 'DSWD 75th Anniversary | Fun Run')

@section('header-logo')
    <img src="{{ asset('storage/images/anniv_logo.png') }}" alt="DSWD 75th Logo">
@endsection

@section('content')


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
            <form action="{{ route('fun-run.store') }}" method="POST" enctype="multipart/form-data">
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
                        <input tpye="text" name="dswd_id" value="{{ old('dswd_id') }}" placeholder="00-0000" required>
                    </div>

                    <div>
                        <label>First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="Juan" required>
                      

                    </div>
                    <div>
                        <label>Middle Name</label>
                        <input type="text" name="middle_name" value="{{ old('middle_name') }}" placeholder="Andress" required>
                    </div>
                    <div>
                        <label>Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Dela Cruz" required>
                    </div>
                    <div>
                        <label>Ext. Name</label>
                        <input type="text" name="ext_name" value="{{ old('ext_name') }}" placeholder="JR." >
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
                        <input type="text" name="contact_number" value="{{ old('contact_number') }}" placeholder="Your Contact Number" required>
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
                        <input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}"  placeholder="Full Name" required>
                    </div>

                    <div class="full-width">
                        <label>In Case of Emergency <small style="color: rgb(219, 86, 86)">(contact number)</small></label>
                        <input type="text" name="emergency_contact_number" value="{{ old('emergency_contact_number') }}" placeholder="Contact Number" required>
                    </div>

                    <div class="full-width2">
                        <label style="display: block; margin-bottom: 8px;">Race Category</label>

                        <div style="display: flex; flex-direction: column; gap: 10px; align-items: flex-start;">
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; white-space: nowrap;">
                                <input type="radio" name="race_category" value="5km_20_35" required>
                                5 km – 20 to 35 years old
                            </label>

                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; white-space: nowrap;">
                                <input type="radio" name="race_category" value="5km_36_above">
                                5 km – 36 years old and above
                            </label>

                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; white-space: nowrap;">
                                <input type="radio" name="race_category" value="3km_20_35">
                                3 km – 20 to 35 years old
                            </label>

                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; white-space: nowrap;">
                                <input type="radio" name="race_category" value="3km_36_above">
                                3 km – 36 years old and above
                            </label>
                        </div>
                    </div>

                    <div class="full-width2">
                        <label>Health Consent Form</label>
                        <input type="file" name="health_consent_form" value="{{ old('health_consent_form') }}" placeholder="Dela Cruz, Juan A.">
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
                                The DSWD FO III complies with the Data Privacy Act of 2012 and is committed in protecting your privacy. For the purpose of this activity, the DRMD will collect personal information for the purpose of documentation. Information collected will be stored for as long as necessary. By filling out the form, you are consenting to the collection, use and retention of your personal information.
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
                <tr><td>04:00 AM</td><td><strong>Attendance</strong> - Bren Z. Guiao Convention Center</td></tr>
                <tr><td>10:00 AM</td><td><strong>Awarding of the Winner</strong> - Bren Z. Guiao Convention Center</td></tr>
                <tr><td>05:00 PM</td><td><strong>Closing</strong> - Sports Complex</td></tr>
            </tbody>
        </table>
    </section>
@endsection


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
    // const API = 'https://psgc.gitlab.io/api'

      @if($errors->any())
        const firstErrorField = document.querySelector('.form-grid input[name], .form-grid select[name]');
        @foreach($errors->keys() as $field)
            const el = document.querySelector(`[name="{{ $field }}"]`);
            if(el) {
                el.focus();
                return; // stop at first error field
            }
        @endforeach
    @endif


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
                //     {{-- <div class="full-width">
                //     <label>Region</label>
                //     <select id="region" required>
                //         <option value="">-- SELECT --</option>
                //     </select>
                // </div>

                // <div class="full-width">
                //     <label>Province</label>
                //     <select id="province" required disabled>
                //         <option value="">-- SELECT --</option>
                //     </select>
                // </div>

                // <div class="full-width">
                //     <label>Municipality</label>
                //     <select id="municipality" required disabled>
                //         <option value="">-- SELECT --</option>
                //     </select>
                // </div>

                // <div class="full-width">
                //     <label>Barangay</label>
                //     <select id="barangay" required disabled>
                //         <option value="">-- SELECT --</option>
                //     </select>
                // </div> --}}
                // </div>

    /* ---------------- Helper ---------------- */

       

    function resetSelect(select) {
        select.innerHTML = '<option value="">-- SELECT --</option>'
        select.disabled = true
    }

})
</script>