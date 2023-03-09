<template>
  <v-app>
    <v-container class="py-6">
      <v-card class="py-3">
        <div class="px-4 py-10">
          <h1>Zutat {{ ingrediente.name }} aktualisieren:</h1>
          <v-divider />
          <v-form
            @submit.prevent="updateIngrediente"
            enctype="multipart/form-data"
          >
            <v-text-field
              id="name"
              label="Neuer Name"
              v-model="ingrediente.name"
              required
            />
            <v-text-field
              id="price"
              label="Neuer Einzelpreis"
              v-model="ingrediente.price"
              type="number"
              step="0.01"
              required
            />
            <v-select
              id="type"
              label="Neuer Type"
              v-model="ingrediente.type"
              :items="typeOptions"
              required
            />
            <v-file-input
              label="Datei auswählen"
              v-on:change="onChange"
            ></v-file-input>
            <v-btn color="primary" type="submit">Zutat aktualisieren</v-btn>
          </v-form>
        </div>
      </v-card>
    </v-container>
  </v-app>
</template>
<script>
import axios from "axios";

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
    onChange(e) {
      this.file = e.target.files[0];
    },
    getIngrediente() {
      axios
        .post(`/api/update/ingrediente/${this.id}`, {})
        .then((response) => {
          this.ingrediente = response.data.ingrediente;
        })
    },
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
      axios
        .post(`/api/updated/ingrediente/${this.id}`, data, config)
        .then(() => {
          this.$router.push({ path: "/home" });
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
};
</script>