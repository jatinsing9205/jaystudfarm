@extends('layout.layout')
@section('content')
    <div class="content-header mb-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="m-0">Nutrition List</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Nutrition List</li>
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
                        <form id="addNutritionForm">
                            @csrf
                            <div class="card-header">
                                <p class="m-0 fw-bold">Add Nutrition List</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Nutrition Name</label>
                                            <input type="text" name="nutrition_name" id="nutrition_name"
                                                class="form-control">
                                            <div class="nutrition_name_err error"></div>
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
                        <form id="updateNutritionForm">
                            @csrf
                            <div class="card-header">
                                <p class="m-0 fw-bold">Update Nutrition List</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Nutrition Name</label>
                                            <input type="text" name="nutrition_name" class="form-control nutrition_name">
                                            <div class="nutrition_name_err error"></div>
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
                            <p class="m-0 fw-bold">Nutrition List</p>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered categoryList dataTable">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Nutrition Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Nutrition List will be loaded here -->
                                </tbody>
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
            $("#updateNutritionForm").hide();
            $("#addNutritionForm").show();

            function clearError() {
                $('.error').text('')
            }

            // Submit form for adding category
            $("#addNutritionForm").submit(function(e) {
                e.preventDefault();
                clearError()
                var form = $("#addNutritionForm")[0];
                var data = new FormData(form);
                $("#submitBtn").prop("disabled", true);
                var loader = $('.preloader');
                var loaderIMG = $('.preloader img');
                loader.height("100vh");
                loaderIMG.show()
                $.ajax({
                    type: "POST",
                    url: "{{ Route('addNutritionListProcess') }}",
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
                            form.reset();
                            loadNutrition();
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
                var nutritionId = $(this).data('id');
                var loader = $('.preloader');
                var loaderIMG = $('.preloader img');
                loader.height("100vh");
                loaderIMG.show()
                $.ajax({
                    type: "GET",
                    url: "{{ url('editNutrition') }}/" + nutritionId,
                    success: function(data) {
                        // console.log(data);
                        loader.height("0vh");
                        loaderIMG.hide()
                        // Show update form and hide add form
                        $("#updateNutritionForm").show();
                        $("#addNutritionForm").hide();

                        // Prefill the form with the nutrition data
                        $("#updateNutritionForm .nutrition_name").val(data.name);
                        $("#updateNutritionForm .status").val(data.status);
                        $("#updateNutritionForm .category_id").val(data.id);
                        $("#updateNutritionForm").attr('data-id', data.id);
                    },
                    error: function(error) {
                        loader.height("0vh");
                        loaderIMG.hide()
                        console.log(error.responseJSON);
                    }
                });
            });

            // Submit form for updating nutrition
            $("#updateNutritionForm").submit(function(e) {
                e.preventDefault();
                clearError()
                var form = $("#updateNutritionForm")[0];
                var data = new FormData(form);
                var loader = $('.preloader');
                var loaderIMG = $('.preloader img');
                loader.height("100vh");
                loaderIMG.show()
                $.ajax({
                    type: "POST",
                    url: "{{ url('updateNutritionListProcess') }}/" + $(this).attr('data-id'),
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
                            loadNutrition();
                            // Hide update form and show add form again
                            $("#updateNutritionForm").hide();
                            $("#addNutritionForm").show();
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
                        loaderIMG.hide();
                        console.log(error.responseJSON);
                    }
                });
            });

            $(document).on('click', '.delete-btn', function() {
                var nutritionId = $(this).data('id');
                var isConfirmed = confirm("Are you sure you want to delete this Nutrition?");
                var loader = $('.preloader');
                var loaderIMG = $('.preloader img');
                loader.height("100vh");
                loaderIMG.show()
                if (isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('deleteNutrition') }}/" + nutritionId,
                        success: function(data) {
                            // console.log(data);
                            loader.height("0vh");
                            loaderIMG.hide()
                            if (data.status == "success") {
                                loadNutrition()
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
                            loader.height("0vh");
                            loaderIMG.hide()
                            console.log(error.responseJSON);
                        }
                    });
                } else {
                    return false;
                }
            });

            function loadNutrition() {
                $.ajax({
                    type: "GET",
                    url: "{{ Route('getAllNutritions') }}",
                    success: function(data) {
                        // console.log(data);
                        var table = $('.categoryList');
                        var tableBody = table.find('tbody').html('');
                        table.DataTable().clear().destroy();

                        data.forEach(function(nutrition, index) {
                            var row = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${nutrition.name}</td>
                                    <td>${nutrition.status === '1' ? 'Active' : nutrition.status === '2' ? 'Inactive' : nutrition.status === '3' ? 'Draft' : 'N/A'}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm border edit-btn" data-id="${nutrition.id}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button data-id="${nutrition.id}" class="btn btn-danger btn-sm delete-btn">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                            tableBody.append(row);
                        });

                        table.DataTable();
                    }
                });
            }

            loadNutrition();
        });

        function printError(err) {
            $.each(err, function(key, value) {
                $("." + key + "_err").text(value)
            })
        }
    </script>
@endsection
