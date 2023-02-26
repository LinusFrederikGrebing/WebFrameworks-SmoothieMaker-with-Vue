<template>
  <v-app>
    <v-container class="py-6">
      <v-card class="py-3">
        <div class="px-4 py-10">
          <h1>Zutat hinzufügen:</h1>
          <v-divider></v-divider>
          <v-form @submit.prevent="storeIngrediente">
            <v-text-field
              v-model="form.name"
              label="Name:"
              required
              :rules="nameRules"
            ></v-text-field>
            <v-text-field
              v-model="form.price"
              label="Einzelpreis:"
              type="number"
              step="0.01"
              required
              :rules="priceRules"
            ></v-text-field>
            <v-select
              v-model="form.type"
              label="Typ:"
              :items="typeOptions"
              required
              :rules="typeRules"
            ></v-select>
            <v-file-input
              label="Datei auswählen"
              :rules="fileRules"
              v-on:change="onChange"
            ></v-file-input>
            <v-btn color="primary" type="submit">Zutat hinzufügen</v-btn>
          </v-form>
        </div>
      </v-card>
    </v-container>
  </v-app>
</template>
<script>
import axios from "axios";

export default {
  data() {
    return {
      typeOptions: ["fruits", "vegetables", "liquid"],
      form: {
        name: "",
        price: null,
        type: "",
      },
      file: null,
    };
  },
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
    onChange(e) {
      this.file = e.target.files[0];
    },
    storeIngrediente(e) {
      e.preventDefault();
      let data = new FormData();
      data.append("file", this.file);
      data.append("name", this.form.name);
      data.append("price", this.form.price);
      data.append("type", this.form.type);
      axios.post("/create/ingrediente", data).then(() => {
        this.$router.push({ path: "/home" });
      });
    },
  },
};
</script> 