@extends("layout.layout")
@section("content")

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Exercise List</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Exercise List</li>
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
                        <form id="addExerciseForm">
                            @csrf
                            <div class="card-header">
                                <p class="m-0 fw-bold">Add Exercise List</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Exercise Name</label>
                                            <input type="text" name="exercise_name" id="exercise_name" class="form-control">
                                            <div class="exercise_name_err error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="form-control form-select">
                                                <option value="">Select Status</option>
                                                <option value="2">Draft</option>
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
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
                        <form id="updateExerciseForm">
                            @csrf
                            <div class="card-header">
                                <p class="m-0 fw-bold">Update Exercise List</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Exercise Name</label>
                                            <input type="text" name="exercise_name" class="form-control exercise_name">
                                            <div class="exercise_name_err error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" class="form-control form-select status">
                                                <option value="">Select Status</option>
                                                <option value="2">Draft</option>
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
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
                            <p class="m-0 fw-bold">Exercise List</p>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered exerciseList">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Exercise Name</th>
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
        $(document).ready(function () {
            // Hide the update form initially
            $("#updateExerciseForm").hide();
            $("#addExerciseForm").show();

            // Submit form for adding category
            $("#addExerciseForm").submit(function (e) {
                e.preventDefault();
                var form = $("#addExerciseForm")[0];
                var data = new FormData(form);
                $("#submitBtn").prop("disabled", true);
                var loader = $('.preloader');
                var loaderIMG = $('.preloader img');
                loader.height("100vh");
                loaderIMG.show()
                $.ajax({
                    type: "POST",
                    url: "{{Route('addExerciseListProcess')}}",
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        loader.height("0vh");
                        loaderIMG.hide()
                        if (data.status == 'success') {
                            Swal.fire({
                                icon: data.status,
                                title: data.message
                            })
                            form.reset();
                            loadSupplements();
                        } else {
                            Swal.fire({
                                icon: data.status,
                                title: data.message
                            })
                            printError(data.error);
                        }
                        $("#submitBtn").prop("disabled", false);
                    },
                    error: function (error) {
                        loader.height("0vh");
                        loaderIMG.hide()
                        console.log(error.responseJSON);
                        $("#submitBtn").prop("disabled", false);
                    }
                });
            });

            // Edit button click
            $(document).on('click', '.edit-btn', function () {
                var exerciseId = $(this).data('id');
                var loader = $('.preloader');
                var loaderIMG = $('.preloader img');
                loader.height("100vh");
                loaderIMG.show()
                $.ajax({
                    type: "GET",
                    url: "{{url('editExercise')}}/" + exerciseId,
                    success: function (data) {
                        loader.height("0vh");
                        loaderIMG.hide()
                        // Show update form and hide add form
                        $("#updateExerciseForm").show();
                        $("#addExerciseForm").hide();

                        // Prefill the form with the supplement data
                        $("#updateExerciseForm .exercise_name").val(data.name);
                        $("#updateExerciseForm .status").val(data.status);
                        $("#updateExerciseForm .category_id").val(data.id);
                        $("#updateExerciseForm").attr('data-id', data.id);
                    },
                    error: function (error) {
                        console.log(error.responseJSON);
                    }
                });
            });

            // Submit form for updating supplement
            $("#updateExerciseForm").submit(function (e) {
                e.preventDefault();
                var form = $("#updateExerciseForm")[0];
                var data = new FormData(form);
                var loader = $('.preloader');
                var loaderIMG = $('.preloader img');
                loader.height("100vh");
                loaderIMG.show()
                $.ajax({
                    type: "POST",
                    url: "{{url('updateExerciseListProcess')}}/" + $(this).attr('data-id'),
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        loader.height("0vh");
                        loaderIMG.hide()
                        // console.log(data);
                        if (data.status == 'success') {
                            Swal.fire({
                                icon: data.status,
                                title: data.message
                            })
                            loadSupplements();
                            // Hide update form and show add form again
                            $("#updateExerciseForm").hide();
                            $("#addExerciseForm").show();
                        } else {
                            Swal.fire({
                                icon: data.status,
                                title: data.message
                            })
                            printError(data.error);
                        }
                    },
                    error: function (error) {
                        loader.height("0vh");
                        loaderIMG.hide()
                        console.log(error.responseJSON);
                    }
                });
            });

            $(document).on('click', '.delete-btn', function () {
                var exerciseId = $(this).data('id');
                var isConfirmed = confirm("Are you sure you want to delete this Exercise?");
                if (isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: "{{url('deleteExercise')}}/" + exerciseId,
                        success: function (data) {
                            if (data.status == "success") {
                                loadSupplements()
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
                        error: function (error) {
                            console.log(error.responseJSON);
                        }
                    });
                } else {
                    return false;
                }
            });

            function loadSupplements() {
                $.ajax({
                    type: "GET",
                    url: "{{Route('getAllExercises')}}",
                    success: function (data) {

                        var table = $('.exerciseList');
                        var tableBody = table.find('tbody').html('');
                        data.forEach(function (supplement, index) {
                            var row = `<tr>
                                                <td>${index + 1}</td>
                                                <td>${supplement.name}</td>
                                                <td>${supplement.status === '1' ? 'Active' : supplement.status === '2' ? 'Draft' : supplement.status === '0' ? 'Inactive' : 'N/A'}</td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm border edit-btn" data-id="${supplement.id}">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button data-id="${supplement.id}" class="btn btn-danger btn-sm delete-btn">
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


            loadSupplements();
        });

        function printError(err) {
            $.each(err, function (key, value) {
                $("." + key + "_err").text(value)
            })
        }


    </script>

@endsection