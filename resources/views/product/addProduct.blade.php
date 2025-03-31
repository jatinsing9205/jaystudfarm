@extends("layout.layout")
@section("content")

    <div class="content-header mb-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="m-0">Products</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Products</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <form action="{{route('addProductProcess')}}" method="post" id="productForm">
                            <div class="card-header">
                                <span class="m-0 fw-bold">Add Product</span>
                            </div>
                            <div class="card-body">
                                @csrf

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product_title">Product Title<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="product_title" id="product_title" class="form-control">
                                            <div class="product_title_err error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product_category">Product Category</label>
                                            <select name="product_category" id="product_category"
                                                class="form-control form-select">
                                                <option value="">Select Category</option>
                                                <?php
    foreach ($categories as $category) {
                                                                                                                                                                ?>
                                                <option value="<?=$category['id']?>"><?=$category['category_name']?>
                                                </option>
                                                <?php
    }
                                                                                                                                                        ?>
                                            </select>
                                            <div class="product_category_err error"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="price">Price<span class="text-danger">*</span></label>
                                            <input type="text" name="price" id="price" class="form-control">
                                            <div class="price_err error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sale_price">Sale Price</label>
                                            <input type="text" name="sale_price" id="sale_price" class="form-control">
                                            <div class="sale_price_err error"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="short_description">Short Description</label>
                                            <textarea id="short_description" name="short_description"
                                                class="form-control"></textarea>
                                            <div class="short_description_err error"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea id="description" name="description" class="form-control"></textarea>
                                            <div class="description_err error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row mt-3 mb-3 bg-light py-3 border border-grey">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="product_image">Product Image<span
                                                            class="text-danger">*</span></label>
                                                    <input type="file" class="form-control" id="product_image"
                                                        name="product_image">
                                                    <div class="product_image_err error"></div>
                                                </div>
                                                <div class="product-image-box" id="product-image-box"></div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="product_gallery">Product Gallery</label>
                                                    <input type="file" class="form-control" id="product_gallery"
                                                        name="product_gallery[]" multiple>
                                                    <div class="product_gallery_err error"></div>
                                                </div>
                                                <div class="product-image-box" id="product-gallery-box"></div>
                                            </div>
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
                                <button type="submit" class="btn btn-primary float-right" id="submitBtn">Add
                                    Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $("#productForm").submit(function (e) {
                e.preventDefault();
                var form = $("#productForm")[0];
                var data = new FormData(form);
                $("#submitBtn").prop("disabled", true);
                $.ajax({
                    type: "POST",
                    url: "{{Route('addProductProcess')}}",
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if (data.status == 'success') {
                            Swal.fire({
                                icon: data.status,
                                title: data.message
                            }).then(() => {
                                window.location.href = "{{Route('products')}}"
                            })
                        } else {
                            Swal.fire({
                                icon: data.status,
                                title: data.message
                            })
                            printError(data.error)
                        }
                        $("#submitBtn").prop("disabled", false);
                    },
                    error: function (error) {
                        console.log(error.responseJSON);
                        $("#submitBtn").prop("disabled", false);
                    }
                })
            })
        })



        function printError(err) {
            $.each(err, function (key, value) {
                $("." + key + "_err").text(value)
            })
        }


        document.getElementById("product_image").addEventListener("change", function (event) {
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

        document.getElementById("product_gallery").addEventListener("change", function (event) {
            const files = event.target.files;
            const galleryBox = document.getElementById("product-gallery-box");

            // Clear any existing previews
            galleryBox.innerHTML = "";

            Array.from(files).forEach(file => {
                const img = document.createElement("img");
                img.src = URL.createObjectURL(file);
                img.classList.add("img-fluid", "preview-image", "m-1");
                galleryBox.appendChild(img);
            });
        });
    </script>

@endsection