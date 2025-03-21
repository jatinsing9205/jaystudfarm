@extends('layout.layout')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Update Companion</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Update Companion</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <section class="container-fluid">
            <div class="card card-outline-brown">
                <form id="updateCompanionForm">

                    {{-- @csrf --}}

                    <div class="card-header">
                        <p class="fw-bold mb-0">UPDATE COMPANION</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="companion_name">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="companion_name" id="companion_name" class="form-control"
                                        value="{{ $companion->name }}">
                                    <div class="companion_name_err error"></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="sex">SEX <span class="text-danger">*</span></label> 
                                    <select name="sex" id="sex" class="form-control form-select">
                                        <option value="">Select Sex</option>
                                        <option @if ($companion->sex == 'F') selected @endif value="F">F</option>
                                        <option @if ($companion->sex == 'M') selected @endif  value="M">M</option>
                                    </select>
                                    <div class="sex_err error"></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="category">Category <span class="text-danger">*</span></label>
                                    <select name="category" id="category" class="form-control form-select">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                @if ($companion->category == $category->id) selected @endif>
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="category_err error"></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="date_of_birth">Date of Birth <span class="text-danger">*</span></label>
                                    <input type="date" name="date_of_birth" id="date_of_birth" class="form-control"
                                        value="{{ $companion->dob }}">
                                    <div class="date_of_birth_err error"></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="height">Height</label>
                                    <input type="text" name="height" id="height" value="{{ $companion->dob }}"
                                        class="form-control">
                                    <div class="height_err error"></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="companion_type">Type</label>
                                    <select name="companion_type" id="companion_type" class="form-control form-select">
                                        <option value="">Select Horse Type</option>
                                        <option value="Show" @if ($companion->type == 'Show') selected @endif>Show
                                        </option>
                                        <option value="Breeding" @if ($companion->type == 'Breeding') selected @endif>Breeding
                                        </option>
                                    </select>

                                    <div class="companion_type_err error"></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="micro_chip_number">Micro Chip Number</label>
                                    <input type="text" name="micro_chip_number" id="micro_chip_number"
                                        value="{{ $companion->micro_chip_number }}" class="form-control">
                                    <div class="micro_chip_number_err error"></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="source">Source <span class="text-danger">*</span></label>
                                    <select name="source" id="source" class="form-control form-select">
                                        <option value="">Select Source</option>
                                        <option value="Purchased" @if ($companion->source == 'Purchased') selected @endif>
                                            Purchased</option>
                                        <option value="Born" @if ($companion->source == 'Born') selected @endif>Born
                                        </option>
                                    </select>
                                    <div class="source_err error"></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6" id="purchase_date_div"
                                @if ($companion->source == 'Born') style="display:none;" @else style="display:block;" @endif>
                                <div class="form-group">
                                    <label for="purchase_date">Purchase Date</label>
                                    <input type="date" id="purchase_date" name="purchase_date"
                                        value="{{ $companion->purchase_date }}" class="form-control">
                                    <div class="purchase_date_err error"></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6" id="purchase_amount_div"
                                @if ($companion->source == 'Born') style="display:none;" @else style="display:block;" @endif>
                                <div class="form-group">
                                    <label for="purchase_amount">Purchase Amount</label>
                                    <input type="text" id="purchase_amount" name="purchase_amount"
                                        value="{{ $companion->purchase_amount }}" class="form-control">
                                    <div class="purchase_amount_err error"></div>
                                </div>
                            </div>

                        </div>


                        <p class="fw-bold">Dam / Sire Information</p>
                        <div class="addBtnDiv mb-3">
                            <button type="button" class="btn btn-success addBtn"><i class="fa fa-plus"></i> Add
                                Info</button>
                        </div>

                        @foreach ($companion->dam_sire_info as $dam_sire)
                            <div class="row mb-3 dam_sire_info">
                                <div class="col-md-3 col-5">
                                    <select name="parent[]" class="form-control form-select">
                                        <option value="">Select ( Dam / Sire )</option>
                                        <option {{ $dam_sire->identifier == 'Dam' ? 'selected' : '' }} value="Dam">Dam
                                        </option>
                                        <option {{ $dam_sire->identifier == 'Sire' ? 'selected' : '' }} value="Sire">
                                            Sire</option>
                                        <option {{ $dam_sire->identifier == 'Grand Sire' ? 'selected' : '' }}
                                            value="Grand Sire">Grand Sire</option>
                                        <option {{ $dam_sire->identifier == 'Great Grand Sire' ? 'selected' : '' }}
                                            value="Great Grand Sire">Great Grand Sire</option>
                                        <option {{ $dam_sire->identifier == 'Dam (Dam)' ? 'selected' : '' }}
                                            value="Dam (Dam)">Dam (Dam)</option>
                                        <option {{ $dam_sire->identifier == 'Dam (Sire)' ? 'selected' : '' }}
                                            value="Dam (Sire)">Dam (Sire)</option>
                                        <option {{ $dam_sire->identifier == 'Dam (Grand Sire)' ? 'selected' : '' }}
                                            value="Dam (Grand Sire)">Dam (Grand Sire)</option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-5">
                                    <input type="text" name="parent_name[]" class="form-control" placeholder="Name"
                                        value="{{ $dam_sire->name }}">
                                </div>
                                <div class="col-md-3 col-2">
                                    <input type="hidden" name="DamSireId[]" value="{{ $dam_sire->id }}">
                                    <button data-ds-id="{{ $dam_sire->id }}" type="button"
                                        class="btn btn-danger delete-dam-sire-info"><i class="fa fa-trash"></i></button>
                                </div>
                            </div>
                        @endforeach

                        <div class="more_input mb-5"></div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="short_description">Short Description</label>
                                    <textarea class="form-control" id="short_description" name="short_description">{{ $companion->short_description }}</textarea>
                                    <div class="short_description_err error"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description">{{ $companion->description }}</textarea>
                                    <div class="description_err error"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row mt-3 mb-3 bg-grey py-3 border border-grey">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="companion_image">Companion Image<span class="text-danger">*</span>
                                                (Max Size : 1MB)</label>
                                            <input type="file" class="form-control" id="companion_image"
                                                name="companion_image" accept="image/*">
                                            <div class="companion_image_err error"></div>
                                        </div>
                                        <div class="product-image-box" id="product-image-box">
                                            <img src="{{ url('') }}/{{ $companion->image }}" alt="">
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="companion_video">Companion Video (Max Video Size : 10MB)</label>
                                            <input type="file" class="form-control" id="companion_video"
                                                name="companion_video[]" multiple='' accept="video/*">
                                            <div class="companion_video_err error"></div>
                                        </div>
                                        <div class="product-image-box" id="product-video-box">
                                            @foreach ($companion->gallery_images as $video)
                                                @if ($video->type == 'video')
                                                    <span class="preview-video m-1">
                                                        <a href="{{ url($video->file_path) }}" data-fancybox>
                                                            <video src="{{ url($video->file_path) }}" controls
                                                                alt="Video"></video>
                                                            {{-- <div class="play-icon">
                                                                <i class="fa fa-play"></i>
                                                            </div> --}}
                                                        </a>
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm delete-video-btn"
                                                            data-image-id="{{ $video->id }}">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="companion_gallery">Companion Gallery</label>
                                            <input type="file" class="form-control" id="companion_gallery"
                                                name="companion_gallery[]" multiple="" accept="image/*">
                                            <div class="companion_gallery_err error"></div>
                                        </div>
                                        <div class="product-image-box" id="product-gallery-box">
                                            @foreach ($companion->gallery_images as $img)
                                                <span class="preview-image m-1">
                                                    @if ($img->type == 'image')
                                                        <img src="{{ url($img->file_path) }}" alt="image">
                                                        <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                            data-image-id="{{ $img->id }}">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    @endif
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control form-select">
                                        <option value="">Select Status</option>
                                        <option value="3" @if ($companion->status == '3') selected @endif>Draft
                                        </option>
                                        <option value="1" @if ($companion->status == '1') selected @endif>Active
                                        </option>
                                        <option value="2" @if ($companion->status == '2') selected @endif>Inactive
                                        </option>
                                    </select>
                                    <div class="status_err error"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="float-right btn btn-brown px-5">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>


    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //Submit Update Form
            $("#updateCompanionForm").submit(function(e) {
                e.preventDefault();
                var form = $("#updateCompanionForm")[0];
                var data = new FormData(form);

                var loader = $('.preloader');
                var loaderIMG = $('.preloader img');
                loader.height("100vh");
                loaderIMG.show()

                clearError();
                let parentData = [];
                $('.dam_sire_info').each(function() {
                    let parent = $(this).find('select[name="parent[]"]').val();
                    let parentName = $(this).find('input[name="parent_name[]"]').val();
                    let DamSireId = $(this).find('input[name="DamSireId[]"]').val();

                    if (parent && parentName) {
                        parentData.push({
                            parent: parent,
                            parentName: parentName,
                            DamSireId: DamSireId
                        });
                    }
                });
                data.append("parentData", JSON.stringify(parentData));

                $("#submitBtn").prop("disabled", true);
                $.ajax({
                    type: "POST",
                    url: "{{ url('updateCompanionProcess') }}/{{ $companion->companion_id }}",
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        loader.height("0vh");
                        loaderIMG.hide()
                        console.log(data);
                        if (data.status == 'success') {
                            Swal.fire({
                                icon: data.status,
                                title: data.message
                            }).then(() => {
                                window.location.href =
                                    "{{ route('viewCompanion', $companion->companion_id) }}"
                            })
                        } else {
                            Swal.fire({
                                icon: data.status,
                                title: data.message,
                                text: JSON.stringify(data.error)
                            })
                            printError(data.error);
                        }
                        $("#submitBtn").prop("disabled", false);
                    },
                    error: function(error) {
                        console.log(error.responseJSON);
                        loader.height("0vh");
                        loaderIMG.hide()
                        $("#submitBtn").prop("disabled", false);
                    }
                });
            });

            function printError(err) {
                $.each(err, function(key, value) {
                    $("." + key + "_err").text(value);
                    $("input[name=" + key + "]").focus();
                });
            }

            //Add Dam Sire info
            $(document).on("click", ".addBtn", function() {
                var input = $(".dam_sire_info").html();
                var newRow = $(`
                                        <div class="row mb-3 dam_sire_info"><div class="col-md-3 col-5">
                                            <select name="parent[]" class="form-control form-select">
                                                <option value="">Select ( Dam / Sire )</option>
                                                <option value="Dam">Dam</option>
                                                <option value="Sire">Sire</option>
                                                <option value="Grand Sire">Grand Sire</option>
                                                <option value="Great Grand Sire">Great Grand Sire</option>
                                                <option value="Dam (Dam)">Dam (Dam)</option>
                                                <option value="Dam (Sire)">Dam (Sire)</option>
                                                <option value="Dam (Grand Sire)">Dam (Grand Sire)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-5">
                                            <input type="text" name="parent_name[]" class="form-control" placeholder="Name">
                                        </div><div class="col-md-3 col-2"> <button class="btn btn-danger removeBtn"><i class="fa fa-trash"></i></button></div></div>
                                    `);
                newRow.find(".addBtnDiv").hide();
                $(".more_input").append(newRow);
            });

            //Remove Dam Sire info
            $(document).on("click", ".removeBtn", function() {
                $(this).closest(".row").remove();
            });
        });

        //Companion image
        document.getElementById("companion_image").addEventListener("change", function(event) {
            const file = event.target.files[0];
            const imageBox = document.getElementById("product-image-box");

            imageBox.innerHTML = "";

            if (file) {
                const img = document.createElement("img");
                img.src = URL.createObjectURL(file);
                img.classList.add("img-fluid", "preview-image");
                imageBox.appendChild(img);
            }
        });

        //Companion Gallery Preview
        $("#companion_gallery").change(function(e) {
            const dt = new DataTransfer();
            const galleryBox = $("#product-gallery-box");

            Array.from(e.target.files).forEach((file, i) => {
                const imgContainer = $(`
                                            <div class="preview-image preimg">
                                                <img src="${URL.createObjectURL(file)}" class="img-fluid">
                                                <button class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-selected-image" data-index="${i}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        `);
                galleryBox.append(imgContainer);
                dt.items.add(file);
            });

            e.target.files = dt.files;
        });

        //Remove selected image from gallery
        $(document).on("click", ".remove-selected-image", function() {
            const index = $(this).data("index");
            const input = document.getElementById("companion_gallery");
            const dt = new DataTransfer();

            Array.from(input.files).forEach((file, i) => i !== index && dt.items.add(file));

            input.files = dt.files;
            $(this).closest(".preview-image").remove();
            $(".preimg").each(function(i) {
                $(this).find(".remove-selected-image").data("index", i);
            });
        });

        //Companion video gallery preview
        $("#companion_video").on("change", function(event) {
            const files = event.target.files;
            const imageBox = document.getElementById("product-video-box");

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

                imageBox.appendChild(videoContainer[0]);
            });
        });

        //Companion remove video selected preview
        $(document).on("click", ".remove-video-btn", function() {
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

            $(".prevdo").each(function(i) {
                $(this).find(".remove-video-btn").data("index", i);
            });
        });

        //On change source payment date and amount
        $(document).ready(function() {
            $("#purchase_date_div").hide()
            $("#purchase_amount_div").hide()
            $("#source").on("change", function() {
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

        //Delete Dam Sire Info
        $(document).on('click', '.dam_sire_info .delete-dam-sire-info', function() {
            var gId = $(this).data('ds-id');
            console.log(gId)
            var isConfirmed = confirm("Are you sure you want to delete this Dam/Sire Info?");
            if (isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('deleteDamSire') }}/" + gId,
                    success: function(data) {
                        if (data.status == "success") {
                            Swal.fire({
                                icon: data.status,
                                title: data.message
                            }).then(() => {
                                window.location.reload();
                            });

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

        //Delete Gallery Image
        $(document).on('click', '#product-gallery-box .delete-btn', function() {
            var gId = $(this).data('image-id');
            var isConfirmed = confirm("Are you sure you want to delete this Image?");
            if (isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('deleteGalleryImage') }}/" + gId,
                    success: function(data) {
                        if (data.status == "success") {
                            Swal.fire({
                                icon: data.status,
                                title: data.message
                            }).then(() => {
                                window.location.reload();
                            });

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

        //Delete gallery video
        $(document).on('click', '#product-video-box .delete-video-btn', function() {
            var gId = $(this).data('image-id');
            var isConfirmed = confirm("Are you sure you want to delete this Video?");
            if (isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('deleteGalleryVideo') }}/" + gId,
                    success: function(data) {
                        if (data.status == "success") {
                            Swal.fire({
                                icon: data.status,
                                title: data.message
                            }).then(() => {
                                window.location.reload();
                            });

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
    </script>
@endsection
