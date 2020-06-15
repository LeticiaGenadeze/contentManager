<template>
  <div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div
                class="text-xs font-weight-bold text-primary text-uppercase mb-1"
              >Posts Publicados</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{estatisticas.posts}}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div
                class="text-xs font-weight-bold text-success text-uppercase mb-1"
              >Páginas Publicadas</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{estatisticas.paginas}}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Categorias dos Posts</div>
              <div class="row no-gutters align-items-center">
                <div class="col-auto">
                  <div class="h5 mb-0 font-weight-bold text-gray-800">{{estatisticas.categorias}}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div
                class="text-xs font-weight-bold text-warning text-uppercase mb-1"
              >Usuários</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{estatisticas.usuarios}}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
        estatisticas: {
        posts: "",
        paginas: "",
        categorias: "",
        usuarios: ""
      }
    };
  },

  created() {
    this.Estatisticas();
  },


  methods: {
    Estatisticas(page_url) {
      page_url = page_url || BASE_URL + "/api/estatisticas";
      var vm = this;
      axios
        .get(page_url)
        .then(function(response) {
          vm.estatisticas = response.data;
        })
        .catch(function(error) {
          console.log(error);
        });
    },


  }
};
</script>
