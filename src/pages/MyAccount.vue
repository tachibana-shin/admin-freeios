<template>
   <div class="main">
      <div class="requestPassword" v-if="!renderPage">
         <form ref="FormDataCofirmPassword" class="form-group">
            <label> Enter Password </label>
            <div class="group-password">
               <input type="password" name="password">
               <span class="eye">
                  <i class="fas fa-eye"></i>
               </span>
            </div>
            <b-button variant="primary" block @click="confirmPassword"> Continue </b-button>
            <small class="text-secondary"> Để tiếp tục bạn cần nhập mật khẩu. </small>
         </form>
      </div>
      <div class="privacy" v-if="renderPage">
         <h1 class="title"> Quản lý tài khoản </h1>
         <div class="content">
            <div class="form-group">
               <label> Email </label>
               <input type="email" placeholder="Example: example@example.com">
               <b-button @click="saveEmail"> Save </b-button>
            </div>
            
            <div class="form-group">
               <label> Change Password </label>
               <div class="group-password">
                  <input type="password">
                  <span class="eye">
                     <i class="fas fa-eye"></i>
                  </span>
               </div>
               <b-button @click="savePassword"> Save </b-button>
            </div>
         </div>
      </div>
   </div>
</template>
<style lang="scss" scoped>
   .main {
      padding: {
         left: 15px;
         right: 15px
      }


      .content {
         .form-group {
            .group-password {
               position: relative;
               &>.eye {
                  position: absolute;
                  z-index: 2;
                  right: 1.2rem;
                  top: 0;
                  bottom: 0;
                  margin: auto 0 auto 0;
               }
            }
         }
      }
   }
</style>
<script>
   export default {
      data() {
         return {
            renderPage: false
         }
      },
      methods: {
         confirmPassword() {
            axios.post("http://localhost:8080/admin/api/confirm-password.php", new FormData(this.$refs.FormDataConfirmPassword))
            .then(res => res.data)
            .then(json => {
               if ( json.error == 1 ) {
                  throw new Error(json.mess)
               }
               this.renderPage = true
            })
            .catch(({ stack, message }) => {
               this.$AppError(message, stack)
            })
         },
         saveEmail() {
            
         },
         savePassword() {
            
         }
      }
   }
</script>