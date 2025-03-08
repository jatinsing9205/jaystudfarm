@extends("layout.layout")
@section("content")

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Companions</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Companions</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-md-12">
                    <a href="{{route("addCompanion")}}"><button class="btn btn-brown float-right"><i class="fa fa-add mx-2"></i> Add
                            Companion</button></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline-brown">
                        <div class="card-header">
                            <h6 class="mb-0 fw-bold">OUR HORSES</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered dataTable">
                                <thead class="bg-grey">
                                    <tr>
                                        <th>S.No</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>DOB</th>
                                        <th>Last Updated</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection