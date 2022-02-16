<template>
  <div class="card shadow-lg">
    <div class="grid grid-cols-1 card-body gap-1">
      <div class="form-control">
        <label class="cursor-pointer label">
          <span class="label-text text-lg font-bold">{{ item.name }}</span>
        </label>
      </div>
      <span class="text-sm text-accent flex flex-wrap flex-row gap-1">
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
        {{ deadline }}
      </span>
      <div class="badge badge-primary mt-2">{{ item.category.name }}</div>
      <div class="grid grid-cols-2 justify-items-between mt-5">
        <button
          class="
            btn
            border-accent
            btn-md
            justify-self-stretch
            flex flex-wrap flex-row
          "
          @click="updateCheck(item.in_progress)"
          v-if="item.completed != true && item.in_progress != true"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="icon icon-tabler icon-tabler-eye-check"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="#ffffff"
            fill="none"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <circle cx="12" cy="12" r="2" />
            <path
              d="M12 19c-4 0 -7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7c-.42 .736 -.858 1.414 -1.311 2.033"
            />
            <path d="M15 19l2 2l4 -4" />
          </svg>
          <p class="text-xs upper-case ml-2">Progress</p>
        </button>
        <button
          class="
            btn
            border-secondary
            btn-md
            justify-self-stretch
            flex flex-wrap flex-row
          "
          @click="updateCheck(item.in_progress)"
          v-if="item.in_progress == true && item.completed == false"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="icon icon-tabler icon-tabler-circle-check"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="#ffffff"
            fill="none"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <circle cx="12" cy="12" r="9" />
            <path d="M9 12l2 2l4 -4" />
          </svg>
          <p class="text-xs upper-case ml-2">Complete</p>
        </button>
        <div v-if="item.in_progress == true && item.completed == true" class="btn btn-md bg-base-100 justify-self-stretch
            flex flex-wrap flex-row">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="icon icon-tabler icon-tabler-checks"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="#ffffff"
            fill="none"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M7 12l5 5l10 -10" />
            <path d="M2 12l5 5m5 -5l5 -5" />
          </svg>
          <span class="ml-2 text-xs">Completed</span>
        </div>
        <button
          class="
            btn btn-circle btn-sm
            bg-red-500
            hover:bg-red-600
            justify-self-end
            self-end
          "
          @click="removeItem()"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="icon icon-tabler icon-tabler-trash"
            width="20"
            height="20"
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
    </div>
  </div>
</template>
<script>
import axios from "axios";
import moment from "moment";
export default {
  props: ["item"],
  data() {
    return {
      deadline: "",
    };
  },
  methods: {
    updateCheck(progress) {
      this.$Progress.start()
      if (progress) {
        axios
          .put("api/item/" + this.item.id, {
            completed: true,
          })
          .then((response) => {
            if (response.status === 200) {
              this.$emit("itemChanged");
            }
          })
          .catch((error) => {
            console.log(error);
          });
          this.$Progress.finish()
      } else {
        this.$Progress.start()
        axios
          .put("api/item/" + this.item.id, {
            in_progress: true,
          })
          .then((response) => {
            if (response.status === 200) {
              this.$emit("itemChanged");
            }
          })
          .catch((error) => {
            console.log(error);
          });
          this.$Progress.finish()
      }
    },
    removeItem() {
      this.$Progress.start()
      axios
        .delete("api/item/" + this.item.id)
        .then((response) => {
          if (response.status === 200) {
            this.$emit("itemChanged");
            this.$Progress.finish()
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  created() {
    this.deadline = moment(this.item.deadline).format("dddd, MMM Do, h:mm a");
  },
};
</script>