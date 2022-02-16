import App from "./vue/app";
import About from "./vue/about";


export default {
    mode: 'history',

    routes: [
        {
            path: '/',
            component: App,
        },
        {
            path: '/about',
            component: About,
        },
    ]
}