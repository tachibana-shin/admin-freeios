import Vue from "vue"
import VueRouter from "vue-router"

import Editor from "../pages/Editor.vue"
import AppManager from "../pages/AppManager.vue"
import iCloud from "../pages/iCloudManager.vue"
import Error404 from "../pages/404.vue"
import MarkdownEditor from "../pages/MarkdownManager.vue"
import Login from "../pages/Login.vue"

Vue.use(VueRouter)

const routes = [
   {
      path: "/",
      component: AppManager
   },
   {
      path: "/editor/:id",
      component: Editor
   },
   {
      path: "/upload",
      component: Editor,
      meta: {
         upload: true
      }
   },
   {
      path: "/icloud",
      component: iCloud
   },
   {
      path: "/md-(tutorial|rules|faqs)",
      component: MarkdownEditor,
      meta: {
         title($route) {
            return {
               "tutorial": "Hướng dẫn",
               "rules": "Nội quy",
               "faqs": "FAQs"
            }[$route.params.pathMatch]
         }
      }
   },
   {
      path: "/login",
      component: Login
   },
   {
      path: "*",
      component: Error404
   },
   {
      path: "/404",
      component: Error404
   }
]

export default new VueRouter({
   mode: "history",
   scrollBehavior(to, from, saved) {
      return saved || { x: 0, y : 0 }
   },
   routes,
   linkActiveClass: "active"
})