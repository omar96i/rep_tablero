@php
$container = 'container-fluid';
$containerNav = 'container-fluid';
@endphp


@extends('layouts/contentNavbarLayout')

@section('title', 'Periodos')

@section('content')
<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card" id="app">
            <div class="row row-bordered g-0">
                <!-- Title -->
                <div class="col-md-12">
                    <h5 class="card-header m-0 me-2 pb-3">Periodos</h5>
                </div>
                <div class="col-md-12">
                    <div class="card-body pt-0">
                        <periodo-index></periodo-index>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
