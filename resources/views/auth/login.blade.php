@extends('layouts/blankLayout')

@section('title', 'Login')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Register -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a class="app-brand-link gap-2">
              <span class="app-brand-logo demo"><img src="{{ asset('/icono.jpg') }}" style="width: 45px;"></span>
              <h3 class="app-brand-text fw-bolder my-0">PER</h3>
            </a>
          </div>
          <!-- /Logo -->

          <h4 class="mb-2 text-center">Bienvenido👋</h4>
          <p class="mb-4">Por favor ingresa tu cuenta para administrar tu pagina</p>

          <form id="formAuthentication" class="mb-3" action="{{route('login.submit')}}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="usuario" class="form-label">Nombre de usuario</label>
              <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Ingresa tu correo" autofocus>
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Contraseña</label>
                <a>
                  <small>Olvido su contraseña?</small>
                </a>
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>

            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">Ingresar</button>
            </div>
          </form>

          {{-- <p class="text-center">
            <a>
              <span>Crear una cuenta</span>
            </a>
          </p> --}}
          @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
        </div>
      </div>
    </div>
    <!-- /Register -->
  </div>
</div>
</div>
@endsection
