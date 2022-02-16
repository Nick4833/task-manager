<template>
  <div class="grid grid-cols-1 gap-5">
    <h1 class="text-xl font-bold">Add a Task</h1>
    <div class="form-control">
      <input
        type="text"
        v-model="item.name"
        placeholder="Task Name"
        class="input input-primary input-bordered"
      />
      <label class="label" v-if="error.name">
        <span class="label-text-alt">{{ error.name[0] }}</span>
      </label>
    </div>
  <div class="form-control">
    <select
      v-model="selectedCategory"
      class="select select-bordered select-primary w-full max-w-xs"
    >
      <option
        v-for="category in categories"
        :key="category.id"
        :value="category.id"
      >
        {{ category.name }}
      </option>
    </select>
    <label class="label" v-if="error.category_id">
      <span class="label-text-alt">{{ error.category_id[0] }}</span>
    </label>
  </div>
    <div class="form-control">
      <input
        type="datetime-local"
        v-model="item.deadline"
        class="input input-primary input-bordered"
      />
      
    <label class="label" v-if="error.deadline">
      <span class="label-text-alt">{{ error.deadline[0] }}</span>
    </label>
    </div>
    <div>
      <button @click="addItem()" class="btn btn-primary">Add a Task</button>

      <button @click="close()" class="btn btn-neutral">Close</button>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  props: ["categories"],
  data: function () {
    return {
      item: {
        name: "",
        deadline: "",
      },
      error: [],
      selectedCategory: "",
    };
  },
  methods: {
    addItem() {
      this.$Progress.start()
      axios
        .post("api/item/store", {
          name: this.item.name,
          category_id: this.selectedCategory,
          deadline: this.item.deadline,
        })
        .then((response) => {
          if (response.status === 201) {
            this.item.name = "";
            this.$emit("reloadList");
            this.$Progress.finish()
          }
        })
        .catch((error) => {
          console.log(error);
          this.error = error.response.data.errors;
        });
    },
    close() {
      this.$emit("reloadList");
      this.$Progress.finish()
    },
  },
};
</script>