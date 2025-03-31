@extends('layout.layout')
@section('content')
    <div class="content-header mb-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="m-0">Users</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header py-1">
                <h5 class="mb-0">
                    <span class="pt-1 fw-bold d-inline-block">Users List</span>
                    <a href="" class="float-right btn btn-brown"><i class="fas fa-add"></i> Create User</a>
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered dataTable">
                    <thead class="bg-grey">
                        <tr>
                            <th>S.NO</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Email</th>
                            <th>Access</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->password }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->access_name }}</td>
                                <td>
                                    @switch($user->status)
                                        @case(1)
                                            Active
                                        @break

                                        @case(2)
                                            Draft
                                        @break

                                        @case(3)
                                            Inactive
                                        @break

                                        @default
                                            Inactive
                                    @endswitch
                                </td>
                                <td> 
                                    <a href="#" data-id="{{$user->id}}" id="editUser" class="text-primary btn btn-sm btn-light border border-primary" ><i class="fas fa-edit"></i></a>
                                    <a href="#" data-id="{{$user->id}}" id="editUser" class="text-danger btn btn-sm btn-light border border-danger"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
