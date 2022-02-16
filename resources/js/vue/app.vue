<template>
  <div>
    <div
      class="flex flex-col drawer-content mb-20"
      v-if="this.existCategory == true"
    >
      <div>
        <div class="grid grid-cols-1 lg:grid-cols-2 p-5 gap-5 items-center">
          <div class="grid grid-cols-3 gap-3 items-stretch h-10 lg:h-10">
            <button
              @click="getList()"
              class="
                text-white
                cursor-pointer
                grid
                items-center
                justify-items-center
                hover:text-gray-200
                bg-gradient-to-r bg-base-100
                focus:from-rose-400
                via-fuchsia-500
                to-indigo-500
                rounded-xl
              "
              href="/"
            >
              <p>
              Upcoming  <span class="badge badge-md ml-2">{{ numbers.todo }}</span>
            </p>
            </button>
            <button
              @click="inProgress()"
              class="
                text-white
                cursor-pointer
                grid
                items-center
                justify-items-center
                hover:text-gray-200
                bg-gradient-to-r bg-base-100
                focus:from-rose-400
                via-fuchsia-500
                to-indigo-500
                rounded-xl
              "
              href="/"
            >
            <p>
              In Progress  <span class="badge badge-md ml-2">{{ numbers.progress }}</span>
            </p>
            </button>
            <button
              @click="completed()"
              class="
                text-white
                cursor-pointer
                grid
                items-center
                justify-items-center
                hover:text-gray-200
                rounded-xl
                bg-gradient-to-r bg-base-100
                focus:from-rose-400
                via-fuchsia-500
                to-indigo-500
              "
              href="/completed"
            >
              <p>
              Completed  <span class="badge badge-md ml-2">{{ numbers.completed }}</span>
            </p>
            </button>
          </div>

          <label for="my-modal" class="
              hidden
              lg:flex
              btn btn-accent
              hover:btn-accent
              lg:justify-self-end
              mt-5
            ">
            Add a New Task
            <div class="text-md text-white ml-2">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="icon icon-tabler icon-tabler-circle-plus"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="#ffffff"
                fill="none"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <circle cx="12" cy="12" r="9" />
                <line x1="9" y1="12" x2="15" y2="12" />
                <line x1="12" y1="9" x2="12" y2="15" />
              </svg>
            </div>
            </label>
          <input type="checkbox" id="my-modal" v-model="checked" class="modal-toggle" />
          <div class="modal">
            <div class="modal-box">
              <add-item-form
                :categories="categories"
                v-on:reloadList="getList()"
              />
            </div>
          </div>
          <div
            class="
              lg:hidden
              absolute
              z-10
              w-full
              bg-neutral
              grid
              justify-items-center
              items-center
              bottom-0
              left-1/2
              transform
              -translate-x-1/2
            "
          >
            <label for="my-modal" class="btn btn-accent btn-md btn-circle mb-5">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="icon icon-tabler icon-tabler-circle-plus"
                width="34"
                height="34"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="#ffffff"
                fill="none"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <circle cx="12" cy="12" r="9" />
                <line x1="9" y1="12" x2="15" y2="12" />
                <line x1="12" y1="9" x2="12" y2="15" />
              </svg>
            </label>
            <input type="checkbox" id="my-modal" class="modal-toggle" />
          </div>
          <!-- <div id="my-modal" class="modal">
            <div class="modal-box">
              
            </div>
          </div> -->
        </div>
        <h1 class="p-5 text-xl font-bold">Tasks - {{ items.length }}</h1>
        <list-view :items="items" v-on:reloadList="getList()" />

        <!-- <div v-if="user">
            {{ user.name }}

            <button type="submit" @click.prevent="logout()">Logout</button>
          </div> -->
      </div>
      
    </div>
    <div
      class="
        uppercase
        text-xl
        min-h-screen
        grid
        items-center
        justify-items-center
      "
      v-if="this.existCategory == false"
    >
      Please add a Project first.
    </div>
  </div>
</template>

<script>
import axios from "axios";
import addItemForm from "./addItemForm.vue";
import listView from "./listView.vue";
import ListCategoryView from "./listCategoryView.vue";
import AddCategoryForm from "./addCategoryForm.vue";

export default {
  components: { addItemForm, listView, ListCategoryView, AddCategoryForm },
  data: function () {
    return {
      items: [],
      user: null,
      categories: [],
      numbers: [],
      plan: null,
      checked: false,
      noCategory: false
    };
  },
  props: ["search"],
  methods: {
    getNo() {
      axios.get("api/numbers")
      .then(response => {
        console.log("no", response.data);
        this.numbers = response.data;
      })
      .catch(error => {
        console.log(error);
      })
    },
    getShowNo() {
      axios.get("api/projects/numbers/" + this.plan)
      .then(response => {
        console.log("show no", response.data);
        this.numbers = response.data;
      })
      .catch(error => {
        console.log(error);
      })
    },
    getList() {
      if (this.plan) {
        axios
          .get("api/projects/" + this.plan)
          .then((response) => {
            this.items = response.data;
            this.getShowNo();
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        axios
          .get("api/items")
          .then((response) => {
            this.items = response.data;
            this.getNo();
          })
          .catch((error) => {
            console.log(error);
          });
      }
      this.checked = false;
    },
    getCategories() {
      axios
        .get("api/categories")
        .then((response) => {
          this.categories = response.data;
          console.log("res", this.categories);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    inProgress() {
      if (this.plan) {
        axios
          .get("api/projects/inprogress/" + this.plan)
          .then((response) => {
            this.items = response.data;
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        axios
          .get("api/inprogress")
          .then((response) => {
            this.items = response.data;
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    completed() {
      if (this.plan) {
        axios
          .get("api/projects/completed/" + this.plan)
          .then((response) => {
            this.items = response.data;
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        axios
          .get("api/completed")
          .then((response) => {
            this.items = response.data;
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
  },
  created() {
    this.$Progress.start()
    this.plan = this.search;
    console.log("plan", this.plan);
    this.getCategories();
    if(this.plan) {
      this.getShowNo();
    }
    else {
      this.getNo();
    }

    console.log("list", this.categories);
    console.log("category", this.noCategory);
    
    this.getList();
  },
  
  computed: {
    existCategory() {
      if (this.categories.length === 0) {
        return false;
      } else {
        return true;
      }
    },
  },
  mounted() {
    axios.get("/api/user").then((response) => {
      this.user = response.data;
    });
    this.$Progress.finish()
  },
};
</script>