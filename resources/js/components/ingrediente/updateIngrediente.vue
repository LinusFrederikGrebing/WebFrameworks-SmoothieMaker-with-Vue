<template>
  <div class="auth-background mt-16">
    <div class="auth-green-background mx-auto rounded-box"></div>
    <v-container class="py-6 d-flex flex-column justify-center">
      <v-row class="justify-center">
        <v-col cols="12" class="mx-auto">
          <v-card
            elevation="10"
            width="800"
            height="550"
            class="mx-auto rounded-box"
          >
            <v-card-text class="w-75 mx-auto">
              <h2 class="font-weight-bold mb-12 mt-16">Zutat {{ ingrediente.name }} aktualisieren:</h2>
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
    showHome() {
      this.$router.push('/home');
    },
    onChange(e) {
      this.file = e.target.files[0];
    },
    getIngrediente() {
      axios.post(`/api/update/ingrediente/${this.id}`, {}).then((response) => {
        this.ingrediente = response.data.ingrediente;
      });
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