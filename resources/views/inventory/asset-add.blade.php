@section('title', env('APP_NAME'))

@include('layouts.title')

@include('layouts.header')

    @include('layouts.sidebar')
<div class="page">

    <!-- HEADER -->
    <div class="header">
        <div class="logo-area">
            <img src="{{ asset('assets/img/WALLPAPER.jpg') }}" alt="Allianz Synergia">
        </div>
        <div class="address-bar">
            SENECA PLAZA BLDG., E. RODRIGUEZ SR. AVE., NEW MANILA, BRGY. MARIANA, QUEZON CITY
        </div>
        <div class="form-title">
            FIXED ASSET TRANSFER FORM
        </div>
    </div>

    <!-- FORM INFORMATION -->
    <div class="form-information">
        <div class="information-left">
            <div class="information-row">
                <span class="information-label">Date of transfer:</span>
                <span class="information-line">{{ $date }}</span>
            </div>
            <div class="information-row">
                <span class="information-label">Original campaign/team:</span>
                <span class="information-line campaign-line">{{ $fromCampaign }}</span>
            </div>
            <div class="information-row">
                <span class="information-label">Asset type:</span>
                <span class="information-line asset-line">{{ $assetType }}</span>
            </div>
            <div class="information-row">
                <span class="information-label">Transferred campaign:</span>
                <span class="information-line transferred-line">{{ $toCampaign }}</span>
            </div>
        </div>

        <div class="information-right">
            <div class="information-row">
                <span class="information-label">Reference no.:</span>
                <span class="information-line reference-line">{{ $reference }}</span>
            </div>
        </div>
        <div class="clear"></div>
    </div>

    <!-- ASSET TABLE -->
    <table class="asset-table">
        <thead>
            <tr>
                <th class="column-description">ASSET DESCRIPTION</th>
                <th class="column-quantity">QTY.</th>
                <th class="column-purchase-date">DATE OF PURCHASE</th>
                <th class="column-original-value">ORIGINAL VALUE</th>
                <th class="column-net-book-value">NET BOOK VALUE</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
            <tr>
                <td>{{ $item['description'] }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>{{ $item['purchase_date'] ?? '' }}</td>
                <td>{{ $item['original_value'] ?? '' }}</td>
                <td>{{ $item['net_book_value'] ?? '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TOTAL -->
    <div class="total-row">
        TOTAL: {{ collect($items)->sum('quantity') }}
    </div>

    <!-- REASON FOR TRANSFER -->
    <div class="reason-box">
        <span class="reason-label">Reason for transfer:</span>
        <div>{{ $remarks ?? '' }}</div>
    </div>

    <!-- SIGNATURE SECTION -->
    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-heading">PREPARED BY:</div>
            <div class="signature-fields">
                <div class="signature-field">
                    <div class="signature-line"></div>
                    <div class="field-caption">Signature over printed name</div>
                </div>
                <div class="date-field">
                    <div class="date-line"></div>
                    <div class="field-caption date-caption">Date</div>
                </div>
            </div>
        </div>

        <div class="signature-box">
            <div class="signature-heading">CHECKED BY:</div>
            <div class="signature-fields">
                <div class="signature-field">
                    <div class="signature-line"></div>
                    <div class="field-caption">Signature over printed name</div>
                </div>
                <div class="date-field">
                    <div class="date-line"></div>
                    <div class="field-caption date-caption">Date</div>
                </div>
            </div>
        </div>

        <div class="signature-box">
            <div class="signature-heading">APPROVED BY:</div>
            <div class="signature-fields">
                <div class="signature-field">
                    <div class="signature-line"></div>
                    <div class="field-caption">Signature over printed name</div>
                </div>
                <div class="date-field">
                    <div class="date-line"></div>
                    <div class="field-caption date-caption">Date</div>
                </div>
            </div>
        </div>
    </div>
</div>
