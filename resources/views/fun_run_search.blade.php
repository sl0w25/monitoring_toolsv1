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

<div class="qr-wrapper">
    <a href="{{ route('fun-run.print-image', $registration->id) }}" target="_blank" class="qr-link">

        <!-- QR CODE -->
        {!! QrCode::size(200)->generate($registration->qr_number) !!}

        <!-- DOWNLOAD ICON -->
        <span class="download-icon">⬇️</span>
    </a>
</div>



        </div>
    @endif
</section>
<style>
.qr-wrapper {
    position: relative;
    display: inline-block;
}

.qr-link {
    position: relative;
    display: inline-block;
}

.download-icon {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);

    font-size: 40px;
    color: white;
    background: rgba(0,0,0,0.6);
    padding: 12px 16px;
    border-radius: 50%;

    opacity: 0;
    transition: opacity 0.3s ease;

    pointer-events: none;
}

/* Show icon on hover */
.qr-link:hover .download-icon {
    opacity: 1;
}

/* Optional zoom effect */
.qr-link:hover svg {
    filter: brightness(0.6);
}
</style>

@endsection
