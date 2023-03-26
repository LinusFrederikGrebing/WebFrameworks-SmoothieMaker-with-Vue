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
            v-for="(liquid, index) in liquids"
            :key="index"
            cols="12"
            sm="6"
            md="4"
            lg="4"
          >
            <v-card
              @mouseenter="hoverEnter($event)"
              @mouseleave="hoverLeave($event)"
              :class="{ 'selected-card': liquid.id === selectedCard }"
              elevation="5"
              class="mx-auto ingrediente-item"
              max-width="600"
              :id="'liquid-card' + index"
            >
              <div>
                <v-img
                  class="white--text align-end ml-auto mr-auto mt-1 mb-1"
                  height="60px"
                  width="60px"
                  :src="'/images/piece/' + liquid.image"
                >
                </v-img>
                <button
                  style="position: absolute; top: 0; right: 0; opacity: 0.4;"
                  @click="showAlertInfo(liquid.id, liquid.name)"
                >
                  <span class="material-symbols-outlined"> info </span>
                </button>
                <div class="d-flex justify-center align-center flex-column">
                  <p class="font-weight-bold ml-1 mr-1">{{ liquid.name }}:</p>
                  <p>{{ liquid.price }}€ / 50ml</p>
                </div>
                <v-row class="d-flex justify-center mx-6 my-2">
                  <v-col cols="auto">
                    <v-btn @click="selectCard(liquid)" color="black">
                      Wählen!
                    </v-btn>
                  </v-col>
                </v-row>
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
                @click="showStep2()"
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
import { showInfo } from '../steps/alerts'

export default {
  name: "Step3ChooseLiquid",
  components: {
    MixerComponent,
    ProgressbarComponent,
    SizeComponent,
  },
  data() {
    return {
      categories: [
        {
          icon: "/images/liquidicon.png",
          title: "Flüssigkeit",
          list: "liquids",
          active: true,
        },
      ],
      liquids: [],
      selectedCard: null,
      liquid: {},
    };
  },
  watch: {
    // as soon as the current liquid list changes, the entergrid function runs again
    liquids() {
      setTimeout(() => {
        this.enterGrid();
      }, 1);
    },
  },
   // when navigating from the page, stop the loop animation for the current mixer instance
  beforeUnmount() {
    this.$refs.mixerComponent.clearInterval();
  },
  mounted() {
    this.getLiquidList();
    this.getActLiquid();
  },
  methods: {
    // This method calls the showInfo function with the provided ingredientId and ingredintName parameters.
    showAlertInfo(ingredientId, ingredintName) {
      showInfo(ingredientId, ingredintName);
    },
    // gsap hover-Animations
    hoverEnter(obj) {
      gsap.to(obj.target, { duration: 0.2, scale: 1.05, opacity: 1 });
    },
    hoverLeave(obj) {
      gsap.to(obj.target, { duration: 0.2, scale: 1, opacity: 1 });
    },
    // sets the returned list of the liquids to the "liquids" variable.
    getLiquidList() {
      axios.get("/api/liquid").then((response) => {
        this.liquids = response.data.ingredientsList;
      });
    },
    // retrieves the current selected liquid. It then calls the "liquidAnimation" method and "selectCard" method with the retrieved liquid as the argument.
    getActLiquid() {
      axios.get("/getCurrentLiquid").then((response) => {
        if (Object.keys(response.data).length === 0) {
          return;
        }
        var response = response.data.liquidItems;
        Object.keys(response).forEach((key) => {
          this.liquid = response[key];
          this.$refs.mixerComponent.liquidAnimation(this.liquid.options.image);
          this.selectCard(this.liquid);
        });
      });
    },
    // animates the liquid image by calling the "liquidAnimation" method on the "mixerComponent" component with the "liquid" object's image property as the argument.
    liquidAnimation(liquid) {
      this.$refs.mixerComponent.liquidAnimation(liquid.image);
    },
    // sets the selected "liquid" object to the "liquid" variable and sets the "selectedCard" variable to the "liquid" object's id property
    // this will add the css classe selected-card
    selectCard(liquid) {
      this.liquidAnimation(liquid);
      this.liquid = liquid;
      this.selectedCard = liquid.id;
    },
    // navigates to the "/shop" path using the Vue router and adds the current "liquid" object to the cart by calling the "addToCart" method with the "liquid" object and a quantity of 1 as arguments if the "liquid" object is not empty.
    showStep3() {
      this.$router.push({ path: "/shop" });
      if (Object.keys(this.liquid).length !== 0) {
        this.addToCart(this.liquid, 1);
      }
    },
    // navigates back to the "/chooseIngrediente" path using the Vue router.
    showStep2() {
      this.$router.push({ path: "/chooseIngrediente" });
    },
    // adds the liquid to the cart if one was previously selected
    addToCart(ingredient, amount) {
      axios.post(`/addCart/${ingredient.id}`, { amount });
    },
    // random fade-in Aniamtion
    enterGrid() {
      for (let i = 0; i < this.liquids.length; i++) {
        let element = document.getElementById("liquid-card" + i);
        gsap.fromTo(
          element, { y: -1000, x: -1000 }, { delay: Math.random() / 2, duration: 2, y: 0, x: 0 }
        );
      }
    },
  },
};
</script>
<style scoped>
.w-70 {
  width: 65%;
}
</style>