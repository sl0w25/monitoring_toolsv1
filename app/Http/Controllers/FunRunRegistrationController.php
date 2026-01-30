<?php

namespace App\Http\Controllers;

use App\Http\Requests\FunRunRegistrationRequest;
use App\Models\FunRunRegistration;
use Illuminate\Support\Facades\Storage;

class FunRunRegistrationController extends Controller
{
    public function create()
    {
        // Divisions and sections
        $divisions = [
        "ADMINISTRATIVE DIVISION"=> [
                    "OFFICE OF THE DIVISION CHIEF",
                    "PROCUREMENT AND BAC SECTION",
                    "PROPERTY AND SUPPLY SECTION",
                    "RECORDS AND ARCHIVES MANAGEMENT SECTION",
                    "BUILDING AND GROUND SECTION",
                    "GENERAL SERVICES SECTION"
                ],
                "HUMAN RESOURCE AND MANAGEMENT DIVISION"=> [
                    "OFFICE OF THE DIVISION CHIEF",
                    "LEARNING AND DEVELOPMENT SECTION",
                    "HUMAN RESOURCE WELFARE SECTION",
                    "PERSONNEL SECTION",
                    "CLINIC",
                    "HRPPMS"
                ],
                "FINANCE MANAGEMENT DIVISION"=> [
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
                "DISASTER RESPONSE AND MANAGEMENT DIVISION"=> [
                    "OFFICE OF THE DIVISION CHIEF",
                    "DISASTER RESPONSE AND REHABILITATION SECTION",
                    "DISASTER RESPONSE AND INFORMATION MANAGEMENT SECTION",
                    "REGIONAL RESOURCE OPERATION SECTION"
                ],
                "POLICY AND PLANS DIVISION"=> [
                    "OFFICE OF THE DIVISION CHIEF",
                    "REGIONAL INFORMATION AND COMMUNICATION MANAGEMENT SECTION",
                    "NATIONAL HOUSEHOLD TARGETING SYSTEM",
                    "STANDARDS SECTION",
                    "RESEARCH AND DEVELOPMENT SECTION"
                ],
                "PROTECTIVE SERVICES DIVISION"=> [
                    "OFFICE OF THE DIVISION CHIEF",
                    "COMMUNITY BASED SECTION",
                    "CRISIS INTERVENTION SECTION",
                    "SUPPLEMENTAL FEEDING PROGRAM",
                    "SOCIAL PENSION",
                    "MINORS TRAVELLING ABROAD",
                    "CENTER BASED SERVICES SECTION"
                ],
                "PROMOTIVE SERVICES DIVISION"=> [
                    "OFFICE OF THE DIVISION CHIEF",
                    "SUSTAINABLE LIVELIHOOD PROGRAM",
                    "KALAHI"
                ],
                "PANTAWID PAMILYANG PILIPINO PROGRAM"=> [
                    "OFFICE OF THE DIVISION CHIEF",
                    "RPMO",
                    "ICT PANTAWID"
                ],
                "INNOVATIONS DIVISION"=> [
                    "OFFICE OF THE DIVISION CHIEF",
                    "STU",
                    "TBTP",
                    "PAG-ABOT",
                    "EPAHP"
                ],
                "OFFICE OF THE FIELD DIRECTOR"=> [
                    "OFFICE OF THE REGIONAL DIRECTOR",
                    "OFFICE OF THE ASSISTANT REGIONAL DIRECTOR FOR ADMINISTRATION",
                    "OFFICE OF THE ASSISTANT REGIONAL DIRECTOR FOR OPERATIONS",
                    "TAAORSS"
                ],
                "SWAD OFFICES"=> [
                    "SWAD - AURORA",
                    "SWAD - BATAAN",
                    "SWAD - BULACAN",
                    "SWAD - NUEVA ECIJA",
                    "SWAD - TARLAC",
                    "SWAD - PAMPANGA",
                    "SWAD - ZAMBALES"
                ],
                "CRCF's"=> [
                    "AMORV",
                    "HAVEN",
                    "RHFG",
                    "RRCY",
                    "RSCC",
                    "THFW",
                    "TLC"
                ]
        ];

        return view('welcome', compact('divisions'));
    }

    public function store(FunRunRegistrationRequest $request)
    {
        $data = $request->validated();

        // Handle file upload
        if ($request->hasFile('health_consent_form')) {
            $data['health_consent_form'] = $request->file('health_consent_form')
                ->store('health_forms', 'public');
        }

        FunRunRegistration::create($data);

        return redirect()->back()->with('success', 'Registration successful!');
    }
}
