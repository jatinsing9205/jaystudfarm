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
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Access </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-5">
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
                                            <input type="text" name="access_name" id="access_name"
                                                class="form-control">
                                            <div class="access_name_err error"></div>
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

                        <!-- Update Category Form -->
                        <form id="updateAccessForm">
                            @csrf
                            <div class="card-header">
                                <p class="m-0 fw-bold">Update Access </p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Access Name</label>
                                            <input type="text" name="access_name" class="form-control access_name">
                                            <div class="access_name_err error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" class="form-control form-select status">
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
                                <button type="submit" class="btn btn-brown px-4 float-right">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-header">
                            <p class="m-0 fw-bold">Access </p>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered AccessTable dataTable">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Access Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Hide the update form initially
            $("#updateAccessForm").hide();
            $("#addAccessForm").show();

            function clearError() {
                $('.error').text('')
            }

            // Submit form for adding category
            $("#addAccessForm").submit(function(e) {
                e.preventDefault();
                clearError()
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
                            loadAccesss();
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

            // Edit button click
            $(document).on('click', '.edit-btn', function() {
                clearError()
                var AccessId = $(this).data('id');
                var loader = $('.preloader');
                var loaderIMG = $('.preloader img');
                loader.height("100vh");
                loaderIMG.show()
                $.ajax({
                    type: "GET",
                    url: "{{ url('editAccess') }}/" + AccessId,
                    success: function(data) {
                        loader.height("0vh");
                        loaderIMG.hide()
                        // Show update form and hide add form
                        $("#updateAccessForm").show();
                        $("#addAccessForm").hide();

                        // Prefill the form with the Access data
                        $("#updateAccessForm .access_name").val(data.access_name);
                        $("#updateAccessForm .status").val(data.status);
                        $("#updateAccessForm .category_id").val(data.id);
                        $("#updateAccessForm").attr('data-id', data.id);
                    },
                    error: function(error) {
                        console.log(error.responseJSON);
                    }
                });
            });

            // Submit form for updating Access
            $("#updateAccessForm").submit(function(e) {
                e.preventDefault();
                clearError()
                var form = $("#updateAccessForm")[0];
                var data = new FormData(form);
                var loader = $('.preloader');
                var loaderIMG = $('.preloader img');
                loader.height("100vh");
                loaderIMG.show()
                $.ajax({
                    type: "POST",
                    url: "{{ url('updateAccessProcess') }}/" + $(this).attr('data-id'),
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        // console.log(data);
                        loader.height("0vh");
                        loaderIMG.hide()
                        if (data.status == 'success') {
                            Swal.fire({
                                icon: data.status,
                                title: data.message
                            })
                            loadAccesss(); 
                            $("#updateAccessForm").hide();
                            $("#addAccessForm").show();
                        } else {
                            Swal.fire({
                                icon: data.status,
                                title: data.message
                            })
                            printError(data.errors);
                        }
                    },
                    error: function(error) {
                        loader.height("0vh");
                        loaderIMG.hide()
                        console.log(error.responseJSON);
                    }
                });
            });

            $(document).on('click', '.delete-btn', function() {
                var AccessId = $(this).data('id');
                var isConfirmed = confirm("Are you sure you want to delete this Access?");
                if (isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('deleteAccess') }}/" + AccessId,
                        success: function(data) {
                            if (data.status == "success") {
                                loadAccesss()
                                Swal.fire({
                                    icon: data.status,
                                    title: data.message
                                })
                            } else {
                                Swal.fire({
                                    icon: data.status,
                                    title: data.message
                                })
                            }
                        },
                        error: function(error) {
                            console.log(error.responseJSON);
                        }
                    });
                } else {
                    return false;
                }
            });

            function loadAccesss() {
                $.ajax({
                    type: "GET",
                    url: "{{ Route('getAllAccess') }}",
                    success: function(data) {

                        var table = $('.AccessTable');
                        var tableBody = table.find('tbody').html('');
                        table.DataTable().clear().destroy();
                        data.forEach(function(Access, index) {
                            var row = `<tr>
                                        <td>${index + 1}</td>
                                        <td>${Access.access_name}</td>
                                        <td>${Access.status === '1' ? 'Active' : Access.status === '2' ? 'Inactive' : Access.status === '3' ? 'Draft' : 'N/A'}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm border edit-btn" data-id="${Access.id}">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button data-id="${Access.id}" class="btn btn-danger btn-sm delete-btn">
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


            loadAccesss();
        });

        function printError(err) {
            $.each(err, function(key, value) {
                $("." + key + "_err").text(value)
            })
        }
    </script>
@endsection
