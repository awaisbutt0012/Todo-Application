require("./bootstrap");
import Vue from "vue";
import Notifications from "vue-notification";
window.Vue = require("vue").default;
Vue.use(Notifications);
console.log("window vue is:",Notifications);
Vue.component("list", require("./components/TodoList.vue").default);

const app = new Vue({
    el: "#app",
});
