<template>
  <div>
    <div v-for="meeting in meetings" :key="meeting.id">
        <list-meeting :meeting="meeting" v-on:meetingChanged="$emit('meetingChanged')"/>
    </div>
  </div>
</template>

<script>
import ListMeeting from './listMeeting.vue';
export default {
  components: { ListMeeting },
  props: ["meetings"],
  created()  {
    console.log(this.$route.query.plan);
  }
};
</script>