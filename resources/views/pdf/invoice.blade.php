<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
@php
    $normal_address = explode(", ", $data['address']->address);
    $items = explode(", ",$data['products']->sub_category);
@endphp

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h2 style="background-color:#99ddff;padding:10px;" class="text-right">PURCHASE ORDER</h2>
            <br><br>
            <div class="pull-left">
                MamaHome Pvt. Ltd.
                <br><small><i>Linking Construction Industry With A Professional Approach</i></small>
            </div>
            <div class="pull-right text-right">
                P.O. #5600012<br>
                Date : {{ date('d F, Y') }}
            </div>
                <br>
                <br>
                <br>
                <br>
            <div>
                #363,19th Main Road, 1st Block<br>
                Rajajinagar, Bangalore-560010<br>
                +91 - 9110636146<br>
                info@mamahome360.com<br>
            </div>
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="pull-left">
                VENDOR : 
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Murali
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MG Road, Bangalore
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#12/4, PIN 5600231
            </div>
            <div class="pull-right">
                SHIP TO :
                    <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['procurement']->procurement_name }}
                    @for($i = 0;$i < count($normal_address); $i++)
                    @if($i % 3 == 0)
                        <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $normal_address[$i] }}
                    @else
                        , {{ $normal_address[$i] }}
                    @endif
                @endfor
            </div>
        </div>
        <br><br><br><br><br><br>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <table class="table table-responsive" border=1>
                    <thead>
                        <tr style="background-color:#e6e6e6">
                            <th>SHIPPING METHOD</th>
                            <th>SHIPPING TERMS</th>
                            <th>DELIVERY DATE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>'</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table class="table table-responsive" border=1>
                    <thead>
                        <tr style="background-color:#e6e6e6">
                            <th>ITEM #</th>
                            <th>DESCRIPTION</th>
                            <th>QTY</th>
                            <th>JOB</th>
                            <th>UNIT PRICE</th>
                            <th>LINE TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                    @for($j = 0; $j < count($items); $j++)
                        <tr>
                            <td class="text-center">{{ $j + 1 }}</td>
                            <td>{{ $items[$j] }}</td>
                            <td>{{ $data['products']->quantity }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endfor
                        <tr>
                            <td colspan="4" rowspan="3"></td>
                            <td class="text-right">SUB TOTAL</td>
                            <td class="text-right"></td>
                        </tr>
                        <tr>
                            <td class="text-right">SALES TAX</td>
                            <td class="text-right"></td>
                        </tr>
                        <tr>
                            <td class="text-right">TOTAL</td>
                            <td class="text-right"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <ol>
                <li>Please send two copies of your invoice.</li>
                <li>Enter this order in accordance with the prices, terms, delivery method, and specifications listed above.</li>
                <li>Please notify us immediately if you are unable to ship as specified.</li>
                <li>Send all correnspondence to:
                <address>
                    MamaHome <br>
                    #363,19th Main Road, 1st Block<br>
                    Rajajinagar, Bangalore-560010<br>
                    +91 - 9110636146<br>
                    info@mamahome360.com<br>
                </address>
                </li>
            </ol>
        </div>
    </div>
</body>
</html>