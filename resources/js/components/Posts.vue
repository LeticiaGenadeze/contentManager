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
        <h6 class="m-0 font-weight-bold text-primary">Posts</h6>
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
                <button class="btn btn-sm btn-success">
                  <span class="fa fa-eye"></span>
                </button>
              </td>
              <td>
                <button class="btn btn-sm btn-info text-white">
                  <span class="fa fa-edit"></span>
                </button>
              </td>
              <td>
                <button class="btn btn-sm btn-danger">
                  <span class="fa fa-trash"></span>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-center">
            <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
              <a class="page-link" href="#" @click="fetchPosts(pagination.prev_page_url)">Anterior</a>
            </li>
            <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
              <a class="page-link" href="#" @click="fetchPosts(pagination.next_page_url)">Próximo</a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      posts: [],
      post_id: "",
      pagination: {},
      edit: false
    };
  },

  created() {
    this.fetchPosts();
  },

  methods: {
    fetchPosts(page_url) {
      page_url = page_url || BASE_URL + "/api/posts";
      var vm = this;
      axios
        .get(page_url)
        .then(function(response) {
          vm.posts = response.data.data;
          vm.makePagination(response);
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    makePagination(response) {
      let pagination = {
        last_page: response.data.last_page_url,
        next_page_url: response.data.next_page_url,
        prev_page_url: response.data.prev_page_url
      };
      this.pagination = pagination;
    }
  }
};
</script>
