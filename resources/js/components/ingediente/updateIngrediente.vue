<template>
    <v-app>
      <v-container class="min-h-screen py-6 d-flex justify-center sm:py-12" fluid>
        <v-card class="relative py-3 sm:max-w-xl sm:mx-auto" outlined>
          <div class="absolute inset-0 bg-gradient-to-r from-lime-400 to-lime-600 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl w-40em"></div>
          <v-card class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20 w-40em">
            <v-container>
              <h1 class="text-2xl font-semibold">Zutat {{ zutat.name }} aktualisieren:</h1>
              <v-divider></v-divider>
              <v-form v-on:submit.prevent="updateZutat">
                <v-text-field
                  id="name"
                  label="Neuer Name"
                  v-model="form.name"
                  :rules="nameRules"
                  required
                ></v-text-field>
                <v-text-field
                  id="price"
                  label="Neuer Einzelpreis"
                  v-model="form.price"
                  :rules="priceRules"
                  type="number"
                  step="0.01"
                  required
                ></v-text-field>
                <v-select
                  id="type"
                  label="Neuer Type"
                  v-model="form.type"
                  :items="typeOptions"
                  required
                ></v-select>
                <v-file-input
                  id="image"
                  label="Neues SVG der Zutat"
                  v-model="form.image"
                ></v-file-input>
                <v-btn color="primary" type="submit">
                  Zutat aktualisieren
                </v-btn>
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
        form: {
          name: "",
          price: "",
          type: "",
          image: null
        },
        nameRules: [val => !!val || "Name is required"],
        priceRules: [
          val => !!val || "Price is required",
          val => /^\d+(\.\d{1,2})?$/.test(val) || "Invalid price format"
        ],
        typeOptions: ["fruits", "vegetables", "liquid"]
      };
    },
    mounted() {
      // set initial form values
      this.form.name = this.zutat.name;
      this.form.price = this.zutat.price;
      this.form.type = this.zutat.type;
    },
    methods: {
      updateZutat() {
        const formData = new FormData();
        formData.append("_method", "PUT");
        formData.append("_token", "{{ csrf_token() }}");
        formData.append("name", this.form.name);
        formData.append("price", this.form.price);
        formData.append("type", this.form.type);
        formData.append("image", this.form.image);
        axios.post(`/updated/ingrediente/${this.zutat.id}`, formData).then(() => {
          // handle success case
        }).catch(() => {
          // handle error case
        });
      }
    }
  };
  </script>