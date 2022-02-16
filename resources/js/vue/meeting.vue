<template>
    <div>
        <add-meeting-form v-on:meetingChanged="getMeetings()"/>
        <list-meeting-view :meetings="meetings" v-on:meetingChanged="getMeetings()"/>
    </div>
</template>

<script>
import axios from 'axios'
import listMeetingView from './listMeetingView.vue'
import AddMeetingForm from './addMeetingForm.vue'
export default {
  components: { listMeetingView, AddMeetingForm },
  data() {
      return {
          meetings: []
      }
  },
  methods: {
      getMeetings() {
          axios.get("/api/meetings")
          .then(response => {
              this.meetings = response.data;
          })
          .catch(error => {
              console.log(error);
          });
          this.$Progress.finish()
      }
  },
  created() {
      this.$Progress.start()
      this.getMeetings();
  }
    
}
</script>