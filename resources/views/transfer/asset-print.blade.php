<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Fixed Asset Transfer Form - Allianz Synergia</title>

    <style>
        /* =========================================================
           PAGE SETUP
           ========================================================= */

        @page {
            size: A4 portrait;
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            background: #ffffff;
            color: #000000;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            font-size: 9px;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 4mm 4mm 8mm 4mm;
            background: #ffffff;
            border: 1px solid #888;
        }


        /* =========================================================
           HEADER
           ========================================================= */

        .header {
            width: 100%;
            text-align: center;
        }

        /*
         * The original reference has a relatively small logo
         * centered above the black address strip.
         */
        .logo-area {
            width: 100%;
            height: 16mm;

            display: flex;
            align-items: center;
            justify-content: center;

            margin: 0;
            padding: 0;
        }

        .logo-area img {
            display: block;

            width: 34mm;
            height: auto;

            max-height: 15mm;

            object-fit: contain;
        }


        /*
         * Black address strip from the reference.
         */
        .address-bar {
            width: 100%;
            height: 5.2mm;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 0 2mm;

            background: #000;
            color: #fff;

            font-size: 7px;
            font-weight: bold;
            line-height: 1;

            white-space: nowrap;
            overflow: hidden;
        }


        /*
         * Form title immediately underneath the black strip.
         */
        .form-title {
            margin-top: 1.8mm;

            font-size: 11px;
            line-height: 1;

            font-weight: bold;
            text-align: center;
        }


        /* =========================================================
           FORM INFORMATION
           ========================================================= */

        .form-information {
            width: 100%;
            margin-top: 5mm;

            font-size: 9px;
            line-height: 1;
        }

        .information-left {
            float: left;
            width: 64%;
        }

        .information-right {
            float: right;
            width: 36%;

            padding-left: 2mm;
        }

        .information-row {
            width: 100%;
            height: 6mm;

            display: flex;
            align-items: flex-end;

            white-space: nowrap;
        }

        .information-label {
            display: inline-block;

            margin-right: 2mm;

            font-weight: normal;
            line-height: 1;
        }

        .information-line {
            display: inline-block;

            height: 4mm;

            border-bottom: 0.7px solid #000;

            flex: 0 0 36mm;
        }

        .campaign-line {
            flex-basis: 39mm;
        }

        .asset-line {
            flex-basis: 39mm;
        }

        .transferred-line {
            flex-basis: 39mm;
        }

        .reference-line {
            flex-basis: 42mm;
        }

        .clear {
            clear: both;
        }


        /* =========================================================
           ASSET TABLE
           ========================================================= */

        .asset-table {
            width: 100%;

            margin-top: 2mm;

            border-collapse: collapse;
            table-layout: fixed;

            font-size: 8px;
        }

        .asset-table th,
        .asset-table td {
            border: 0.7px solid #000;
        }

        .asset-table th {
            height: 9mm;

            padding: 1.2mm 1.5mm;

            text-align: center;
            vertical-align: middle;

            font-size: 7.8px;
            font-weight: bold;

            line-height: 1.1;
        }

        .asset-table td {
            height: 9mm;

            padding: 1mm 1.5mm;

            vertical-align: middle;
        }


        /*
         * Column widths based on the proportions visible
         * in the reference image.
         */
        .column-description {
            width: 39%;
        }

        .column-quantity {
            width: 10%;
        }

        .column-purchase-date {
            width: 18%;
        }

        .column-original-value {
            width: 16.5%;
        }

        .column-net-book-value {
            width: 16.5%;
        }


        /* =========================================================
           TOTAL
           ========================================================= */

        .total-row {
            width: 100%;
            height: 7mm;

            display: flex;
            align-items: center;
            justify-content: flex-end;

            border: 0.7px solid #000;
            border-top: none;

            padding-right: 4mm;

            font-size: 8.5px;
            font-weight: bold;
        }


        /* =========================================================
           REASON FOR TRANSFER
           ========================================================= */

        .reason-box {
            width: 100%;
            height: 20mm;

            margin-top: 3mm;

            border: 0.7px solid #000;

            padding: 2mm 2.5mm;

            font-size: 8.5px;
        }

        .reason-label {
            font-weight: bold;
        }


        /* =========================================================
           SIGNATURE SECTION
           ========================================================= */

        .signature-section {
            width: 100%;

            margin-top: 3mm;

            display: table;
            table-layout: fixed;

            border: 0.7px solid #000;

            border-collapse: collapse;
        }


        /*
         * Each signature box is intentionally narrower and
         * evenly distributed.
         */
        .signature-box {
            display: table-cell;

            width: 33.3333%;
            height: 29mm;

            padding: 2mm 3mm;

            vertical-align: top;

            border-right: 0.7px solid #000;
        }

        .signature-box:last-child {
            border-right: none;
        }


        .signature-heading {
            margin: 0;

            font-size: 8px;
            font-weight: bold;

            line-height: 1;
        }


        /*
         * Signature lines.
         *
         * The reference has a noticeably longer signature line
         * and a shorter date line separated horizontally.
         */
        .signature-fields {
            width: 100%;

            display: flex;
            align-items: flex-start;

            margin-top: 9mm;
        }

        .signature-field {
            flex: 1;

            padding-right: 4mm;
        }

        .date-field {
            flex: 0 0 18mm;
            padding-right: 0;
        }

        .signature-line {
            width: 100%;
            height: 4mm;

            border-bottom: 0.7px solid #000;
        }

        .date-line {
            width: 100%;
            height: 4mm;

            border-bottom: 0.7px solid #000;
        }


        /*
         * Text beneath the lines.
         */
        .field-caption {
            margin-top: 1mm;

            font-size: 6.8px;
            line-height: 1.1;

            color: #333;

            white-space: nowrap;
        }

        .date-caption {
            text-align: left;
        }


        /* =========================================================
           PRINT
           ========================================================= */

        @media print {

            html,
            body {
                width: 210mm;
                min-height: 297mm;

                margin: 0;
                padding: 0;

                background: #fff;
            }

            .page {
                width: 210mm;
                min-height: 297mm;

                margin: 0;
                padding: 4mm 4mm 8mm 4mm;

                border: 1px solid #888;
            }
        }
    </style>
