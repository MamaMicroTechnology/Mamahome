<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quotation</title>
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
    $bill = explode(", ", $data['price']->billaddress);
    $ship = explode(", ", $data['price']->shipaddress);
@endphp

    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            <h4 style="background-color:#FD871F;padding:5px;" class="text-center">QUOTATION</h4>
            
            <div class="pull-left" style="padding-top: 20px;">
                <b>Mama Home Pvt. Ltd.</b>
            </div>
            <div class="pull-right text-right col-md-6">
                <img height="35px" width="250px" src="data:image/png;base64,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" alt="">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="pull-left">
                #363,19th Main Road, 1st Block<br>
                Rajajinagar, Bangalore-560010<br>
                <b>GST : 29AAKCM5956G1ZX</b><br>
                CIN : U45309KA2016PTC096188<br>
                Email : info@mamahome360.com<br>
            </div>
            <div class="pull-right">

               <div style="padding-right: 50px;">Quotation ID : {{ $data['price']->quotation_id }}<br>
                Date : {{ date('d F, Y') }}<br>
              {{ $data['price']->manu_id == null ? "project ID" : "Manufacturer ID" }} : {{ $data['price']->manu_id == null ? $data['price']->project_id : $data['price']->manu_id}}  <br>
             
            </div>
            </div>
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="pull-left">
                <b>BILL TO : </b>
                <br><b>{{ $data['procurement'] == null ? $data['mprocurement']->name : $data['procurement']->procurement_name }} </b>
                    @for($i = 0;$i < count($bill); $i++)
                    @if($i % 3 == 0)
                        <br>{{ $bill[$i] }}
                    @else
                        {{ $bill[$i] }}
                    @endif
                    @endfor
            </div>
            <div class="pull-right">
                <b> SHIP TO :</b>         
                <br><b>{{ $data['procurement'] == null ? $data['mprocurement']->name : $data['procurement']->procurement_name }} </b>
                    @for($i = 0;$i < count($ship); $i++)
                    @if($i % 3 == 0)
                        <br>{{ $ship[$i] }}
                    @else
                        {{ $ship[$i] }}
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
                            <th>SL.NO</th>
                            <th>DESCRIPTION OF GOODS</th>
                            <th>HSN/SAC</th>
                            <th>UNIT</th>
                            <th colspan="2">QUANTITY</th>
                            <th>RATE/UNIT</th>
                            <th colspan="2" >AMOUNT(<img src="https://cdn3.iconfinder.com/data/icons/indian-rupee-symbol/800/Indian_Rupee_symbol.png" width="8px" height="10px" style="margin-top: 4px;">)</th>
                                <?php
                           $count = count($data['price']['igstpercent']);
                        
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                 
                        <tr>
                            <td class="text-center">1</td>
                            <td>{{$data['price']->description}}</td>
                            <td></td>
                            <td>{{ $data['price']->unit }}</td>
                            <td colspan="2">{{ $data['price']->quantity }}</td>
                            <td>{{ $data['price']->pricewithoutgst}}</td>
                            <td colspan="2">{{ $data['price']->totalamount}}</td>
                        </tr>
                
                        <tr>
                            <td colspan="4" rowspan="6"></td>
                            <td colspan="2" class="text-left"><b>GROSS AMOUNT</b></td>
                            <td class="text-left"></td>
                            <td colspan="2" class="text-left">{{ $data['price']->totalamount }}</td>
                        </tr>
                        <!-- <tr>
                            <td class="text-left">Discount Amount</td>
                            <td class="text-left"></td>
                            <td class="text-left"></td>
                        </tr> -->
                        <tr>
                            <td colspan="2"  class="text-left"><b>TOTAL AMOUNT</b></td>
                            <td class="text-left"></td>
                            <td colspan="2" class="text-left">{{ $data['price']->totalamount }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-left">CGST({{$data['price']->cgstpercent}}%)</td>
                            <td class="text-left"></td>
                            <td colspan="2" class="text-left">
                                @if($count == 1)
                                  -
                                  @else
                                    {{ $data['price']->cgst }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-left">SGST({{$data['price']->sgstpercent}}%)</td>
                            <td class="text-left"></td>
                            <td colspan="2" class="text-left">
                                @if($count == 1)
                                  -
                                  @else
                                {{ $data['price']->sgst }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-left">IGST({{$data['igst']}}%)</td>
                            <td class="text-left"></td>
                            <td colspan="2" class="text-left">
                                @if($count == 1)
                                {{ $data['price']->igst }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-left"><b>TOTAL</b></td>
                            <td class="text-left"></td>
                            <td colspan="2" class="text-left">{{ $data['price']->amountwithgst }}</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="9">
                                <b> Amount In Words</b> &nbsp;&nbsp;&nbsp; {{ $data['price']->gstamount_word }} Only
                            </td>
                        </tr>
                        <tr>
                            <th rowspan=2>HSN/SAC</th>
                            <th rowspan=2>Taxable Value</th>
                            <th colspan=2>CGST</th>
                            <th colspan=2>SGST</th>
                            <th colspan=2>IGST</th>
                            <th rowspan=2>Total Tax Amount</th>
                        </tr>
                        <tr>
                            <th>Rate</th>
                            <th>Amount</th>
                            <th>Rate</th>
                            <th>Amount</th>
                             <th>Rate</th>
                            <th>Amount</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{ $data['price']->totalamount}}</td>
                            <td>{{$data['price']->cgstpercent}}%</td>
                            <td>@if($count == 1)
                                  -
                                  @else
                                    {{ $data['price']->cgst }}
                                @endif</td>
                            <td>{{$data['price']->sgstpercent}}%</td>
                            <td>@if($count == 1)
                                  -
                                  @else
                                    {{ $data['price']->cgst }}
                                @endif</td>
                            <td>{{$data['igst']}}%</td>
                            <td>@if($count == 1)
                                {{ $data['price']->igst }}
                                @else
                                    -
                                @endif</td>
                            <td>{{ $data['price']->totaltax}}</td>
                        </tr>
<tr class="clearfix">
                            <td colspan="9">
                                <div class="pull-left col-md-6 clearfix" style="padding-left: 150px;">
                                    <b>Tax Amount In Words</b> &nbsp;&nbsp;&nbsp; {{ $data['price']->tax_word }} Only
                                </div>
                                <br><br>
                                <div class="pull-left col-md-6 clearfix">
                                    <i><b>Terms And Conditions</b></i>
                                    <br>
                                    Tax invoice will be provided once goods gets delivered<br>
                                    Reward Points are not Applicable for Offer Price<br>
                                    <br>
                                     This Quotation is Valid For Only 24Hours <br>
                                </div>
                                <div class="pull-right col-md- clearfix6">
                                    For  Mama Home Pvt Ltd 
                                </div>
                                <br><br><br><br>
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
                            <td colspan="9" class="text-center">This is a computer generated invoice</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>