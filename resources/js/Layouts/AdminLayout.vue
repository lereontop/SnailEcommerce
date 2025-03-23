<template>
    <AdminNavbar />
    <router-view />
    <AdminFooter />
  </template>

  <script setup>
  import AdminNavbar from "@/components/AdminNavbar.vue";
  import AdminFooter from "@/components/AdminFooter.vue";
  </script>
