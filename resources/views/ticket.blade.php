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
      @if(Auth::user()->id == $ticket->user_id)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $ticket->name }}</td>
            <td>{{ $ticket->sub }}</td>
            <td>{{ $ticket->message }}</td>
            <td>{{ $ticket->cat }}</td>
            <td>{{ $ticket->product }}</td>
            <td> <button disabled class=" btn btn-sm" style="background-color:green;color:white;">{{ $ticket->status }}</button> </td>
            <td><a href="ticketchat" class="btn btn-sm btn-primary">Chat
            </a></td>
            <td>
             <form  method="post" action="http://localhost:8000/api/close">
                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

              <select name="close" class="form-control" onchange="form.submit();">
                <option value="">-----Select---</option>
                <option {{ $ticket->status == "Close" ? 'selected' : '' }} value="Close">Close</option>
                <option {{ $ticket->status == "Open" ? 'selected' : '' }} value="Open">Open</option>
           </select>
           </form></td>
            <td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal{{$ticket->id}}">Feedback</td>
        </tr>
         <!-- The Modal -->
 
        @endif
    @endforeach
                
</tbody>
</table>
 @foreach($data->ticket as $ticket)
 <div class="modal" id="myModal{{$ticket->id}}">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header" style="background-color:#f4811f;padding:1px;">
          <h3 class="modal-title">Customer Feedback</h3>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
         <p>We Would Love to hear your thoughts or feedback on how we can improve your experience!<br><br>
        <form  method="post" id="submit{{ $ticket->id }}"  action="http://localhost:8000/api/feedback">
                    {{ csrf_field() }}
                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                    <input type="hidden" name="user_name" value="{{ $ticket->user_name }}">
                    <input type="hidden" name="user_id" value="{{ $ticket->user_id }}">
                    
          <h4>Feedback Type</h4>
          <label>
         <input type="radio" name="bug" value="comment">Comments
          </label> <br>
          <label>
              
         <input type="radio" name="bug" value="question">Questions
          </label><br>  
          <label>
              
         <input type="radio" name="bug" value="bug">Bug Reports
          </label><br>
          <label>
              
         <input type="radio" name="bug" value="feature request"> Feature Request
          </label><br>
    
        
         <h4>Feedback  </h4>
         
         <input type="text" name="feedback" class="form-control" style="width:70%;">
         <h4>Suggestions for Improvement  </h4>
         
         <input type="text" name="improve" class="form-control" style="width:70%;"><br>
        
        <center> <button type="submit"  class="btn btn-sm btn-default" style="background-color:#f4811f;color:black;" onclick="submit('{{ $ticket->id }}')">Send  &rarr;</button></center>
        
   </form>
        </div>

         <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
  @endforeach
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