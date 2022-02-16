<template>
  <div class="grid grid-cols-1 gap-2">
    <div class="form-control">
      <input
        type="text"
        v-model="category.name"
        placeholder="Project Name"
        class="input input-primary input-bordered"
      />
    <label class="label" v-if="error.name">
      <span class="label-text-alt">{{ error.name[0] }}</span>
    </label>
    </div>
    <button @click="addCategory()" class="btn btn-primary">Add</button>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data: function () {
    return {
      category: {
        name: "",
      },
      error: [],
    };
  },
  methods: {
    addCategory() {
      this.$Progress.start()
      axios
        .post("api/category/store", {
          name: this.category.name,
        })
        .then((response) => {
          if (response.status === 201) {
            this.category.name = "";
            this.$emit("reloadCategories");
            this.$router.go(-1);
            this.$Progress.finish()
          }
        })
        .catch((error) => {
          this.error = error.response.data.errors;
        });
    },
  },
};
</script>