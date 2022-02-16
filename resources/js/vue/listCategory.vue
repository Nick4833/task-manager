<template>
  <div class="grid grid-cols-2 w-full items-center">
    <router-link
      :to="{ name: 'project', query: { plan: this.category.id } }"
      class="flex flex-wrap flex-row items-center"
    >
      <span class="ml-2">{{ category.name }}</span>
    </router-link>
    <button @click="removeCategory()" class="btn btn-ghost btn-sm justify-self-end">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="icon icon-tabler icon-tabler-trash"
        width="14"
        height="14"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="#ffffff"
        fill="none"
        stroke-linecap="round"
        stroke-linejoin="round"
      >
        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
        <line x1="4" y1="7" x2="20" y2="7" />
        <line x1="10" y1="11" x2="10" y2="17" />
        <line x1="14" y1="11" x2="14" y2="17" />
        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
      </svg>
    </button>
  </div>
</template>

<script>
export default {
  props: ["category"],
  methods: {
    removeCategory() {
      this.$Progress.start()
      axios
        .delete("api/category/" + this.category.id)
        .then((response) => {
          if (response.status === 200) {
            this.$emit("categoryChanged");
            this.$Progress.finish()
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>