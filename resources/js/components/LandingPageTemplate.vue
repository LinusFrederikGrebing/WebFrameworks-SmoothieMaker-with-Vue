<template>
  <v-container class="container">
    <v-row class="seperate">
      <v-col cols="6" md="10" xl="6" sm="10">
        <div elevation="10" id="left-text">
          <h1 class="mx-5 mt-5 font-weight-bold">Smoothiemaker</h1>
          <h5 class="mx-5 my-5">
            Stelle Dir jetzt deinen perfekten Smoothie zusammen! Deine Auswahl
            erstreckt sich aus einer Vielzahl verschiedener Zutaten. Es gibt
            vier veschiedene Smoothie-Größen. Du kannst entscheiden, ob dein
            Smoothie aus 500ml, 750ml, 1000ml oder sogar 1250ml leckeren Zutaten
            bestehen soll. Den Smoothie kannst du kostenlos und ohne Anmeldung
            zusammenstellen. Registriert kannst du deine eigenen
            Smoothie-Zusammenstellungen erstellen und zwischenspeichern. Bei
            Kauf errechnet sich der Preis Deines Getränks aus den Einzelpreisen
            der Zutaten.
          </h5>
          <button class="mx-5 mb-5 green-bg custom-btn" @click="showStep1()">
            Beginne mit der Zusammenstellung
          </button>
        </div>
      </v-col>
      <v-col cols="6" xl="6" md="10" sm="10" class="perspective-image">
        <v-card elevation="10 mt-8" id="right-img">
          <v-img src="/images/smoothie.jpg"></v-img>
        </v-card>
      </v-col>
    </v-row>
    <StepsComponent />
    <SmoothieTips />
  </v-container>
</template>

<script>
import SmoothieTips from "./landingpage/SmoothieTipsComponent.vue";
import StepsComponent from "./landingpage/StepsComponent.vue";
import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";
gsap.registerPlugin(ScrollTrigger);

export default {
  name: "LandingPageTemplate",
  components: {
    SmoothieTips,
    StepsComponent,
  },
  mounted() {
    this.fadeInAnimation();
  },
  methods: {
    choosePreset(presetName) {
      axios.get(`/checkPreset/${presetName}`).then((response) => {
        this.$router.push({ path: "/shop" });
      });
    },
    showStep1() {
      this.$router.push({ path: "/chooseBottleSize" });
    },
    fadeInAnimation() {
      gsap.fromTo(
        "#left-text",
        {
          scale: 0,
          opacity: 0,
          y: 200,
        },
        {
          y: 0,
          delay: 0.2,
          duration: 2,
          scale: 1,
          opacity: 1,
          ease: "power3.out",
        }
      );
      gsap.fromTo(
        "#right-img",
        {
          x: 500,
          scale: 0,
          opacity: 0,
        },
        {
          x: 0,
          delay: 0.2,
          duration: 2,
          scale: 1,
          opacity: 1,
          ease: "power3.out",
        }
      );
    },
  }
};
</script>
<style scoped>
@media (min-width: 1400px) {
  .container-xxl,
  .container-xl,
  .container-lg,
  .container-md,
  .container-sm,
  .container {
    max-width: 1320px !important;
  }
}
.perspective-image {
  transform: scale(1) perspective(1040px) rotateY(-11deg) rotateX(2deg)
    rotate(2deg);
}
</style>
