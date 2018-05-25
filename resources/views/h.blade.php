 
@extends('layouts.app')

@section('content')
<div class="container">
                     <div class="row">
                       <div class="col-sm-12"> 
                       <h3 style="color:#398439;">Assign Stage</h3>&nbsp;&nbsp;&nbsp;&nbsp;
                          &nbsp;&nbsp;&nbsp;     <input id="selectall" onClick="selectAll(this)" type="checkbox" value="ALL"><span style="color:orange;font-size:15px">&nbsp;&nbsp; ALL</span>
                          <table>
                             <tr id="sp">
                             <div class="checkbox">
                            <lable><td style=" padding:20px 40px 20px 40px;" ><input type="checkbox" name="stage[]" value="Planning">&nbsp;&nbsp;Planning</td>
                                 <td  style=" padding:20px 40px 20px 40px;"><input type="checkbox" name="stage[]" value="Digging">&nbsp;&nbsp;Digging</td>
                                 <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Foundation">&nbsp;&nbsp;Foundation</td>
                                 <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Pillars">&nbsp;&nbsp;Pillars</td>
                                 <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Walls">&nbsp;&nbsp;Walls</td></lable>
                                 </div>
                                 </tr>
                                 </table>
                                 </div>
                                 </div>
                                 </div>
                                 @endsection
