import Vue from "vue"
import Vuex from "vuex"
import axios from "axios"

Vue.use(Vuex)
Vuex.Store.prototype.$axios = axios

export default new Vuex.Store({
   state: {
      account: null
   },
   mutations: {
      updateAccount(state, payload) {
         state.account = payload
      },
      emptyAccount(state) {
         state.account = null
      }
   },
   actions: {
      currentUser({ commit }) {
         return this.$axios.post("/admin/api/check-login.php")
            .then(res => { if (typeof res.data == "object") return res.data; try { return JSON.parse(res.data) } catch (e) { return { error: 1, mess: res.data } } })
            .then(json => {
               if (json.logined == true) {
                  commit("updateAccount", json.data)
               }
               return json
            })
            .catch(({ stack }) => {
               return {
                  logined: false,
                  error: 1,
                  mess: stack
               }
            })
      }
   }
})