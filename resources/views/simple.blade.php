<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Mama MicroTechnology</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <link rel="stylesheet" href="public/form.css" >
        <script src="form.js"></script>
        <link rel="stylesheet" type="text/css" href="https://www.jquery-a.com/javascript/alert/dist/sweetalert.css">
    </head>
    <body >
    <center><div class="container">
<div col="col-sm-4">
<h2><a href="javascript:history.back()" class="btn btn-sm btn-danger pull-left" style="width:100px;margin-left:1.5%;">Back</a> Open Ticket</h2>
<!-- <img src="{{ URL::to('/') }}/public/ticket.png" width="200px" height="100px"> -->
</div></div>
        <div class="container">
            <div class="row">
                <div style="width:95%; margin:auto;" id="form_container">
                    <h3>Case Information</h3> 
                    
                    <form role="form" method="post"  action="http://localhost:8000/api/test" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                    <input type="hidden" name="user_name" value="{{Auth::user()->name}}">
                    <input type="hidden" name="dept_id" value="{{Auth::user()->department_id}}">
                    <input type="hidden" name="group_id" value="{{Auth::user()->group_id}}">

                        <div class="row">
                        <div class="row">
                            <div class="col-sm-6 form-group" >
                                <label for="name">User Name</label>
                                <input type="text" class="form-control" id="name" name="name" required style="width:70%;">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="email"> Email</label>
                                <input type="email" class="form-control" id="email" name="email" required style="width:70%;">
                            </div>
                        </div>
                        </div>
                        <div class="row">
                        <div class="row">
                            <div class="col-sm-6 form-group" >
                                <label for="name">Designation</label>
                                <input type="text" class="form-control" id="name" name="desc" required style="width:70%;">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="email"> Phone Number</label>
                                <input type="text" class="form-control" id="email" name="number" required style="width:70%;">
                            </div>
                        </div>
                        </div>
                        <div class="row">
                          <div class="row">
                            <div class="col-sm-6 form-group" >
                                <label for="name">Subject</label>
                                <input type="text" class="form-control" id="name" name="sub" required style="width:70%;">
                            </div>
                             <div class="col-sm-6 form-group" >
                                <label for="name">Error Image</label>
                                <input  type="file" class="form-control" id="name" name="image"required style="width:70%;background: rgba(255,255,255,0.2);">
                            </div>
                            </div>
                            </div>
                           <div class="col-sm-12 form-group">
                                <label for="message"> Description:</label>
                                <textarea class="form-control" type="textarea" id="message" name="message" maxlength="6000" rows="6" style="width:90%;"></textarea>
                            </div>
                            <div class="row">
                        <div class="row">
                            <div class="col-sm-6 form-group" >
                                <label for="name">Category</label>
                                <select  class="form-control" id="name" name="cat" required style="width:65%;background: rgba(255,255,255,0.2);">
                                <option value="select">----Select----</option>
                                <option value="software">Software</option>
                                <option value="hardware">Hardware</option>
                                <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="email"> Product Name</label>
                                <input type="text" class="form-control" id="email" name="product" required style="width:70%;">
                            </div>
                        </div>

                       <div class="row">
                            <div class="col-sm-6 form-group" >
                                <label for="name">Priority</label>
                                <select  class="form-control" id="name" name="pri" required style="width:65%;background: rgba(255,255,255,0.2);">
                                <option value="select">----Select----</option>
                                <option value="high">High</option>
                                <option value="medium">Medium</option>
                                <option value="low">Low</option>
                                </select>
                            </div>
                            <div class="col-sm-6 form-group" >
                                <label for="name">Channel</label>
                                <select  class="form-control" id="name" name="channel" required style="width:65%;background: rgba(255,255,255,0.2);">
                                <option value="select">----Select----</option>
                                <option value="Phone">Phone</option>
                                <option value="Email">Email</option>
                                <option value="Facebook">Facebook</option>
                                <option value="Web">Web</option>
                                <option value="Chat">Chat</option>
                           </select>
                            </div>
                        </div>
                     </div>
                         <div class="row">
                            <div class="col-sm-12 form-group">
                               <center> <button type="submit" class="btn btn-lg btn-default" >Send &rarr;</button></center>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
</center>
    </body>
</html>

