<template>
  <div class="footer">
    <v-col class="text-center footerText bg-thm-grey text-white" cols="12">
      {{ new Date().getFullYear() }} —  © WebFrameworks, ein Projekt aus dem Fachbereich IEM-Medieninformatik
    </v-col>
  </div>
</template>

<script>
export default {
  name: "footer-template",
}
</script>

<style>
.footer {
  position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
  background-color: red;
  color: white;
  text-align: center;
}
</style>
