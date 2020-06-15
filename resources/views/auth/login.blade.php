@extends('layouts.login')

@section('content')

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-6 col-md-6">

              <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                  <!-- Nested Row within Card Body -->

                      <div class="p-5">
                        <div class="text-center">
                            <h1 class="h2 text-gray-900 mb-4">Content Manager</h1>
                        </div>
                        <div class="text-center">
                          <h1 class="h4 text-gray-900 mb-4">Bem Vindo ao Login!</h1>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                          <div class="form-group">
                            <input id="email" type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Seu email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                          </div>
                          <div class="form-group">
                            <input id="password" type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Sua senha">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                          <div class="form-group">
                            <div class="custom-control custom-checkbox small">
                              <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                              <label class="custom-control-label" for="customCheck">Lembrar Senha</label>

                            </div>
                          </div>
                          <button type="submit" class="btn btn-primary btn-user btn-block">
                             Login
                          </button>
                        </form>
                        <hr>
                    </div>
                </div>
              </div>
            </div>
          </div>
    </div>
@endsection
