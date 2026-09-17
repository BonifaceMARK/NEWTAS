{{-- filepath: c:\xampp\htdocs\ASI-INVENTORY\resources\views\transfer\print.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fixed Asset Transfer - {{ $assetTransfer->reference_no }}</title>
    <style>
        @page { size: A4 landscape; margin: 12mm; }
        * { box-sizing: border-box; }
        body { margin: 0; color: #111; font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
        .page { max-width: 273mm; margin: 0 auto; }
        .top-border { border: 1px solid #222; }
        .brand { padding: 8px 12px 5px; text-align: center; }
        .brand img { width: 180px; max-height: 55px; object-fit: contain; }
        .address { padding: 6px; color: #fff; background: #111; text-align: center; font-size: 11px; font-weight: 700; }
        .title { padding: 9px; border-bottom: 1px solid #222; text-align: center; font-size: 16px; font-weight: 700; }
        .information { display: grid; grid-template-columns: 1fr 1fr; gap: 4px 28px; padding: 18px 14px 12px; }
        .info-row { display: flex; min-height: 25px; align-items: end; gap: 6px; }
        .info-label { white-space: nowrap; }
        .info-value { flex: 1; min-height: 20px; padding: 0 3px 2px; border-bottom: 1px solid #222; }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        th, td { padding: 9px 7px; border: 1px solid #222; vertical-align: middle; }
        th { background: #d9e1e1; text-align: center; font-size: 11px; }
        td { height: 35px; }
        .description { width: 38%; }
        .quantity { width: 10%; text-align: center; }
        .purchase { width: 18%; text-align: center; }
        .value { width: 17%; text-align: right; }
        .book { width: 17%; text-align: right; }
        .total { display: flex; justify-content: flex-end; border: 1px solid #222; border-top: 0; }
        .total-label { width: 18%; padding: 8px; background: #d9e1e1; font-weight: 700; text-align: center; }
        .total-value { width: 17%; padding: 8px; }
        .remarks { min-height: 72px; margin-top: 14px; padding: 8px; border: 1px solid #222; }
        .remarks-label { display: block; margin-bottom: 10px; font-weight: 700; }
        .signatures { display: grid; grid-template-columns: repeat(3, 1fr); margin-top: 22px; border: 1px solid #222; }
        .signature { min-height: 92px; padding: 8px; border-right: 1px solid #222; }
        .signature:last-child { border-right: 0; }
        .signature-title { font-weight: 700; }
        .signature-line { margin-top: 42px; padding-top: 4px; border-top: 1px solid #222; text-align: center; font-size: 10px; }
        @media (max-width: 650px) {
            .information, .signatures { grid-template-columns: 1fr; }
            .signature { border-right: 0; border-bottom: 1px solid #222; }
            .signature:last-child { border-bottom: 0; }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="top-border">
            <div class="brand">
                <img src="{{ asset('assets/img/asi_logo.jpg') }}" alt="Company logo">
            </div>
            <div class="address">SENECA PLAZA BLDG., E. RODRIGUEZ SR. AVE., NEW MANILA, BRGY. MARIANA, QUEZON CITY</div>
            <div class="title">FIXED ASSET TRANSFER FORM</div>

            <div class="information">
                <div class="info-row"><span class="info-label">Date of transfer:</span><span class="info-value">{{ $assetTransfer->date_of_transfer ? \Carbon\Carbon::parse($assetTransfer->date_of_transfer)->format('F d, Y') : '—' }}</span></div>
                <div class="info-row"><span class="info-label">Reference no.:</span><span class="info-value">{{ $assetTransfer->reference_no ?: '—' }}</span></div>
                <div class="info-row"><span class="info-label">Original campaign/team:</span><span class="info-value">{{ $assetTransfer->from_campaign ?: '—' }}</span></div>
                <div class="info-row"><span class="info-label">Asset type:</span><span class="info-value">{{ $assetTransfer->asset_type ?: '—' }}</span></div>
                <div class="info-row"><span class="info-label">Status:</span><span class="info-value">{{ $assetTransfer->status ?: 'Ongoing' }}</span></div>
                <div class="info-row"><span class="info-label">Transferred campaign:</span><span class="info-value">{{ $assetTransfer->to_campaign ?: '—' }}</span></div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th class="description">ASSET DESCRIPTION</th>
                        <th class="quantity">QTY.</th>
                        <th class="purchase">DATE OF PURCHASE</th>
                        <th class="value">ORIGINAL VALUE</th>
                        <th class="book">NET BOOK VALUE</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $assetTransfer->asset_type ?: '—' }}</td>
                        <td class="quantity">—</td>
                        <td class="purchase">—</td>
                        <td class="value">—</td>
                        <td class="book">—</td>
                    </tr>
                    <tr><td>&nbsp;</td><td></td><td></td><td></td><td></td></tr>
                    <tr><td>&nbsp;</td><td></td><td></td><td></td><td></td></tr>
                </tbody>
            </table>

            <div class="total">
                <div class="total-label">TOTAL:</div>
                <div class="total-value">—</div>
            </div>

            <div class="remarks">
                <span class="remarks-label">Reason for transfer:</span>
                {{ $assetTransfer->remarks ?: '—' }}
            </div>

            @if ($assetTransfer->signature_path)
                <div style="margin-top: 10px; font-size: 11px;">
                    <strong>Employee signature:</strong><br>
                    <img src="{{ asset('storage/' . $assetTransfer->signature_path) }}" alt="Employee signature" style="max-width: 150px; max-height: 60px; object-fit: contain;">
                </div>
            @endif

            <div class="signatures">
                <div class="signature"><div class="signature-title">PREPARED BY:</div><div class="signature-line">Signature over printed name &nbsp;&nbsp; Date</div></div>
                <div class="signature"><div class="signature-title">CHECKED BY:</div><div class="signature-line">Signature over printed name &nbsp;&nbsp; Date</div></div>
                <div class="signature"><div class="signature-title">APPROVED BY:</div><div class="signature-line">Signature over printed name &nbsp;&nbsp; Date</div></div>
            </div>
        </div>

    </div>
</body>
</html>
