@extends('layout.layout')
@section('content')
    <div class="content-header mb-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="m-0">Access </h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Access </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <!-- Add Category Form -->
                        <form id="addAccessForm">
                            @csrf
                            <div class="card-header">
                                <p class="m-0 fw-bold">Add Access </p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Access Name</label>
                                            <input type="text" name="access_name" id="access_name" class="form-control">
                                            <div class="access_name_err error"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="permissions">Permissions</label>
                                            <div class="permissions">
                                                @foreach ($permissions as $permission)
                                                    <div class="form-check d-inline-block">
                                                        <input class="form-check-input" type="checkbox" name="permissions[]"
                                                            value="{{ $permission->id }}"
                                                            id="permission{{ $permission->id }}">
                                                        <label class="form-check-label"
                                                            for="permission{{ $permission->id }}">
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="permissions_err error"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="form-control form-select">
                                                <option value="">Select Status</option>
                                                <option value="3">Draft</option>
                                                <option value="1">Active</option>
                                                <option value="2">Inactive</option>
                                            </select>
                                            <div class="status_err error"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-brown px-4 float-right">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Submit form for adding category
            $("#addAccessForm").submit(function(e) {
                e.preventDefault();
                var form = $("#addAccessForm")[0];
                var data = new FormData(form);
                $("#submitBtn").prop("disabled", true);
                var loader = $('.preloader');
                var loaderIMG = $('.preloader img');
                loader.height("100vh");
                loaderIMG.show()
                $.ajax({
                    type: "POST",
                    url: "{{ Route('addAccessProcess') }}",
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        loader.height("0vh");
                        loaderIMG.hide()
                        if (data.status == 'success') {
                            Swal.fire({
                                icon: data.status,
                                title: data.message
                            })
                            form.reset();
                        } else {
                            Swal.fire({
                                icon: data.status,
                                title: data.message
                            })
                            printError(data.error);
                        }
                        $("#submitBtn").prop("disabled", false);
                    },
                    error: function(error) {
                        loader.height("0vh");
                        loaderIMG.hide()
                        console.log(error.responseJSON);
                        $("#submitBtn").prop("disabled", false);
                    }
                });
            });
        });

        function printError(err) {
            $('.error').text('')
            $.each(err, function(key, value) {
                $("." + key + "_err").text(value)
            })
        }
    </script>
@endsection