</head>


<body>

<div class="page">

    <!-- =========================================================
         HEADER
         ========================================================= -->

    <div class="header">

        <div class="logo-area">
            <img
                src="{{ asset('assets/img/WALLPAPER.jpg') }}"
                alt="Allianz Synergia"
            >
        </div>

        <div class="address-bar">
            SENECA PLAZA BLDG., E. RODRIGUEZ SR. AVE., NEW MANILA, BRGY. MARIANA, QUEZON CITY
        </div>

        <div class="form-title">
            FIXED ASSET TRANSFER FORM
        </div>

    </div>


    <!-- =========================================================
         FORM INFORMATION
         ========================================================= -->

    <div class="form-information">

        <div class="information-left">

            <div class="information-row">
                <span class="information-label">
                    Date of transfer:
                </span>

                <span class="information-line"></span>
            </div>


            <div class="information-row">
                <span class="information-label">
                    Original campaign/team:
                </span>

                <span class="information-line campaign-line"></span>
            </div>


            <div class="information-row">
                <span class="information-label">
                    Asset type:
                </span>

                <span class="information-line asset-line"></span>
            </div>


            <div class="information-row">
                <span class="information-label">
                    Transferred campaign:
                </span>

                <span class="information-line transferred-line"></span>
            </div>

        </div>


        <div class="information-right">

            <div class="information-row">

                <span class="information-label">
                    Reference no.:
                </span>

                <span class="information-line reference-line"></span>

            </div>

        </div>


        <div class="clear"></div>

    </div>


    <!-- =========================================================
         ASSET TABLE
         ========================================================= -->

    <table class="asset-table">

        <thead>
            <tr>

                <th class="column-description">
                    ASSET DESCRIPTION
                </th>

                <th class="column-quantity">
                    QTY.
                </th>

                <th class="column-purchase-date">
                    DATE OF<br>
                    PURCHASE
                </th>

                <th class="column-original-value">
                    ORIGINAL<br>
                    VALUE
                </th>

                <th class="column-net-book-value">
                    NET BOOK<br>
                    VALUE
                </th>

            </tr>
        </thead>


        <tbody>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

        </tbody>

    </table>


    <!-- =========================================================
         TOTAL
         ========================================================= -->

    <div class="total-row">
        TOTAL:
    </div>


    <!-- =========================================================
         REASON FOR TRANSFER
         ========================================================= -->

    <div class="reason-box">

        <span class="reason-label">
            Reason for transfer:
        </span>

    </div>


    <!-- =========================================================
         SIGNATURES
         ========================================================= -->

    <div class="signature-section">


        <!-- ================= PREPARED BY ================= -->

        <div class="signature-box">

            <div class="signature-heading">
                PREPARED BY:
            </div>


            <div class="signature-fields">

                <div class="signature-field">

                    <div class="signature-line"></div>

                    <div class="field-caption">
                        Signature over printed name
                    </div>

                </div>


                <div class="date-field">

                    <div class="date-line"></div>

                    <div class="field-caption date-caption">
                        Date
                    </div>

                </div>

            </div>

        </div>


        <!-- ================= CHECKED BY ================= -->

        <div class="signature-box">

            <div class="signature-heading">
                CHECKED BY:
            </div>


            <div class="signature-fields">

                <div class="signature-field">

                    <div class="signature-line"></div>

                    <div class="field-caption">
                        Signature over printed name
                    </div>

                </div>


                <div class="date-field">

                    <div class="date-line"></div>

                    <div class="field-caption date-caption">
                        Date
                    </div>

                </div>

            </div>

        </div>


        <!-- ================= APPROVED BY ================= -->

        <div class="signature-box">

            <div class="signature-heading">
                APPROVED BY:
            </div>


            <div class="signature-fields">

                <div class="signature-field">

                    <div class="signature-line"></div>

                    <div class="field-caption">
                        Signature over printed name
                    </div>

                </div>


                <div class="date-field">

                    <div class="date-line"></div>

                    <div class="field-caption date-caption">
                        Date
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>
