@php
$container = 'container-fluid';
$containerNav = 'container-fluid';
@endphp


@extends('layouts/contentNavbarLayout')

@section('title', 'User')

@section('vendor-style')
@endsection

@section('vendor-script')
@endsection

@section('page-script')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card" id="app">
            <div class="row row-bordered g-0">
                <!-- Title -->
                <div class="col-md-12">
                    <h5 class="card-header m-0 me-2 pb-3">Resultados</h5>
                </div>
                <div class="col-md-12">
                    <div class="card-body" id="app">
                        <iframe title="Report Section" width="100%" height="804" src="https://app.powerbi.com/view?r=eyJrIjoiMTYzNjE1MWYtNTcyOS00YTdmLThmMWYtYjQxY2Q1ZDYxODZkIiwidCI6IjJlNjBlNWFlLTA2MGYtNGExMC1hZWJiLTkyODY2MjFjNGQ4MiJ9" frameborder="0" allowFullScreen="true"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
