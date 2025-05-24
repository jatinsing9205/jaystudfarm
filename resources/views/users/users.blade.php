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
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
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
                    <a href="{{ route('add-user') }}" class="float-right btn btn-brown"><i class="fas fa-add"></i> Create
                        User</a>
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered dataTable" id="userTable">
                    <thead class="bg-grey">
                        <tr>
                            <th>S.NO</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Access</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).on('click', '.delete-btn', function() {
            var userId = $(this).data('user-id');
            var isConfirmed = confirm("Are you sure you want to delete this User?");
            var loader = $('.preloader');
            var loaderIMG = $('.preloader img');
            loader.height("100vh");
            loaderIMG.show()
            if (isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('deleteUser') }}/" + userId,
                    success: function(data) {
                        loader.height("0vh");
                        loaderIMG.hide()
                        if (data.status == "success") {
                            Swal.fire({
                                icon: data.status,
                                title: data.message
                            })
                            loadUsers()
                        } else {
                            Swal.fire({
                                icon: data.status,
                                title: data.message
                            })
                        }
                    },
                    error: function(error) {
                        loader.height("0vh");
                        loaderIMG.hide()
                        console.log(error.responseJSON);
                    }
                });
            } else {
                return false;
            }
        });


        function loadUsers() {
            $.ajax({
                type: "GET",
                url: "{{ Route('getAllUsers') }}",
                success: function(data) {

                    var table = $('#userTable');
                    var tableBody = table.find('tbody').html('');
                    table.DataTable().clear().destroy();
                    data.forEach(function(user, index) {
                        var row = `<tr>
                                        <td>${index + 1}</td>
                                        <td>${user.name}</td>
                                        <td>${user.username}</td>
                                        <td>${user.email}</td>
                                        <td>${user.access_name}</td>
                                        <td>${user.status === '1' ? 'Active' : user.status === '2' ? 'Inactive' : user.status === '3' ? 'Draft' : 'N/A'}</td>
                                        <td>
                                            <a href="{{url('editUser')}}/${user.id}"><button class="btn btn-light btn-sm edit-btn border border-primary text-primary" data-id="${user.id}">
                                                <i class="fa fa-edit"></i>
                                            </button></a>
                                            <button data-user-id="${user.id}" class="btn btn-light btn-sm delete-btn border border-danger text-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>`;
                        tableBody.append(row);
                    });
                    table.DataTable();
                }
            });
        }


        loadUsers();
    </script>
@endsection
