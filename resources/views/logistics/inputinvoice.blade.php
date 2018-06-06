@extends('layouts.app')
@section('content')
<?php
    $products = explode(",",$orders->main_category);
?>
@for($i = 0;$i<count($products);$i++)
<form method="POST" action="/saveinvoice" enctype="multipart/form-data">
{{ csrf_field() }}
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
                        <input type="hidden" name="project_id" value="{{ $orders->project_id }}">
                    </tr>
                    <tr>
                        <td colspan="2">Delivery Date:</td>
                        <td colspan="2">{{ date('d/m/Y'),strtotime($orders->delivered_on )}}</td>
                        <input type="hidden" name="delivery_date" value="{{ date('Y-m-d'), strtotime($orders->delivered_on) }}">
                    </tr>
                    <tr>
                        <td colspan="2">Invoice No</td>
                        <td colspan="2">{{ $_GET['id'] }}</td>
                        <input type="hidden" name="invoice_no" value="{{ $_GET['id'] }}">
                    </tr>
                    <tr>
                        <td colspan="2">
                            Shipped To:<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $owner->owner_name }}<br>
                            <?php
                                $cuAddress = explode(", ",$address->address);
                                for($j = 0;$j<count($cuAddress); $j++){
                                    echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$cuAddress[$j].",<br>");
                                }
                            ?>
                            <input type="hidden" name="address" value="{{ $address->address }}">                       
                        </td>
                        <td colspan="2">
                            Bill To:<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $owner->owner_name }}<br>
                            <?php
                                $cuAddress = explode(", ",$address->address);
                                for($k = 0;$k<count($cuAddress); $k++){
                                    echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$cuAddress[$k].",<br>");
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Customer Name</td>
                        <td colspan="2">{{ $owner->owner_name }}</td>
                        <input type="hidden" name="customer_name" value="{{ $owner->owner_name }}">
                    </tr>
                    <tr>
                        <td colspan=2>Date of Invoice</td>
                        <td colspan=2><input required type="date" name="dateOfInvoice" id="" class="form-control"></td>
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
                        <td>{{ $products[$i] }}</td>
                        <input type="hidden" name="product" value="{{ $products[$i] }}">
                        <td><input type="text" required name="quantity" placeholder="Quantity" id="quantity{{ $i }}" class="form-control"></td>
                        <td><input type="text" required name="price" placeholder="Price" id="price{{ $i }}" class="form-control"></td>
                    </tr>
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
                        <td colspan=2><input type="file" name="signature" class="form-control"></td>
                    </tr>
                    <tr>
                        <td colspan=2>Weighment Slip</td>
                        <td colspan=2><input type="file" name="weighment" class="form-control"></td>
                    </tr>
                    <tr>
                        <td colspan=2>Pic Manufacturer Invoice</td>
                        <td colspan=2><input type="file" name="manufacturer_invoice" id="" class="form-control"></td>
                    </tr>
                    <tr>
                        <td colspan=2>Amount Given To Manufacturer</td>
                        <td colspan=2><input required type="text" placeholder="Amount paid to manufacturer" name="amount_to_manufacturer" class="form-control"></td>
                    </tr>
                    <tr>
                        <td colspan=2>Mamahome Invoice Amount</td>
                        <td colspan=2><input required type="text" name="mhinvoice" placeholder="Mamahome Invoice Amount" id="" class="form-control"></td>
                    </tr>
                    <tr>
                        <td colspan=2>Manufacturer No.</td>
                        <td colspan=2>MH210</td>
                    </tr>
                    <!-- <tr>
                        <td colspan=2>Quantity</td>
                        <td colspan=2><input type="text" name="" placeholder="Quantity" id="" class="form-control"></td>
                    </tr> -->
                    <tr>
                        <td colspan=4>
                            <button type="submit" class="btn btn-primary form-control">Save</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</form>
@endfor
@endsection