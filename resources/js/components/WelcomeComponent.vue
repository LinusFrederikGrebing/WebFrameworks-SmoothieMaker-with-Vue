<template>
  <v-container class="container">
      <v-row class="mt-16 mb-16 seperate">
        <v-col cols="6" md="12" xl="6"  style="
          transform: scale(1) perspective(1040px) rotateY(21deg) rotateX(-2deg)
            rotate(-2deg);
        ">
          <h1 class="mx-4 my-4">Smoothiemaker</h1>
        <v-card-text class="mx-4 my-4 mb-16"
          >Stelle Dir jetzt deinen perfekten Smoothie zusammen! Deine Auswahl
          erstreckt sich aus einer Vielzahl verschiedener Zutaten. Es gibt vier
          veschiedene Smoothie-Größen. Du kannst entscheiden, ob dein Smoothie
          aus 250ml, 500ml, 750ml oder sogar 1l leckeren Zutaten bestehen soll.
          Den Smoothie kannst du kostenlos und ohne Anmeldung zusammenstellen.
          Bei Kauf errechnet sich der Preis deines Getränks aus den
          Einzelpreisen der Zutaten.
        </v-card-text>
        <v-btn class="mx-4 my-4" @click="showInhalt()">Beginne mit der Zusammenstellung</v-btn>
        </v-col>
        <v-col cols="6" xl="6" md="12" style="
          transform: scale(1) perspective(1040px) rotateY(-11deg) rotateX(2deg)
            rotate(2deg);
        " >
          <v-img   src="/images/smoothie.jpg" ></v-img>
        </v-col>
      </v-row>
      <v-row
        id="stepsheader"
        class="mt-16 mb-16"
      ><div class="text-center">
        <h2>Nur drei Schritte bis zu deinem Smoothie!</h2>
        <p>
          An warmen Tagen sind erfrischende Drinks wichtiger, denn je! Und
          Smoothies sind als Erfrischung (und auch als Frühstück) dafür einfach
          perfekt. Sie sind gesund, voller Vitamine und machen fit für den Tag.
          Ich kriege von Smoothies diesen Sommer auf jeden Fall nicht genug.
          Deswegen schnapp‘ dir auch einen und lass uns auf dem Balkon, Terrasse
          oder in meinem Fall im Park chillen.
        </p>
      </div>
        
      </v-row>
      <v-row class="grid gap-8 row-gap-0 lg:grid-cols-3">
        <v-col
          class="relative text-center"
          cols="12"
          md="4"
          v-for="(item, index) in items"
          :key="index"
          :id="'step' + (index+1)"
        >
          <div
            class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-indigo-50 sm:w-20 sm:h-20"
          >
            <v-icon
              class="w-12 h-12 text-deep-purple-accent-400 sm:w-16 sm:h-16"
            >
            mdi-polygon
            </v-icon>
          </div>
          <h4 class="mb-2" v-text="item.title"></h4>
          <p
            class="max-w-md mb-3 text-sm text-gray-900 sm:mx-auto"
            v-text="item.text"
          ></p>
          <div
            class="top-0 right-0 flex items-center justify-center h-24 lg:-mr-8 lg:absolute"
          >
            <v-icon
              class="w-8 text-gray-700 transform rotate-90 lg:rotate-0"
              stroke-width="2"
            >
              mdi-line-weight
            </v-icon>
          </div>
        </v-col>
      </v-row>
      <v-row
        id="tipsheader"
        class="p-4 mx-auto my-6 space-y-1 text-center"
      >
        <h4 class="pb-3 text-2xl font-bold md:text-3xl">
          Unsere Smoothie-Tipps der Woche
        </h4>
        <p>
          Hier findest du unsere Smoothie-Geheimtipps. Lasse dich gerne von
          unseren Top-Vorschlägen inspirieren!
        </p>
        </v-row>
        <v-row>
          <v-col cols="12">
            <v-divider></v-divider>
          </v-col>
        </v-row>
        <v-row
          v-for="(item, index) in smoothieItems"
          :key="index"
          class="tip mx-16"
        >
          <v-col cols="12" md="6" :order="index % 2 === 0 ? 1 : 2">
            <div class="rounded-lg">
              <v-img
                :src="item.src"
                alt=""
                height="400"
                contain
                class="rotate-x-2 rotate-y-11 rotate--2"
              ></v-img>
            </div>
          </v-col>
          <v-col
            cols="12"
            md="6"
            :order="index % 2 === 0 ? 2 : 1"
            class="d-flex flex-column align-center justify-center"
          >
            <div class="rounded-lg">
              <v-card-text>
                <h4 class="text-h4 font-weight-bold" v-text="item.title"></h4>
                <p class="my-6" v-text="item.text"></p>
              </v-card-text>
            </div>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12">
            <v-divider></v-divider>
          </v-col>
        </v-row>
  </v-container>
