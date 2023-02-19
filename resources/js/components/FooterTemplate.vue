<template>
  <v-footer app height="40" padless color="rgb(74, 92, 102)">
    <v-col class="text-center footerText" cols="12">
      {{ new Date().getFullYear() }} —  © 2023 WebFrameworks, ein Projekt aus dem Fachbereich IEM-Medieninformatik
    </v-col>
  </v-footer>
</template>

<script>
export default {
  name: "footer-template",
}
</script>
