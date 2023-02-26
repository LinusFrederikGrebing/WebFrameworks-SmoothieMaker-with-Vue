<template>
  <v-app>
    <v-container class="min-h-screen py-6 d-flex justify-center sm:py-12" fluid>
      <v-card class="relative py-3 sm:max-w-xl sm:mx-auto" outlined>
        <div
          class="absolute inset-0 bg-gradient-to-r from-lime-400 to-lime-600 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl w-40em"
        ></div>
        <v-card
          class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20 w-40em"
        >
          <v-container>
            <h1 class="text-2xl font-semibold">
              Zutat {{ ingrediente.name }} aktualisieren:
            </h1>
            <v-divider></v-divider>
            <v-form @submit="updateIngrediente" enctype="multipart/form-data">
              <v-text-field
                id="name"
                label="Neuer Name"
                v-model="ingrediente.name"
                required
              ></v-text-field>
              <v-text-field
                id="price"
                label="Neuer Einzelpreis"
                v-model="ingrediente.price"
                type="number"
                step="0.01"
                required
              ></v-text-field>
              <v-select
                id="type"
                label="Neuer Type"
                v-model="ingrediente.type"
                :items="typeOptions"
                required
              ></v-select>
              <input type="file" class="form-control" v-on:change="onChange" />
              <v-btn color="primary" type="submit"> Zutat aktualisieren </v-btn>
            </v-form>
          </v-container>
        </v-card>
      </v-card>
    </v-container>
  </v-app>
</template>
  <script>
export default {
  props: ["id"], // das Prop "id" anstelle von "ingrediente" verwenden
  data() {
    return {
      ingrediente: {}, // Variable "ingrediente" anstelle von Prop verwenden
      typeOptions: ["fruits", "vegetables", "liquid"],
      file: "",
    };
  },
  mounted() {
    this.getIngrediente(this.id);
  },
  created() {
    console.log(this.id);
    this.getIngrediente(this.id);
  },
  methods: {
    onChange(e) {
      this.file = e.target.files[0];
    },
    getIngrediente(e) {
      axios
        .post("/update/ingrediente/" + this.id, {})
        .then((response) => {
          this.ingrediente = response.data.ingrediente;
          console.log(this.ingrediente);
        })
        .catch((error) => {
          console.error(error);
        });
    },
    updateIngrediente(e) {
      e.preventDefault();
      const config = {
        headers: {
          "content-type": "multipart/form-data",
        },
      };
      let data = new FormData();
      data.append("file", this.file);
      data.append("name", this.ingrediente.name);
      data.append("price", this.ingrediente.price);
      data.append("type", this.ingrediente.type);
      axios
        .post("/updated/ingrediente/" + this.id, data, config)
        .then(
          this.$router.push({ path: "/home" })
        )
    },
  },
};
</script>