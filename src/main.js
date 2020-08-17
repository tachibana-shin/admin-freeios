import Vue from "vue"
import App from "./App.vue"
import BootstrapVue from "bootstrap-vue"
import router from "./router/index.js"
import VueFab from "vue-float-action-button"
import VueLoadingOverlay from "vue-loading-overlay"
import VueProgressBar from "vue-progressbar"
import VueNotification from "vue-notification"

Vue.use(BootstrapVue)
Vue.use(VueSweetAlert2)
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