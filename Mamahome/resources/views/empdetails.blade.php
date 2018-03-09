<div class="panel panel-default">
<div class="panel-heading">
    Employees on {{ $dept }}
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
    <?php $total = 0; ?>
        <tr>
        <td>{{ $user->employeeId}}</td>
        <td>{{ $user->name}}</td>
        <td>{{ $user->email}}</td>
        <td>
            <table class="table" border=1>
                <thead><th>Date</th><th>LE</th><th>TL</th></thead>
                <tbody>
            @foreach($expenses as $expense)
                @if($user->id == $expense->user_id)
                    <tr>
                        <td>{{ $expense->logindate }}</td>
                        <td><?php echo $cal = $expense->afternoonMeter - $expense->gtracing; ?></td>
                        <td>
                            @if($expense->total_kilometers != NULL)
                                {{ $total += $expense->total_kilometers }}
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