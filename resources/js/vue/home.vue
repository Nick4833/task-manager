<template>
  <div class="min-h-screen w-screen">
    <!-- <div class="grid grid-cols-3 w-1/6 bg-primary">
          <div class="bg-neutral text-xl">test</div>
          <div>test</div>
          <div>test</div>
        </div> -->
      <vue-progress-bar></vue-progress-bar>
    <div class="shadow bg-base-200 drawer drawer-mobile min-h-screen">
      <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
      <div class="flex flex-col drawer-content">
        <div class="grid grid-cols-2 p-5" v-if="user">
          <p class="text-2xl font-bold">Task Manager</p>
          <label
            for="my-drawer-2"
            class="
              mb-4
              btn btn-neutral btn-circle btn-md
              drawer-button
              lg:hidden
              justify-self-end
            "
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="icon icon-tabler icon-tabler-menu-2"
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
              <line x1="4" y1="6" x2="20" y2="6" />
              <line x1="4" y1="12" x2="20" y2="12" />
              <line x1="4" y1="18" x2="20" y2="18" />
            </svg>
          </label>
        </div>
        <div>
          <router-view
            v-on:refresh="test()"
            :key="$route.fullPath"
            v-on:notLogin="notlogged()"
          ></router-view>
          
        </div>
      </div>
      <div class="drawer-side" v-if="user">
        <label for="my-drawer-2" class="drawer-overlay"></label>
        <ul class="menu p-4 overflow-y-auto w-60 bg-base-100 text-base-content">
          <!-- <img src="img/bg.svg" class="w-full mt-5" /> -->
          <p class="tex-2xl font-bold mt-5">To Don'ts</p>
          <li class="mt-5">
            <router-link
              :to="{ name: 'home' }"
              class="flex flex-wrap flex-row gap-2"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="icon icon-tabler icon-tabler-home-2"
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
                <polyline points="5 12 3 12 12 3 21 12 19 12" />
                <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                <rect x="10" y="12" width="4" height="4" />
              </svg>
              Dashboard
            </router-link>
          </li>
          <li class="mt-5">
            <router-link
              :to="{ name: 'meeting' }"
              class="flex flex-wrap flex-row gap-2"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="icon icon-tabler icon-tabler-message-circle-2"
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
                <path d="M3 20l1.3 -3.9a9 8 0 1 1 3.4 2.9l-4.7 1" />
                <line x1="12" y1="12" x2="12" y2="12.01" />
                <line x1="8" y1="12" x2="8" y2="12.01" />
                <line x1="16" y1="12" x2="16" y2="12.01" />
              </svg>
              Meetings
            </router-link>
          </li>
          <li class="mt-5 ">
            <button @click="logout()" class="flex flex-wrap flex-row gap-2 rounded-xl">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="icon icon-tabler icon-tabler-user"
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
                <circle cx="12" cy="7" r="4" />
                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
              </svg>
              Logout
            </button>
          </li>
          <p class="tex-xl font-bold mt-5 mb-2">Projects</p>
          <div
            class="
              overflow-auto
              mb-5
              scrollbar-thin scrollbar-thumb-base-100 scrollbar-track-gray-100
            "
            style="height: 50vh"
          >
            <list-category-view :categories="categories" v-on:reloadCategories="getCategories()" />
          </div>
          <a href="#project-modal" class="btn btn-primary">Add a Project</a>
          <div id="project-modal" class="modal fixed left-50">
            <div class="modal-box">
              <add-category-form v-on:reloadCategories="getCategories()" />
            </div>
          </div>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import AddCategoryForm from "./addCategoryForm.vue";
import listCategoryView from "./listCategoryView.vue";
export default {
  components: { listCategoryView, AddCategoryForm },
  data() {
    return {
      user: false,
      categories: [],
    };
  },
  mounted() {
    this.$on("refresh", this.eventHandler);
  },

  methods: {
    test() {
      this.user = true;
    },
    notlogged() {
      this.user = false;
    },
    getCategories() {
      axios
        .get("api/categories")
        .then((response) => {
          this.categories = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    logout() {
      axios
        .post("/api/logout")
        .then(() => {
          this.$router.push({ name: "login" });
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  created() {
    axios
      .get("/api/authenticated")
      .then((response) => {
        this.user = response.data;
        console.log(this.user);
      })
      .catch((error) => {
        this.user = false;
        console.log(this.user);
      });
    this.getCategories();
  },
};
</script>