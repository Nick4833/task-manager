<template>
  <div>
    <div v-for="category in categories" :key="category.id">
      <li class="mt-5">
        <router-link :to="{ name: 'home' }" class="grid grid-cols-2 gap-2">
          <list-category
            :category="category"
            v-on:categoryChanged="$emit('reloadCategories')"
          />
        </router-link>
      </li>
    </div>
  </div>
</template>

<script>
import listCategory from "./listCategory.vue";
export default {
  components: { listCategory },
  props: ["categories"],
};
</script>