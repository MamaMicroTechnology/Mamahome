<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Invoive</title>
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
@if( $data['manu'] == null)
@if( $data['supplier']['ship'] == null)
            @php 
                $normal_address = $data['address']->address;
               
            @endphp
            @else
            @php 
                $normal_address = $data['supplier']['ship'];
                @endphp
            @endif
@else
    @if( $data['supplier']['ship'] == null)
           @php 
                    $normal_address =$data['manu']['address'];
               
               
            @endphp
            @else 
                @php
                   $normal_address = $data['supplier']['ship']; 
               
                @endphp
            @endif
@endif


    <div class="row">
        <div align="text-center">
        <a  href="{{ URL::to('/') }}/public/supplierinvoice/{{$data['invoiceimage']}}"><p style="text-transform: uppercase;">CLICK HERE TO VIEW {{ $data['supplier']['supplier_name']}} INVOICE</p></a>
        </div>
        <div class="col-md-6 col-md-offset-3">
            <h4 style="background-color:#33cc33;padding:10px;text-transform: uppercase;" class="text-center" >{{ $data['supplier']['supplier_name']}} INVOICE</h4>
            <br>
            <div class="pull-left col-md-6" style="margin-right: 20px;margin-top: 30px;">

                <b>Mama Home Pvt. Ltd.</b>
                <br>
                #363,19th Main Road, 1st Block<br>
                Rajajinagar, Bangalore-560010<br>
                <b>GST : 29AAKCM5956G1ZX</b><br>
                Email : info@mamahome360.com<br>
            </div>
            <div class="pull-right col-md-6" style="margin-right: 5%;">

          <img src="{{ URL::to('/') }}/public/brands/{{ $data['supplierimage'] }} " height="50px" width="150px"> <br>
                Date : {{ date('d F, Y') }}<br>
                LPO : {{ $data['supplier']['lpo'] }}<br>
                Invoice Number : {{ $data['invoice']->invoice_number}}<br>
                OrderId :{{ $data['invoice']->order_id}}<br>
            </div>
        </div>
    </div><br><br>
    <div class="row">
       
            <div class="pull-left col-md-6" style="margin-left:15px;">
               <b> SUPPLIER NAME : </b><br>
                {{ $data['supplier']['supplier_name']}}<br>
               <?php
                $address = $data['supplier']['address'];
                echo wordwrap($address,45,"<br>\n");
                ?>
                    
                 <br><b>GST : {{ $data['supplier']['gst'] }}</b><br>
            </div>
           <div class="pull-right  col-md-6" style="padding-right: 30px; ">
                 <b>SHIP TO :</b><br>
               CHETTINAD CEMENT<br>
                 <?php
                $address = $data['supplier']['address'];
                echo wordwrap($address,45,"<br>\n");
                ?>
                   
            </div>
       
        <br><br><br><br><br><br><br><br>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <table class="table table-responsive" border=1>
                    <thead>
                        <tr style="background-color:#e6e6e6">
                            <th>ITEM #</th>
                            <th>DESCRIPTION OF GOODS</th>
                            <th>QUANTITY</th>
                            <th>Unit</th>
                            <th>UNIT PRICE</th>
                            <th>AMOUNT (<img src="https://cdn3.iconfinder.com/data/icons/indian-rupee-symbol/800/Indian_Rupee_symbol.png" width="8px" height="10px" style="margin-top: 4px;">)</th>
                            <?php 
                            $count = count($data['supplier']['igstpercent']) ;
                            if($count == 0){
                               
                                    $cgst = ($data['supplier']['amount'] * $data['supplier']['cgstpercent'])/100;
                                    $sgst = ($data['supplier']['amount'] * $data['supplier']['cgstpercent'])/100;
                                    $igst = "";
                            }
                            else{
                               $cgst = "";
                               $sgst = "";
                                $t1 = ($data['supplier']['amount'] * $data['supplier']['cgstpercent'])/100;
                                $t2 = ($data['supplier']['amount'] * $data['supplier']['cgstpercent'])/100;
                                $igst = $t1 + $t2 ;
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                   
                        <tr>
                            <td class="text-center">1 </td>
                            <td>{{ $data['supplier']['description']}}</td>
                        <td>{{ $data['supplier']['quantity'] }}</td>
                            <td>{{ $data['supplier']['unit'] }}</td>
                            <td>{{ $data['supplier']['unitwithoutgst']}}</td>
                            <td>{{ $data['supplier']['amount']}}</td>
                        </tr>
                   
                        <tr>
                            <td colspan="3" rowspan="5"></td>
                            <td class="text-left"><b>SUB TOTAL</b></td>
                            <td class="text-left"></td>
                            <td class="text-left">{{$data['supplier']['amount']}}</td>
                        </tr>
                        <tr>
                            <td class="text-left">CGST 
                            @if($count ==  0)
                            ({{$data['supplier']['cgstpercent']}}%)
                            @endif
                        </td>
                            <td class="text-left"></td>
                            <td class="text-left">{{$cgst}}</td>
                        </tr>
                        <tr>
                            <td class="text-left">SGST
                            @if($count == 0)
                                ({{$data['supplier']['sgstpercent']}}%)
                            @endif
                        </td>
                            <td class="text-left"></td>
                            <td class="text-left">{{$sgst}}</td>
                        </tr>
                        <tr>
                            <td class="text-left">IGST
                            @if($count == 1)
                            ({{$data['supplier']['igstpercent']}}%)
                            @endif
                        </td>
                            <td class="text-left"></td>
                            <td class="text-left">{{$igst}}</td>
                        </tr>
                        <tr>
                            <td class="text-left"><b>TOTAL</b></td>
                            <td class="text-left"></td>
                            <td class="text-left">{{$data['supplier']['totalamount']}}</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="6">
                                Amount In Words : &nbsp;&nbsp;&nbsp;  {{ $data['supplier']['tamount_words']}} ONLY
                            </td>
                        </tr>
                       
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
