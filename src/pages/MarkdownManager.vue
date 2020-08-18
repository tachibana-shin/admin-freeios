<template>
   <div class="main">
      <div class="form-group">
         <label> <i class="fad fa-edit"></i> Chế độ chỉnh sửa cho <strong> {{ $route.meta.title($route) }} </strong> </label>
         <textarea v-model="md"></textarea>
      </div>
      <vue-fab size="big" icon="save" @click.native="Save" />
   </div>
</template>
<style lang="scss" scoped>
   .main {
      .form-group {
         padding: {
            left: 15px;
            right: 15px;
         }

         ;
      }
   }
</style>
<script>
   import EasyMDE from "easymde"
   import EasyConfig from "./EasyConfig.js"
   import axios from "axios"

   export default {
      data() {
         return {
            MDE: null,
            md: ""
         }
      },
      watch: {
         md(newVal) {
            if ( this.MDE ) {
               this.MDE.value(newVal)
            }
         },
         "$route"() {
            this.fetchData()
         }
      },
      methods: {
         Save() {
            let loading = this.$loading.show({
               width: 50,
               height: 50,
               container: null
            })
            
            let formData = new FormData
            formData.append("path", this.$route.params.pathMatch)
            formData.append("md", this.MDE.value())
            

            axios.post("http://localhost:8080/admin/api/markdown.php", formData)
               .then(res => res.data)
               .then(json => {
                  console.log(json)
                  if (json.error == 0) {
                     throw new Error(json.mess)
                  } else {
                     this.$AppSuccess("Success", "Update success")
                  }
               })
               .catch(e => {
                  console.log(e)
                  this.$AppError(e.message, e.stack)
               })
               .finally(() => loading.hide())
         },
         fetchData() {
         
            
            let loading = this.$loading.show({
               width: 50,
               height: 50,
               container: null
            })
            
            axios.get("http://localhost:8080/admin/api/markdown.php", {
                  params: {
                     path: this.$route.params.pathMatch
                  }
               })
               .then(res => res.data)
               .then(json => {
                  if (json.error == 1) {
                     if ( json["auth-error"] == true ) {
                        this.$router.push(""/login?url=" + this.$route.path")
                     } else {
                        this.$router.replace("/404")
                     }
                     throw new Error(json.mess)
                  } else {
                     this.md = json.md
                  }
               })
               .catch(e => {
                  setTimeout(() => {
                     this.$AppError(e.message, e.stack)
                  })
               })
               .finally(() => loading.hide())
         }
      },
      created() {
         this.fetchData()
      },
      mounted() {
         this.MDE = new EasyMDE(EasyConfig)
      }
   }
</script>