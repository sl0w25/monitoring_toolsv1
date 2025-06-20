<!-- resources/views/emails/beneficiary-assigned.blade.php -->
<p>A beneficiary has been assigned:</p>
<ul>
    <li>Name: {{ $beneficiary->first_name }} {{ $beneficiary->last_name }}</li>
    <li>Province: {{ $beneficiary->province }}</li>
    <li>Municipality: {{ $beneficiary->municipality }}</li>
    <li>Barangay: {{ $beneficiary->barangay }}</li>
</ul>
