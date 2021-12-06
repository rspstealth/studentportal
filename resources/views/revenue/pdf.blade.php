<!DOCTYPE html>
<html>
<head>
    <title>Invoice.pdf</title>
    <style>
        @page {
            footer: page-footer;
            margin: 0;
            margin-top: 35pt;
            margin-bottom: 50pt;
            margin-footer: 18pt;
        }

        @page :first {
            margin-top: 0;
        }

        body {
            margin: 0;
            font-family: sans-serif;
            font-size: 12pt;
        }

        table, tr, td {
            padding: 0;
            border-collapse: collapse;
        }
        table { width: 100%; }
        td { vertical-align: top; }

        .page-break-before { page-break-before: always; }

        .container { padding: 0 45pt; }

        main .container {
            margin-top: 2em;
        }

        .clearfix {
            clear: both;
        }

        .col1  { width: 8.33333%; }
        .col2  { width: 16.66667%; }
        .col3  { width: 25%; }
        .col4  { width: 33.33333%; }
        .col5  { width: 41.66667%; }
        .col6  { width: 50%; }
        .col7  { width: 58.33333%; }
        .col8  { width: 66.66667%; }
        .col9  { width: 75%; }
        .col10 { width: 83.33333%; }
        .col11 { width: 91.66667%; }
        .col12 { width: 100%; }

        #header {
            border: none;
            padding: 20pt 0;
        }
        .details-column-table {
            margin: 0 15pt;
            table-layout: fixed;
        }

        .details-column-table tr {
            border: none;
            border: 1px solid #000;
        }

        .details-column-table tr:last-child {
            border: none;
        }

        .details-column-table td {
            line-height: 30pt;
            padding:0 5pt;
        }

        .details-column-table .label {
            font-weight: bold;
        }

    </style>
</head>
<body>
<header id="header">
    <div class="container">
        <h1 style="text-align: right;font-size: 1.6em;padding:0;">INVOICE</h1>
    </div>
</header>
<main>
    <div class="container">
        <table style="margin: 0 ;">
            <tr>
                <td class="col6"><b>Student Name</b></td>
                <td class="col6" style="text-align:right"><p>INVOICE NUMBER: 1</p></td>
            </tr>
            <tr>
                <td class="col6"><p>description</p></td>
                <td class="col6" style="text-align:right"><p>DATA: 24/06/2021</p></td>
            </tr>
            <tr>

                <td> <br> <br><b>BILL TO:</b> student name</td>
            </tr>
        </table>
        <br><br>
        <table class="details-column-table" style="margin: 0;">
                <thead>
                <tr>
                    <td class="col2"><b>QUANTITY</b></td>
                    <td class="col6"><b>DESCRIPTION</b></td>
                    <td class="col2"><b>UNIT PRICE</b></td>
                    <td class="col2"><b>TOTAL</b></td>
                </tr>
                </thead>
            <?php
            $running_total = 0;
            foreach($revenues as $revenue){
                if($revenue->entry_type === 'sale') {
                    $running_total += $revenue->cost;
                }else{
                    $running_total -= $revenue->cost;
                }
            }
            ?>
                <tr>
                    <td class="label">{{count($revenues)}}</td>
                    <td class="value">Miscellaneous</td>
                    <td class="value"></td>
                    <td class="value">₤{{$running_total}}</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td class="value" style="text-align:right;"><b>TOTAL DUE:</b></td>
                    <td class="value">₤{{$running_total}}</td>
                </tr>
        </table>
        <br>
        <br>
        <br>
        <h2 style="text-align: left;font-size: 1.6em;padding:0;">Payment Details</h2>
        <p>student name</p>
        <p style="text-align:center"><b>Thank you for your business!</b></p>
    </div>
    <div class="container">
        <div class="tags">
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="page-break-before"></div>
    <div class="container">
       <h2 style="font-size: 1.6em;padding:0;">Sales Record</h2>
        <table class="details-column-table" style="margin: 0;">
            <thead>
            <tr>
                <td class="col2"><b>Date</b></td>
                <td class="col2"><b>Student #</b></td>
                <td class="col6"><b>Description / Course</b></td>
                <td class="col2"><b>Cost</b></td>
            </tr>
            </thead>
            <?php
            foreach($revenues as $revenue){
                echo '<tr>
                <td>'.date("d-m-Y", strtotime($revenue->date)).'</td>
                <td>'.$revenue->student_number.'</td>
                <td>'.$revenue->description.'</td>
                <td>'.$revenue->cost.'</td>
            </tr>';
            }
            ?>
        </table>
    </div>
</main>
</body>
</html>