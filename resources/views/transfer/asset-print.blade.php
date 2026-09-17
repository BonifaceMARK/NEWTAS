<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fixed Asset Transfer Form</title>
    <style>
        @page { size: A4 landscape; margin: 12mm; }
        * { box-sizing: border-box; }
        html, body { margin: 0; padding: 0; background: #fff; color: #111; font-family: Arial, Helvetica, sans-serif; }
        body { font-size: 10px; }
        .page { width: 297mm; min-height: 210mm; margin: 0 auto; padding: 8mm 12mm; }
        .form { border: 1px solid #222; }
        .brand { height: 25mm; display: flex; align-items: center; justify-content: center; padding: 2mm; }
        .brand img { width: 45mm; height: 22mm; object-fit: contain; }
        .address { height: 7mm; display: flex; align-items: center; justify-content: center; padding: 0 3mm; color: #fff; background: #050505; font-size: 8px; font-weight: 700; white-space: nowrap; }
        .title { padding: 2mm 0; border-bottom: 1px solid #222; text-align: center; font-size: 13px; font-weight: 700; }
        .information { display: grid; grid-template-columns: 2fr 1fr; min-height: 34mm; padding: 4mm 5mm 2mm; }
        .information-left { padding-right: 10mm; }
        .info-row { display: flex; min-height: 7mm; align-items: end; gap: 2mm; }
        .info-label { white-space: nowrap; }
        .info-value { flex: 1; min-height: 5mm; padding: 0 1mm 1mm; border-bottom: 1px solid #222; overflow: hidden; white-space: nowrap; }
        .information-right { padding-left: 3mm; }
        .reference-row { display: flex; min-height: 7mm; align-items: end; gap: 2mm; }
        .reference-value { flex: 1; min-height: 5mm; padding: 0 1mm 1mm; border-bottom: 1px solid #222; overflow: hidden; white-space: nowrap; }
        .asset-table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        .asset-table th, .asset-table td { border: 1px solid #222; }
        .asset-table th { height: 8mm; padding: 1mm; background: #dfe5e5; text-align: center; font-size: 9px; font-weight: 700; }
        .asset-table td { height: 11mm; padding: 1.5mm 2mm; vertical-align: middle; }
        .description { width: 39%; }
        .quantity { width: 10%; text-align: center; }
        .purchase { width: 18%; text-align: center; }
        .value { width: 16.5%; text-align: right; }
        .book { width: 16.5%; text-align: right; }
        .total { display: grid; grid-template-columns: 39% 10% 18% 16.5% 16.5%; height: 7mm; }
        .total-label { grid-column: 3 / 5; padding: 1.5mm; border: 1px solid #222; border-top: 0; background: #dfe5e5; text-align: right; font-weight: 700; }
        .total-value { grid-column: 5; padding: 1.5mm; border-right: 1px solid #222; border-bottom: 1px solid #222; }
        .reason { min-height: 23mm; margin-top: 4mm; padding: 2mm; border: 1px solid #222; }
        .reason-label { display: block; margin-bottom: 2mm; font-weight: 700; }
        .reason-text { white-space: pre-wrap; }
        .signatures { display: grid; grid-template-columns: repeat(3, 1fr); min-height: 28mm; margin-top: 5mm; border: 1px solid #222; }
        .signature { padding: 2mm; border-right: 1px solid #222; }
        .signature:last-child { border-right: 0; }
        .signature-title { font-weight: 700; }
        .signature-lines { display: grid; grid-template-columns: 1fr 18mm; gap: 5mm; margin-top: 13mm; }
        .signature-line, .date-line { min-height: 4mm; border-bottom: 1px solid #222; }
        .caption { margin-top: 1mm; color: #333; font-size: 8px; text-align: center; }
        @media screen and (max-width: 700px) { .page { width: 100%; min-height: 0; padding: 12px; } .information { grid-template-columns: 1fr; } .information-right { padding: 2mm 0 0; } }
    </style>
</head>
<body>
    @php
        $transferItems = collect($items ?? []);
        $rows = $transferItems->take(4)->values();
        $dateValue = $date ?? now()->format('Y-m-d');
        $formattedDate = $dateValue && strtotime($dateValue) ? date('F d, Y', strtotime($dateValue)) : $dateValue;
    @endphp

    <main class="page">
        <section class="form">
            <div class="brand">
                <img src="{{ asset('assets/img/WALLPAPER.jpg') }}" alt="Allianz Synergia">
            </div>
            <div class="address">SENECA PLAZA BLDG., E. RODRIGUEZ SR. AVE., NEW MANILA, BRGY. MARIANA, QUEZON CITY</div>
            <div class="title">FIXED ASSET TRANSFER FORM</div>

            <section class="information">
                <div class="information-left">
                    <div class="info-row"><span class="info-label">Date of transfer:</span><span class="info-value">{{ $formattedDate ?: '—' }}</span></div>
                    <div class="info-row"><span class="info-label">Original campaign/team:</span><span class="info-value">{{ $fromCampaign ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-label">Asset type:</span><span class="info-value">{{ $assetType ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-label">Transferred campaign:</span><span class="info-value">{{ $toCampaign ?? '—' }}</span></div>
                </div>
                <div class="information-right">
                    <div class="reference-row"><span>Reference no.:</span><span class="reference-value">{{ $reference ?? '—' }}</span></div>
                </div>
            </section>

            <table class="asset-table">
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
                    @for ($index = 0; $index < 4; $index++)
                        @php $item = $rows->get($index); @endphp
                        <tr>
                            <td>{{ data_get($item, 'description', data_get($item, 'item_name', '')) }}</td>
                            <td class="quantity">{{ data_get($item, 'quantity', '') }}</td>
                            <td class="purchase">{{ data_get($item, 'purchase_date', '') }}</td>
                            <td class="value">{{ data_get($item, 'original_value', '') }}</td>
                            <td class="book">{{ data_get($item, 'net_book_value', '') }}</td>
                        </tr>
                    @endfor
                </tbody>
            </table>

            <div class="total">
                <div class="total-label">TOTAL:</div>
                <div class="total-value"></div>
            </div>

            <div class="reason">
                <span class="reason-label">Reason for transfer:</span>
                <div class="reason-text">{{ $remarks ?? '—' }}</div>
            </div>

            <div class="signatures">
                @foreach (['PREPARED BY:', 'CHECKED BY:', 'APPROVED BY:'] as $title)
                    <div class="signature">
                        <div class="signature-title">{{ $title }}</div>
                        <div class="signature-lines">
                            <div><div class="signature-line"></div><div class="caption">Signature over printed name</div></div>
                            <div><div class="date-line"></div><div class="caption">Date</div></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

    </main>
</body>
</html>
