@extends('layout.layout')
@section('content')
    <div class="content-header mb-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="m-0">Update User</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Update User</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <a href="{{ route('users') }}">
            <button class="backBtn">
                <i class="fa-solid fa-circle-left"></i>
                <span>Back</span>
            </button>
        </a>
        <div class="row">
            <div class="col-md-12">
                <form id="updateUserForm" method="POST" autocomplete="off">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <span>Update User</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="username">Username ( No space allowed ) <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="username" disabled autocomplete="off"
                                            class="form-control" value="{{ $user->username }}">
                                        <div class="error username_err"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ $user->name }}">
                                        <div class="error name_err"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ $user->email }}">
                                        <div class="error email_err"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="access">Access <span class="text-danger">*</span></label>
                                        <select name="access" id="access" class="form-control form-select">
                                            <option value="">Select Access</option>
                                            @foreach ($access as $ac)
                                                <option @if ($user->access == $ac->id) selected @endif
                                                    value="{{ $ac->id }}">{{ $ac->access_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="error access_err"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="password">Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" name="password" id="password" class="form-control"
                                                value="{{ $user->password }}">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span type="button" id="toggle-password"><i
                                                            class="fas fa-eye"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="error password_err"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label> <br>
                                        <span class="px-2 d-inline-flex align-items-center">
                                            <input type="radio" name="status" value="3" class="mr-2"
                                                @if ($user->status == 3) checked @endif> Draft
                                        </span>
                                        <span class="px-2 d-inline-flex align-items-center">
                                            <input type="radio" name="status" value="1" class="mr-2"
                                                @if ($user->status == 1) checked @endif> Active
                                        </span>
                                        <span class="px-2 d-inline-flex align-items-center">
                                            <input type="radio" name="status" value="2" class="mr-2"
                                                @if ($user->status == 2) checked @endif> Inactive
                                        </span>
                                        <div class="error status_err"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <button type="submit" class="float-right btn btn-brown px-5 text-uppercase"
                                id="submitBtn">Submit Information</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $("#updateUserForm").submit(function(e) {
                e.preventDefault();
                clearError()
                var form = $("#updateUserForm")[0];
                var data = new FormData(form);
                $("#submitBtn").prop("disabled", true);
                var loader = $('.preloader');
                var loaderIMG = $('.preloader img');
                loader.height("100vh");
                loaderIMG.show()
                $.ajax({
                    type: "POST",
                    url: "{{ Route('user.update') }}",
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
                            }).then(() => {
                                window.location.href = "{{ route('users') }}"
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
        })

        function printError(err) {
            $.each(err, function(key, value) {
                $("." + key + "_err").text(value)
            })
        }

        const passwordField = document.getElementById('password');
        const togglePasswordButton = document.getElementById('toggle-password');
        togglePasswordButton.addEventListener('click', function(e) {
            e.preventDefault();
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                togglePasswordButton.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                passwordField.type = 'password';
                togglePasswordButton.innerHTML = '<i class="fas fa-eye"></i>';
            }
        });
    </script>
@endsection
