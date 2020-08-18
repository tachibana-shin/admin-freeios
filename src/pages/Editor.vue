<template>
   <div class="main">
      <form ref="FormData" :class="{
            'was-validated': WasValidate
         }">
         <div class="basic item">
            <div class="left">
               <input hidden type="file" @change="updateIcon" ref="File" name="icon" :required="$route.meta.upload">
               <img class="avatar inspiration" :src="app.images" @click="$refs.File.click()">
            </div>
            <div class="right">
               <input class="no-input app-name form-control" placeholder="App name" v-model="app.name" :disabled="disabledEditName" name="name" required>
               <input class="no-input app-developer form-control" placeholder="Developer" v-model="app.author" name="author" required>
            </div>
         </div>
         <div class="active item">
            <div class="form-group">
               <label> Tải khoản kích hoạt </label>
               <input class="form-control" placeholder="example@icloud.com" v-model="app.account" :disabled="app.category == 'ipa'" name="account" :required="app.category != 'ipa'">
               <small class="text-secondary"> Nếu đây là iPA bỏ trống trường này </small>
            </div>
            <div class="form-group">
               <label> Category </label>
               <select class="form-control form-select" v-model="app.category" name="category" required>
                  <option v-for="item in $options.optsCategory" :value="item.value"> {{ item.text }} </option>
               </select>
            </div>
         </div>
         <div class="advanced item">
            <div class="form-group">
               <label class="d-flex justify-content-between">
                  <span> Version </span>
                  <span @click="app.versions.push([])"> + </span>
               </label>
               <div class="content" :class="{
                     'is-invalid': !app.versions || !app.versions.length,
                     'is-valid': app.versions && app.versions.length
                  }">
                  <ul class="version-list">
                     <li>
                        <div class="input-group my-2" v-for="(item, index) in app.versions">
                           <input class="form-control" placeholder="Verions" v-model="item[0]" name="versions[]" required>
                           <input class="form-control" placeholder="URL" v-model="item[1]" name="urls[]" required>
                           <div class="input-group-append">
                              <span class="input-group-text bg-0" @click="app.versions.splice(index, 1)"> &times; </span>
                           </div>
                        </div>
                     </li>
                  </ul>
                  <div v-show="!app.versions || !app.versions.length">
                     <div class="text-center py-3 text-secondary border border-top-0" @click="app.versions.push([])">
                        Tap to +
                     </div>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <label> Support (ex: 10, 11, 12) </label>
               <input placeholder="Input iOS app support" class="form-control" :value="app.supports.join(', ')" @input="app.supports = $event.target.value.replace(/ /g, '').split(',')" name="supports" required>
            </div>
            <div class="form-group">
               <label> Description </label>
               <textarea class="form-control" id="description" v-model="app.description" ref="Textarea" name="description" required></textarea>
            </div>
         </div>
      </form>
      <vue-fab size="big" fab-item-animate="alive" :scroll-auto-hide="false" v-if="!$route.meta.upload" icon="toc" main-btn-color="#999">
         <fab-item icon="save" title="Save changes" :idx="0" color="#C7D23B" @clickItem="Save" />
         <fab-item icon="restore" title="Restore" :idx="1" color="#ff9900" @clickItem="Restore" />
         <fab-item icon="delete" title="Delete" :idx="2" color="#dc3545" @clickItem="Delete" />
      </vue-fab>
      <vue-fab size="big" icon="save" v-else @click.native="Save" />
   </div>
</template>
<style lang="scss" scoped>
   @import "https://unpkg.com/easymde/dist/easymde.min.css";

   .main {
      form {
         &>.item {
            padding: 1.5rem (10rem / 16);
            background-color: #fff;
            margin: 15px;
            box-shadow: 0 2px 2px rgba(0, 0, 0, .2);
            border: 1px solid #ced4da;
            border-radius: .25rem;

            .form-group {
               margin-top: 1rem;

               &:first-child {
                  margin-top: 0;
               }
            }
         }

         .basic {
            display: flex;
            margin: 0;

            .left {
               margin-right: 10px;

               .avatar {
                  width: 96px;
                  height: 96px;
                  border-radius: 10px;
                  border: 1px solid rgba(0, 0, 0, .1);
                  background-color: rgba(200, 200, 200, .5);
               }
            }

            .right {
               display: flex;

               flex: {
                  direction: column;
                  grow: 1;
                  basis: 0;
               }


               justify-content: space-around;

               .app-name {
                  font-size: (36rem / 16) !important;
                  padding: 0 !important;
                  margin: 0 !important;
                  padding-bottom: .5rem !important;
                  font-weight: 500 !important;

                  @media (max-width: 768px) {
                     font-size: (26rem / 16) !important;
                  }

                  width: 100% !important;
                  min-width: 0 !important;
               }

               .app-developer {
                  font-size: (24rem / 16) !important;
                  color: rgba(0, 0, 0, .8) !important;
                  padding: 0 !important;
                  margin: 0 !important;

                  @media (max-width: 768px) {
                     font-size: (18rem / 16) !important;
                  }

                  width: 100% !important;
                  min-width: 0 !important;
               }

               .no-input {
                  appearance: none;
                  -webkit-appearance: none;
                  border: none;
                  outline: none;
                  background-color: #00000000;
               }
            }
         }

         .advanced {
            .form-group {
               .content {
                  .version-list {
                     list-style: none;
                     margin: 0;
                     padding: 0;
                  }
               }
            }
         }


         &.was-validated {

            input,
            textarea {

               &:valid+.inspiration,
               &.no-input:valid {
                  border: 1px solid #28a745;
               }

               &:valid+.inspiration {
                  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
                  background-repeat: no-repeat;
                  background-position: top right;
                  background-size: calc(.75em + .375rem) calc(.75em + .375rem)
               }

               &:valid+.inspiration:hover,
               &.no-input:valid:focus {
                  border: 1px solid #28a745;
                  box-shadow: 0 0 0 .2rem rgba(40, 167, 69, .25);
               }

               &:invalid+.inspiration,
               &.no-input:invalid {
                  border: 1px solid #dc3545;
               }

               &:invalid+.inspiration {
                  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
                  background-repeat: no-repeat;
                  background-position: top right;
                  background-size: calc(.75em + .375rem) calc(.75em + .375rem)
               }

               &:invalid:focus+.inspiration,
               &.no-input:invalid:focus {
                  border: 1px solid #dc3545;
                  box-shadow: 0 0 0 .2rem rgba(220, 53, 69, .25)
               }
            }

            .advanced {
               .form-group {
                  .content {

                     /*
                     &.is-valid {
                        border: 1px solid #28a745;
                        border-top: 0;
                     }
*/
                     &.is-invalid {
                        border: 1px solid #dc3545;
                        border-top: 0;
                     }
                  }
               }
            }
         }
      }

   }
