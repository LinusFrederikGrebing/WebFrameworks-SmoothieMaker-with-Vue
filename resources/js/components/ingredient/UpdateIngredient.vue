<template>
  <div class="auth-background seperate">
    <div class="auth-green-background mx-auto rounded-box"></div>
    <v-container class="py-6 d-flex flex-column justify-center">
      <v-row class="justify-center">
        <v-col cols="12" class="mx-auto">
          <v-card elevation="10" max-width="800" min-height="550" class="mx-auto rounded-box">
            <v-card-text class="w-75 mx-auto">
              <h2 class="font-weight-bold mb-12 mt-16">
                Zutat {{ ingredient.name }} aktualisieren:
              </h2>
              <v-form @submit.prevent="updateIngredient" enctype="multipart/form-data">
                <v-text-field id="name" label="Neuer Name" v-model="ingredient.name" required />
                <v-text-field id="price" label="Neuer Einzelpreis" v-model="ingredient.price" type="number" step="0.01"
                  required />
                <v-select id="type" label="Neuer Type" v-model="ingredient.type" :items="typeOptions" required />
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
      ingredient: {},
      typeOptions: ["fruits", "vegetables", "liquid"],
      file: "",
    };
  },
  mounted() {
    this.getIngredient(this.id);
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
    getIngredient() {
      axios.post(`/api/update/ingredient/${this.id}`, {}).then((response) => {
        this.ingredient = response.data.ingredient;
      });
    },
    // Sends a POST request to update an ingredient's information, including the image file. If successful, it redirects the user to the employeeTemplate page and displays a success message.
    updateIngredient() {
      const config = {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      };
      const data = new FormData();
      data.append("file", this.file);
      data.append("name", this.ingredient.name);
      data.append("price", this.ingredient.price);
      data.append("type", this.ingredient.type);
      axios.post(`/api/updated/ingredient/${this.id}`, data, config)
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