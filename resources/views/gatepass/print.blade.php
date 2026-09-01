<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Gatepass</title>
	<style>
		@page {
			size: A4 landscape;
			margin: 12mm;
		}

		:root {
			--ink: #202020;
			--line: #555;
			--soft-line: #9a9a9a;
		}

		* {
			box-sizing: border-box;
		}

		body {
			margin: 0;
			background: #f1f1f1;
			color: var(--ink);
			font-family: Arial, Helvetica, sans-serif;
			font-size: 11px;
		}

		.page {
			position: relative;
			width: 297mm;
			min-height: 210mm;
			margin: 16px auto;
			padding: 12mm;
			background: #fff;
		}

		.header {
			min-height: 25mm;
		}

		.company {
			width: 55%;
			padding-top: 2px;
			line-height: 1.25;
		}

		.company-address {
			margin: 0;
			font-size: 11px;
			font-weight: 700;
		}

		.company-email {
			margin-top: 2px;
			font-size: 10px;
		}

		.header-right {
			position: absolute;
			top: 0;
			right: 10mm;
			width: 30%;
		}

		.gatepass {
			width: 84%;
			margin-left: auto;
		}

		.brand {
			width: 100%;
			height: 23mm;
			overflow: hidden;
			margin: 0 0 2mm;
		}

		.brand-logo {
			display: block;
			width: 100%;
			height: 23mm;
			object-fit: cover;
			object-position: center;
		}

		.gatepass-title {
			padding: 7px 10px 6px;
			background: #1f1f1f;
			color: #fff;
			font-size: 20px;
			font-weight: 700;
			letter-spacing: 1px;
		}

		.control-number {
			height: 16mm;
			border: 1px solid var(--soft-line);
			border-top: 0;
			padding: 6px 10px;
			color: #555;
			font-size: 10px;
		}

		.details {
			margin: 0 0 4mm;
		}

		.detail-row {
			display: flex;
			align-items: baseline;
			min-height: 7mm;
		}

		.detail-label {
			width: 9%;
			font-weight: 700;
		}

		.detail-field {
			display: inline-block;
			min-height: 5mm;
			border-bottom: 1px solid var(--line);
		}

		.detail-field.wide {
			width: 30%;
		}

		.detail-field.medium {
			width: 20%;
		}

		.detail-label.compact {
			width: auto;
			margin-left: 5%;
			margin-right: 8px;
		}

		.allowance {
			margin: 2mm 0 3mm;
			font-size: 11px;
		}

		.allowance .detail-field {
			width: 36%;
			height: 1em;
			min-height: 0;
			vertical-align: baseline;
		}

		.items {
			width: 100%;
			border-collapse: collapse;
			table-layout: fixed;
			font-size: 10px;
		}

		.items th,
		.items td {
			border: 1px solid var(--soft-line);
			padding: 4px 6px;
			vertical-align: top;
		}

		.items th {
			height: 8mm;
			color: #555;
			font-size: 10px;
			font-weight: 700;
			text-transform: uppercase;
			letter-spacing: .04em;
		}

		.items td {
			height: 18mm;
			padding: 5px 6px;
			line-height: 1.2;
		}

		.items .quantity { width: 12%; }
		.items .unit { width: 14%; }
		.items .description { width: 42%; }
		.items .remarks { width: 32%; }

		.approval-grid {
			display: grid;
			grid-template-columns: 1fr 1fr 1.25fr 1fr 1fr;
			margin-top: 7mm;
			border: 1px solid var(--soft-line);
		}

		.approval {
			min-height: 37mm;
			border-right: 1px solid var(--soft-line);
			text-align: center;
		}

		.approval:last-child {
			border-right: 0;
		}

		.approval-title {
			min-height: 7mm;
			padding: 4px 3px 3px;
			background: #242424;
			color: #fff;
			font-size: 9px;
			font-weight: 700;
			line-height: 1.15;
			text-transform: uppercase;
		}

		.approval-role {
			display: block;
			min-height: 7mm;
			padding: 4px 2px 2px;
			color: #202020;
			font-size: 9px;
			font-weight: 700;
			line-height: 1.15;
			text-transform: uppercase;
		}

		.approval:nth-child(4),
		.approval:nth-child(5) {
			position: relative;
			padding-top: 7mm;
		}

		.approval:nth-child(4) .approval-title {
			position: absolute;
			top: 0;
			left: 0;
			z-index: 1;
			width: calc(200% + 1px);
		}

		.approval:nth-child(5) .approval-title {
			display: none;
		}

		.signature-space {
			height: 17mm;
			margin: 0 8px;
			border-bottom: 1px solid var(--line);
		}

		.signature-label {
			padding: 4px 2px;
			color: #555;
			font-size: 9px;
			line-height: 1.15;
		}

		@media print {
			body {
				background: #fff;
			}

			.page {
				position: relative;
				width: auto;
				min-height: auto;
				margin: 0;
				padding: 0;
			}
		}

		@media screen and (max-width: 760px) {
			.page {
				width: 100%;
				min-height: 0;
				margin: 0;
				padding: 24px;
			}

			.header {
				gap: 20px;
			}

			.brand {
				height: 28mm;
			}

			.brand-logo {
				height: 28mm;
			}

			.items th,
			.items td,
			.allowance,
			.company-address {
				font-size: 9px;
			}
		}
	</style>
</head>
<body>
	<main class="page">
		<header class="header">
			<div class="company">
				<p class="company-address">
					R304-305 Seneca Plaza Bldg., E. Rodriguez Sr. Avenue,<br>
					Brgy. Mariana, New Manila, Quezon City, 1112<br>
					02-77999101
				</p>
				<div class="company-email">hr@allianz-synergia.com</div>
			</div>

			<div class="header-right">
				<div class="brand" aria-label="Allianz Synergia">
					<img class="brand-logo" src="{{ asset('assets/img/WALLPAPER.jpg') }}" alt="Allianz Synergia">
				</div>

				<div class="gatepass">
					<div class="gatepass-title">GATEPASS</div>
					<div class="control-number">CONTROL NO.</div>
				</div>
			</div>
		</header>

		<section class="details" aria-label="Gatepass details">
			<div class="detail-row">
				<span class="detail-label">OWNER:</span>
				<span class="detail-field wide">{{ $owner ?? 'N/A' }}</span>
			</div>
			<div class="detail-row">
				<span class="detail-label">CONTACT:</span>
				<span class="detail-field medium">{{ $contact ?? 'N/A' }}</span>
			</div>
			<div class="detail-row">
				<span class="detail-label">DATE:</span>
				<span class="detail-field medium">{{ $date ?? now()->format('M d, Y') }}</span>
				<span class="detail-label compact">TIME:</span>
				<span class="detail-field medium">{{ $time ?? now()->format('h:i A') }}</span>
			</div>
			<div class="detail-row">
				<span class="detail-label">FROM:</span>
				<span class="detail-field wide">{{ $fromSiteFloor ?? 'N/A' }}</span>
			</div>
			<div class="detail-row">
				<span class="detail-label">TO:</span>
				<span class="detail-field wide">{{ $toSiteFloor ?? 'N/A' }}</span>
			</div>
		</section>

		<p class="allowance">
			Please allow the bearer Mr./Ms. <span class="detail-field wide">{{ $bearer ?? 'N/A' }}</span>
			to bring out/in the following items from <strong>{{ $fromSiteFloor ?? 'N/A' }}</strong> to <strong>{{ $toSiteFloor ?? 'N/A' }}</strong>:
		</p>

		<table class="items">
			<thead>
				<tr>
					<th class="quantity">Quantity</th>
					<th class="unit">Unit</th>
					<th class="description">Description</th>
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

		<section class="approval-grid" aria-label="Approvals">
			<div class="approval">
				<div class="approval-title">Prepared by:</div>
				<div class="approval-role">Owner</div>
				<div class="signature-space"></div>
				<div class="signature-label">Signature over<br>printed name</div>
			</div>
			<div class="approval">
				<div class="approval-title">Approved by:</div>
				<div class="approval-role">Supervisor</div>
				<div class="signature-space"></div>
				<div class="signature-label">Signature over<br>printed name</div>
			</div>
			<div class="approval">
				<div class="approval-title">Verified by:</div>
				<div class="approval-role">Premises Officer</div>
				<div class="signature-space"></div>
				<div class="signature-label">Signature over printed name</div>
			</div>
			<div class="approval">
				<div class="approval-title">Checked by:</div>
				<div class="approval-role">Compliance Officer</div>
				<div class="signature-space"></div>
				<div class="signature-label">Signature over<br>printed name</div>
			</div>
			<div class="approval">
				<div class="approval-title">&nbsp;</div>
				<div class="approval-role">Asset Protection Specialist</div>
				<div class="signature-space"></div>
				<div class="signature-label">Signature over<br>printed name</div>
			</div>
		</section>
	</main>
</body>
</html>
