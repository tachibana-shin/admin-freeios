import Vue from "vue"
import App from "./App.vue"
import BootstrapVue from "bootstrap-vue"
import router from "./router/index.js"
import VueFab from "vue-float-action-button"
import VueLoadingOverlay from "vue-loading-overlay"
import VueProgressBar from "vue-progressbar"
import VueNotification from "vue-notification"
import Eruda from "eruda"

Eruda.init()

Vue.use(BootstrapVue)
Vue.use(VueFab)
Vue.use(VueLoadingOverlay)
Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: "#f00",
  height: '3px'
})
Vue.use(VueNotification)

new Vue({
   el: "#app",
   router,
   template: "<App/>",
   components: { App }
})
