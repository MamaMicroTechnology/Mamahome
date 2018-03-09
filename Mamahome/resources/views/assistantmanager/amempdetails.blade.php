<div class="panel panel-default" style="border-color:#f4811f">
<div class="panel-heading" style="background-color:#f4811f">
    <b style="color:white;font-size:1.3em">Employees on {{ $dept }}</b>
</div>
<div class="panel-body" style="height:500px;max-height:500px;overflow-x:hidden; overflow-y:scroll;">
<table class="table table-hover">
<thead>
    <th>Emp Id</th>
    <th>Name</th>
    <th>Email</th>
    <th>Expenses</th>
</thead>
<tbody>
@if($dept == "Operation")
    @foreach($users as $user)
    <?php $total = 0;
        $total2 = 0;
    ?>
        <tr>
        <td>{{ $user->employeeId}}</td>
        <td>{{ $user->name}}</td>
        <td>{{ $user->email}}</td>
        <td>
            <table id="current{{ $user->employeeId }}" class="table table-responsive table-hover" border="1">
                <thead>
                    <th>Date</th>
                    <th>LE</th>
                    <th>TL<button onclick="edit('{{ $user->employeeId }}')" class="pull-right btn-success" type="button">Edit</button>
                    </th>
                </thead>
                <tbody>
            @foreach($expenses as $expense)
                @if($user->id == $expense->user_id)
                    <tr>
                        <td>{{ $expense->logindate }}</td>
                        <td><?php echo $cal = $expense->afternoonMeter - $expense->gtracing; ?></td>
                        <td>
                            @if($expense->total_kilometers != NULL)
                                {{ $expense->total_kilometers }}
                                <?php $total += $expense->total_kilometers; ?>
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <td>Total</td>
                <td></td>
                <td>{{ $total }}km X ₹2 = ₹{{ $total * 2 }}</td>
            </tr>
            </tbody>
            </table>
            
            <form method="post" action="{{ URL::to('/') }}/savePetrolExpenses">
                {{ csrf_field() }}
            <table id="edit{{ $user->employeeId }}" class="hidden" border="1">
                <thead>
                    <th>Date</th>
                    <th>LE</th>
                    <th>TL<button onclick="cancel('{{ $user->employeeId }}')" class="pull-right btn-success" type="button">Close</button>
                    <button onclick="submit('{{ $user->employeeId }}')" class="pull-right btn-primary">Submit</button>
                    </th>
                </thead>
                <tbody>
            @foreach($expenses as $expense)
                @if($user->id == $expense->user_id)
                    <tr>
                        <td>{{ $expense->logindate }}</td>
                        <td><?php echo $cal = $expense->afternoonMeter - $expense->gtracing; ?></td>
                        <td>
                            <input type="hidden" value="{{ $expense->id }}" name="id[]" class="form-control">
                            <input type="text" value="{{ $expense->total_kilometers }}" name="exp[]" class="form-control">
                        </td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <td>Total</td>
                <td></td>
                <td>{{ $total }}km X ₹2 = ₹{{ $total * 2 }}</td>
            </tr>
            </tbody>
            </table>
            </form>
        </td>
        </tr>
    @endforeach
@else
    @foreach($users as $user)
        <tr>
        <td>{{ $user->employeeId}}</td>
        <td>{{ $user->name}}</td>
        <td>{{ $user->email}}</td>
        <td>N/A</td>
        </tr>
    @endforeach
@endif
</tbody>
</table>
</div>
</div>

<script>
    function edit(arg){
        var edit = 'edit'+arg;
        var current = 'current'+arg;
        document.getElementById(edit).className="table table-responsive table-hover";
        document.getElementById(current).className="hidden";
    }
    function cancel(arg){
        var edit = 'edit'+arg;
        var current = 'current'+arg;
        document.getElementById(edit).className="hidden";
        document.getElementById(current).className="table table-responsive table-hover";
    }
</script>

