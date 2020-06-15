@extends('layouts.admin')

@section('content')

        <div class="card shadow mb-4">
           @include('admin.includes.flash-message')
          <div class="card-header py-3">
            <div class="row">
              <div class="col-md-12">
                <h6 class="m-0 font-weight-bold text-primary">Meu Perfil</h6>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6 text-center pt-5">
                  <p>  @if(auth()->user()->imagem)
                  <img class="img-profile rounded-circle" style="max-width: 200px" src="{{asset('storage/usuario').'/'.$usuario->imagem}}">
                   @endif</p>
                <p>
                  <b>Nome:</b> {{$usuario->name}}
                </p>
                <p>
                  <b>Email:</b> {{$usuario->email}}
                </p>
              </div>
              <div class="col-md-6">
              <form action="{{route('admin.perfil.update', $usuario->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                  <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" placeholder="Informe seu nome" value="{{$usuario->name}}" name="name" />
                  </div>

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input
                      type="email"
                      class="form-control"
                      id="email"
                      aria-describedby="emailHelp"
                      placeholder="Informe seu email"
                      value="{{$usuario->email}}"
                      name="email"
                    />

                  </div>
                    <div class="form-group">
                        <label class="label">
                            Imagem do Perfil
                        </label>
                        <input name="imagem" type="file" class="form-control-file border">
                    </div>

                  <div class="form-group">
                    <label for="senha">Senha</label>
                    <input
                      type="password"
                      class="form-control"
                      id="senha"
                      placeholder="Informe sua senha"
                      name="password"
                    />
                  </div>
                  <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
              </div>
            </div>
          </div>
        </div>
@endsection
