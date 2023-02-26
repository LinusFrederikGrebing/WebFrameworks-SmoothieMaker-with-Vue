<template>
    <v-app>
      <v-container class="py-12">
        <v-row>
          <v-col class="mb-5" cols="12">
            <v-card class="mx-auto d-flex flex-wrap">
              <v-btn
                v-for="(category, index) in categories"
                :key="index"
                class="mx-auto flex-grow-1"
                @click="handleCategoryClick(category)"
              >
                <img
                  :src="category.icon"
                  :alt="category.title"
                  width="20"
                  height="20"
                  class="my-2"
                />
                {{ category.title }}
              </v-btn>
            </v-card>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" sm="6" md="3" lg="2">
            <v-card
              class="mx-auto"
              max-width="400"
              height="200"
              color="success"
              @click="changeRouteCreate"
            >
              <v-card-text class="text-center">
                <v-icon size="172">mdi-plus</v-icon>
              </v-card-text>
            </v-card>
          </v-col>
          <v-col
            v-for="(ingrediente) in ingredients"
            :key="ingrediente.id"
            cols="12"
            sm="6"
            md="3"
            lg="2"
          >
            <v-card class="mx-auto mb-4" max-width="400">
              <v-img
                class="white--text align-end"
                :src="'/images/' + ingrediente.image"
                height="150px"
              >
                <v-card-title>
                  <span class="font-weight-bold">{{ ingrediente.name }}</span>
                  <div>Preis: {{ ingrediente.price }}€</div>
                </v-card-title>
              </v-img>
              <div class="d-flex align-items-center">
                <v-btn icon width="45" @click="changeRouteUpdate(ingrediente)">
                  <span class="material-symbols-outlined">edit</span>
                </v-btn>
                <v-btn
                  icon
                  width="45"
                  @click="deleteIngrediente(ingrediente.id)"
                >
                  <span class="material-symbols-outlined">delete</span>
                </v-btn>
              </div>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-app>
  </template>

<script>
import axios from "axios";

const categories = [
  {
    icon: "/images/fruitsicon.png",
    title: "Früchte",
    method: "getFruitsIngredientsList",
  },
  {
    icon: "/images/vegetablesicon.png",
    title: "Gemüse",
    method: "getVeggieIngredientsList",
  },
  {
    icon: "/images/liquidicon.png",
    title: "Flüssigkeit",
    method: "getLiquidIngredientsList",
  },
];

export default {
  name: "Dashboard",
  data() {
    return {
      ingredients: {},
      categories,
    };
  },
  created() {
    this.getFruitsIngredientsList();
  },
  methods: {
    changeRouteCreate() {
      this.$router.push({ path: "/create" });
    },
    changeRouteUpdate(ingrediente) {
      this.$router.push({ path: `/update/ingrediente/${ingrediente.id}` });
    },
    handleCategoryClick(category) {
      // Rufe die entsprechende Methode basierend auf der Kategorie auf
      this[category.method]();
    },
    deleteIngrediente(id) {
      axios.post(`/delete/ingrediente/${id}`);
      this.getFruitsIngredientsList();
    },
    getFruitsIngredientsList() {
      this.getIngredientsList("/fruits");
    },
    getVeggieIngredientsList() {
      this.getIngredientsList("/vegetables");
    },
    getLiquidIngredientsList() {
      this.getIngredientsList("/liquid");
    },
    getIngredientsList(path) {
      axios
        .get(path)
        .then((response) => {
          this.ingredients = response.data.ingrediente;
        })
        .catch((err) => {
          console.log(err);
        });
    }
  },
};
</script>
  <style>
.v-card__title {
  justify-content: center;
}
</style> 