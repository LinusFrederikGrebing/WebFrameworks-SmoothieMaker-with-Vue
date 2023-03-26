<template>
  <div class="container mt-16">
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
                <button
                  style="position: absolute; top: 0; right: 0; opacity: 0.4;"
                  @click="showAlertInfo(ingrediente.id, ingrediente.name)"
                >
                  <span class="material-symbols-outlined"> info </span>
                </button>
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
import { showInfo, showAlertError } from '../steps/alerts'

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
      selectedAmounts: [], // the selectedAmounts variable can be set and set by the user for specific ingredients. The respective SelectedAmount value of the ingredient is transferred to the backend and the number of ingredients set is added
      liquid: null,
      vegetablesList: null,
      fruitsList: null,
    };
  },
  // when navigating from the page, stop the loop animation for the current mixer instance
  beforeUnmount() {
    this.$refs.mixerComponent.clearInterval();
  },
  mounted() {
    this.getIngredientsList();
    this.getActLiquid();
  },
  watch: {
    // as soon as the current ingredients list changes, the entergrid function runs again
    ingredients() {
      setTimeout(() => {
        this.enterGrid();
      }, 1);
    },
  },
  methods: {
    // This method calls the showInfo function with the provided ingredientId and ingredintName parameters.
    showAlertInfo(ingredientId, ingredintName) {
      showInfo(ingredientId, ingredintName);
    },
    // changes the list of ingredients based on the selected category and sets the active state of the categories accordingly.
    handleCategoryClick(category) {
      this.changeIngredientsList(category.list);
      this.setCategoriesActive(category);
    },
    // loops through all categories and sets the active state of the provided category to true, while setting all other categories' active state to false.
    setCategoriesActive(category) {
      for (let i = 0; i < this.categories.length; i++) {
        if (this.categories[i] === category) {
          this.categories[i].active = true;
        } else {
          this.categories[i].active = false;
        }
      }
    },
    // gsap hover-Animations
    hoverEnter(obj) {
      gsap.to(obj.target, { duration: 0.2, scale: 1.05 });
    },
    hoverLeave(obj) {
      gsap.to(obj.target, { duration: 0.2, scale: 1 });
    },
    // random fade-in Aniamtion
    enterGrid() {
      for (let i = 0; i < this.ingredients.length; i++) {
        let element = document.getElementById("ingrediente-card" + i);
        gsap.fromTo(
          element, { y: -1000, x: -1000 }, { delay: Math.random() / 2, duration: 2, y: 0, x: 0 }
        );
      }
    },
    // filters the response to get only fruits and vegetables, sets the ingredients array to the filtered list and init the selectedAmounts var.
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
    // changes the ingredients array to the array provided in the list parameter.
    changeIngredientsList(list) {
      this.ingredients = this[list];
    },
    // increases the selected amount of the ingredient at the provided index by 1, up to a maximum of 20.
    increaseSelectedAmount(index) {
      if (this.selectedAmounts[index] < 20) {
        this.selectedAmounts[index]++;
      }
    },
    // decreases the selected amount of the ingredient at the provided index by 1, down to a minimum of 1.
    decreaseSelectedAmount(index) {
      if (this.selectedAmounts[index] > 1) {
        this.selectedAmounts[index]--;
      }
    },
    // navigates to the /chooseLiquid route using the Vue Router.
    showStep3() {
      this.$router.push({ path: "/chooseLiquid" });
    },
    // navigates to the /chooseBottleSize route using the Vue Router.
    showBottleSize() {
      this.$router.push({ path: "/chooseBottleSize" });
    },
    // If the response indicates that the ingredient was successfully added to the cart, it calls methods on three child components (mixerComponent, sizeComponent, and progressComponent) to update their state accordingly.
    // Otherwise, it displays an error message using the showAlertError function.
    addToCart(ingredient, amount) {
      axios.post(`/addCart/${ingredient.id}`, { amount }).then((response) => {
        if (response.data.stored) {
          this.$refs.mixerComponent.setImg(response.data.image, amount);
          this.$refs.sizeComponent.getCartCount();
          this.$refs.progressComponent.getProgress();
        } else {
          showAlertError("Du hast zu viele Zutaten ausgewählt!", "");
        }
      });
    },
    // get the current liquid in the mixer, sets the liquid object to the response data, and calls a method on the mixerComponent child component to animate the liquid using the provided image.
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
    // displays a confirmation dialog using the SweetAlert library, and if the user confirms, it navigates to the /chooseBottleSize route using the Vue Router.
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
  },
};
</script>
<style scoped>
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
