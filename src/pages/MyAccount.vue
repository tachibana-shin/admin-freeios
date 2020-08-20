<template>
   <div class="main">
      <h1 class="title"> Quản lý tài khoản </h1>
      <div class="content">
         <div class="header">
            <img class="avatar" :src="avatar"/>
         </div>
         <div class="body">
            <div class="basic">
               <div class="form-input">
                  <label> Full name </label>
                  <input class="input">
               </div>
               <div class="form-input">
                  <label> Email </label>
                  <input class="input">
               </div>
               <b-button variant="primary"> Save </b-button>
            </div>
            
            <div class="password">
               <h1 class="title"> Đổi mật khẩu </h1>
               <div class="form-input">
                  <label> New password </label>
                  <input class="input">
               </div>
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
      };
      .title {
         font-weight: normal !important;
         font-size: 16px !important;
         color: #6c757d;
         text-transform: uppercase;
      }
      .content {
         .header {
            text-align: center;
            .avatar {
               width: 3rem;
               height: 3rem;
               border-radius: 50%;
            }
         }
         .body {
            .form-input {
               border-radius: .25rem;
               border: 1px solid rgba(0, 0, 0, .1);
               padding: 0.5rem .25rem;
               label {
                  text-transform: uppercase;
                  color: #6c757d;
               }
               .input {
                  appearance: none;
                  -webkit-appearance: none;
                  border: 0;
                  outline: none;
                  background-color: #00000000;
                  padding: 0 !important;
                  margin: 0 !important;
                  width: 100%;
               }
            }
            .basic {
               margin-top: 3rem;
            }
            .password {
               margin-top: 3rem;
            }
         }
      }
   }
</style>

<script>
   export default {
      data() {
         return {
            avatar: null
         }
      }
   }
</script>