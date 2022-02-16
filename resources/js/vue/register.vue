<template>
  <div
    class="
      grid grid-cols-1
      gap-3
      md:grid-cols-2
      flex-row
      justify-items-center
      items-center
      min-w-screen min-h-screen
    "
  >
    <img src="/img/team_r.svg" class="w-full h-full bg-primary" />
    <form class="flex flex-col gap-5 px-5 w-full max-w-lg rounded-xl mt-5">
      <span>
        <h1 class="text-3xl font-bold">Are you new here?</h1>
        <small class="text-sm">Create a new account.</small>
      </span>

      <div class="form-control">
        <input
          type="text"
          placeholder="Name"
          v-model="form.name"
          class="input input-neutral-focus input-bordered"
        />
        <label class="label" v-if="errors.name">
          <span class="label-text-alt">{{ errors.name[0]}}</span>
        </label>
      </div>
      <div class="form-control">
        <input
          type="email"
          placeholder="Email"
          v-model="form.email"
          class="input input-neutral-focus input-bordered"
        />
        <label class="label" v-if="errors.email">
          <span class="label-text-alt">{{ errors.email[0]}}</span>
        </label>
      </div>
      <div class="form-control">
        <input
          type="password"
          placeholder="Password"
          v-model="form.password"
          class="input input-neutral-focus input-bordered"
        />
        <label class="label" v-if="errors.password">
          <span class="label-text-alt">{{ errors.password[0]}}</span>
        </label>
      </div>
      <div class="form-control">
        <input
          type="password"
          placeholder="Retype Password"
          v-model="form.password_confirmation"
          class="input input-neutral-focus input-bordered"
        />
      </div>
      <button type="submit" @click.prevent="register()" class="btn btn-primary">
        Register
      </button>
      <router-link
        :to="{ name: 'login' }"
        class="self-end hover:text-primary"
        >Already have an account? Sign in here!</router-link
      >
    </form>
  </div>
  <!-- <div>
    <form>
      <input />
      <input />
      <input  />
      <input
        
      />
      <button >Register</button>
    </form>
  </div> -->
</template>

<script>
import axios from "axios";
export default {
  data: function () {
    return {
      form: {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
      errors: [],
    };
  },

  methods: {
    register() {
      axios
        .post("/api/register", this.form)
        .then((response) => {
          this.$router.push({ name: "login" });
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
          console.log(this.errors);
        });
    },
  },
  created() {
    this.$Progress.start()
    this.$emit('notLogin');
  },
  mounted () {
    this.$Progress.finish()
  },
};
</script>