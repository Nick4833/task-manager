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
    v-if="hide === false"
  >
    <img src="/img/team.svg" class="w-full h-full bg-primary" />
    <form class="flex flex-col gap-5 px-3 w-full max-w-lg rounded-xl mt-5">
      <span>
        <h1 class="text-3xl font-bold">Welcome Back!</h1>
        <small class="text-sm">Sign into your account.</small>
      </span>

      <div class="form-control">
        <input
          type="email"
          placeholder="Email"
          v-model="form.email"
          class="input input-neutral-focus input-bordered"
        />
        <label class="label" v-if="error.email">
          <span class="label-text-alt">{{ error.email[0] }}</span>
        </label>
      </div>
      <div class="form-control">
        <input
          type="password"
          placeholder="Password"
          v-model="form.password"
          class="input input-neutral-focus input-bordered"
        />
        <!-- <label class="label" v-if="error.password[0]">
          <span class="label-text-alt">{{ error.password[0] }}</span>
        </label> -->
      </div>
      <button type="submit" @click.prevent="login()" class="btn btn-primary">
        Login
      </button>
      <router-link
        :to="{ name: 'register' }"
        class="self-end hover:text-primary"
        >Don't have an account? Register Now</router-link
      >
    </form>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      form: {
        email: "",
        password: "",
      },
      error:[],
      hide: false
    };
  },
  methods: {
    login() {
      axios
        .post("/api/login", this.form)
        .then((respose) => {
          this.hide = true;
          this.$logged = true;
          console.log("logging", this.$logged);
          this.$router.push({ name: "home" });
          this.$emit("refresh");
        })
        .catch((error) => {
          this.error = error.response.data.errors;
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