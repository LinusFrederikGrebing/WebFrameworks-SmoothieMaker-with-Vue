<template>
  <div class="container">
    <v-container class="py-12">
      <v-row>
        <v-col class="mb-5" cols="12">
          <div class="mx-auto d-flex flex-wrap">
            <button
              v-for="(category, index) in categories"
              :key="index"
              v-on:click="handleCategoryClick(category)"
              :class="[
                'mx-2 flex-grow-1 custom-btn',
                { 'grey-bg': category.active === false },
                { 'grey-active-bg': category.active === true },
              ]"
            >
              <img
                width="25"
                height="25"
                :src="category.icon"
                :alt="category.title"
              />
              {{ category.title }}
            </button>
          </div>
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
           <div class="text-center">
             <v-icon size="172" >mdi-plus</v-icon>
           </div>
          </v-card>
        </v-col>
        <v-col
          v-for="ingrediente in ingredients"
          :key="ingrediente.id"
          cols="12"
          sm="6"
          md="3"
          lg="2"
        >
          <v-card class="mx-auto mb-4" max-width="400">
            <v-img
              class="white--text align-end"
              :src="'/images/piece/' + ingrediente.image"
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
              <v-btn icon width="45" @click="deleteIngrediente(ingrediente.id)">
                <span class="material-symbols-outlined">delete</span>
              </v-btn>
            </div>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import axios from "axios";

const categories = [
  {
    icon: "/images/fruitsicon.png",
    title: "Früchte",
    list: "fruitsList",
    active: true
  },
  {
    icon: "/images/vegetablesicon.png",
    title: "Gemüse",
    list: "vegetablesList",
    active: false
  },
  {
    icon: "/images/liquidicon.png",
    title: "Flüssigkeit",
    list: "liquidList",
    active: false
  },
];

export default {
  name: "Dashboard",
  data() {
    return {
      ingredients: [],
      categories,
      vegetablesList: null,
      fruitsList: null,
      liquidList: null,
    };
  },
  mounted() {
    this.getIngredientsList().then(() => {
      this.ingredients = this.fruitsList;
    });
  },
  methods: {
    changeRouteCreate() {
      this.$router.push({ path: "/create" });
    },
    changeRouteUpdate(ingrediente) {
      this.$router.push({ path: `/update/ingrediente/${ingrediente.id}` });
    },
    handleCategoryClick(category) {
      this.changeIngredientsList(category.list);
      this.setCategoriesActive(category)
    },
    setCategoriesActive(category) {
      for(let i = 0; i < this.categories.length; i++){
        if(this.categories[i] === category){
          this.categories[i].active = true;
        } else {
          this.categories[i].active = false;
        }
      }
    },
    deleteIngrediente(id) {
      axios.post(`/delete/ingrediente/${id}`);
      this.getIngredientsList();
      this.getActiveIngredienteList();
    },
    getActiveIngredienteList() {
      for(let i = 0; i < this.categories.length; i++){
        if(this.categories[i].active){
          this.ingredients = this.categories[i].list;
        }
      }
    },
    getIngredientsList() {
      return new Promise((resolve, reject) => {
        axios.get('/getIngredientsList').then((response) => {
          this.fruitsList = response.data.ingredientsList.filter((cartItem) => cartItem.type === "fruits");
          this.vegetablesList = response.data.ingredientsList.filter((cartItem) => cartItem.type === "vegetables");
          this.liquidList = response.data.ingredientsList.filter((cartItem) => cartItem.type === "liquid");
          resolve();
        });
      });
    },
    changeIngredientsList(list){
        this.ingredients = this[list];
    },
  },
};
</script>
<style scoped>
.v-card__title {
  justify-content: center;
}
</style> 