<template>
  <v-container class="mt-16">
    <div class="text-center mx-4 mt-8">
      <h2 class="font-weight-bold">Wähle jetzt deine Smoothie-Größe!</h2>
    </div>
    <v-row class="mx-auto ml-16 mb-8" :class="$vuetify.display.mobile ? 'w-100' : 'w-75'" no-gutters>
      <v-col
        sm="12"
        md="12"
        xl="6"
        lg="6"
        xs="12"
        v-for="bottle in bottles"
        :key="bottle.id"
        class="bg-container"
        :id="'bottle-card' + bottle.id"
      >
        <div class="green-background-rotate mx-auto rounded-box"></div>
        <v-card
          class="my-4 mx-4 card-color rounded-box"
          elevation="10"
          min-height="300"
          @mouseenter="hoverEnter($event)"
          @mouseleave="hoverLeave($event)"
        >
          <v-row>
            <v-col  sm="12"
              md="4"
              xl="4"
              lg="5"
              xs="6">
              <img
                class="size-image mt-4"
                :src="'/images/' + bottle.image"
                :alt="bottle.name"
                style="width: 17em; height: 100%; object-fit: contain"
              />
            </v-col>
            <v-col  sm="12"
              md="8"
              xl="8"
              lg="7"
              xs="12">
              <div class="mt-8">
                <h4 class="mx-4 font-weight-bold">Größe: {{ bottle.name }}</h4>
                <p class="mx-4 mb-4">{{ bottle.description }}</p>
                <button
                  class="mx-4 my-4 green-bg custom-btn"
                  @click="storeBottle(bottle)"
                >
                  Weiter
                </button>
              </div>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import gsap from "gsap";
export default {
  name: "Step1ChooseBottleSize",
  data() {
    return {
      bottles: [],
    };
  },
  mounted() {
    this.getBottles();
    console.log(this.$vuetify.display.mobile)
  },

  methods: {
    // This method uses Axios to fetch bottle data from a server endpoint ("/bottleSize"). Upon a successful response, it sets the fetched bottle data to the "bottles" data property of the component, 
    // clears a session storage variable using the "clearMixer" method, and calls the "enterGrid" method to animate the display of the bottle cards on the page.
    async getBottles() {
      try {
        const response = await axios.get("/bottleSize");
        this.bottles = response.data.bottles;
        this.clearMixer();
        setTimeout(() => {
          this.enterGrid();
        }, 0);
      } catch (error) {
        console.log(error);
      }
    },
    // gsap hover-Animations
    hoverEnter(obj) {
      gsap.to(obj.target, { duration: 0.2, scale: 1.05 });
    },
    hoverLeave(obj) {
      gsap.to(obj.target, { duration: 0.2, scale: 1 });
    },
    // loops through all bottles and applies a GSAP animation to each bottle card element to move it from either the left or right side of the page to the center
    enterGrid() {
      for (let i = 1; i <= this.bottles.length; i++) {
        let element = document.getElementById("bottle-card" + i);
        let start = 1400;
        if (i % 2 == 0) {
          start = -1400;
        }
        gsap.fromTo(element, { x: start }, { duration: 1, x: 0 });
      }
    },
    // clears the ingredients stored for the mixer in sessionStorage
    clearMixer() {
      sessionStorage.setItem("ingredientsArray", JSON.stringify([]));
    },
    // navigates to the next side after set the actual bottle size
    async storeBottle(bottle) {
      try {
        await axios.get("/schritt1/" + bottle.id);
        this.$router.push({ path: "/chooseIngredient" });
      } catch (error) {
        console.error(error);
      }
    },
  },
};
</script>
