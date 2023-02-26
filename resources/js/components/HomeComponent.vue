<template>
    <v-app>
  <v-container class="py-12">
    <v-row>
      <v-col class="mb-5" cols="12">
        <v-card class="mx-auto d-flex flex-wrap">
          <v-btn
            class="mx-auto flex-grow-1"
            v-for="(category, index) in categories"
            :key="index"
            v-on:click="handleCategoryClick(category)"
          >
            <img
              width="20"
              height="20"
              class="my-2"
              :src="category.icon"
              :alt="category.title"
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
          @click="changeRouteCreate()"
        >
          <v-card-text class="text-center">
            <v-icon size="172">mdi-plus</v-icon>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col
        v-for="(zutat, index) in zutaten"
        :key="index"
        cols="12"
        sm="6"
        md="3"
        lg="2"
      >
        <v-card class="mx-auto mb-4" max-width="400">
          <v-img
            class="white--text align-end"
            height="150px"
            :src="'/images/' + zutat.image"
          >
            <v-card-title>
              <span class="font-weight-bold">{{ zutat.name }}</span>
              <div>Preis: {{ zutat.price }}€</div>
            </v-card-title>
          </v-img>
      
            <div class="d-flex align-items-center">
              <v-btn icon width="45" @click="changeRouteUpdate(zutat)"><span class="material-symbols-outlined">
                edit
                </span></v-btn>
                <v-btn icon width="45" @click="deleteIngrediente(zutat.id)"><span class="material-symbols-outlined">
                delete
                </span></v-btn>
            </div>
      
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</v-app>
</template>

  <script>
export default {
  name: "Dashboard",
  data() {
    return {
      zutaten: {},
      categories: [
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
      ],
    };
  },
  created() {
    this.getFruitsIngredientsList();
  },
  methods: {
    changeRouteCreate() {
      this.$router.push({ path: "/create" });
    },
    changeRouteUpdate(zutat) {
        this.$router.push({ path: "/update/ingrediente/" + zutat.id })
    },
    handleCategoryClick(category) {
      // Rufe die entsprechende Methode basierend auf der Kategorie auf
      this[category.method]();
    },
    deleteIngrediente(id){
        axios.post("/delete/ingrediente/" + id);
        this.getFruitsIngredientsList();
    },
    getFruitsIngredientsList() {
      axios
        .get("/fruits")
        .then((response) => {
          this.zutaten = response.data.zutaten;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getVeggieIngredientsList() {
      axios
        .get("/vegetables")
        .then((response) => {
          this.zutaten = response.data.zutaten;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getLiquidIngredientsList() {
      axios
        .get("/liquid")
        .then((response) => {
          this.zutaten = response.data.zutaten;
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>
  <style>
.v-card__title {
  justify-content: center;
}
</style> 