@extends('layout.layout')
@section('content')
    <div class="content-header mb-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="m-0">Dashboard</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <a href="{{route('companions')}}">
                    <div class="info-box border border-warning">
                        <span class="info-box-icon bg-grey"><i class="fas fa-rectangle-list text-warning"></i></span>
                        <div class="info-box-content">
                            <h5 class="info-box-text m-0 text-warning">Total Companions</h5>
                            <h2 class="info-box-number m-0">{{$companionCount}}</h2>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-6">
                <a href="">
                    <div class="info-box border border-purple">
                        <span class="info-box-icon bg-grey"><i class="fas fa-horse text-purple"></i></span>
                        <div class="info-box-content">
                            <h5 class="info-box-text m-0 text-purple">Horses</h5>
                            <h2 class="info-box-number m-0">{{$horsesCount}}</h2>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-6">
                <a href="">
                    <div class="info-box border border-danger">
                        <span class="info-box-icon bg-grey"><i class="fas fa-dog text-danger"></i></span>
                        <div class="info-box-content">
                            <h5 class="info-box-text m-0 text-danger">Dogs</h5>
                            <h2 class="info-box-number m-0">{{$dogsCount}}</h2>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-6">
                <a href="{{route('category')}}">
                    <div class="info-box border border-success">
                        <span class="info-box-icon bg-grey"><i class="fas fa-tag text-success"></i></span>
                        <div class="info-box-content">
                            <h5 class="info-box-text m-0 text-success">Categories</h5>
                            <h2 class="info-box-number m-0">{{$categoryCount}}</h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
