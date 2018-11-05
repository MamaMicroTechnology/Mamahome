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
    <style>
        body{
            font-size: 12px;
        }
        table{
            padding: 0px;
        }
    </style>
</head>
<body>
@php
    $normal_address = explode(", ", $data['address']->address);
    $items = explode(", ",$data['products']->sub_category);
@endphp

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h4 style="background-color:#99ddff;padding:10px;" class="text-center">PROFORMA INVOICE</h4>
            <br>
            <div class="pull-left">
                <b>MamaHome Pvt. Ltd.</b>
            </div>
            <div class="pull-right text-right">
                Invoice No :  #{{ $data['products']->id }}<br>
                Date : {{ date('d F, Y') }} <br>
                Project ID : {{ $data['products']->project_id }} <br>
                Mode Of Payment : {{ $data['products']->payment_mode }}
            </div>
            <br><br>
            <div>
                #363,19th Main Road, 1st Block<br>
                Rajajinagar, Bangalore-560010<br>
                GST : 29AAKCM5956G1ZX<br>
                CIN : U45309KA2016PTC096188<br>
                Email : info@mamahome360.com<br>
            </div>
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="pull-left">
                BILL TO : 
                    <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['procurement']->procurement_name }}
                    @for($i = 0;$i < count($normal_address); $i++)
                    @if($i % 3 == 0)
                        <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $normal_address[$i] }}
                    @else
                        , {{ $normal_address[$i] }}
                    @endif
                    @endfor
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
                            <th>ITEM #</th>
                            <th>DESCRIPTION OF GOODS</th>
                            <th>HSN/SAC</th>
                            <th>UNIT</th>
                            <th>QUANTITY</th>
                            <th>RATE (PER UNIT)</th>
                            <th>AMOUNT</th>
                        </tr>
                    </thead>
                    <tbody>
                    @for($j = 0; $j < count($items); $j++)
                        <tr>
                            <td class="text-center">{{ $j + 1 }}</td>
                            <td>{{ $items[$j] }}</td>
                            <td></td>
                            <td></td>
                            <td>{{ $data['products']->quantity }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endfor
                        <tr>
                            <td colspan="4" rowspan="7"></td>
                            <td class="text-right"><b>GROSS AMOUNT</b></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                        </tr>
                        <tr>
                            <td class="text-right">Discount Amount</td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                        </tr>
                        <tr>
                            <td class="text-right"><b>TOTAL AMOUNT</b></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                        </tr>
                        <tr>
                            <td class="text-right">CGST(14%)</td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                        </tr>
                        <tr>
                            <td class="text-right">SGST(14%)</td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                        </tr>
                        <tr>
                            <td class="text-right">IGST</td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                        </tr>
                        <tr>
                            <td class="text-right"><b>TOTAL</b></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="7">
                                Amount In Words
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7"></td>
                        </tr>
                        <tr>
                            <th rowspan=2>HSN/SAC</th>
                            <th rowspan=2>Taxable Value</th>
                            <th colspan=2>CGST</th>
                            <th colspan=2>SGST</th>
                            <th rowspan=2>Total Tax Amount</th>
                        </tr>
                        <tr>
                            <th>Rate</th>
                            <th>Amount</th>
                            <th>Rate</th>
                            <th>Amount</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="clearfix">
                            <td colspan="7">
                                <div class="pull-left col-md-6 clearfix">
                                    Tax Amount In Words
                                </div>
                                <div class="pull-right col-md- clearfix6">
                                    s
                                </div>
                                <br><br>
                                <div class="pull-left col-md-6 clearfix">
                                    <i><b>Terms And Conditions</b></i>
                                    <br>
                                    Reward Points are not Applicable for Offer Price
                                </div>
                                <div class="pull-right col-md- clearfix6">
                                    For  Mama Home Pvt Ltd 
                                </div>
                                <br><br><br>
                                <div class="pull-left col-md-6 clearfix">
                                    <i><b>Payment Terms:</b></i>
                                    <br>
                                    Full Payment in Advance 
                                </div>
                                <div class="pull-right col-md- clearfix6">
                                    Authorised Signatory
                                </div>
                                <br><br>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7" class="text-center">This is a computer generated invoice</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>