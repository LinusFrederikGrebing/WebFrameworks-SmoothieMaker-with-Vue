<template>
  <div elevation="10" class="seperate my-8 mx-8">
    <v-row id="stepsheader" class="my-6 mx-6">
      <div class="ml-auto mr-auto mt-4">
        <h2 class="text-center font-weight-bold">
          Nur drei Schritte bis zu deinem Smoothie!
        </h2>
      </div>
    </v-row>
    <v-divider width="80%" class="ml-auto mr-auto"></v-divider>
    <v-row id="steps" class="grid gap-8 row-gap-0 lg:grid-cols-3 my-6 mx-6">
      <v-col
        class="relative text-center"
        cols="12"
        md="4"
        v-for="(item, index) in items"
        :key="index"
        :id="'step' + (index + 1)"
      >
        <div
          class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-indigo-50 sm:w-20 sm:h-20"
        >
          <span class="material-symbols-outlined item-icon">
            {{ item.icon }}
          </span>
        </div>
        <div class="d-flex">
          <div>
            <h4 class="mb-2" v-text="item.title"></h4>
            <p
              class="max-w-md mb-3 text-sm text-gray-900 sm:mx-auto"
              v-text="item.text"
            ></p>
          </div>
          <div
            class="top-0 right-0 flex items-center justify-center h-24 lg:-mr-8 lg:absolute"
          >
            <v-icon
              class="w-8 text-gray-700 transform rotate-90 lg:rotate-0"
              stroke-width="2"
              v-if="index != items.length - 1"
            >
              mdi-arrow-right
            </v-icon>
          </div>
        </div>
      </v-col>
    </v-row>
  </div>
</template>
  
  <script>
import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";
gsap.registerPlugin(ScrollTrigger);

export default {
  name: "StepsComponent",
  data() {
    return {
      items: [
        {
          icon: "aspect_ratio",
          title: "Schritt 1",
          text: "Wähle deine Smoothiegröße aus! Du hast die Wahl zwischen 500ml, 750ml, 1000ml oder sogar 1250ml",
        },
        {
          icon: "manage_search",
          title: "Schritt 2",
          text: "Bei Schritt 2 hast Du die Auswahl aus vielen verschiedenen Früchten.",
        },
        {
          icon: "check",
          title: "Schritt 3",
          text: "Wähle abschließend Deine Flüssigkeit. Danach kannst du dein Zusammenstellung noch einmal überprüfen und deinen Kauf abschließen!",
        },
      ],
    };
  },
  mounted() {
    gsap
      .timeline({
        delay: 0,
        scrollTrigger: {
          trigger: "#steps",
          start: "top 100%",
          end: "bottom 0%",
          toggleActions: "play reset play reset ",
        },
      })
      .fromTo(
        "#stepsheader",
        {
          delay: 0,
          opacity: 0,
        },
        {
          opacity: 1,
        }
      )
      .fromTo(
        "#step1",
        {
          delay: 0.5,
          y: 300,
          opacity: 0,
        },
        {
          opacity: 1,
          y: 0,
        }
      )
      .fromTo(
        "#step2",
        {
          y: 300,
          delay: 0.5,
          opacity: 0,
        },
        {
          opacity: 1,
          y: 0,
        }
      )
      .fromTo(
        "#step3",
        {
          delay: 0.5,
          y: 300,
          opacity: 0,
        },
        {
          opacity: 1,
          y: 0,
        }
      );
  },
};
</script>

  