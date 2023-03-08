<template>
  <v-container>
    <div class="text-center mx-4 mt-8">
      <h2 class="font-weight-bold">Wähle jetzt deine Smoothie-Größe!</h2>
    </div>
    <v-row class="mx-auto ml-16 mb-8 w-70" no-gutters>
      <v-col
        sm="12"
        md="12"
        xl="6"
        lg="12"
        xs="12"
        v-for="bottle in bottles"
        :key="bottle.id"
      >
        <v-card
          :id="'bottle-card' + bottle.id"
          class="my-4 mx-4 card-color"
          elevation="10"
          min-height="300"
          @mouseenter="hoverEnter($event)"
          @mouseleave="hoverLeave($event)"
        >
          <v-row>
            <div class="d-flex">
              <img
                class="size-image mt-4"
                :src="'/images/' + bottle.image"
                :alt="bottle.name"
                style="width: 17em; height: 100%; object-fit: contain"
              />
              <div class="mt-8">
                <h4 class="mr-8 font-weight-bold">Größe: {{ bottle.name }}</h4>
                <p class="mr-8 mb-4">{{ bottle.description }}</p>
                <button
                  class="mr-4 my-4 green-bg custom-btn"
                  @click="storeBottle(bottle)"
                >
                  Weiter
                </button>
              </div>
            </div>
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
  async mounted() {
    try {
      const response = await axios.get("/bottleSize");
      this.bottles = response.data.bottles;
      this.clearMixer();
      setTimeout(() => {
        this.enterGrid()
      }, 0);
    } catch (error) {
      console.log(error);
    }
  },
  methods: {
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
      for (let i = 1; i <= this.bottles.length; i++) {
        let element = document.getElementById("bottle-card" + i);
        let start = 1400;
        if(i % 2 == 0) { start = -1400 } 
        gsap.fromTo(
          element,
          {
            x: start
          },
          {
            duration: 1,
            x: 0
          }
        );
      }
    },
    clearMixer() {
      sessionStorage.setItem("ingredientsArray", JSON.stringify([]));
    },
    async storeBottle(bottle) {
      try {
        await axios.get("/schritt1/" + bottle.id);
        this.$router.push({ path: "/chooseIngrediente" });
      } catch (error) {
        console.error(error);
      }
    },
  },
};
</script>
<style scoped>
.w-70 {
  width: 75%;
}
.size-image {
  margin-left: -1em;
}
.card-color {
  background-color: rgb(229 231 235);
}
</style>