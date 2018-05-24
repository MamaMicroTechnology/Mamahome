@extends('layouts.app')
@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
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
                        <td colspan=4 class="hidden">
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
                        <td colspan="2">{{ $orders->project_id }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Delivery Date:</td>
                        <td colspan="2">{{ date('d/m/Y'),strtotime($orders->delivered_on )}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Invoice No</td>
                        <td colspan="2">{{ $_GET['id'] }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Shipped To:<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $owner->owner_name }}<br>
                            <?php
                                $cuAddress = explode(", ",$address->address);
                                for($i = 0;$i<count($cuAddress); $i++){
                                    echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$cuAddress[$i].",<br>");
                                }
                            ?>
                                                        
                        </td>
                        <td colspan="2">
                            Bill To:<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $owner->owner_name }}<br>
                            <?php
                                $cuAddress = explode(", ",$address->address);
                                for($i = 0;$i<count($cuAddress); $i++){
                                    echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$cuAddress[$i].",<br>");
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Customer Name</td>
                        <td colspan="2">{{ $owner->owner_name }}</td>
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
                    <?php
                        $products = explode(",",$orders->main_category);
                    ?>
                    @for($i = 0;$i<count($products);$i++)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $products[$i] }}</td>
                        <td><input type="text" name="quantity[]" placeholder="Quantity" id="quantity{{ $i }}" class="form-control"></td>
                        <td><input type="text" name="price[]" placeholder="Price" id="price{{ $i }}" class="form-control"></td>
                    </tr>
                    @endfor
                    <!-- <tr>
                        <td colspan=3>
                            <div class="col-md-5 col-md-offset-7">
                                <p>CGST - Output Payable @ 2.5 %</p>
                                <p>SGST - Output Payable @ 2.5 %</p>
                                <p>Basic Total - </p>
                                <hr>
                                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    Total:</p>
                            </div>
                        </td>
                        <td>
                            <p id="cgst">₹0</p>
                            <p id="sgst">₹0</p>
                            <p id="bTotal">₹0</p>
                                <hr>
                            <p id="total">₹0</p>
                        </td>
                    </tr> -->
                    <tr>
                        <td colspan=4 style="text-align: center;">
                            <center>
                                <h4>Manufacturer Details</h4>
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td colspan=2>Invoice Pic</td>
                        <td colspan=2><input type="file" name="invoicePic" class="form-control"></td>
                    </tr>
                    <tr>
                        <td colspan=2>Signature</td>
                        <td colspan=2><input type="file" name="invoicePic" class="form-control"></td>
                    </tr>
                    <tr>
                        <td colspan=2>Weighment Slip</td>
                        <td colspan=2><input type="file" name="invoicePic" class="form-control"></td>
                    </tr>
                    <tr>
                        <td colspan=2>Amount Given To Manufacturer</td>
                        <td colspan=2><input type="text" placeholder="Amount paid to manufacturer" name="invoicePic" class="form-control"></td>
                    </tr>
                    <tr>
                        <td colspan=2>Manufacturer No.</td>
                        <td colspan=2>MH210</td>
                    </tr>
                    <tr>
                        <td colspan=2>Quantity</td>
                        <td colspan=2><input type="text" name="" id="" class="form-control"></td>
                    </tr>
                    <tr>
                        <td colspan=2>Date of Invoice</td>
                        <td colspan=2><input type="date" name="" id="" class="form-control"></td>
                    </tr>
                    <tr>
                        <td colspan=2>Total Amount</td>
                        <td colspan=2><input type="text" name="" id="" class="form-control"></td>
                    </tr>
                    <tr>
                        <td colspan=2>Pic Manufacturer Invoice</td>
                        <td colspan=2><input type="file" name="" id="" class="form-control"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection