<template>
    <div>
        <app :search="this.$route.query.plan"/>
    </div>
</template>
<script>
import App from './app.vue';
export default {
    components: {App},
    created() {
        console.log(this.$route.query.plan);
    },
}
</script>