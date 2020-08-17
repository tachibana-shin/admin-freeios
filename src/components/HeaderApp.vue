<template>
   <b-navbar toggleable="lg" type="light" variant="light">
      <b-navbar-toggle class="navbar-toggler border-0" :target="id"/>
      
      <b-navbar-brand tag="span" class="navbar-brand">
         Free iOS Admin
      </b-navbar-brand>
      
      <b-navbar-brand/>
      
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