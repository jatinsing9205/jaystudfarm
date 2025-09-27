@extends('layout.layout')
@section('content')
    <div class="content-header mb-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="m-0">Permissions</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Permissions</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('permissions.add') }}">
                    <button class="btn btn-brown btn-sm px-3 mb-3"> <i class="fa fa-add"></i>&nbsp; Add Permissions</button>
                </a>
                <div class="card">
                    <div class="card-header bg-cream">
                        <h3 class="card-title">
                            <span>Permissions List</span>
                        </h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped dataTable" id="permissionsTable">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Permission Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $permission->name }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-transparent btn-outline-danger deleteBtn"
                                                data-id="{{ $permission->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('script')
    <script>
        $('.deleteBtn').on("click", function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            if (confirm("Are you sure you want to delete this permission?") == false) {
                return;
            }

            var delURL = '{{ route('permissions.delete', ':id') }}';
            $.ajax({
                url: delURL.replace(":id", id),
                type: 'GET',
                data: {
                    id: id
                },
                success: function(response) {
                    if (response.status == 'success') {
                        showToast(response.message, response.status);
                        setTimeout(() => {
                            window.location.href = '{{ route('permissions.view') }}';
                        }, 2000);
                    } else {
                        showToast(response.message, response.status);
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }

            });
        });
    </script>
@endsection
