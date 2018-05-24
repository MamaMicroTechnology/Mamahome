@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-success">
                    <div class="panel-heading">Mamahome Invoice</div>
                    <div class="panel-body">
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
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#43, Residency Road, Shanthala Nagar,<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ashok Nagar, Bengaluru, Karnataka 560025<br>
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
                                            Invoice No. : 32132132132132<br>
                                            Invoice Date. : 12/02/2018
                                        </div>    
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">Project Id</td>
                                <td colspan="2">23</td>
                            </tr>
                            <tr>
                                <td colspan="2">Delivery Date:</td>
                                <td colspan="2">80/01/2018</td>
                            </tr>
                            <tr>
                                <td colspan="2">Invoice No</td>
                                <td colspan="2">234234234</td>
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
                                <td colspan="2">seetharam</td>
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
                                <td>Cement</td>
                                <td>40</td>
                                <td>10000</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Blocks</td>
                                <td>2000</td>
                                <td>450000</td>
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
                                        ₹234
                                    <br>₹345
                                    <br>₹47456
                                    <br>
                                    <br>₹48035
                                </td>
                            </tr>
                            <tr>
                                <td colspan=4 style="text-align: center;">
                                    Amount In Words : <?php echo(strtoupper($text)); ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection