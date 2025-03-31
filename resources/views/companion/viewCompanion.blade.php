@extends('layout.layout')
@section('content')
    <div class="content-header mb-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="m-0 text-uppercase">Horse Details</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
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
                    <a href="{{ url('updateCompanion') }}/{{ $companion->companion_id }}"
                        class="position-absolute btn btn-primary btn-sm" style="top: 7px;right:10px;"> <i
                            class="fa fa-edit"></i> Edit Info</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 pr-lg-5">
                            <ul id="lightSlider">

                                <!-- Display main image -->
                                <li data-thumb="{{ url('') }}/{{ $companion->image }}">
                                    <a href="{{ url('') }}/{{ $companion->image }}" data-fancybox="images">
                                        <img src="{{ url('') }}/{{ $companion->image }}" />
                                    </a>
                                </li>

                                <!-- Gallery Images & Videos -->
                                @foreach ($companion->gallery_images as $item)
                                    @if ($item->type == 'video')
                                        <li data-thumb="{{ url('public/dist/img/play-icon.png') }}" class="video">
                                            <a href="{{ url('') }}/{{ $item->file_path }}" data-fancybox="video">
                                                <video height="320" autoplay muted controls>
                                                    <source src="{{ url('') }}/{{ $item->file_path }}"
                                                        type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </a>
                                        </li>
                                    @else
                                        <li data-thumb="{{ url('') }}/{{ $item->file_path }}">
                                            <a href="{{ url('') }}/{{ $item->file_path }}" data-fancybox="images">
                                                <img src="{{ url('') }}/{{ $item->file_path }}" />
                                            </a>
                                        </li>
                                    @endif
                                @endforeach

                            </ul>

                        </div>
                        <div class="col-md-6">
                            <div class="companion-infomation-box">
                                <h2 class="companion-title">{{ $companion->name }}</h2>
                                <hr class="divider">
                                <table class="info-table table table-bordered">
                                    <tr>
                                        <th width="50%">Sex</th>
                                        <td>{{ $companion->sex }}</td>
                                    </tr>
                                    <tr>
                                        <th width="50%">Category</th>
                                        <td>{{ $companion->category_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date of Birth </th>
                                        <td>{{ $companion->dob }}</td>
                                    </tr>
                                    <tr>
                                        <th>Height </th>
                                        <td>{{ $companion->height }}</td>
                                    </tr>
                                    <tr>
                                        <th>Type </th>
                                        <td>{{ $companion->type }}</td>
                                    </tr>
                                    <tr>
                                        <th>Source </th>
                                        <td>{{ $companion->source }}</td>
                                    </tr>
                                    <tr>
                                        <th>Purchased Date </th>
                                        <td>
                                            @if (!empty($companion->purchase_date))
                                                {{ $companion->purchase_date }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Purchase Amount </th>
                                        <td>
                                            @if (!empty($companion->purchase_amount))
                                                {{ $companion->purchase_amount }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Microchip Number </th>
                                        <td>{{ $companion->micro_chip_number }}</td>
                                    </tr>
                                </table>
                                <hr class="divider">
                                <p class="fw-bold mb-2 text-brown">Dam / Sire Information</p>
                                <table class="info-table table table-bordered">
                                    @foreach ($companion->dam_sire_info as $dam_sire)
                                        <tr>
                                            <th width="50%">{{ $dam_sire->identifier }}</th>
                                            <td>{{ $dam_sire->name }}</td>
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
                        <?= $companion->short_description ?>
                    </div>
                    <hr class="divider">
                    <h6 class="fw-bold">Description :-</h6>
                    <div class="description">
                        <?= $companion->description ?>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header p-0">
                    <ul class="nav horse-report-tabs nav-tabs d-flex" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="Nutrition-tab" data-bs-toggle="tab"
                                data-bs-target="#Nutrition-tab-pane" type="button" role="tab"
                                aria-controls="Nutrition-tab-pane" aria-selected="false">Nutrition</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="Supplements-tab" data-bs-toggle="tab"
                                data-bs-target="#Supplements-tab-pane" type="button" role="tab"
                                aria-controls="Supplements-tab-pane" aria-selected="false">Supplements</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="Medical-tab" data-bs-toggle="tab"
                                data-bs-target="#Medical-tab-pane" type="button" role="tab"
                                aria-controls="Medical-tab-pane" aria-selected="true">Medical</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="Exercise-tab" data-bs-toggle="tab"
                                data-bs-target="#Exercise-tab-pane" type="button" role="tab"
                                aria-controls="Exercise-tab-pane" aria-selected="false">Exercise</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="Grooming-tab" data-bs-toggle="tab"
                                data-bs-target="#Grooming-tab-pane" type="button" role="tab"
                                aria-controls="Grooming-tab-pane" aria-selected="false">Grooming</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="BodyWeight-tab" data-bs-toggle="tab"
                                data-bs-target="#BodyWeight-tab-pane" type="button" role="tab"
                                aria-controls="BodyWeight-tab-pane" aria-selected="false">Body Weight</button>
                        </li>

                        @if ($companion->sex == 'F')
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="Pregnancy-tab" data-bs-toggle="tab"
                                    data-bs-target="#Pregnancy-tab-pane" type="button" role="tab"
                                    aria-controls="Pregnancy-tab-pane" aria-selected="false">Pregnancy</button>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active accordion-item border-0" id="Nutrition-tab-pane"
                            role="tabpanel" aria-labelledby="Nutrition-tab" tabindex="0">
                            <div class="text-center">
                                <button id="addNutritionsBtn" class="btn btn-warning">Add Nutritions</button>
                            </div>
                            <table class="table table-bordered bg-light dataTable">
                                <thead class="bg-warning">
                                    <tr>
                                        <th>Date</th>
                                        <th>Food</th>
                                        <th>Quantity</th>
                                        <th>Time of first feed</th>
                                        <th>Time of second feed</th>
                                        <th>Administered by</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>01-01-2025</td>
                                        <td>Nera</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>01-01-2025</td>
                                        <td>Lussan</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>01-01-2025</td>
                                        <td>Javi</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>01-01-2025</td>
                                        <td>Feed</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>01-01-2025</td>
                                        <td>Meetha Soda</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>01-01-2025</td>
                                        <td>Gur</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>01-01-2025</td>
                                        <td>Etc</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade accordion-item border-0" id="Supplements-tab-pane" role="tabpanel"
                            aria-labelledby="Supplements-tab" tabindex="0">
                            <div class="text-center">
                                <button id="addSupplementsBtn" class="btn bg-orange">Add Supplements</button>
                            </div>
                            <table class="table table-bordered bg-light dataTable">
                                <thead class="bg-orange">
                                    <tr>
                                        <th>Date</th>
                                        <th>Supplements</th>
                                        <th>Quantity</th>
                                        <th>Time Given</th>
                                        <th>Administered by</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>

                        <div class="tab-pane fade accordion-item border-0" id="Medical-tab-pane" role="tabpanel"
                            aria-labelledby="Medical-tab" tabindex="0">
                            <div class="text-center">
                                <button id="addMedicalBtn" class="btn btn-success">Add Medical</button>
                            </div>
                            <table class="table table-bordered bg-light dataTable">
                                <thead class="bg-success">
                                    <tr>
                                        <th>Deworming</th>
                                        <th>Date of treatment</th>
                                        <th>Medication Given </th>
                                        <th>Next follow up treatment (Remarks) </th>
                                        <th>Date of follow up treatment</th>
                                        <th>Doctor's remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Deworming</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Tetnus</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Pregnancy</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Chrolic</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Laminitus</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Hoove Ring</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Body Injury</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Sara</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Rodococus</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Running Nose and Cold</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade accordion-item border-0" id="Exercise-tab-pane" role="tabpanel"
                            aria-labelledby="Exercise-tab" tabindex="0">
                            <div class="text-center">
                                <button id="addExerciseBtn" class="btn btn-primary">Add Exercise</button>
                            </div>
                            <table class="table table-bordered bg-light  dataTable">
                                <thead class="bg-primary">
                                    <tr>
                                        <th>Date</th>
                                        <th>Type of Exercise</th>
                                        <th>Given by </th>
                                        <th>Monitored by </th>
                                        <th>Time Spent </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>01-01-2025</td>
                                        <td>Lounging</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Riding</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Gazing</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Show Training</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Swimming</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade accordion-item border-0" id="Grooming-tab-pane" role="tabpanel"
                            aria-labelledby="Grooming-tab" tabindex="0">
                            <div class="text-center">
                                <button id="addGroomingBtn" class="btn bg-purple">Add Grooming</button>
                            </div>
                            <table class="table table-bordered bg-light  dataTable">
                                <thead class="bg-purple">
                                    <tr>
                                        <th>Date</th>
                                        <th>Grooming (Morning)</th>
                                        <th>Grooming (Evening)</th>
                                        <th>Administered by </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="tab-pane fade accordion-item border-0" id="BodyWeight-tab-pane" role="tabpanel"
                            aria-labelledby="BodyWeight-tab" tabindex="0">
                            <div class="text-center">
                                <button id="addBodyWeightBtn" class="btn bg-gray">Add Body Weight</button>
                            </div>
                            <table class="table table-bordered bg-light  dataTable">
                                <thead class="bg-gray">
                                    <tr>
                                        <th>Date</th>
                                        <th>Weight</th>
                                        <th>Checked By</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        @if ($companion->sex == 'F')
                            <div class="tab-pane fade accordion-item border-0" id="Pregnancy-tab-pane" role="tabpanel"
                                aria-labelledby="Pregnancy-tab" tabindex="0">
                                <div class="text-center">
                                    <button id="addPregnancyBtn" class="btn bg-maroon">Add Pregnancy</button>
                                </div>
                                <table class="table table-bordered bg-light  dataTable">
                                    <thead class="bg-maroon">
                                        <tr>
                                            <th>Date</th>
                                            <th>Stallion</th>
                                            <th>Date of Mating</th>
                                            <th>1st Checkup Date</th>
                                            <th>2nd Checkup Date</th>
                                            <th>3rd Checkup Date</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        @endif
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
