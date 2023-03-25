<template>
  <div v-if="isUserLoggedIn" class="mt-16">
    <div class="text-center pt-16 mt-16">
      <h3 class="font-weight-bold">Kunden-Ansicht</h3>
      <p class="">Hier kannst du deine abgespeicherten Zusammenstellungen aufrufen!</p>
    </div>
    <div elevation="5" class="ml-8 w-95 mt-3 mb-3">
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
              <p class="w-75 py-3">{{ preset }}</p>
            </td>
            <td>
              <a @click="deletePreset(preset)" class="mr-4 text-black">löschen</a>
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
export default {
  name: "CustomerTemplate",
  data() {
    return {
      isUserLoggedIn: false, // A boolean variable indicating whether the user is logged in or not
      presetNames: [], //Array to store preset names
    };
  },
  mounted() {
    // This method is called when the component is mounted to the DOM
    // It checks whether the user is logged in and gets all preset-names
    this.checkLoggedInUser();
    this.getPresets();
  },
  methods: {
    checkLoggedInUser() {
      // Sends an HTTP GET request to check if the user is logged in
      axios.get(`/checkLoggedInUser`).then((response) => {
        this.isUserLoggedIn = response.data.loggedIn;
        console.log(this.isUserLoggedIn);
      });
    },
    deletePreset(presetName) {
      // Sends an HTTP GET request to delete a preset by preset name -> presetnames are unique for spezific users
      axios.get(`/deletePreset/${presetName}`).then(() => {
        this.getPresets(); // Calls getPresets() methods to update the visible preset-list
      });
    },
    getPresets() {
      // Sends an HTTP GET request to get user presets
      axios.get("/user-presets")
        .then((response) => {
          this.presetNames = response.data.userPresets; // Stores the preset names in the array
        })
        .catch((error) => {
          console.log(error);
        });
    },
    choosePreset(presetName) {
      // Sends an HTTP GET request to check if a preset with the given name exists
      axios.get(`/checkPreset/${presetName}`).then(() => {
        this.$router.push({ path: "/shop" }); // Navigates to the shop page
      });
    },
  },
};
</script>
