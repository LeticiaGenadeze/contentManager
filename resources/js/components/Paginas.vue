<template>
  <div>
    <FlashMessage :position="'right bottom'"></FlashMessage>
    <vue-confirm-dialog></vue-confirm-dialog>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <div class="row">
          <div class="col-md-8">
            <h6 class="m-0 font-weight-bold text-primary">Páginas</h6>
          </div>
          <div class="col-md-4 text-right">
            <button
              @click="openModalAddPost()"
              class="btn bg-gradient-info text-white"
            >Adicionar nova Página</button>
          </div>
        </div>
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Título</th>
              <th scope="col"></th>
              <th scope="col"></th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <tr role="row" class="odd" v-for="post in posts" v-bind:key="post.id">
              <td class="sorting_1" style="width:70%">{{ post.nome }}</td>
              <td>
                <button @click="visualizarPost(post)" class="btn btn-sm btn-success">
                  <span class="fa fa-eye"></span>
                </button>
              </td>
              <td>
                <button @click="editarPost(post)" class="btn btn-sm btn-info text-white">
                  <span class="fa fa-edit"></span>
                </button>
              </td>
              <td>
                <button @click="deletarPost(post.id)" class="btn btn-sm btn-danger">
                  <span class="fa fa-trash"></span>
                </button>
              </td>
            </tr>
          </tbody>
        </table>

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
                <h5 class="modal-title" id="exampleModalLabel">Página</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form @submit.prevent="addPost" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="nome">Título</label>
                    <input
                      type="text"
                      class="form-control"
                      id="nome"
                      placeholder="Dígite o Título"
                      required
                      v-model="post.nome"
                    />
                  </div>
                  <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <input
                      type="text"
                      class="form-control"
                      id="descricao"
                      placeholder="Dígite a Descrição"
                      required
                      v-model="post.descricao"
                    />
                  </div>

                  <div class="form-group">
                    <label for="conteudo">Conteúdo</label>
                    <textarea class="form-control" rows="6" v-model="post.conteudo"></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary float-right">Salvar</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div
          class="modal fade"
          id="verpost"
          tabindex="-1"
          role="dialog"
          aria-labelledby="exampleModalLabel"
          aria-hidden="true"
        >
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{verpost.nome}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>
                  <b>Descrição:</b>
                  {{verpost.descricao}}
                </p>
                <p>
                  <b>Conteúdo:</b>
                  {{verpost.conteudo}}
                </p>
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
      posts: [],
      categorias: [],
      post: {
        id: "",
        nome: "",
        conteudo: "",
        descricao: ""
      },
      verpost: {
        id: "",
        nome: "",
        conteudo: "",
        descricao: ""
      },
      post_id: "",
      //pagination: {},
      edit: false
    };
  },

 /*Inicializa funcões ao montar a página do post*/
  created() {
    this.fetchPosts();
    this.fetchCategorias();
  },

  methods: {
      /*Busca as páginas na API */
    fetchPosts(page_url) {
      page_url = page_url || BASE_URL + "/api/paginas";
      var vm = this;
      axios
        .get(page_url)
        .then(function(response) {
          vm.posts = response.data;
         // vm.makePagination(response);
        })
        .catch(function(error) {
          console.log(error);
        });
    },

   /* makePagination(response) {
      let pagination = {
        last_page: response.data.last_page_url,
        next_page_url: response.data.next_page_url,
        prev_page_url: response.data.prev_page_url
      };
      this.pagination = pagination;
    },*/

    /*Apaga uma Pagina*/
    deletarPost(id, page_url) {
      page_url = page_url || BASE_URL + "/api/paginas";
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
                vm.fetchPosts(page_url);
                vm.flashMessage.success({
                  status: "success",
                  message: "Página foi deletada!"
                });
              })
              .catch(function(error) {
                console.log(error);
                vm.flashMessage.error({
                  status: "error",
                  message: "Ocorreu um erro ao deletar a Página!"
                });
              });
          }
        }
      });
    },

    /*Abre a modal para adicionar as paginas*/
    openModalAddPost() {
      var vm = this;
      vm.limparPost();
      $("#exampleModal").modal("show");
      $(".modal-backdrop").add();
    },

    /*Adicionar pagina, da um post pra API e retorna a resposta*/
    addPost(page_url) {
      if (this.edit === false) {
        page_url = BASE_URL + "/api/paginas/";
        var vm = this;
        axios
          .post(page_url, {
            nome: this.post.nome,
            descricao: this.post.descricao,
            conteudo: this.post.conteudo,
            method: "post",
            body: JSON.stringify(this.post),
            headers: {
              "content-type": "multipart/form-data"
            }
          })
          .then(function(response) {
            console.log(response);
            $("#exampleModal").modal("hide");
            $(".modal-backdrop").remove();
            vm.fetchPosts(page_url);
            vm.limparPost();
            vm.flashMessage.success({
              status: "success",
              message: "Página adicionada com Sucesso!"
            });
          })
          .catch(function(error) {
            alert(error);
            console.log(error);
            vm.flashMessage.error({
              status: "error",
              message: "Ocorreu um erro ao adicionar a Página!"
            });
          });
      } else {
        page_url = BASE_URL + "/api/paginas/" + this.post.id;
        var vm = this;
        axios
          .put(page_url, {
            nome: this.post.nome,
            descricao: this.post.descricao,
            conteudo: this.post.conteudo,
            method: "post",
            body: JSON.stringify(this.post),
            headers: {
              "content-type": "multipart/form-data"
            }
          })
          .then(function(response) {
            console.log(response);
            $("#exampleModal").modal("hide");
            $(".modal-backdrop").remove();
            vm.fetchPosts();
            vm.edit = false;
            vm.limparPost();
            vm.flashMessage.success({
              status: "success",
              message: "Página atualizada com Sucesso!"
            });
          })
          .catch(function(error) {
            alert(error);
            console.log(error);
            vm.flashMessage.error({
              status: "error",
              message: "Ocorreu um erro ao editar a Página!"
            });
          });
      }
    },

    /*Limpa os dados da memória após fechar a modal*/
    limparPost() {
      var vm = this;
      this.post.id = "";
      this.post.nome = "";
      this.post.descricao = "";
      this.post.conteudo = "";
    },

    /*Seta os dados e abre a modal de edição*/
    editarPost(post) {
      this.edit = true;
      this.post.id = post.id;
      this.post.post_id = post.id;
      this.post.nome = post.nome;
      this.post.descricao = post.descricao;
      this.post.conteudo = post.conteudo;
      $("#exampleModal").modal("show");
      $(".modal-backdrop").add();
    },

     /*Seta os dados e abre modal para visualizar*/
    visualizarPost(post) {
      this.verpost.id = post.id;
      this.verpost.post_id = post.id;
      this.verpost.nome = post.nome;
      this.verpost.descricao = post.descricao;
      this.verpost.conteudo = post.conteudo;
      $("#verpost").modal("show");
      $(".modal-backdrop").add();
    },

    fetchCategorias(page_url) {
      page_url = page_url || BASE_URL + "/api/paginas";
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
    }
  }
};
</script>
