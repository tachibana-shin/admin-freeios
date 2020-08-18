<template>
   <b-navbar toggleable="lg" type="light" variant="light">
      <b-navbar-toggle class="border-0" :target="id"/>
      
      <b-navbar-brand tag="span">
         Free iOS Admin
      </b-navbar-brand>
      
      <b-navbar-brand tag="span">
         <S-SDropdown>
            <template v-slot:button-content>
               <b-avatar src="https://nguyenthanh1995.github.io/favicon.ico"/>
               <div class="dropdown-menu">
                  <a to="/myaccount" class="dropdown-item">
                     Manager Account
                  </a>
                  <a to="/logout" class="dropdown-item">
                     Log out
                  </a>
               </div>
            </template>
         </S-SDropdown>
      </b-navbar-brand>
      
      <b-collapse :id="id" is-nav>
         <b-navbar-nav>
            <b-nav-item to="/" active-class="" exact-active-class="active"> App Manager </b-nav-item>
            <b-nav-item to="/upload"> Upload App </b-nav-item>
            <b-nav-item to="/icloud"> iCloud Manager </b-nav-item>
            <b-nav-item-dropdown text="Bộ mã markdown">
               <b-dropdown-item to="/md-tutorial"> Hướng dẫn </b-dropdown-item>
               <b-dropdown-item to="/md-rules"> Nội quy </b-dropdown-item>
               <b-dropdown-item to="/md-faqs"> FAQs </b-dropdown-item>
            </b-nav-item-dropdown>
         </b-navbar-nav>
      </b-collapse>
   </b-navbar>
</template>

<style lang="scss" scoped>
   .navbar-toggler:hover {
      border: 0 !important;
      outline: none !important;
      box-shadow: none !important;
   }
   .collapsw {
      .navbar-nav {
         margin-left: 1rem !important
      }
   }
</style>

<script>
   export default {
      name: "HeaderApp",
      data() {
         return {
            id: "_" + Math.random().toString(36)
         }
      }
   }
</script>