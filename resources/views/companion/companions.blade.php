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
                    <a href="{{ route('addCompanion') }}">
                        <button class="btn btn-brown float-right">
                            <i class="fa fa-add mx-2"></i> Add Companion
                        </button>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline-brown">
                        <div class="card-header">
                            <h6 class="mb-0 fw-bold">OUR HORSES</h6>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered dataTable text-center">
                                <thead class="bg-grey">
                                    <tr>
                                        <th>Companion ID</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>DOB</th>
                                        <th>Last Updated</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($companions as $companion)
                                                                    <tr>
                                                                        <td>
                                                                            <a href="{{ route('viewCompanion',$companion->companion_id) }}"
                                                                                class="fw-bold">
                                                                                <i class="fa fa-link"></i> {{ $companion->companion_id }}
                                                                            </a>
                                                                        </td>
                                                                        <td class="py-1">
                                                                            <img src="{{ asset($companion->image) }}" class="horse-image"
                                                                                alt="{{ $companion->name }}">
                                                                        </td>
                                                                        <td>{{ $companion->name }}</td>
                                                                        <td>{{ $companion->category_name }}</td>
                                                                        <td>{{ $companion->dob ? date('d-M-Y', strtotime($companion->dob)) : 'N/A' }}</td>
                                                                        <td>{{ $companion->updated_at ? date('d-M-Y | H:i A', strtotime($companion->updated_at)) : 'N/A' }}
                                                                        </td>
                                                                        <td>
                                                                            @php
                                                                                $statusMap = [
                                                                                    1 => 'Active',
                                                                                    2 => 'Inactive',
                                                                                    3 => 'Draft',
                                                                                ];
                                                                                $status = $statusMap[$companion->status] ?? 'N/A';
                                                                            @endphp
                                                                            {{ $status }}
                                                                        </td>

                                                                        <td>
                                                                            <a href="{{ route('updateCompanion', $companion->companion_id) }}">
                                                                                <button class="btn btn-sm btn-primary">
                                                                                    <i class="fa fa-edit"></i>
                                                                                </button>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection