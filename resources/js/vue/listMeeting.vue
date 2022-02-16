<template>
<div class="grid grid-cols-1 shadow-lg m-5">
    <div class="grid grid-cols-1 col-span-3 p-5 gap-3">
        <p class="text-xl font-bold">{{meeting.title}}</p>
        <p>{{ meeting.desc }}</p>
        <p class="flex flex-wrap items-center text-md text-accent gap-2">
            <svg
          xmlns="http://www.w3.org/2000/svg"
          class="icon icon-tabler icon-tabler-calendar-event"
          width="14"
          height="14"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="#37cdbe"
          fill="none"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
          <rect x="4" y="5" width="16" height="16" rx="2" />
          <line x1="16" y1="3" x2="16" y2="7" />
          <line x1="8" y1="3" x2="8" y2="7" />
          <line x1="4" y1="11" x2="20" y2="11" />
          <rect x="8" y="15" width="2" height="2" />
        </svg>
            {{meeting_time}}</p>
    </div>
    <button class="justify-self-end self-center m-5 btn btn-circle btn-base-100" @click="deleteMeeting()">
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="icon icon-tabler icon-tabler-trash"
            width="25"
            height="25"
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
import moment from "moment"
import axios from 'axios'
export default {
    props: ['meeting'],
    data() {
        return {
            meeting_time: ''
        }
    },
    methods: {
        deleteMeeting() {
            this.$Progress.start()
            axios.delete("/api/meeting/" + this.meeting.id)
            .then(response => {
                console.log('deleted');
                this.$emit("meetingChanged");
                this.$Progress.finish()
            })
            .catch(error => {
                console.log(error);
            })
        }
    },
    created() {
        this.meeting_time = moment(this.meeting.meeting_time).format("dddd, MMM Do, h:mm a");
    }
    
}
</script>