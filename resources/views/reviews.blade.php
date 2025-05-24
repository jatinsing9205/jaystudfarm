@extends('layout.layout')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Reviews</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Reviews</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title fw-bold">Pending Reviews</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered dataTable" id="pendingReviewsTable">
                            <thead>
                                <tr>
                                    <th>S.NO.</th>
                                    <th>Product ID</th>
                                    <th>Name / Email</th>
                                    <th>Review</th>
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title fw-bold">Approved Reviews</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered dataTable" id="approvedReviewsTable">
                            <thead>
                                <tr>
                                    <th>S.NO.</th>
                                    <th>Product ID</th>
                                    <th>Name / Email</th>
                                    <th>Review</th>
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

    <script>
        function loadPendingReviews() {
            $.ajax({
                type: "GET",
                url: "{{ Route('loadPendingReviews') }}",
                success: function(data) {

                    var table = $('#pendingReviewsTable');
                    var tableBody = table.find('tbody').html('');
                    table.DataTable().clear().destroy();
                    data.forEach(function(reviews, index) {
                        var row = `<tr>
                                <td>${index + 1}</td>
                                <td>${reviews.product_id}</td>
                                <td>${reviews.name}<br>${reviews.email}</td>
                                <td>${reviews.review}</td>
                                <td>${reviews.status == '1' ? 'Approved' : 'Pending'}</td>
                                <td>
                                    <button class="btn btn-success btn-sm border approve-btn" data-id="${reviews.id}">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    <button data-id="${reviews.id}" class="btn btn-danger btn-sm delete-btn">
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
        loadPendingReviews();

        function loadApprovedReviews() {
            $.ajax({
                type: "GET",
                url: "{{ Route('loadApprovedReviews') }}",
                success: function(data) {

                    var table = $('#approvedReviewsTable');
                    var tableBody = table.find('tbody').html('');
                    table.DataTable().clear().destroy();
                    data.forEach(function(reviews, index) {
                        var row = `<tr>
                                <td>${index + 1}</td>
                                <td><a href="{{ url('product-details') }}/'+${reviews.product_id}">${reviews.product_id}</a></td>
                                <td>${reviews.name}<br>${reviews.email}</td>
                                <td>${reviews.review}</td>
                                <td>${reviews.status == '1' ? 'Approved' : 'Pending'}</td>
                                <td>
                                    <button data-id="${reviews.id}" class="btn btn-danger btn-sm delete-btn">
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
        loadApprovedReviews()


        $(document).on('click', '.approve-btn', function() {
            var reviewID = $(this).data('id');
            var isConfirmed = confirm("Are you sure you want to approve this Review?");
            if (isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('approveReview') }}/" + reviewID,
                    success: function(data) {
                        if (data.status == "success") {
                            loadPendingReviews()
                            loadApprovedReviews()
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

        //Delete Review
        $(document).on('click', '.delete-btn', function() {
            var reviewID = $(this).data('id');
            var isConfirmed = confirm("Are you sure you want to delete this Review?");
            if (isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('deleteReview') }}/" + reviewID,
                    success: function(data) {
                        if (data.status == "success") {
                            loadPendingReviews()
                            loadApprovedReviews()
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
    </script>
@endsection
