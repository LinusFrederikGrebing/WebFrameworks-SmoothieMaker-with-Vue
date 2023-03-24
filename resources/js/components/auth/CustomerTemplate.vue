<template>
  <div v-if="isUserLoggedIn" class="mt-16">
    <div class="text-center mx-4 pt-16 mt-16">
      <h3 class="font-weight-bold">Kunden-Ansicht</h3>
      <p class="">Hier kannst du deine abgespeicherten Zusammenstellungen aufrufen!</p>
    </div>
    <div elevation="5" class="w-95 ml-5 mt-3 mb-3">
      <v-table v-if="presetNames.length > 0" density="compact">
        <thead>
          <tr>
            <th class="text-left text-black w-75">Name</th>
            <th class="text-left text-black">Entfernen</th>
            <th class="text-left text-black">Wählen!</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(preset, index) in presetNames" :key="index">
            <td>
              <p class="w-75 py-4">{{ preset }}</p>
            </td>
            <td>
              <a @click="deletePreset(preset)" class="mr-4 text-black"
                >löschen</a
              >
            </td>
            <td>
              <v-btn @click="choosePreset(preset)" color="black">
                Wählen!
              </v-btn>
            </td>
          </tr>
        </tbody>
      </v-table>
      <p v-if="presetNames.length < 1" class="text-center">
        Du hast aktuell noch keine Zusammenstellungen gespeichert. Wenn du
        zukünftig welche als Preset abspeicherst, kannst du sie hier einsehen
        und abrufen und Dir so bei deiner nächsten Bestellung Zeit sparen!
      </p>
    </div>
  </div>
</template>

<script>
import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";
gsap.registerPlugin(ScrollTrigger);

export default {
  name: "CustomerTemplate",
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
  },
};
</script>