</template>

<script>
import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";
gsap.registerPlugin(ScrollTrigger);

export default {
  name: "example-component",
  data() {
    return {
      items: [
        {
          icon: "mdi-polygon",
          title: "Schritt 1",
          text: "Wähle deine Smoothiegröße aus! Du hast die Wahl zwischen 250ml, 500ml, 750ml und 1000ml",
        },
        {
          icon: "mdi-polygon",
          title: "Schritt 2",
          text: "Bei Schritt 2 hast Du die Auswahl aus vielen verschiedenen Früchten.",
        },
        {
          icon: "mdi-polygon",
          title: "Schritt 3",
          text: "Überprüfe deine Bestellung! Nach deiner Bestellung liefern wir Dir deine Smoothie-Zusammenstellung innerhalb von einer Stunde!",
        },
      ],
      smoothieItems: [
        {
          src: "/images/beerensmoothie.jpg",
          title: "Beeren-Smoothie mit Flohsamenschalen & Kokoswasser",
          text: "Dieser beerige Smoothie liefert viele wertvolle Ballaststoffe, wichtige Antioxidantien und Eisen. Er schmeckt fruchtig frisch und erhält eine leichte Schärfe durch den enthaltenen Ingwer. Der natürliche, fettfreie Iso-Drink aus der Kokosnuss - das Kokoswasser - rundet den Smoothie perfekt ab.",
        },
        {
          src: "/images/rucolasmoothie.jpg",
          title: "Grüner Smoothie mit Rucola",
          text: "Dieses Exemplar ist perfekt für alle, die sich gerade erst an dieses Metier herantrauen, denn Mango und Zitrone bieten noch viel Fruchtigkeit. Mit einem leistungsstarken Mixer werden die Fasern des Rucolas optimal aufgespalten und du erhältst einen samtigen Smoothie, der fast so fein wie Saft ist.",
        },
        {
          src: "/images/schokosmoothie.jpg",
          title: "Avocado-Schoko-Smoothie",
          text: "Schokolade zum Frühstück – mit diesem Smoothie ist das problemlos möglich. Dank Bananen, Avocado und Backkakao wird es nicht nur lecker, sondern auch gesund.",
        },
      ],
    };
  },
  methods: {
    showInhalt() {
      this.$router.push({ path: "/chooseBottleSize" });
    },
  },
  mounted() {
    gsap.fromTo(
      "#tipsheader",
      {
        opacity: 0,
      },
      {
        opacity: 1,
        scrollTrigger: {
          trigger: "#tipsheader",
          start: "top 90%",
          end: "bottom 95%",
          scrub: true,
          id: "scrub",
        },
      }
    );
    const tips = document.querySelectorAll(".tip");

    tips.forEach((tip, index) => {
      gsap.fromTo(
        tip,
        {
          y: 0,
          x: index % 2 === 0 ? 1000 : -1000,
          opacity: 0,
        },
        {
          opacity: 1,
          x: 0,
          scrollTrigger: {
            trigger: tip,
            start: "top 90%",
            end: "bottom 95%",
            scrub: true,
            id: "scrub",
          },
        }
      );
    });

    gsap
      .timeline({
        delay: 0,
        scrollTrigger: {
          trigger: "#steps",
          start: "top 80%",
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
<style scoped>
@media (min-width: 1400px) {
  .container-xxl, .container-xl, .container-lg, .container-md, .container-sm, .container {
    max-width: 1320px !important;
  }
}

.seperate {
  margin-bottom: 15em !important;
  margin-top: 15em !important;
}
</style>