@extends('layouts.aeheader')
@section('content')

<div class="container">
    <div class="row">
        <div class="panel panel-success">
            <div class="panel-heading">
                Projects of {{ $user->builder_name }} ({{ count($projects) }})
            </div>
            <div class="panel-body" style="max-length:500px; overflow-x:scroll;">
                <table class="table table-hover" border=1>
                    <thead>
                        <th>Project Name</th>
                        <th>Manager</th>
                        <th>Manager Contact</th>
                        <th>Manager Email</th>
                        <th>Site Engineer</th>
                        <th>Site Engineer Contact</th>
                        <th>Site Engineer Email</th>
                        <th>Project Location</th>
                        <th>Sub Ward</th>
                        <th>Approx. Value (Cr.)</th>
                        <th>Size (Sq. Ft.)</th>
                        <th>No of Floors</th>
                        <th>Project Status</th>
                        <th>Posession Date</th>
                        <th>Project Website</th>
                        <th>Referal Image</th>
                        <th>Remarks</th>
                    </thead>
                    <tbody>
                        @foreach($projects as $project)
                        <tr>
                            <td>{{ $project->project_name }}</td>
                            <td>{{ $project->project_manager }}</td>
                            <td>{{ $project->pm_contact }}</td>
                            <td>{{ $project->pm_email }}</td>
                            <td>{{ $project->site_engineer }}</td>
                            <td>{{ $project->se_contact }}</td>
                            <td>{{ $project->se_email }}</td>
                            <td>{{ $project->project_location }}</td>
                            <td>{{ $project->sub_ward }}</td>
                            <td>{{ $project->project_approx_value }}</td>
                            <td>{{ $project->total_size }}</td>
                            <td>{{ $project->no_of_floors }}</td>
                            <td>{{ $project->project_status }}</td>
                            <td>{{ $project->posession_date }}</td>
                            <td>{{ $project->project_website }}</td>
                            <td>{{ $project->referal_image }}</td>
                            <td>{{ $project->remarks }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection