@extends('layout.layout')
@section('content')
    <div class="content-header mb-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="m-0">Add Permissions</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Add Permissions</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-cream">
                        <h3 class="card-title ">
                            <i class="fas fa-plus"></i> Add Permission
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST" id="addPermissionForm">
                            @csrf
                            <div class="form-group">
                                <label for="name">Permission Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter permission name" required>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Add Permission" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('script')
        <script>
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#addPermissionForm').on('submit', function(e) {
                    debugger
                    e.preventDefault();
                    var form = this;
                    var formData = $(this).serialize();

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('permissions.store') }}',
                        data: formData,
                        success: function(response) {
                            console.log(response);
                            if (response.status == 'success') {
                                form.reset();
                                showToast(response.message, response.status);
                                setTimeout(() => {
                                    window.location.href =
                                    '{{ route('permissions.view') }}';
                                }, 2000);
                            } else {
                                showToast(response.message, response.status);
                            }
                        },
                        error: function(xhr) {
                            var errors = xhr.responseJSON.errors;
                            showToast(errors, "error");
                        }
                    });
                });
            });
        </script>
    @endsection
