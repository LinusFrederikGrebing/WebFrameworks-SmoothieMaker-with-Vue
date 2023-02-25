<template>
    <v-app>
      <v-container fluid class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
        <v-card class="relative py-3 sm:max-w-xl sm:mx-auto">
          <div class="absolute inset-0 bg-gradient-to-r from-lime-400 to-lime-600 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl w-40em"></div>
          <v-card class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20 w-40em">
            <v-card-title>
              <h1 class="text-2xl font-semibold">Neue Zutat hinzufügen:</h1>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
              <v-form @submit.prevent="submitForm">
                <v-row>
                  <v-col cols="12">
                    <v-text-field label="Name:" v-model="name" required></v-text-field>
                    <span v-if="errors.name" class="error">{{ errors.name[0] }}</span>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col cols="12">
                    <v-text-field label="Einzelpreis:" v-model="price" type="number" step="0.01" required></v-text-field>
                    <span v-if="errors.price" class="error">{{ errors.price[0] }}</span>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col cols="12">
                    <v-select label="Type:" v-model="type" :items="types" required></v-select>
                    <span v-if="errors.type" class="error">{{ errors.type[0] }}</span>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col cols="12">
                    <v-file-input label="SVG der Zutat:" v-model="image" accept=".svg" required></v-file-input>
                    <span v-if="errors.image" class="error">{{ errors.image[0] }}</span>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col cols="12">
                    <v-btn type="submit" color="primary">Neue Zutat hinzufügen</v-btn>
                  </v-col>
                </v-row>
              </v-form>
            </v-card-text>
          </v-card>
        </v-card>
      </v-container>
    </v-app>
  </template>
  <script>
  export default {
    data() {
      return {
        types: ["fruits", "vegetables", "liquid"],
        form: {
          name: "",
          price: null,
          type: "",
          image: null,
        },
        errors: {},
      };
    },
    methods: {
      async onSubmit() {
        this.errors = {};
        const formData = new FormData();
        formData.append("name", this.form.name);
        formData.append("price", this.form.price);
        formData.append("type", this.form.type);
        formData.append("image", this.form.image);
        try {
          await axios.post("/create/ingrediente", formData);
          this.$router.push("/ingrediente");
        } catch (error) {
          if (error.response && error.response.status === 422) {
            this.errors = error.response.data.errors;
          } else {
            console.log(error);
          }
        }
      },
    },
  };
  </script>