@extends('layouts.app')

@section('title', 'DSWD 75th Anniversary | Fun Run')

@section('header-logo')
    <img src="{{ asset('storage/images/anniv_logo.png') }}" alt="DSWD 75th Logo">
@endsection

@section('content')
    <section class="card">
        <h2 class="section-title">FUN RUN (DSWD 75TH ANNIVERSARY)</h2>
        <p> <!-- Paste your Fun Run description here --> </p>
    </section>

    <section class="card">
        <h2 class="section-title">Registration</h2>
        <form>
            <!-- Paste your form here -->
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
