@extends("layout.layout")
@section("content")

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Add Companion</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add Companion</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <section class="container-fluid">
            <div class="card card-outline-brown">
                <form id="addCompanionForm">

                    {{-- @csrf --}}

                    <div class="card-header">
                        <p class="fw-bold mb-0">ADD COMPANION</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="companion_name">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="companion_name" id="companion_name" class="form-control">
                                    <div class="companion_name_err error"></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="sex">SEX <span class="text-danger">*</span></label>
                                    <input type="text" name="sex" id="sex" class="form-control">
                                    <div class="sex_err error"></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="category">Category <span class="text-danger">*</span></label>
                                    <select name="category" id="category" class="form-control form-select">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="category_err error"></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="date_of_birth">Date of Birth <span class="text-danger">*</span></label>
                                    <input type="date" name="date_of_birth" id="date_of_birth" class="form-control">
                                    <div class="date_of_birth_err error"></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="height">Height</label>
                                    <input type="text" name="height" id="height" class="form-control">
                                    <div class="height_err error"></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="companion_type">Type</label>
                                    <select name="companion_type" id="companion_type" class="form-control form-select">
                                        <option value="">Select Horse Type
                                        </option>
                                        <option value="Show">Show</option>
                                        <option value="Breeding">Breeding</option>
                                    </select>
                                    <div class="companion_type_err error"></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="micro_chip_number">Micro Chip Number</label>
                                    <input type="text" name="micro_chip_number" id="micro_chip_number" class="form-control">
                                    <div class="micro_chip_number_err error"></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="source">Source <span class="text-danger">*</span></label>
                                    <select name="source" id="source" class="form-control form-select">
                                        <option value="">Select Source</option>
                                        <option value="Purchased">Purchased</option>
                                        <option value="Born">Born</option>
                                    </select>
                                    <div class="source_err error"></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6" id="purchase_date_div">
                                <div class="form-group">
                                    <label for="purchase_date">Purchase Date</label>
                                    <input type="date" id="purchase_date" name="purchase_date" class="form-control">
                                    <div class="purchase_date_err error"></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6" id="purchase_amount_div">
                                <div class="form-group">
                                    <label for="purchase_amount">Purchase Amount</label>
                                    <input type="text" id="purchase_amount" name="purchase_amount" class="form-control">
                                    <div class="purchase_amount_err error"></div>
                                </div>
                            </div>

                        </div>


                        <p class="fw-bold">Dam / Sire Information</p>
                        <div class="row dam_sire_info mb-3">
                            <div class="col-md-3 col-5">
                                <select name="parent[]" id="parent" class="form-control form-select">
                                    <option value="">Select ( Dam / Sire )</option>
                                    <option value="Sire">Sire</option>
                                    <option value="Dam">Dam</option>
                                    <option value="Dam (Sire)">Dam (Sire)</option>
                                    <option value="Dam (Dam)">Dam (Dam)</option>
                                    <option value="Dam (Grand Sire)">Dam (Grand Sire)</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-5">
                                <input type="text" name="parent_name[]" id="parent_name" class="form-control"
                                    placeholder="Name">

                            </div>
                            <div class="col-md-3 col-2 addBtnDiv">
                                <button type="button" class="btn btn-success addBtn"><i class="fa fa-add"></i></button>
                            </div>
                        </div>
                        <div class="more_input"></div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="short_description">Short Description</label>
                                    <textarea class="form-control" id="short_description"
                                        name="short_description"></textarea>
                                    <div class="short_description_err error"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description"></textarea>
                                    <div class="description_err error"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row mt-3 mb-3 bg-grey py-3 border border-grey">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="companion_image">Companion Image<span
                                                    class="text-danger">*</span></label>
                                            <input type="file" class="form-control" id="companion_image"
                                                name="companion_image" accept="image/*">
                                            <div class="companion_image_err error"></div>
                                        </div>
                                        <div class="product-image-box" id="product-image-box"></div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="companion_video">Companion Video</label>
                                            <input type="file" class="form-control" id="companion_video"
                                                name="companion_video[]" multiple="" accept="video/*">
                                            <div class="companion_video_err error"></div>
                                        </div>
                                        <div class="product-image-box" id="product-video-box"></div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="companion_gallery">Companion Gallery</label>
                                            <input type="file" class="form-control" id="companion_gallery"
                                                name="companion_gallery[]" multiple="" accept="image/*">
                                            <div class="companion_gallery_err error"></div>
                                        </div>
                                        <div class="product-image-box" id="product-gallery-box"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
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
                        <button class="float-right btn btn-brown px-5">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>


    <script>
        $(document).ready(function () {
            // Add CSRF token to AJAX headers
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#addCompanionForm").submit(function (e) {
                e.preventDefault();
                var form = $("#addCompanionForm")[0];
                var data = new FormData(form);
                clearError();
                let parentData = [];
                $('.dam_sire_info').each(function () {
                    let parent = $(this).find('select[name="parent[]"]').val();
                    let parentName = $(this).find('input[name="parent_name[]"]').val();

                    if (parent && parentName) {
                        parentData.push({ parent: parent, parentName: parentName });
                    }
                });
                data.append("parentData", JSON.stringify(parentData));

                $("#submitBtn").prop("disabled", true);
                $.ajax({
                    type: "POST",
                    url: "{{route('addCompanionProcess')}}",
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        console.log(data);
                        if (data.status == 'success') {
                            form.reset()
                            Swal.fire({
                                icon: data.status,
                                title: data.message
                            }).then(() => {
                                window.location.href = "{{route('companions')}}"
                            })
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
                        console.log(error.responseJSON);
                        $("#submitBtn").prop("disabled", false);
                    }
                });
            });

            function printError(err) {
                $.each(err, function (key, value) {
                    $("." + key + "_err").text(value);
                });
            }

            // Add button functionality for the dam/sire section
            $(document).on("click", ".addBtn", function () {
                var input = $(".dam_sire_info").html();
                var newRow = $(`<div class="row mb-3 dam_sire_info">${input}
                                                                <div class="col-md-3 col-2">
                                                                    <button class="btn btn-danger removeBtn"><i class="fa fa-trash"></i></button>
                                                                </div>
                                                            </div>`);

                newRow.find(".addBtnDiv").hide();
                $(".more_input").append(newRow);
            });

            // Event delegation for removing rows
            $(document).on("click", ".removeBtn", function () {
                $(this).closest(".row").remove();
            });
        });


        document.getElementById("companion_image").addEventListener("change", function (event) {
            const file = event.target.files[0];
            const imageBox = document.getElementById("product-image-box");

            // Clear any existing previews
            imageBox.innerHTML = "";

            if (file) {
                const img = document.createElement("img");
                img.src = URL.createObjectURL(file);
                img.classList.add("img-fluid", "preview-image");
                imageBox.appendChild(img);
            }
        });

        $("#companion_gallery").change(function (e) {
            const dt = new DataTransfer();
            const galleryBox = $("#product-gallery-box");

            Array.from(e.target.files).forEach((file, i) => {
                const imgContainer = $(`<div class="preview-image preimg">
                    <img src="${URL.createObjectURL(file)}" class="img-fluid">
                    <button class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-selected-image" data-index="${i}">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>`);
                galleryBox.append(imgContainer);
                dt.items.add(file);
            });

            e.target.files = dt.files;
        });

        $(document).on("click", ".remove-selected-image", function () {
            const index = $(this).data("index");
            const input = document.getElementById("companion_gallery");
            const dt = new DataTransfer();

            Array.from(input.files).forEach((file, i) => i !== index && dt.items.add(file));

            input.files = dt.files;
            $(this).closest(".preview-image").remove();
            $(".preimg").each(function (i) {
                $(this).find(".remove-selected-image").data("index", i);
            });
        });

        $("#companion_video").on("change", function (event) {
            const files = event.target.files;
            const imageBox = document.getElementById("product-video-box");

            // Loop through the selected files and create previews
            Array.from(files).forEach((file, i) => {
                const videoUrl = URL.createObjectURL(file);

                const videoContainer = $(`
                    <span class="preview-video prevdo m-1">
                        <video src="${videoUrl}" alt="Video" controls></video>
                        <button type="button" class="btn btn-danger btn-sm remove-video-btn" data-index="${i}">
                            <i class="fa fa-trash"></i>
                        </button>
                    </span>
                `);

                // Append the video preview to the imageBox
                imageBox.appendChild(videoContainer[0]);
            });
        });

        // Remove video and update file list
        $(document).on("click", ".remove-video-btn", function () {
            const index = $(this).data("index");
            const input = document.getElementById("companion_video");
            const dt = new DataTransfer();

            Array.from(input.files).forEach((file, i) => {
                if (i !== index) {
                    dt.items.add(file);
                }
            });

            input.files = dt.files;
            $(this).closest(".preview-video").remove();

            $(".prevdo").each(function (i) {
                $(this).find(".remove-video-btn").data("index", i);
            });
        });

        $(document).ready(function () {
            $("#purchase_date_div").hide()
            $("#purchase_amount_div").hide()
            $("#source").on("change", function () {
                var source = $("#source").val()
                if (source == "Purchased") {
                    // console.log("Purchased")
                    $("#purchase_date_div").show()
                    $("#purchase_amount_div").show()
                } else {
                    // console.log("born")
                    $("#purchase_date_div").hide()
                    $("#purchase_amount_div").hide()
                    $("#purchase_date").val('')
                    $("#purchase_amount").val('')
                }
            })
        })



    </script>

@endsection