<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECT Beneficiaries</title>
    <style>
        /* Set the paper size (CR80) */
        @page {
            size: 85.60mm 54.00mm; /* CR80 dimensions */
            margin: 2;

        }

        body {
            margin: 0;
            padding: 0;
            border-style: solid;


            width: 83.60mm;
            height: 54.00mm;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }


        /* Set the size of the QR code container */
        .qr-container {
            width: 323.57px;  /* 85.60mm converted to pixels (CR80 width) */
            height: 204.12px; /* 54.00mm converted to pixels (CR80 height) */
            margin-top: 1px;
            position: absolute;
            margin-left: 78;
        }

        /* Ensure content fits within the page */
        h4 {
            margin: 0;
        }

        h3{
            margin-top: 110px;
            margin-bottom: 0;
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

        .h1 {
        width: 100%;
        vertical-align: left;
        position: absolute;
        top: 5px;
        left: -130px;
        font-size: 12px;
        }

        .h2 {
            width: 100%;
            vertical-align: left;
            position: absolute;
            top: 5px;
            left: -90px;
            font-size: 12px;
        }




    </style>
</head>
<body>
    <div>
        @foreach ($records as $location)
        <div class="h1">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/storage/images/dswd2.png'))) }}" alt="" width="50" height="15" />
            </div>
        <div class="h2">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/storage/images/pilipinas.png'))) }}" alt="" width="20" height="13"/>
        </div>

        <h4>4PS Beneficiaries</h4>
        <p>Municipality: {{$location->municipality}}</p>

        <h5>QR Code</h5>

        <div class="qr-container">
            @if (!empty($location->qr_number))
                {!! DNS2D::getBarcodeHTML($location->qr_number, 'QRCODE', 5, 5) !!}
            @endif
        </div>
        <h3>{{ $location->first_name }} @if($location->middle_name)
            {{ Str::substr($location->middle_name, 0, 1,) }}.
            @endif{{ $location->last_name }}</h3>
        @endforeach
    </div>
</body>
</html>
