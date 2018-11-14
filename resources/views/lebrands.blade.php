<style>
.dot {
    height: 8px;
    width: 8px;
    background-color: green;
    border-radius: 50%;
    display: inline-block;
}
</style>
@extends('layouts.app')
@section('content')
<div class="col-md-6 col-md-offset-3">
    <div class="panel panel-default" style="border-color: green;">
                <div class="panel-heading text-center" style="background-color:green; color:white;"><b>Categories And Brands</b>
                    @if(session('ErrorFile'))
                        <div class="alert-danger pull-right">{{ session('ErrorFile' )}}</div>
                    @endif 
                </div>
                <div class="panel-body" >

                    <table class="table table-responsive " >
                        <thead> 
	                        <th>Category</th>
	                        <th>Brand</th>
                        </thead>
                        <tr> 
                            <td><label>M-Sand</label></td>
                            <td><span class="dot" ></span>&nbsp;&nbsp;Triveni<br>
                            	<span class="dot" ></span>&nbsp;&nbsp;SRK<br>
                            	<span class="dot" ></span>&nbsp;&nbsp;VRR Concrete Products
                            </td>
                        </tr>
                        <tr>
                            <td><label>Aggregates</label></td>
                            <td><span class="dot" ></span>&nbsp;&nbsp;SRK<br>
                            <span class="dot" ></span>&nbsp;&nbsp;VRR concrete products</td>
                        </tr>
                        <tr>
                            <td><label>Cement</label></td>
                            <td><span class="dot" ></span>&nbsp;&nbsp;Chettinad<br>
                            <span class="dot" ></span>&nbsp;&nbsp;Dalmia<br>
                            <span class="dot" ></span>&nbsp;&nbsp;ultra tech<br>
                            <span class="dot" ></span>&nbsp;&nbsp;birla super</td>
                        </tr>
                        <tr>
                            <td><label>Steel</label></td>
                            <td><span class="dot" ></span>&nbsp;&nbsp;Tirumala <br>
                            	<span class="dot" ></span>&nbsp;&nbsp;Prime Gold <br>
                             	<span class="dot" ></span>&nbsp;&nbsp;VRKP<br>
                             	<span class="dot" ></span>&nbsp;&nbsp;Sunvik<br>
                         		<span class="dot" ></span>&nbsp;&nbsp;A one gold<br>
                         		<span class="dot" ></span>&nbsp;&nbsp;RD steel</td>
                        </tr>
                        <tr>
                            <td><label>Electricals</label></td>
                            <td><span class="dot" ></span>&nbsp;&nbsp;Havells<br>
                            	<span class="dot" ></span>&nbsp;&nbsp;Hager<br>
                            	<span class="dot" ></span>&nbsp;&nbsp;Standard<br>
                            	<span class="dot" ></span>&nbsp;&nbsp;LLyod<br>
                            	<span class="dot" ></span>&nbsp;&nbsp;Crab Tree<br>
                            	<span class="dot" ></span>&nbsp;&nbsp;Hi-fi</td>
                        </tr>
                         <tr>
                            <td><label>Plywoods</label></td>
                            <td><span class="dot" ></span>&nbsp;&nbsp;Oswin plywoods<br>
                             <span class="dot" ></span>&nbsp;&nbsp;Keshav plywoods</td>
                        </tr>
                        <tr>
                            <td><label>UPVC Doors And Windows</label></td>
                            <td><span class="dot" ></span>&nbsp;&nbsp;UBS<br>
                           	<span class="dot" ></span>&nbsp;&nbsp;Aparna Venster<br>
                         	<span class="dot" ></span>&nbsp;&nbsp;Karthik doors and windows</td>
                        </tr>
                        <tr> 
                            <td><label>RMC</label></td>
                            <td><span class="dot" ></span>&nbsp;&nbsp;RMC India P Ltd<br>
                             <span class="dot" ></span>&nbsp;&nbsp;Qcrete<br>
                             <span class="dot" ></span>&nbsp;&nbsp;3Q Meister <br>
                             <span class="dot" ></span>&nbsp;&nbsp;TBS<br>
                         <span class="dot" ></span>&nbsp;&nbsp;Sri Venkateshwara Ready mix concrete</td>
                        </tr>
                        <tr>
                            <td><label>Plumbing</label></td>
                            <td><span class="dot" ></span>&nbsp;&nbsp;Raksha pipes(shand)<br>
                             <span class="dot" ></span>&nbsp;&nbsp;Avon Pipes<br>
                         <span class="dot" ></span>&nbsp;&nbsp;Ashirwadh pipes</td>
                        </tr>
                        <tr>
                            <td><label>Blocks</label></td>
                            <td><span class="dot" ></span>&nbsp;&nbsp;APCO<br>
                             <span class="dot" ></span>&nbsp;&nbsp;VRR concrete</td>
                        </tr>
                        <tr>
                            <td><label>Sanitary And Bath Fittings</label></td>
                            <td><span class="dot" ></span>&nbsp;&nbsp;Bravat<br>
                             <span class="dot" ></span>&nbsp;&nbsp;Cotto<br>
                             <span class="dot" ></span>&nbsp;&nbsp;Parryware<br>
                            <span class="dot" ></span>&nbsp;&nbsp;Cera<br>
                            <span class="dot" ></span>&nbsp;&nbsp;Jaguar<br>
                            <span class="dot" ></span>&nbsp;&nbsp;Xen<br>
                        	<span class="dot" ></span>&nbsp;&nbsp;Sonara</td>
                        </tr>
                        <tr>
                            <td><label>Flooring</label></td>
                            <td><span class="dot" ></span>&nbsp;&nbsp;Cotto<br>
                            <span class="dot" ></span>&nbsp;&nbsp;Crystal ceramics <br>
                            <span class="dot" ></span>&nbsp;&nbsp;Nanogress<br>
                            <span class="dot" ></span>&nbsp;&nbsp;Cera<br>
                           <span class="dot" ></span>&nbsp;&nbsp;RAK<br>
                           <span class="dot" ></span>&nbsp;&nbsp;oasis<br>
                           <span class="dot" ></span>&nbsp;&nbsp;Max granito<br>
                           <span class="dot" ></span>&nbsp;&nbsp;Captivo<br>
                           <span class="dot" ></span>&nbsp;&nbsp;Victory<br>
                        	<span class="dot" ></span>&nbsp;&nbsp;Naveen tiles</td>
                        </tr>
                        <tr>
                            <td><label>Paintings</label></td>
                            <td><span class="dot" ></span>&nbsp;&nbsp;Nerolac</td>
                        </tr>
                        <tr>
                            <td><label>Wood And Adhesive</label></td>
                            <td><span class="dot" ></span>&nbsp;&nbsp;Nerolac<br>
                            <span class="dot" ></span>&nbsp;&nbsp;Laticrete</td>
                        </tr>
                     </table>
                </div>
            </div>
</div>

@endsection