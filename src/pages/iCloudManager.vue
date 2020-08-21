<template>
   <div class="main">
      <form class="my-2 was-validated" @submit.prevent="update($event.target)">
         <label> Các tài khoản </label>
         <table is="transition-group" name="slide" tag="table" class="table-responsive">
            <tr v-for="(item, index) in accounts" :key="item.key">
               <td> <input class="no-input form-control" v-model="item.username" name="username[]" required placeholder="Username"> </td>
               <td> <input class="no-input form-control" v-model="item.password" name="password[]" required placeholder="Password"> </td>
               <td class="icon" @click="item.show = item.show ? 0 : 1">
                  <i :class="[
                     'fas',
                     item.show == 1 ? 'fa-eye' : 'fa-eye-slash'
                  ]"></i>
               </td>
               <td class="icon" @click="remove(index)">
                  <i class="fad fa-trash"></i>
               </td>
            </tr>
         </table>
         <div v-if="accounts.length == 0" class="text-center text-secondary py-3">
            Không có tài khoản nào
         </div>
      </form>
      <vue-fab icon="toc" main-btn-color="#999" size="big" fab-item-animate="alive">
         <fab-item icon="save" color="#c7d23b" @clickItem="save" :idx="0" />
         <fab-item icon="add" @clickItem="addRow" :idx="1" />
      </vue-fab>
   </div>
</template>
<style lang="scss" scoped>
   .main {
      form {
         padding: {
            left: 15px;
            right: 15px;
         }


         table {
            margin: 0 auto;

            tr {
               border-top: 1px solid #ccc;
               background-color: #fff;

               th {
                  text-align: inherit;
                  border: 1px solid #ddd;
                  padding: 6px 13px;
               }

               td {
                  border: 1px solid #ddd;

                  &.icon {
                     padding: {
                        left: .5rem;
                        right: .5rem;
                     }
                  }
               }
            }
         }

         .slide-move {
            transition: all .4s;
         }

         .slide-enter,
         .slide-leave-to {
            opacity: 0;
            transform: translateX(30px);
         }

         .slide-leave-active {
            position: absolute;
         }

         .no-input {
            -webkit-appearance: none;
            display: inline-block;
            width: 100%;
            border: 0;
         }
      }
   }
</style>
<script>
   import axios from "axios"
   export default {
      data() {
         return {
            accounts: []
         }
      },
      methods: {
         addRow() {
            let newRow = {
               username: "",
               password: "",
               key: Date.now(),
               show: 1
            }
            this.accounts.push(newRow)
         },
         save() {
            let loading = this.$loading.show({
               width: 50,
               height: 50,
               container: null
            })
            
            let formData = new FormData
            
            formData.append("action", "put")
            formData.append("json", JSON.stringify(this.accounts.map(({ username, password, show }) => ({ username, password, show }))))

           this.$axios.post("/admin/api/icloud.php", formData)
               .then(res => { if ( typeof res.data == "object" ) return res.data; try { return JSON.parse(res.data) } catch(e) { return { error: 1, mess: res.data } } })
               .then(json => {
                  
                  if (json.error == 1) {
                     throw new Error(json.mess)
                  } else {
                     this.$AppSuccess("Success", "Update success.")
                  }
               })
               .catch(e => {
                  
                  this.$AppError(e.message, e.stack)
               })
               .finally(() => loading.hide())
         },
         remove(index) {

            this.accounts.splice(index, 1)
         }
      },
      created() {
         let loading = this.$loading.show({
            width: 50,
            height: 50,
            container: null
         })
        this.$axios.get("/admin/api/icloud.php")
            .then(res => { if ( typeof res.data == "object" ) return res.data; try { return JSON.parse(res.data) } catch(e) { return { error: 1, mess: res.data } } })
            .then(json => {
               
               if (Array.isArray(json)) {
                  json.map(e => {
                     if (!("key" in e)) {
                        e.key = Date.now() + Math.random()
                     }
                  })
               }
               if (json.error == 1) {
                  if (json["auth-error"]) {
                     this.$router.push("/login?url=" + this.$route.path)
                  }
                  throw new Error(json.mess)
               }

               this.accounts = json
            })
            .catch(e => {
               setTimeout(() => {
                  this.$notify({
                     group: "App",
                     width: "100%",
                     position: "top left",
                     title: e.message,
                     message: e.stack,
                     type: "error"
                  })
               })
            })
            .finally(() => loading.hide())
      },
      mounted() {
         this.$emit("hook:mounted")
      }
   }
</script>