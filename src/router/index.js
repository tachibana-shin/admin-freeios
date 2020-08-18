import Vue from "vue"
import VueRouter from "vue-router"
/*
import Editor from "../pages/Editor.vue"
import AppManager from "../pages/AppManager.vue"
import iCloud from "../pages/iCloudManager.vue"
import Error404 from "../pages/404.vue"
import MarkdownEditor from "../pages/MarkdownManager.vue"
import Login from "../pages/Login.vue"
*/
Vue.use(VueRouter)

const routes = [
   {
      path: "/",
      component: () => import("../pages/AppManager.vue")
   },
   {
      path: "/editor/:id",
      component: () =>  import("../pages/Editor.vue")
   },
   {
      path: "/upload",
      component: () => import("../pages/Editor.vue"),
      meta: {
         upload: true
      }
   },
   {
      path: "/icloud",
      component: () => import("../pages/iCloudManager.vue")
   },
   {
      path: "/md-(tutorial|rules|faqs)",
      component: () => import("../pages/MarkdownManager.vue"),
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
      component: () => import("../pages/Login.vue")
   },
   {
      path: "/myaccount",
      component: () => import("../pages/MyAccount.vue")
   },
   {
      path: "/logout",
      component: () => import("../pages/Logout.vue")
   },
   {
      path: "*",
      component: () => import("../pages/404.vue")
   },
   {
      path: "/404",
      component: () =>  import("../pages/404.vue")
   }
]

export default new VueRouter({
   mode: "history",
   base: "/admin/",
   scrollBehavior(to, from, saved) {
      return saved || { x: 0, y : 0 }
   },
   routes,
   linkActiveClass: "active"
})
