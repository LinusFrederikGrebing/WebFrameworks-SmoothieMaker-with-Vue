<template>
 <v-app>
    <v-container class="min-h-screen py-6 d-flex justify-center sm:py-12" fluid>
      <v-card class="relative py-3 sm:max-w-xl sm:mx-auto" outlined>
        <v-card
          class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20 w-40em"
        >
          <v-container>
            <h1 class="text-2xl font-semibold">
              Zutat hinzufügen:
            </h1>
            <v-divider></v-divider>
            <v-form @submit="storeIngrediente" enctype="multipart/form-data">
              <v-text-field
                id="name"
                label="Neuer Name"
                v-model="form.name"
                :rules="[
                  v => !!v || 'Der Name wird benötigt',
                ]"
              >  </v-text-field> <span v-if="errors.name" class="error">{{ errors.name[0] }}</span>
              <v-text-field
                id="price"
                label="Neuer Einzelpreis"
                v-model="form.price"
                type="number"
                step="0.01"
                :rules="[
                  v => !!v || 'Der Preis wird benötigt',
                ]"
              ></v-text-field>
              <v-select
                id="type"
                label="Neuer Type"
                v-model="form.type"
                :items="typeOptions"
                :rules="[
                  v => !!v || 'Der Typ wird benötigt',
                ]"
              ></v-select>
              <input type="file" class="form-control" v-on:change="onChange" required  />
             
              <v-btn color="primary" type="submit"> Zutat hinzufügen </v-btn>
            </v-form>
          </v-container>
        </v-card>
      </v-card>
    </v-container>
  </v-app>
  </template>
  <script>
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
        errors: {},
      };
    },
    methods: {
      onChange(e) {
        this.file = e.target.files[0];
      },
      storeIngrediente(e) {
        e.preventDefault();
        const config = {
          headers: {
            "content-type": "multipart/form-data",
          },
        };
        let data = new FormData();
        data.append("file", this.file);
        data.append("name", this.form.name);
        data.append("price", this.form.price);
        data.append("type", this.form.type);
        axios
          .post("/create/ingrediente", data, config)
          .then((response) => {
            this.$router.push({ path: "/home" })
        })
      },
    },
  };
  </script>