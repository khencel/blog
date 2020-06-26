require('./bootstrap');

window.token = document.getElementsByName("user-token")[0].content;
import VueRouter from 'vue-router'
import { Form, HasError} from 'vform'

let routes = [
    { path: '/home', component: require('./components/blog/index.vue').default },
    { path: '/create', component: require('./components/blog/create.vue').default },
    { path: '/edit/:id', component: require('./components/blog/create.vue').default },
    { path: '/deleted', component: require('./components/blog/deleted.vue').default },
];

const router = new VueRouter({
    routes,
    mode: 'history',
});


window.Vue = require('vue');
window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.use(VueRouter)

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app',
    router,
});
