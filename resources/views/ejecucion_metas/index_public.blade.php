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
    <div class="container mt-3">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card" id="app">
                    <div class="row row-bordered g-0">
                        <!-- Title -->
                        <div class="col-md-12">
                            <h5 class="card-header m-0 me-2 pb-3">Lista de Metas Asignadas</h5>
                        </div>
                        <div class="col-md-12">
                            <div class="card-body pt-0" id="app">
                                <ejecucion-meta-show-public :periodo="{{ $periodo_activo }}"></ejecucion-meta-show-public>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
