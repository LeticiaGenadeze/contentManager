<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
      <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
      <!-- Nav Item - User Information -->
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{auth()->user()->name}}</span>
        @if(auth()->user()->imagem)
         <img class="img-profile rounded-circle" src="{{asset('storage/usuario').'/'.auth()->user()->imagem}}">
        @endif
        </a>
        <!-- Dropdown - User Information -->


        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="{{url('admin/perfil')}}">
            <i class="fas fa-user fa-sm fa-fw mr-2"></i>
            Meus Dados
          </a>
        <form action="{{url('/logout')}}" method="POST">
            @csrf
            <button class="dropdown-item">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Deslogar
            </button>
        </form>
        </div>
      </li>
    </ul>
  </nav>
