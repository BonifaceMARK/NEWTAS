
@section('title', 'Gatepass Details')
@include('layouts.title')

<style>
    .gatepass-show-page {
        width: 100%;
        padding: 1rem;
    }

    .gatepass-show-card {
        width: 100%;
        max-width: 100%;
        margin: 0;
        overflow: hidden;
        border: 0;
        border-radius: 14px;
    }

    .gatepass-show-header {
        padding: 1.5rem;
        color: #fff;
        background: linear-gradient(135deg, #123b78, #1769aa);
    }

    .gatepass-show-header h1 {
        margin: 0;
        font-size: clamp(1.1rem, 2vw, 1.5rem);
    }

    .gatepass-show-header p {
        margin: .35rem 0 0;
        opacity: .85;
    }

    .detail-card {
        height: 100%;
        padding: 1rem;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
    }

    .detail-label {
        display: block;
        margin-bottom: .3rem;
        color: #64748b;
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .detail-value {
        color: #1e293b;
        font-size: 1rem;
        font-weight: 500;
        overflow-wrap: anywhere;
        word-break: break-word;
    }

    .description-box {
        min-height: 80px;
        white-space: pre-wrap;
        word-break: break-word;
    }

    .record-id {
        display: inline-block;
        padding: .35rem .65rem;
        color: #1d4ed8;
        background: #eff6ff;
        border-radius: 6px;
        font-weight: 700;
    }

    .status-badge {
        display: inline-block;
        padding: .35rem .65rem;
        border-radius: 999px;
        font-weight: 700;
    }

    .status-ongoing {
        color: #92400e;
        background: #fef3c7;
    }

    .status-completed {
        color: #166534;
        background: #dcfce7;
    }

    .status-cancelled {
        color: #991b1b;
        background: #fee2e2;
    }

    /* Tablet */
    @media (max-width: 992px) {

        .gatepass-show-page {
            padding: .75rem;
        }

        .gatepass-show-header {
            padding: 1.25rem;
        }
    }

    /* Mobile */
    @media (max-width: 768px) {

        .gatepass-show-page {
            padding: .5rem;
        }

        .gatepass-show-header {
            padding: 1rem;
        }

        .detail-card {
            padding: .75rem;
        }

        .detail-value {
            font-size: .95rem;
        }
    }

    @media print {

        .sidebar,
        .header,
        .show-actions {
            display: none !important;
        }

        .main {
            margin: 0 !important;
            padding: 0 !important;
        }

        .gatepass-show-page {
            padding: 0;
        }

        .gatepass-show-card {
            box-shadow: none !important;
            width: 100%;
        }
    }
</style>

<body>
    @include('layouts.header')
    @include('layouts.sidebar')

    <main id="main" class="main">
        <div class="container-fluid gatepass-show-page">
            <div class="card gatepass-show-card shadow-sm">
                <div class="gatepass-show-header d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>
                        <h1><i class="bi bi-file-earmark-text me-2"></i>Gatepass Details</h1>
                        <p>Complete information for the selected gatepass.</p>
                    </div>
                    <div class="show-actions d-flex gap-2">
                        <a href="{{ route('inventory.gatepass.list') }}" class="btn btn-light text-primary">
                            <i class="bi bi-arrow-left me-1"></i>Back
                        </a>
                        <a href="{{ route('inventory.gatepass.edit', $gatepass->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>
                        <a href="{{ route('inventory.gatepass.print', $gatepass->id) }}" target="_blank" class="btn btn-outline-light">
                            <i class="bi bi-printer me-1"></i>Print
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

   

                    <div class="row g-3">
                        
                      
                        <div class="col-12 col-md-4">
                            <div class="detail-card">
                                <span class="detail-label">Quantity / Unit</span>
                                <span class="detail-value">{{ $gatepass->quantity }} {{ $gatepass->unit ?: '' }}</span>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="detail-card">
                                <span class="detail-label">Status</span>
                                @php $status = $gatepass->status ?: 'Ongoing'; @endphp
                                <span class="status-badge status-{{ strtolower($status) }}">{{ $status }}</span>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Owner</span>
                                <span class="detail-value">{{ $gatepass->owner ?: '—' }}</span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Contact</span>
                                <span class="detail-value">{{ $gatepass->contact ?: '—' }}</span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Bearer</span>
                                <span class="detail-value">{{ $gatepass->bearer ?: '—' }}</span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Site / Floor</span>
                                <span class="detail-value">{{ $gatepass->site_floor ?: '—' }}</span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Date</span>
                                <span class="detail-value">{{ $gatepass->date ? \Carbon\Carbon::parse($gatepass->date)->format('F d, Y') : '—' }}</span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Time</span>
                                <span class="detail-value">{{ $gatepass->time ? \Carbon\Carbon::parse($gatepass->time)->format('h:i A') : '—' }}</span>
                            </div>
                        </div>
                <div class="col-6">
                    <div class="detail-card description-box">
                        <span class="detail-label">Description</span>
                        <span class="detail-value">{{ $gatepass->description ?: '—' }}</span>
                    </div>
                </div>
                  <div class="col-6">
                            <div class="detail-card description-box">
                                <span class="detail-label">Remarks</span>
                                <span class="detail-value">{{ $gatepass->remarks ?: '—' }}</span>
                            </div>
                        </div>
<!-- SIGNATURE SECTION -->
<div class="col-12">

    <div class="detail-card">

        <span class="detail-label">
            Approval Signatures
        </span>

        <div class="row g-3">

            @foreach($gatepass->signatures as $signature)

                <div class="col-md-4">

                    <div class="border rounded p-3 h-100">

                        <div class="fw-bold mb-2">
                            {{ str_replace('_', ' ', $signature->role) }}
                        </div>

                        <div
                            class="d-flex align-items-center justify-content-center bg-light rounded"
                            style="height:100px;">
@if($signature->signature_path)

    <img
        src="{{ asset('storage/' . $signature->signature_path) }}"
        alt="{{ $signature->role }} Signature"
        style="tain;">

@else

    <div class="text-muted">
        <i class="bi bi-clock-history"></i>
        Waiting for Signature
    </div>

@endif
                             

                        </div>

                        <div class="text-center mt-2">

                            <strong>
                                {{ $signature->fullname ?: 'Not Yet Signed' }}
                            </strong>

                            @if($signature->signed_at)

                                <br>

                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($signature->signed_at)->format('M d, Y h:i A') }}
                                </small>

                            @endif

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</div>
 
                       
 
                      
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
const canvas = document.getElementById('signature-pad');

if (canvas) {

    const ctx = canvas.getContext('2d');

    let drawing = false;

    function getPosition(e) {
        const rect = canvas.getBoundingClientRect();

        const clientX = e.clientX || e.touches[0].clientX;
        const clientY = e.clientY || e.touches[0].clientY;

        return {
            x: clientX - rect.left,
            y: clientY - rect.top
        };
    }

    function startDrawing(e) {
        drawing = true;
        draw(e);
    }

    function stopDrawing() {
        drawing = false;
        ctx.beginPath();
    }

    function draw(e) {

        if (!drawing) return;

        const pos = getPosition(e);

        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        ctx.strokeStyle = '#000';

        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();

        ctx.beginPath();
        ctx.moveTo(pos.x, pos.y);
    }

    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mousemove', draw);

    canvas.addEventListener('touchstart', startDrawing);
    canvas.addEventListener('touchend', stopDrawing);
    canvas.addEventListener('touchmove', draw);

    window.clearSignature = function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    }

    window.saveDrawnSignature = function() {

        document.getElementById('signature_data').value =
            canvas.toDataURL('image/png');

        document.getElementById('draw-signature-form').submit();
    }
}
</script>
    @include('layouts.footer')
</body>
</html>