</style>
<script>
   import axios from "axios"
   import EasyMDE from "easymde"
   import Swal from "sweetalert2"
   import EasyConfig from "./EasyConfig.js"

   export default {
      optsCategory: [
         { value: "ipa", text: "iPA" },
         { value: "apps", text: "Apps" },
         { value: "games", text: "Games" },
         { value: "jailbreak", text: "Jailbreak" }
      ],
      data() {
         return {
            MDE: null,
            disabledEditName: false,
            app: {
               images: "https://upload.wikimedia.org/wikipedia/commons/0/06/OOjs_UI_icon_add.svg",
               name: "",
               author: "",
               account: "",
               versions: [],
               supports: [],
               description: "",
               category: "ipa"
            },

            WasValidate: false
         }
      },
      methods: {
         updateIcon(e) {
            let file = e.target.files[0]

            let fileReader = new FileReader

            fileReader.onload = () => {
               this.$set(this.app, "images", fileReader.result)
            };
            fileReader.readAsDataURL(file)
         },
         Delete() {
            let { id, name } = this.app
            Swal.fire({
               title: "Are you sure?",
               html: `You have delete "${name}"? <br>`,
               icon: "warning",
               showCancelButton: true,
               showConfirmButton: true,
               confirmButtonText: "Delete",
               confirmButtonColor: "#dc3545",
               showLoaderOnConfirm: true,
               preConfirm: () => {
                  return axios
                     .delete("http://localhost:8080/admin/api/app.php", {
                        data: {
                           id,
                           action: "delete"
                        }
                     })
                     .then(res => res.data)
                     .then(response => {
                        console.log(response)
                        if (response.error == 1)
                           throw new Error(response.mess)
                        return response
                     })
                     .catch(error => {
                        Swal.showValidationMessage(
                           `${error}`
                        )
                     })
               },

               allowOutsideClick: () => !Swal.isLoading()
            }).then(({ value }) => {
               let { error, mess } = value
               if (error == 0) {
                  this.$AppSuccess("Delete success", "You delete app.")
                  setTimeout(() => this.$router.go(-1))
               } else {
                  this.$AppError("Delete failed", mess)
               }
            })

         },
         CheckValidate() {
            if (this.$refs.FormData.checkValidity() && this.app.versions.length > 0) {
               return true
            } else {
               return false
            }
         },
         Save() {
            if (!this.CheckValidate()) {
               this.WasValidate = true
               return
            }

            let formData = new FormData(this.$refs.FormData)

            formData.append("id", this.app.id)
            formData.append("action", this.$route.meta.upload ? "post" : "put")

            let loading = this.$loading.show({
               width: 50,
               height: 50,
               container: null
            })

            axios.post("http://localhost:8080/admin/api/app.php", formData)
               .then(res => res.data)
               .then(json => {
                  console.log(json)
                  if (json.error == 1) {
                     throw new Error(json.mess)
                  } else {
                     this.$AppSuccess("Successfully", "Upload to server success.")
                  }
               })
               .catch(e => {
                  console.log(e)
                  this.$AppError(e.message, e.stack)
               })
               .finally(() => loading.hide())
         },
         Restore() {
            let loading = this.$loading.show({
               width: 50,
               height: 50,
               container: null
            })
            axios.get("http://localhost:8080/admin/api/app.php", {
                  params: {
                     id: this.$route.params.id
                  }
               })
               .then(res => res.data)
               .then(json => {
                  console.log( json )
                  if (json.error == 1) {
                     if ( json["auth-error"] == true ) {
                        this.$router.push("/login?url=" + this.$route.path)
                     } else {
                        this.$router.replace("/404")
                     }
                     throw new Error(json.mess)
                  } else {
                     this.app = json
                     this.MDE.value(json.description)
                  }
               })
               .catch(e => {
                  this.$AppError(e.message, e.stack)
               })
               .finally(() => loading.hide())
         }
      },
      watch: {
         "app.category"(newVal) {
            if (newVal == "ipa") {
               this.app.account = ""
            }
         }
      },
      created() {
         if (this.$route.meta.upload) {
            return
         }
         this.Restore()
      },
      mounted() {
         this.MDE = new EasyMDE(EasyConfig)
      }
   }
</script>