import Vue from 'vue';
import Router from 'vue-router';
import MintUI from 'mint-ui';
import 'mint-ui/lib/style.css';
import App from './App.vue';
import Todo from './components/Todo.vue';

Vue.use(Router);
Vue.use(MintUI);

const routes = new Router({
    routes: [
        {
            name: 'todo',
            path: '/',
            component: Todo
        }
    ]
});

new Vue({
    el: '#app',
    router: routes,
    render: app => app(App)
});

