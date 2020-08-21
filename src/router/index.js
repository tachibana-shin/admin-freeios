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
      component: () => import("../pages/AppManager.vue"),
      meta: {
         title: "Admin App Manager - FreeiOS"
      }
   },
   {
      path: "/editor/:id",
      component: () =>  import("../pages/Editor.vue"),
      meta: {
         title: "Upgrade App - FreeiOS"
      }
   },
   {
      path: "/upload",
      component: () => import("../pages/Editor.vue"),
      meta: {
         upload: true,
         title: "Update App - FreeiOS"
      }
   },
   {
      path: "/icloud",
      component: () => import("../pages/iCloudManager.vue"),
      meta: {
         title: "iCloud Manager - FreeiOS"
      }
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
         },
         _title: $route => $route.meta.title($route) + " - FreeiOS"
      }
   },
   {
      path: "/login",
      component: () => import("../pages/Login.vue"),
      meta: {
         title: "Login Admin - FreeiOS"
      }
   },
   {
      path: "/myaccount",
      component: () => import("../pages/MyAccount.vue"),
      meta: {
         title: "My Account Admin - FreeiOS"
      }
   },
   {
      path: "/logout",
      component: () => import("../pages/Logout.vue"),
      meta: {
         title: "Logout - FreeiOS"
      }
   },
   {
      path: "*",
      component: () => import("../pages/404.vue"),
      meta: {
         title: "404 Not Found - FreeiOS"
      }
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
