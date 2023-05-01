require('./bootstrap');



Vue.component('login-component', require('./components/logincomponent.vue').default);
Vue.component('todoheader-component', require('./components/todoheadercomponent.vue').default);

const login = new Vue({
    el: '#login',
});
const todoheader = new Vue({
    el: '#todoheader',
});
