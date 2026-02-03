@extends('layouts.app')

@section('title', 'Generate QR Code')

@section('header-logo')
    <img src="{{ asset('storage/images/anniv_logo.png') }}" alt="DSWD 75th Logo">
@endsection

@section('content')
<section class="card">
    <h2 class="section-title">Generate Your QR Code</h2>

    {{-- Search Form --}}
    <form action="{{ route('fun-run.qr.search') }}" method="POST" style="margin-top: 20px; display: flex; flex-direction: column; gap: 10px;">
        @csrf
        <input type="text" name="dswd_id" placeholder="Enter your DSWD ID" value="{{ old('dswd_id') }}" required
               style="padding: 10px; border-radius: 6px; border: 1px solid #ccc; width: 100%; max-width: 300px;">
               <div style="display: flex; gap: 30px; text-align: center; margin-top: -10px;">
                <button type="submit" class="btn-submit" style="text-decoration: none; width: fit-content;">Generate</button>
                <a href="/" class="btn-submit" style="text-decoration: none; width: fit-content;">Go back to Registration</a>
               </div>
    </form>


    @if($errors->any())
        <div style="margin-top: 15px; color: red;">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif


    @if(isset($registration))
        <div style="margin-top: 30px;">
            <p><strong>Name:</strong> {{ $registration->first_name }} {{ $registration->last_name }}</p>
            <p><strong>DSWD ID:</strong> {{ $registration->dswd_id }}</p>


            <div style="margin: 15px 0;">
                {!! QrCode::size(200)->generate($registration->qr_number) !!}
            </div>


            <a href="{{ route('fun-run.print-image', $registration->id) }}" target="_blank" style="text-decoration: none;" class="btn-submit">Download QR Code</a>

        </div>
    @endif
</section>
@endsection
