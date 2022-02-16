<template>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-5 p-5 w-full min-h-full">
    <div v-for="item in items" :key="item.id" class="m-0 p-0">
      <list-item :item="item" v-on:itemChanged="$emit('reloadList')" />
    </div>
    
  </div>
</template>
<script>
import listItem from "./listItem.vue";
export default {
  components: { listItem },
  props: ["items"],
};
</script>