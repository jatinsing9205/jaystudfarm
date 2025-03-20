@extends("layout.layout")
@section("content")

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-uppercase">Horse Details</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Horse Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <span class=""><b>Last Updated :</b>
                        {{ $companion->updated_at ? date('d-M-Y | H:i A', strtotime($companion->updated_at)) : 'N/A' }}</span>
                    <a href="{{url('updateCompanion')}}/{{$companion->companion_id}}"
                        class="position-absolute btn btn-primary btn-sm" style="top: 7px;right:10px;">Edit Info</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 pr-lg-5">
                            <ul id="lightSlider">
                                <!-- Display main image -->
                                <li data-thumb="{{url('')}}/{{$companion->image}}">
                                    <a href="{{url('')}}/{{$companion->image}}" data-fancybox="images">
                                        <img src="{{url('')}}/{{$companion->image}}" />
                                    </a>
                                </li>

                                <!-- Loop through gallery images -->
                                @foreach ($companion->gallery_images as $item)
                                    @if ($item->type == "video")
                                        <li data-thumb="{{url('public/dist/img/play-icon.png')}}" class="video">
                                            <a href="{{url('')}}/{{$item->file_path}}" data-fancybox="video">
                                                <video height="320" autoplay muted controls>
                                                    <source src="{{url('')}}/{{$item->file_path}}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </a>
                                        </li>
                                    @else
                                        <li data-thumb="{{url('')}}/{{$item->file_path}}">
                                            <a href="{{url('')}}/{{$item->file_path}}" data-fancybox="images">
                                                <img src="{{url('')}}/{{$item->file_path}}" />
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>

                        </div>
                        <div class="col-md-6">
                            <div class="companion-infomation-box">
                                <h2 class="companion-title">{{$companion->name}}</h2>
                                <hr class="divider">
                                <table class="info-table table table-bordered">
                                    <tr>
                                        <th width="50%">Sex</th>
                                        <td>{{$companion->sex}}</td>
                                    </tr>
                                    <tr>
                                        <th width="50%">Category</th>
                                        <td>{{$companion->category_name}}</td>
                                    </tr>
                                    <tr>
                                        <th>Date of Birth </th>
                                        <td>{{$companion->dob}}</td>
                                    </tr>
                                    <tr>
                                        <th>Height </th>
                                        <td>{{$companion->height}}</td>
                                    </tr>
                                    <tr>
                                        <th>Type </th>
                                        <td>{{$companion->type}}</td>
                                    </tr>
                                    <tr>
                                        <th>Source </th>
                                        <td>{{$companion->source}}</td>
                                    </tr>
                                    <tr>
                                        <th>Purchased Date </th>
                                        <td>
                                            @if (!empty($companion->purchase_date))
                                                {{$companion->purchase_date}}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Purchase Amount </th>
                                        <td>
                                            @if (!empty($companion->purchase_amount))
                                                {{$companion->purchase_amount}}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Microchip Number </th>
                                        <td>{{$companion->micro_chip_number}}</td>
                                    </tr>
                                </table>
                                <hr class="divider">
                                <p class="fw-bold mb-2 text-brown">Dam / Sire Information</p>
                                <table class="info-table table table-bordered">
                                    @foreach ($companion->dam_sire_info as $dam_sire)
                                        <tr>
                                            <th width="50%">{{$dam_sire->identifier}}</th>
                                            <td>{{$dam_sire->name}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h6 class="fw-bold">Short Description :-</h6>
                    <div class="short-description">
                        <?=$companion->short_description?>
                    </div>
                    <hr class="divider">
                    <h6 class="fw-bold">Description :-</h6>
                    <div class="description">
                        <?=$companion->description?>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Modal -->
    <div class="modal fade p-3" id="popupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog m-0" style="max-width:100%;">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <button type="button" class="btn-close btn bg-maroon" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body px-0 pt-2 pb-0">

                </div>
            </div>
        </div>
    </div>


@endsection