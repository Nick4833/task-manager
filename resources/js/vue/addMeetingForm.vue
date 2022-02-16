<template>
  <div class="grid p-5 gap-5">
    <div class="grid grid-cols-2 gap-5">
      <div class="form-control">
        <label class="label"> </label>
        <input
          type="text"
          v-model="meeting.title"
          placeholder="Meeting Title"
          class="input input-primary input-bordered"
        />
        <label class="label" v-if="error.title">
          <span class="label-text-alt">{{error.title[0]}}</span>
        </label>
      </div>
      <div class="form-control">
        <label class="label"> </label>
        <input
          type="datetime-local"
          v-model="meeting.meeting_time"
          placeholder="Meeting Time"
          class="input input-primary input-bordered"
        />
        <label class="label" v-if="error.meeting_time">
          <span class="label-text-alt">{{error.meeting_time[0]}}</span>
        </label>
      </div>
      <div class="form-control col-span-2">
        <label class="label"> </label>
        <input
          type="text"
          v-model="meeting.desc"
          placeholder="Meeting Description"
          class="input input-primary input-bordered"
        />
        <label class="label" v-if="error.desc">
          <span class="label-text-alt">{{error.desc[0]}}</span>
        </label>
      </div>
    </div>
    <button @click="addMeeting()" class="btn btn-outline btn-accent">
      Add
    </button>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data: function () {
    return {
      meeting: {
        title: "",
        meeting_time: "",
        desc: "",
      },
      error: [],
    };
  },
  methods: {
    addMeeting() {
      this.$Progress.start()
      axios
        .post("/api/meeting/store", {
          title: this.meeting.title,
          meeting_time: this.meeting.meeting_time,
          desc: this.meeting.desc,
        })
        .then((response) => {
          if (response.status === 200) {
            this.meeting.title = "";
            this.meeting.meeting_time = "";
            this.meeting.desc = "";
            this.$emit("meetingChanged");
          }
        })
        .catch((error) => {
          this.error = error.response.data.errors;
        });
        this.$Progress.finish()
    },
  },
};
</script>