@extends('layouts.app')

@section('title', 'Fun Run Registration Success')

@section('header-logo')
    <img src="{{ asset('storage/images/anniv_logo.png') }}" alt="DSWD 75th Logo">
@endsection

@section('content')
<section class="card">
    <h2 class="section-title">Registration Successful!</h2>

    <p>Thank you, <strong>{{ $registration->first_name }} {{ $registration->last_name }}</strong>, for registering for the <strong>DSWD 75th Anniversary Fun Run</strong>.</p>

    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 40px;">
        <!-- Registration Details -->
        <ul style="flex: 1; list-style: none; padding: 0;">
            <li>
                <strong>Registration #:</strong>
                <b>{{ str_pad($registration->id, 3, '0', STR_PAD_LEFT) }}</b>
            </li>
            <li><strong>Division:</strong> {{ $registration->division }}</li>
            <li><strong>Section:</strong> {{ $registration->section }}</li>
            <li><strong>Race Category:</strong> {{ $registration->race_category_label }}</li>
        </ul>
    </div>
            <!-- QR Code -->
        <div>
             {!! str_replace('<svg ', '<svg width="800"', $qrSvg) !!}
        </div>
    <p>Please keep your QR code secured and present it on the day of the event.</p>
    <p>Participants are required to: Prepare their own <b>Personnel Locator Slip (PLS)</b> or <b>Request<br> for Authority  to Travel (RFA)</b> documents. Accomplish and sign a <b>Health Consent Form</b>.<br> Proper running attire and hydration are advised. </i></p>

    <div style="margin-top: 100px; display: flex; gap: 20px; text-align: center; grid-column: span 3;">
        <a href="{{ route('fun-run.create') }}" class="btn-submit">Register Another Participant</a>
         <a href="{{ route('fun-run.print-image') }}" target="_blank" class="btn-submit">Download QR Code</a>
    </div>
</section>


@endsection
