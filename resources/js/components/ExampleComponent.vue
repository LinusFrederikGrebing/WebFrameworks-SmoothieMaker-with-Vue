<template>
  <v-container class="d-flex justify-content-center my-16">
    <v-card
      width="600"
      style="
        transform: scale(1) perspective(1040px) rotateY(21deg) rotateX(-2deg)
          rotate(-2deg);
      "
    >
      <h1 class="mx-4 my-4">Smoothiemaker</h1>
      <v-card-text class="mx-4 my-4"
        >Stelle Dir jetzt deinen perfekten Smoothie zusammen! Deine Auswahl
        erstreckt sich aus einer Vielzahl verschiedener Zutaten. Es gibt vier
        veschiedene Smoothie-Größen. Du kannst entscheiden, ob dein Smoothie aus
        250ml, 500ml, 750ml oder sogar 1l leckeren Zutaten bestehen soll. Den
        Smoothie kannst du kostenlos und ohne Anmeldung zusammenstellen. Bei
        Kauf errechnet sich der Preis deines Getränks aus den Einzelpreisen der
        Zutaten.
      </v-card-text>
      <v-btn class="mx-4 my-4" @click="showInhalt()"
        >Beginne mit der Zusammenstellung</v-btn
      >
    </v-card>

    <img
      width="650"
      height="400"
      id="right-img"
      src="/images/smoothie.jpg"
      style="
        transform: scale(1) perspective(1040px) rotateY(-11deg) rotateX(2deg)
          rotate(2deg);
      "
      alt=""
    />
  </v-container>
</template>

<script>
export default {
  name: "example-component",
  methods: {
    showInhalt() {
      window.location = "/custom/bottleSize";
    },
  },
};
</script>

