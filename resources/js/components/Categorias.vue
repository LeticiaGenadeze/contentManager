<template>
  <div>
    <FlashMessage :position="'right bottom'"></FlashMessage>
    <vue-confirm-dialog></vue-confirm-dialog>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <div class="row">
          <div class="col-md-8">
            <h6 class="m-0 font-weight-bold text-primary">Categorias</h6>
          </div>
          <div class="col-md-4 text-right">
            <button
              @click="openModalAddCat()"
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
              <a
                class="page-link"
                href="#"
                @click="fetchCategorias(pagination.prev_page_url)"
              >Anterior</a>
            </li>
            <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
              <a
                class="page-link"
                href="#"
                @click="fetchCategorias(pagination.next_page_url)"
              >Próximo</a>
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
import FlashMessage from "@smartweb/vue-flash-message";
Vue.use(FlashMessage);
import VueConfirmDialog from "vue-confirm-dialog";
Vue.use(VueConfirmDialog);
Vue.component("vue-confirm-dialog", VueConfirmDialog.default);

/*Seta as variáveis e objetos do sistema. */
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

 /*Inicializa funcões ao montar a página do post*/
  created() {
    this.fetchCategorias();
  },

  methods: {
       /*Busca as categorias na API */
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
      let mekealert = alert(alerta);
    },
    makePagination(response) {
      let pagination = {
        last_page: response.data.last_page_url,
        next_page_url: response.data.next_page_url,
        prev_page_url: response.data.prev_page_url
      };
      this.pagination = pagination;
    },

    /*Apaga uma Categoria*/
    deletarCategoria(id, page_url) {
      page_url = page_url || BASE_URL + "/api/categorias";
      var vm = this;
      this.$confirm({
        message: `Você tem certeza que quer deletar?`,
        button: {
          no: "Não",
          yes: "Sim"
        },
        /**
         * Callback Function
         * @param {Boolean} confirm
         */
        callback: confirm => {
          if (confirm) {
            axios
              .delete(page_url + "/" + id, {
                method: "delete"
              })
              .then(function(response) {
                vm.fetchCategorias();
                vm.flashMessage.success({
                  status: "success",
                  message: "Categoria foi deletada!"
                });
              })
              .catch(function(error) {
                console.log(error);
                vm.flashMessage.error({
                  status: "error",
                  message: "Ocorreu um erro ao deletar a Categoria!"
                });
              });
          }
        }
      });
    },

    /*Abre a modal para adicionar as categorias*/
    openModalAddCat() {
      var vm = this;
      vm.limparCat();
      $("#exampleModal").modal("show");
      $(".modal-backdrop").add();
    },

    /*Limpa os dados da memória após fechar a modal*/
    limparCat() {
      var vm = this;
      this.categoria.id = "";
      this.categoria.nome = "";
      this.categoria.descricao = "";
    },

    /*Adicionar categoria, da um post pra API e retorna a resposta*/
    addCategoria(page_url) {
      if (this.edit === false) {
        page_url = BASE_URL + "/api/categorias/";
        var vm = this;
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
            vm.fetchCategorias();
            vm.flashMessage.success({
              status: "success",
              message: "Categoria adicionada com Sucesso!"
            });
          })
          .catch(function(error) {
            alert(error);
            console.log(error);
            vm.flashMessage.error({
              status: "error",
              message: "Ocorreu um erro ao adicionar a Categoria!"
            });
          });
      } else {
        page_url = BASE_URL + "/api/categorias/" + this.categoria.id;
        var vm = this;
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
            vm.fetchCategorias();
            vm.edit = false;
            vm.limparCat();
            vm.flashMessage.success({
              status: "success",
              message: "Categoria atualizada com Sucesso!"
            });
          })
          .catch(function(error) {
            console.log(error);
            vm.flashMessage.error({
              status: "error",
              message: "Ocorreu um erro ao editar a Categoria!"
            });
          });
      }
    },

    /*Seta os dados e abre a modal de edição*/
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
