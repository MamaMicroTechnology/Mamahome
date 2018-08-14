@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-success">
                    <div class="panel-heading">Mamahome Invoice</div>
                    <div class="panel-body">
                   <center> <button onclick="myFunction()" id="invoice" class="btn btn-primary">Print The Invoice</button></center><br>
                    @foreach($invoices as $invoice)
                        <table class="table table-hover" border=1>
                            <tr>
                                <th colspan="4" style="background-color:rgb(191, 191, 63)">
                                    <center>GST INVOICE<br>
                                        <small>Mamahome Pvt. Ltd.</small>
                                    </center>
                                </th>
                            </tr>
                            <tr>
                            
                                <td colspan="2">
                                    Regd. Off :<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#363,19th Main Road, 1st Block<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rajajinagar, Bengaluru, Karnataka 560010<br>
                                </td>
                                <td colspan="2"><br>
                                    Ph: 9110636146<br>
                                    Email: info@mamahome360.com
                                </td>
                            </tr>
                            <tr>
                                <td colspan=4>
                                    <div class="col-md-12">
                                        GST NO : 3495830948304958
                                        <div class="col-md-4 pull-right">
                                            Invoice No. : {{ $invoice->invoice_id }}<br>
                                            Invoice Date. : 12/02/2018
                                        </div>    
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">Project Id</td>
                                <td colspan="2">{{ $invoice->project_id }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">Delivery Date:</td>
                                <td colspan="2">{{ $invoice->delivery_date }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">Invoice No</td>
                                <td colspan="2">{{ $invoice->invoice_id }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Shipped To:<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;seetharam,<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Flat no.412, 4th Floor Whitestone Veroso,<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;k.Dommasandra, Sonnenahalli, Krishnarajapura,<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bengaluru, Karnataka 560049, India
                                </td>
                                <td colspan="2">
                                    Bill To:<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;seetharam,<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Flat no.412, 4th Floor Whitestone Veroso,<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;k.Dommasandra, Sonnenahalli, Krishnarajapura,<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bengaluru, Karnataka 560049, India
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">Customer Name</td>
                                <td colspan="2">{{ $invoice->customer_name }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" style="padding-bottom:20px;"></td>
                            </tr>
                            <tr style="background-color: rgba(127, 178, 76, 0.7)">
                                <td>S. No.</td>
                                <td>Description of Item</td>
                                <td>Quantity</td>
                                <td>Price</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>{{ $invoice->item }}</td>
                                <td>{{ $invoice->quantity }}</td>
                                <td>{{ $invoice->price }}</td>
                            </tr>
                            <tr>
                                <td colspan=3>
                                    <div class="col-md-5 col-md-offset-7">
                                        CGST - Output Payable @ 2.5 %<br>
                                        SGST - Output Payable @ 2.5 %<br>
                                        Basic Total - <br>
                                    </div>
                                    <div class="col-md-3 pull-right">
                                        <br>Total:
                                    </div>
                                </td>
                                <td>
                                        ₹{{ $cgst = ($invoice->total_amount * 2.5/100) }}
                                    <br>₹{{ $sgst = ($invoice->total_amount * 2.5/100) }}
                                    <br>₹{{ $btotal = $invoice->total_amount }}
                                    <br>
                                    <br>₹{{ $total = round($cgst + $sgst + $btotal) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan=4 style="text-align: center;">
                                    Amount In Words :
                                    <?php
                                        $amtInWords = convert($total);
                                        echo(strtoupper($amtInWords));
                                    ?>
                                </td>
                            </tr>
                            <!-- <tr>
                                <td colspan=2>Transactional Profit</td>
                                <td colspan=2>{{ $invoice->transactional_profit }}</td>
                            </tr> -->
                        </table>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    function convert($number){
        $length = strlen($number);
        if($number < 20){
            $length = 1;
        }
        $ones = array(
            0 => "", 
            1 => "one", 
            2 => "two", 
            3 => "three", 
            4 => "four", 
            5 => "five", 
            6 => "six", 
            7 => "seven", 
            8 => "eight", 
            9 => "nine", 
            10 => "ten", 
            11 => "eleven", 
            12 => "twelve", 
            13 => "thirteen", 
            14 => "fourteen", 
            15 => "fifteen", 
            16 => "sixteen", 
            17 => "seventeen", 
            18 => "eighteen", 
            19 => "nineteen" 
        ); 
        $tens = array(
            0 => "and",
            2 => "twenty", 
            3 => "thirty", 
            4 => "forty", 
            5 => "fifty", 
            6 => "sixty", 
            7 => "seventy", 
            8 => "eighty", 
            9 => "ninety" 
        ); 
        $hundreds = array( 
            "hundred", 
            "thousand", 
            "lakhs", 
            "crores", 
            "trillion", 
            "quadrillion" 
        );
        switch($length){
            case 1:
            // ones
                $text = $ones[$number];
                break;
            case 2:
            // tens
                $first = substr($number,0,1);
                $second = substr($number,-1);
                if($second != 0){
                    $text = $tens[$first]." ".$ones[$second];
                }else{
                    $text = $tens[$first];
                }
                break;
            case 3:
            // hundreds
                $first = substr($number,0,1);
                $text = $ones[$first]." ".$hundreds[0];
                $second = substr($number,-2);
                if($second != 0){
                    $number = $second;
                    $first = substr($number,0,1);
                    $second = substr($number,-1);
                    if($second != 0){
                        $text .= " ".$tens[$first]." ".$ones[$second];
                    }else{
                        $text .= " ".$tens[$first];
                    }
                }
            break;
            case 4:
            // thounsands
                $first = substr($number,0,1);
                $text = $ones[$first]." ".$hundreds[1];
                $second = substr($number,-3);
                if($second != 0){
                    $number = $second;
                    $first = substr($number,0,1);
                    if($first != 0){
                        $text .= " ".$ones[$first]." ".$hundreds[0];
                    }
                    $second = substr($number,-2);
                    if($second != 0){
                        $number = $second;
                        $first = substr($number,0,1);
                        $second = substr($number,-1);
                        if($second != 0){
                            $text .= " ".$tens[$first]." ".$ones[$second];
                        }else{
                            $text .= " ".$tens[$first];
                        }
                    }
                }
                break;
            case 5:
            // ten thousands
                $first = substr($number,0,2);
                if($first < 20){
                    $text = $ones[$first]." ".$hundreds[1];
                }else{
                    $another = substr($first,0,1);
                    $and = substr($first,-1);
                    $text = $tens[$another]." ".$ones[$and]." ".$hundreds[1];
                }
                $second = substr($number,-3);
                if($second != 0){
                    $number = $second;
                    $first = substr($number,0,1);
                    if($first != 0){
                        $text .= " ".$ones[$first]." ".$hundreds[0];
                    }
                    $second = substr($number,-2);
                    if($second != 0){
                        $number = $second;
                        $first = substr($number,0,1);
                        $second = substr($number,-1);
                        if($second != 0){
                            $text .= " ".$tens[$first]." ".$ones[$second];
                        }else{
                            $text .= " ".$tens[$first];
                        }
                    }
                }
                break;
            case 6:
            // lakhs
                $first = substr($number,0,1);
                if($first == 1){
                    $text = $ones[$first]." lakh";
                }else{
                    $text = $ones[$first]." ".$hundreds[2];
                }
                $first = substr($number,1,2);
                $check = substr($first,0,1);
                if($check == 0){
                    $first = substr($first,1,1);
                }
                if($first < 20){
                    $text .= " ".$ones[$first]." ".$hundreds[1];
                }else{
                    $another = substr($first,0,1);
                    $and = substr($first,-1);
                    $text .= " ".$tens[$another]." ".$ones[$and]." ".$hundreds[1];
                }
                $second = substr($number,-3);
                if($second != 0){
                    $number = $second;
                    $first = substr($number,0,1);
                    if($first != 0){
                        $text .= " ".$ones[$first]." ".$hundreds[0];
                    }
                    $second = substr($number,-2);
                    if($second != 0){
                        $number = $second;
                        $first = substr($number,0,1);
                        $second = substr($number,-1);
                        if($second != 0){
                            $text .= " ".$tens[$first]." ".$ones[$second];
                        }else{
                            $text .= " ".$tens[$first];
                        }
                    }
                }
                break;
            default: $text = "";
        }
        return $text;
    }
    ?>

    <script type="text/javascript">
        
       
function myFunction() {

 document.getElementById("invoice").style.display="none";
   window.print();
   document.getElementById("invoice").style.display="";
}
    </script>
@endsection
