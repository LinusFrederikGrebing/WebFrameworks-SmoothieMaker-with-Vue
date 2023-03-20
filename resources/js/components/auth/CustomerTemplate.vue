<template>
    <div v-if="isUserLoggedIn">
      <div class="text-center mx-4 mt-8">
        <h3 class="font-weight-bold">Kunden-Ansicht</h3>
        <p>Hier kannst du deine abgespeicherten Zusammenstellungen aufrufen!</p>
      </div>
      <div>
        <v-row class="mx-auto ml-16 mb-8" no-gutters>
          <v-col
            sm="12"
            md="6"
            xl="4"
            lg="4"
            v-for="(preset, index) in presetNames"
            :key="index"
            ><div class="mx-8 mb-4 d-flex">
              <v-btn class="w-75 py-4" @click="choosePreset(preset)">{{
                preset
              }}</v-btn>
              <v-btn class="w-25 py-4" @click="deletePreset(preset)">
                <v-icon color="red">mdi-delete</v-icon></v-btn
              >
            </div>
          </v-col>
          <p v-if="presetNames.length < 1">Du hast aktuell noch keine Zusammenstellungen gespeichert. Wenn du zukünftig welche als Preset abspeicherst, kannst du sie hier einsehen und abrufen und Dir so bei deiner nächsten Bestellung Zeit sparen!</p>
        </v-row>
      </div>
    </div>
</template>

<script>
import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";
gsap.registerPlugin(ScrollTrigger);

export default {
  name: "SmoothieTipsComponent",
  data() {
    return {
      isUserLoggedIn: false,
      presetNames: [],
    };
  },
  mounted() {
    this.checkLoggedInUser();
    this.getPresets();
  },
  methods: {
    checkLoggedInUser() {
      axios.get(`/checkLoggedInUser`).then((response) => {
        this.isUserLoggedIn = response.data.loggedIn;
        console.log(this.isUserLoggedIn);
      });
    },
    deletePreset(presetName) {
      axios.get(`/deletePreset/${presetName}`).then((response) => {
        this.getPresets();
      });
    },
    getPresets() {
      axios
        .get("/user-presets")
        .then((response) => {
          this.presetNames = response.data.userPresets;
          console.log(this.presetNames);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    choosePreset(presetName) {
      axios.get(`/checkPreset/${presetName}`).then((response) => {
        this.$router.push({ path: "/shop" });
      });
    },
  }
}
</script>