<template>
  <div class="container">
    <SizeComponent ref="sizeComponent" />
    <v-row class="mt-1">
      <v-col class="mb-1" cols="12">
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
      <v-col cols="12" md="8" class="mb-1 mt-1">
        <v-row class="item-list">
          <v-col
            v-for="(ingrediente, index) in ingredients"
            :key="index"
            cols="12"
            sm="6"
            md="3"
            lg="auto"
          >
            <v-card
              @mouseenter="hoverEnter($event)"
              @mouseleave="hoverLeave($event)"
              :id="'ingrediente-card' + index"
              elevation="5"
              class="mx-auto ingrediente-item"
              max-width="400"
            >
              <div>
                <v-img
                  class="white--text align-end ml-auto mr-auto mt-1 mb-1"
                  height="60px"
                  width="60px"
                  :src="'/images/piece/' + ingrediente.image"
                >
                </v-img>
                <div class="text-center">
                  <p class="font-weight-bold ml-1 mr-1">
                    {{ ingrediente.name }}:
                  </p>
                  <p>{{ ingrediente.price }}€ / 50g</p>
                </div>

                <v-form enctype="multipart/form-data" method="post">
                  <div class="d-flex align-items-center mb-2">
                    <button
                      class="w-30px"
                      @click.prevent="increaseSelectedAmount(index)"
                    >
                      <v-icon>mdi-plus</v-icon>
                    </button>
                    <div width="15" :complete="false">
                      {{ selectedAmounts[index] }}
                    </div>
                    <button
                      class="w-30px"
                      @click.prevent="decreaseSelectedAmount(index)"
                    >
                      <v-icon>mdi-minus</v-icon>
                    </button>
                    <button
                      class="white--text bg-white w-40px"
                      type="submit"
                      @click.prevent="
                        addToCart(ingrediente, selectedAmounts[index])
                      "
                    >
                      <i style="color: black" class="material-icons"
                        >shopping_cart</i
                      >
                    </button>
                  </div>
                </v-form>
              </div>
            </v-card>
          </v-col>
        </v-row>
        <v-row>
          <v-col class="mb-5" cols="12">
            <div class="mx-auto d-flex flex-wrap">
              <button
                color="error"
                class="mx-auto flex-grow-1 red-bg custom-btn"
                @click="removeAllAlert()"
              >
                Zurück
              </button>
              <button
                color="success"
                class="mx-auto flex-grow-1 green-bg custom-btn"
                @click="showStep3()"
              >
                Weiter
              </button>
            </div>
          </v-col>
        </v-row>
      </v-col>
      <v-col cols="12" md="4">
        <div max-width="400">
          <MixerComponent ref="mixerComponent" />
          <ProgressbarComponent ref="progressComponent" />
        </div>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import gsap from "gsap";
import MixerComponent from "../layouts/MixerComponent.vue";
import ProgressbarComponent from "../layouts/ProgressbarComponent.vue";
import SizeComponent from "../layouts/SizeComponent.vue";

export default {
  name: "Step2ChooseIngrediente",
  components: {
    MixerComponent,
    ProgressbarComponent,
    SizeComponent,
  },
  data() {
    return {
      categories: [
        {
          icon: "/images/fruitsicon.png",
          title: "Früchte",
          list: "fruitsList",
          active: true,
        },
        {
          icon: "/images/vegetablesicon.png",
          title: "Gemüse",
          list: "vegetablesList",
          active: false,
        },
      ],
      ingredients: [],
      selectedAmounts: [],
      liquid: null,
      vegetablesList: null,
      fruitsList: null,
    };
  },
  beforeUnmount() {
    this.$refs.mixerComponent.clearInterval();
  },
  mounted() {
    this.getIngredientsList();
    this.getActLiquid();
  },
  watch: {
    ingredients() {
      setTimeout(() => {
        this.enterGrid();
      }, 0);
    },
  },
  methods: {
    handleCategoryClick(category) {
      this.changeIngredientsList(category.list);
      this.setCategoriesActive(category);
    },
    setCategoriesActive(category) {
      for (let i = 0; i < this.categories.length; i++) {
        if (this.categories[i] === category) {
          this.categories[i].active = true;
        } else {
          this.categories[i].active = false;
        }
      }
    },
    hoverEnter(obj) {
      gsap.to(obj.target, {
        duration: 0.2,
        scale: 1.05,
      });
    },
    hoverLeave(obj) {
      gsap.to(obj.target, { duration: 0.2, scale: 1 });
    },
    enterGrid() {
      for (let i = 0; i < this.ingredients.length; i++) {
        let element = document.getElementById("ingrediente-card" + i);
        gsap.fromTo(
          element,
          {
            y: -1000,
            x: -1000,
          },
          {
            delay: Math.random() / 2,
            duration: 2,
            y: 0,
            x: 0,
          }
        );
      }
    },
    getIngredientsList() {
      axios.get("/api/getIngredientsList").then((response) => {
        this.fruitsList = response.data.ingredientsList.filter(
          (cartItem) => cartItem.type === "fruits"
        );
        this.vegetablesList = response.data.ingredientsList.filter(
          (cartItem) => cartItem.type === "vegetables"
        );
        this.ingredients = this.fruitsList;
        this.selectedAmounts = Array(this.ingredients.length).fill(1);
      });
    },
    changeIngredientsList(list) {
      this.ingredients = this[list];
    },
    increaseSelectedAmount(index) {
      if (this.selectedAmounts[index] < 20) {
        this.selectedAmounts[index]++;
      }
    },
    decreaseSelectedAmount(index) {
      if (this.selectedAmounts[index] > 1) {
        this.selectedAmounts[index]--;
      }
    },
    showStep3() {
      this.$router.push({ path: "/chooseLiquid" });
    },
    showBottleSize() {
      this.$router.push({ path: "/chooseBottleSize" });
    },
    addToCart(ingredient, amount) {
      axios.post(`/addCart/${ingredient.id}`, { amount }).then((response) => {
        if (response.data.stored) {
          this.$refs.mixerComponent.setImg(response.data.image, amount);
          this.$refs.sizeComponent.getCartCount();
          this.$refs.progressComponent.getProgress();
        } else {
          this.showAlertTooMany();
        }
      });
    },
    getActLiquid() {
      axios.get("/getCurrentLiquid").then((response) => {
        if (Object.keys(response.data).length === 0) {
          return;
        }
        var response = response.data.liquidItems;
        Object.keys(response).forEach((key) => {
          this.liquid = response[key];
          this.$refs.mixerComponent.liquidAnimation(this.liquid.options.image);
        });
      });
    },
    removeAllAlert() {
      Swal.fire({
        title: "Bist du Dir sicher?",
        text: "Wenn du zurückgehst wird deine bisherige Zusammenstellung unwiederruflich gelöscht!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#6D9E1F",
        cancelButtonColor: "#d33",
        confirmButtonText: "Weiter zurück!",
        cancelButtonText: "Abbrechen!",
      }).then((result) => {
        if (result.isConfirmed) {
          this.$router.push({ path: "/chooseBottleSize" });
        }
      });
    },
    showAlertTooMany() {
      Swal.fire({
        title: "Du hast zu viele Zutaten ausgewählt!",
        text: "",
        icon: "error",
        showCancelButton: false,
        confirmButtonColor: "#6D9E1F",
        confirmButtonText: "Okay!",
      });
    },
  },
};
</script>
<style scoped>
p {
  margin-bottom: 0;
}
.w-30px {
  width: 39px;
}
.w-40px {
  width: 60px;
}
.item-list {
  height: 42em;
  overflow-y: scroll;
}
</style>
