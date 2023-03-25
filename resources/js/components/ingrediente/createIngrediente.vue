<template>
  <div class="auth-background seperate">
    <div class="auth-green-background mx-auto rounded-box"></div>
    <v-container class="py-6 d-flex flex-column justify-center">
      <v-row class="justify-center">
        <v-col cols="12" class="mx-auto">
          <v-card elevation="10" width="800" height="550" class="mx-auto rounded-box">
            <v-card-text class="w-75 mx-auto">
              <h2 class="font-weight-bold mb-12 mt-16">Zutat hinzufügen:</h2>
              <v-form @submit.prevent="storeIngrediente">
                <v-text-field v-model="form.name" label="Name:" required :rules="nameRules"></v-text-field>
                <v-text-field v-model="form.price" label="Einzelpreis:" type="number" step="0.01" required
                  :rules="priceRules"></v-text-field>
                <v-select v-model="form.type" label="Typ:" :items="typeOptions" required :rules="typeRules"></v-select>
                <v-file-input label="Datei auswählen" :rules="fileRules" v-on:change="onChange"></v-file-input>
                <v-row class="d-flex justify-end">
                  <v-col cols="auto">
                    <a @click="showHome" class="mr-4 text-black">Zurück</a>
                    <v-btn color="black" type="submit">Zutat hinzufügen</v-btn>
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
import { showAlertError } from '../steps/alerts'
export default {
  name: "CreateIngrediente",
  data() {
    return {
      typeOptions: ["fruits", "vegetables", "liquid"],
      form: {
        name: "",
        price: null,
        type: "",
      },
      file: null,
      ingredientId: null,
    };
  },
  // define validation rules for form fields.
  computed: {
    nameRules() {
      return [(v) => !!v || "Der Name wird benötigt"];
    },
    priceRules() {
      return [(v) => !!v || "Der Preis wird benötigt"];
    },
    typeRules() {
      return [(v) => !!v || "Der Typ wird benötigt"];
    },
    fileRules() {
      return [(v) => !!v || "Ein Bild wird benötigt"];
    },
  },
  methods: {
    // redirect back to the employeeTemplate
    showHome() {
      this.$router.push("/employeeTemplate");
    },
    // sets the value of the file variable to the file selected in the input field.
    onChange(e) {
      this.file = e.target.files[0];
    },
    // displays a success message using the SweetAlert library and navigates the user to a new page based on their response.
    showAlertSuccess(title, text) {
      Swal.fire({
        title: title,
        text: text,
        icon: "success",
        showCancelButton: true,
        cancelButtonText: "Später hinzufügen",
        confirmButtonColor: "#6D9E1F",
        confirmButtonText: "Informationen hinzufügen",
      }).then((result) => {
        if (result.isConfirmed) {
          this.$router.push({ path: `/create/IngredientInfo/${this.ingredientId}` });
        } else {
          this.$router.push({ path: "/employeeTemplate" });
        }
      });
    },
    // sends a post request to the server with data entered in the form, including the image file selected by the user, and displays a success or error message.
    storeIngrediente(e) {
      if (this.file == null) {
        showAlertError("Du musst eine Bilddatei ausgewählt haben!");
        return;
      }
      e.preventDefault();
      let data = new FormData();
      data.append("file", this.file);
      data.append("name", this.form.name);
      data.append("price", this.form.price);
      data.append("type", this.form.type);
      axios.post("/api/create/ingrediente", data).then((response) => {
        this.ingredientId = response.data.ingrediente;
        this.showAlertSuccess("Die Zuatat wurde erfolgreich hinzugefügt!", "Klicke auf Informationen hinzufügen, um die Inhaltsstoffe der Zutat einzutragen!");
      });
    },
  },
};
</script> 