<template>
   <div class="main">
      <div class="logout">
         <div class="header">
            <b-avatar src="https://nguyenthanh1995.github.io/favicon.ico"/>
         </div>
         <div class="loading">
            <b-spinner type="border"/> Logout...
         </div>
      </div>
   </div>
</template>

<style lang="scss" scoped>
   .main {
      padding: {
         top: 40px;
         bottom: 40px;
      };
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      .logout {
         .loading {
            display: flex;
            justify-content: center;
            align-items: center;
         }
      }
   }
</style>

<script>
   export default {
      created() {
         axios.post("http://localhost:8080/admin/api/logout.php")
         .then(res => res.data)
         .then(json => {
            if ( json.error == 1 ) {
               throw new Error(json.mess)
            }
            this.$AppSuccess("Success", "Logout!")
         })
         .catch(({ message, stack }) => {
            this.$AppError(message, stack)
         })
      }
   }
</script>