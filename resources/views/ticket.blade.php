@extends('layouts.app')

@section('content')
<div class="col-md-8">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default" style="border-color:green">
            <div class="panel-heading text-center" style="background-color:green">
                <b style="color:white">Tickets</b>
                <a  href="javascript:history.back()" class="btn btn-sm btn-danger btn-sm pull-right">Back</a> 
            </div>
             @if (session()->has('success'))
                    <center><h4 style="color:green;size:20px;">{{ session('message') }}</h4></center>
                    @endif
        <table  class="table table-responsive table-striped" border="1">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>UserName</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>category</th>
                        <th>Product</th>
                        <th>Status</th>
                        <th>Chat</th>
                        <th>Close Ticket</th>
                        <th>Feedback</th>
                        
                    </tr>
                </thead>

                <tbody>
                <?php $i = 1 ?>
   @foreach($data->ticket as $ticket)
          <tr>

            <td></td>
          </tr>
    
    @endforeach
                
</tbody>
</table>

</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
    function submit(arg){
        
        document.getElementById('submit'+arg).submit();
    }

</script>
@endsection