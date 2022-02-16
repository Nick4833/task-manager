require("./bootstrap");

import Vue from "vue";
import VueRouter from "vue-router";
import App from "./vue/home";
import Home from "./vue/app";
import About from "./vue/about";
import Login from "./vue/login";
import Register from "./vue/register";
import Meeting from "./vue/meeting";
import Project from "./vue/project";
import VueProgressBar from "vue-progressbar";

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            name: "home",
            component: Home,
            beforeEnter: (to, from, next) => {
                axios
                    .get("/api/authenticated")
                    .then(() => {
                        next();
                    })
                    .catch(() => {
                        return next({ name: "login" });
                    });
            },
        },
        {
            path: "/about",
            name: "about",
            component: About,
        },
        {
            path: "/login",
            name: "login",
            component: Login,
            beforeEnter: (to, from, next) => {
                axios
                    .get("/api/authenticated")
                    .then(() => {
                        console.log("ho");
                        next({ name: "home" });
                    })
                    .catch(() => {
                        return next();
                    });
            },
        },
        {
            path: "/register",
            name: "register",
            component: Register,
            beforeEnter: (to, from, next) => {
                axios
                    .get("/api/authenticated")
                    .then(() => {
                        console.log("ho");
                        next({ name: "home" });
                    })
                    .catch(() => {
                        return next();
                    });
            },
        },
        {
            path: "/meeting",
            name: "meeting",
            component: Meeting,
            beforeEnter: (to, from, next) => {
                axios
                    .get("/api/authenticated")
                    .then(() => {
                        next();
                    })
                    .catch(() => {
                        return next({ name: "login" });
                    });
            },
        },
        {
            path: "/project",
            name: "project",
            component: Project,
            beforeEnter: (to, from, next) => {
                axios
                    .get("/api/authenticated")
                    .then(() => {
                        next();
                    })
                    .catch(() => {
                        return next({ name: "login" });
                    });
            },
        },
    ],
});

Vue.use(VueRouter);
Vue.prototype.$logged = false;

const options = {
    color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '50px'
  }
  
  Vue.use(VueProgressBar, options)

const app = new Vue({
    el: "#app",
    components: { App },
    router,
});
