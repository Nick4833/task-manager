<template>
  <div>
    <div class="form-control">
      <label class="label">
        <span class="label-text">Primary</span>
      </label>
      <input
        type="text"
        placeholder="username"
        class="input input-primary input-bordered"
      />
    </div>

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
    <div class="form-control">
      <input
        type="datetime-local"
        v-model="item.deadline"
        placeholder="username"
        class="input input-primary input-bordered bg-black"
      />
    </div>
    <button
      @click="addItem()"
      :class="[item.name ? 'active' : 'inactive', 'plus']"
    >
      Add a Task
    </button>
    {{ error.msg }}
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
      error: {
        msg: "",
      },
      selectedCategory: "",
    };
  },
  methods: {
    addItem() {
      if (this.item.name == "") {
        console.log(this.selectedCategory);
        this.error.msg = "The text field is empty.";
        return;
      }
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
          }
        })
        .catch((error) => {
          this.error.msg = error.response.data.errors.name[0];
        });
    },
  },
};
</script>

<style scoped>
.addItem {
  display: flex;
  justify-content: center;
  align-items: center;
}
input {
  background-color: #f7f7f7;
  border: none;
  outline: none;
  padding: 1em;
  margin-right: 10px;
  width: 100%;
}
.plus {
  font-size: 20px;
}
.active {
  color: aquamarine;
}
.inactive {
  color: #999999;
}
</style>