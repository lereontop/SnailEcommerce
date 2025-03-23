  <template>
    <UserNavbar />
    <router-view />
    <FooterComponent />
  </template>

  <script setup>
  import UserNavbar from "@/components/UserNavbar.vue";
  import FooterComponent from "@/components/Footer.vue";
  </script>
