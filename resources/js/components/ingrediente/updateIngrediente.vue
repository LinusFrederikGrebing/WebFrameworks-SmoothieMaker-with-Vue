<template>
  <div class="auth-background seperate">
    <div class="auth-green-background mx-auto rounded-box"></div>
    <v-container class="py-6 d-flex flex-column justify-center">
      <v-row class="justify-center">
        <v-col cols="12" class="mx-auto">
          <v-card elevation="10" width="800" height="550" class="mx-auto rounded-box">
            <v-card-text class="w-75 mx-auto">
              <h2 class="font-weight-bold mb-12 mt-16">
                Zutat {{ ingrediente.name }} aktualisieren:
              </h2>
              <v-form @submit.prevent="updateIngrediente" enctype="multipart/form-data">
                <v-text-field id="name" label="Neuer Name" v-model="ingrediente.name" required />
                <v-text-field id="price" label="Neuer Einzelpreis" v-model="ingrediente.price" type="number" step="0.01"
                  required />
                <v-select id="type" label="Neuer Type" v-model="ingrediente.type" :items="typeOptions" required />
                <v-file-input label="Datei auswählen" v-on:change="onChange"></v-file-input>
                <v-row class="d-flex justify-end">
                  <v-col cols="auto">
                    <a @click="showHome" class="mr-4 text-black">Zurück</a>
                    <v-btn color="black" type="submit">Zutat aktualisieren</v-btn>
                  </v-col>
                </v-row>
              </v-form>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import axios from "axios";
import { showAlertSuccess } from '../steps/alerts'

export default {
  props: ["id"],
  data() {
    return {
      ingrediente: {},
      typeOptions: ["fruits", "vegetables", "liquid"],
      file: "",
    };
  },
  mounted() {
    this.getIngrediente(this.id);
  },
  methods: {
    // redirect back to the employeeTemplate
    showHome() {
      this.$router.push("/employeeTemplate");
    },
    // Sets the file property to the file that was selected by the user.
    onChange(e) {
      this.file = e.target.files[0];
    },
    // retrieves the data for the specific ingredient.
    getIngrediente() {
      axios.post(`/api/update/ingrediente/${this.id}`, {}).then((response) => {
        this.ingrediente = response.data.ingrediente;
      });
    },
    // Sends a POST request to update an ingredient's information, including the image file. If successful, it redirects the user to the employeeTemplate page and displays a success message.
    updateIngrediente() {
      const config = {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      };
      const data = new FormData();
      data.append("file", this.file);
      data.append("name", this.ingrediente.name);
      data.append("price", this.ingrediente.price);
      data.append("type", this.ingrediente.type);
      axios.post(`/api/updated/ingrediente/${this.id}`, data, config)
        .then(() => {
          showAlertSuccess("Die Zutat wurde erfolgreich aktualisiert!", "");
          this.$router.push({ path: "/employeeTemplate" });
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
};
</script>