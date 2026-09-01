<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gatepass Inventory List</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 12mm;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: #f3f3f3;
            color: #1f2937;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background: #fff;
            padding: 10mm 12mm;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8mm;
            padding-bottom: 4mm;
            border-bottom: 1px solid #cfcfcf;
        }

        .title {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .meta {
            text-align: right;
            font-size: 10px;
            color: #4b5563;
        }

        .summary {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px 18px;
            margin-bottom: 6mm;
            font-size: 11px;
        }

        .summary-row {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .summary-label {
            font-weight: 700;
            min-width: 80px;
        }

        .summary-value {
            flex: 1;
            border-bottom: 1px solid #666;
            min-height: 16px;
            padding-top: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            font-size: 10px;
        }

        th, td {
            border: 1px solid #7d7d7d;
            padding: 5px 6px;
            vertical-align: top;
            text-align: left;
        }

        th {
            background: #f5f5f5;
            text-transform: uppercase;
            font-size: 9px;
            letter-spacing: .04em;
            font-weight: 700;
            height: 9mm;
        }

        td {
            height: 16mm;
            line-height: 1.25;
        }

        .qty { width: 12%; }
        .unit { width: 12%; }
        .desc { width: 42%; }
        .remarks { width: 34%; }

        .footer {
            margin-top: 10mm;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 10mm;
            font-size: 10px;
        }

        .signature-box {
            width: 28%;
            text-align: center;
        }

        .line {
            height: 14mm;
            border-bottom: 1px solid #2f2f2f;
            margin-bottom: 4px;
        }

        @media print {
            body { background: #fff; }
            .page { width: auto; min-height: auto; margin: 0; padding: 0; }
        }
    </style>
</head>
<body>
    <main class="page">
        <header class="header">
            <div class="title">Item List</div>
            <div class="meta">
                <div>{{ $date ?? now()->format('M d, Y') }}</div>
                <div>Gatepass {{ $owner ?? 'N/A' }}</div>
            </div>
        </header>
        <section class="summary">
            <div class="summary-row">
                <span class="summary-label">Owner:</span>
                <span class="summary-value">{{ $owner ?? 'N/A' }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Bearer:</span>
                <span class="summary-value">{{ $bearer ?? 'N/A' }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">From:</span>
                <span class="summary-value">{{ $fromSiteFloor ?? 'N/A' }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">To:</span>
                <span class="summary-value">{{ $toSiteFloor ?? 'N/A' }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Date:</span>
                <span class="summary-value">{{ $date ?? now()->format('M d, Y') }}</span>
            </div>
        </section>
        <table>
            <thead>
                <tr>
                    <th class="qty">Quantity</th>
                    <th class="unit">Unit</th>
                    <th class="desc">Description</th>
                    <th class="remarks">Remarks</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items ?? [] as $item)
                    <tr>
                        <td>{{ $item['quantity'] ?? 1 }}</td>
                        <td>{{ $item['unit'] ?? 'Unit' }}</td>
                        <td>{{ $item['description'] ?? ($item['item_name'] ?? 'Inventory Item') }}</td>
                        <td>{{ $item['remarks'] ?? 'Transferred' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td>1</td>
                        <td>Unit</td>
                        <td>Inventory Item</td>
                        <td>Transferred</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            <div class="signature-box">
                <div class="line"></div>
                <div>Prepared By</div>
            </div>
            <div class="signature-box">
                <div class="line"></div>
                <div>Approved By</div>
            </div>
            <div class="signature-box">
                <div class="line"></div>
                <div>Checked By</div>
            </div>
        </div>
    </main>
</body>
</html>
