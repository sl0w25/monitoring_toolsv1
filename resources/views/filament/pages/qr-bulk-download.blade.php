<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECT Beneficiaries</title>
    <style>
        @page {
            size: A4;
            margin: 10mm;
        }

        body {
            text-align: center;
        }


        .container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }



        .card {
            width: 47%;
            height: 55mm;
            border: 1px solid black;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            padding: 5px;
            margin-bottom: 8mm;
        }

        .qr-container {
            width: 60px;
            right: 165px;
            height: 60px;
            margin-top: 5px;
            position: absolute;
        }

        h4 {
            margin: 0;
        }

        h3 {
            margin-top: 120px;
            margin-bottom: 0;
            font-size: 15px;
        }

        h5 {
            margin-top: -6;
            margin-bottom: 4;

        }

        p {
            font-size: 12px;
            line-height: 1.2;
            margin-bottom: 10px;
            margin-top: 1px;
        }

        .h1 img, .h2 img {
            position: absolute;
        }

        .h1 img {
            top: 5px;
            left: 5px;
            width: 50px;
            height: 15px;
        }

        .h2 img {
            top: 5px;
            right: 271px;
            width: 20px;
            height: 13px;
        }
    </style>
</head>
<body>
    <div class="container">
        @foreach ($records as $location)
            <div class="card">
                <div class="h1">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/storage/images/dswd2.png'))) }}" alt="DSWD Logo" width="50" height="15">
                </div>
                <div class="h2">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/storage/images/pilipinas.png'))) }}" alt="Pilipinas Logo"width="20" height="13">
                </div>

                <h4>4PS Beneficiaries</h4>
                <p>Municipality: {{ $location->municipality }}</p>

                <h5>QR Code</h5>
                <div class="qr-container center">
                    @if (!empty($location->qr_number))
                        {!! DNS2D::getBarcodeHTML($location->qr_number, 'QRCODE', 5, 5) !!}
                    @endif
                </div>
                <h3>{{ $location->first_name }}
                    @if ($location->middle_name)
                        {{ Str::substr($location->middle_name, 0, 1) }}.
                    @endif
                    {{ $location->last_name }}
                </h3>
            </div>
        @endforeach
    </div>
</body>
</html>
