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
            <li><strong>DSWD ID:</strong> {{ $registration->dswd_id }}</li>
            <li><strong>Division:</strong> {{ $registration->division }}</li>
            <li><strong>Section:</strong> {{ $registration->section }}</li>
            <li><strong>Race Category:</strong> {{ $registration->race_category_label }}</li>
            <li><strong>Contact Number:</strong> {{ $registration->contact_number }}</li>
        </ul>
        <!-- QR Code -->
        <div style="flex-shrink: 0; transform: scale(4); transform-origin: top right;">
            {!! $qrSvg !!}
        </div>
    </div>
    <p>Please take a picture of your qr code or print it to present it on the day of event.</p>

    <div style="margin-top: 100px; display: flex; gap: 20px; text-align: center;">
        <a href="{{ route('fun-run.create') }}" class="btn-submit">Register Another Participant</a>
         <a href="{{ route('fun-run.print-image', $registration->id) }}" target="_blank" class="btn-submit">Download QR Code</a>
    </div>
</section>


@endsection
