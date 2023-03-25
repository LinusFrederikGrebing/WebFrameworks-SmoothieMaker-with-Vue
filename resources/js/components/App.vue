<template>
   <v-app>
    <HeaderTemplate />
    <v-card elevation="24" class="content-container ml-auto mr-auto">
      <router-view />
    </v-card>
    <FooterTemplate />
  </v-app>
</template>

<script>
import FooterTemplate from "../components/layouts/FooterTemplate";
import HeaderTemplate from "../components/layouts/HeaderTemplate";

export default {
  name: "AppComponent",
  components: {
    FooterTemplate,
    HeaderTemplate,
  },
};
</script>
