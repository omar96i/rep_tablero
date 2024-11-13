@php
    $container = 'container-fluid';
    $containerNav = 'container-fluid';
@endphp


@extends('layouts/commonMaster')

@section('title', 'Plan Operativo')

@section('vendor-style')
@endsection

@section('vendor-script')
@endsection

@section('page-script')
@endsection

@section('layoutContent')
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card" id="app">
                <div class="row row-bordered g-0">
                    <div class="col-12">
                        <a href="{{ route('plan-ejecucion') }}" class="btn btn-primary " style="width: 100%;">volver</a>
                    </div>

                    <div class="col-md-12">
                        <h5 class="card-header m-0 me-2 pb-3">Plan Indicativo - Ejecucion de meta</h5>
                    </div>
                    <div class="col-md-12">
                        <div class="card-body" id="app">
                            <ejecucion-meta-show :meta="{{ $meta }}" state="public"></ejecucion-meta-show>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
