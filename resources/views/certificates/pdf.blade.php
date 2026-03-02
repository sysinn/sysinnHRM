<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Experience Certificate</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; line-height: 1.6; padding: 40px; }
        h1 { text-align: center; }
    </style>
</head>
<body>
    <h1>Experience Certificate</h1>
    <p>This is to certify that <strong>{{ $certificate->employee->name }}</strong> worked with us as a <strong>{{ $certificate->designation }}</strong> from <strong>{{ \Carbon\Carbon::parse($certificate->start_date)->format('d M, Y') }}</strong> to <strong>{{ \Carbon\Carbon::parse($certificate->end_date)->format('d M, Y') }}</strong>.</p>

    @if($certificate->remarks)
    <p>Remarks: {{ $certificate->remarks }}</p>
    @endif

    <p>We found {{ $certificate->employee->name }} to be sincere and professional throughout their time with us.</p>

    <p>We wish them all the best in future endeavors.</p>

    <br><br>
    <p>Authorized Signature</p>
</body>
</html>
