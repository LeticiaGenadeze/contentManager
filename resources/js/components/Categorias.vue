<template>
  <div>
    <link
      href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
      rel="stylesheet"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
      crossorigin="anonymous"
    />
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <div class="row">
          <div class="col-md-8">
            <h6 class="m-0 font-weight-bold text-primary">Categorias</h6>
          </div>
          <div class="col-md-4 text-right">
            <button
              data-toggle="modal"
              data-target="#exampleModal"
              class="btn bg-gradient-info text-white"
            >Adicionar nova Categoria</button>
          </div>
        </div>
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Título</th>
              <th scope="col">Descrição</th>
              <th scope="col"></th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <tr role="row" class="odd" v-for="categoria in categorias" v-bind:key="categoria.id">
              <td class="sorting_1" style="width:30%">{{ categoria.nome }}</td>
              <td class="sorting_1" style="width:40%">{{ categoria.descricao }}</td>
              <td>
                <button @click="editarCategoria(categoria)" class="btn btn-sm btn-info text-white">
                  <span class="fa fa-edit"></span>
                </button>
              </td>
              <td>
                <button @click="deletarCategoria(categoria.id)" class="btn btn-sm btn-danger">
                  <span class="fa fa-trash"></span>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-center">
            <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
              <a class="page-link" href="#" @click="fetchCategorias(pagination.prev_page_url)">Anterior</a>
            </li>
            <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
              <a class="page-link" href="#" @click="fetchCategorias(pagination.next_page_url)">Próximo</a>
            </li>
          </ul>
        </nav>

        <div
          class="modal fade"
          id="exampleModal"
          tabindex="-1"
          role="dialog"
          aria-labelledby="exampleModalLabel"
          aria-hidden="true"
        >
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Categorias</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form @submit.prevent="addCategoria" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="nome">Nome</label>
                    <input
                      type="text"
                      class="form-control"
                      id="nome"
                      placeholder="Dígite o Nome da Categoria"
                      required
                      v-model="categoria.nome"
                    />
                  </div>

                  <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <input
                      type="text"
                      class="form-control"
                      id="descricao"
                      placeholder="Dígite a Descrição da Categoria"
                      required
                      v-model="categoria.descricao"
                    />
                  </div>

                  <button type="submit" class="btn btn-primary float-right">Salvar</button>
                </form>
              </div>
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
      categorias: [],
      categoria: {
        id: "",
        nome: "",
        descricao: ""
      },
      categoria_id: "",
      pagination: {},
      mekealert: "",
      edit: false
    };
  },

  created() {
    this.fetchCategorias();
  },

  methods: {
         fetchCategorias(page_url) {
       page_url = page_url || BASE_URL + "/api/categorias";
      var vm = this;
      axios
        .get(page_url)
        .then(function(response) {
          vm.categorias = response.data;
          vm.makePagination(response);
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    makealert(alerta) {
      let mekealert = alert(alerta)
    },

    makePagination(response) {
      let pagination = {
        last_page: response.data.last_page_url,
        next_page_url: response.data.next_page_url,
        prev_page_url: response.data.prev_page_url
      };
      this.pagination = pagination;
    },
    deletarCategoria(id, page_url) {
      page_url = page_url || BASE_URL + "/api/categorias";

      if (confirm("Tem certeza que deseja excluir?" + id)) {
        axios
          .delete(page_url + "/" + id, {
            method: "delete"
          })
          .then(function(response) {
              mekealert(teste)
         //   location.reload();
          })
          .catch(function(error) {
            console.log(error);
          });
      }
    },

    addCategoria(page_url) {
      if (this.edit === false) {
        page_url = BASE_URL + "/api/categorias/";
        axios
          .post(page_url, {
            nome: this.categoria.nome,
            descricao: this.categoria.descricao,
            method: "post",
            body: JSON.stringify(this.categoria),
            headers: {
              "content-type": "multipart/form-data"
            }
          })
          .then(function(response) {
            console.log(response);
            $("#exampleModal").modal("hide");
            $(".modal-backdrop").remove();
             this.fetchCategorias();
            //location.reload();
          })
          .catch(function(error) {
            alert(error);
            console.log(error);
          });
      } else {
        page_url = BASE_URL + "/api/categorias/" + this.categoria.id;
        axios
          .put(page_url, {
            nome: this.categoria.nome,
            descricao: this.categoria.descricao,
            method: "post",
            body: JSON.stringify(this.categoria),
            headers: {
              "content-type": "multipart/form-data"
            }
          })
          .then(function(response) {
            console.log(response);
            $("#exampleModal").modal("hide");
            $(".modal-backdrop").remove();
            location.reload();
          })
          .catch(function(error) {
            alert(error);
            console.log(error);
          });
      }
    },
    editarCategoria(categoria) {
      this.edit = true;
      this.categoria.id = categoria.id;
      this.categoria.categoria_id = categoria.id;
      this.categoria.nome = categoria.nome;
      this.categoria.descricao = categoria.descricao;
      $("#exampleModal").modal("show");
      $(".modal-backdrop").add();
    }
  }
};
</script>
