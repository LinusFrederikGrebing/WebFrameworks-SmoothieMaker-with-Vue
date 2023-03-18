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
              Smoothie aus 250ml, 500ml, 750ml oder sogar 1l leckeren Zutaten
              bestehen soll. Den Smoothie kannst du kostenlos und ohne Anmeldung
              zusammenstellen. Bei Kauf errechnet sich der Preis deines Getränks
              aus den Einzelpreisen der Zutaten.
            </h5>
            <button class="mx-5 mb-5 green-bg custom-btn" @click="showStep1()">
              Beginne mit der Zusammenstellung
            </button>
          </div>
        </v-col>
        <v-col
          cols="6"
          xl="6"
          md="10"
          sm="10"
          style="
            transform: scale(1) perspective(1040px) rotateY(-11deg)
              rotateX(2deg) rotate(2deg);
          "
        >
          <v-card elevation="10 mt-8" id="right-img">
            <v-img src="/images/smoothie.jpg"></v-img>
          </v-card>
        </v-col>
      </v-row>
      <v-row id="" class="my-6 mx-6">
          <div class="ml-auto mr-auto mt-4">
            <h2 class="text-center font-weight-bold">
              Hier kannst du deine abgespeicherten Zusammenstellungen aufrufen!
            </h2>
          </div>
      </v-row>
      <div>
        <v-row class="mx-auto ml-16 mb-8" no-gutters>
          <v-col
            sm="12"
            md="6"
            xl="4"
            lg="4"
            v-for="(preset, index) in presetNames" :key="index"
          ><div class="mx-8 mb-4 d-flex">
            <v-btn class="w-75 py-4" @click="choosePreset(preset)">{{ preset }}</v-btn>
            <v-btn class="w-25 py-4" @click="deletePreset(preset)"> <v-icon color="red">mdi-delete</v-icon></v-btn>
          </div>
          </v-col>
        </v-row>
      </div>
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
      <div id="tipsheader" class="seperate">
        <div
          elevation="10"
          class="d-flex flex-column justify-center text-center my-6 mx-6"
        >
          <div class="my-6 mx-6">
            <h2 class="font-weight-bold">Unsere Smoothie-Tipps der Woche</h2>
            <p>
              Hier findest du unsere Smoothie-Geheimtipps. Lasse dich gerne von
              unseren Top-Vorschlägen inspirieren!
            </p>
          </div>
        </div>
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
            <v-card class="rounded-lg">
              <v-card-text>
                <div>
                  <h4
                    class="my-6 mx-6 text-h4 font-weight-bold"
                    v-text="item.title"
                  ></h4>
                  <p class="my-6 mx-6" v-text="item.text"></p>
                  <button class="mx-5 mb-5 green-bg custom-btn" @click="choosePreset(item.title)">
                   Wählen
                  </button>
                </div>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12">
            <v-divider></v-divider>
          </v-col>
        </v-row>
      </div>
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
      presetNames: [],
      items: [
        {
          icon: "aspect_ratio",
          title: "Schritt 1",
          text: "Wähle deine Smoothiegröße aus! Du hast die Wahl zwischen 250ml, 500ml, 750ml und 1000ml",
        },
        {
          icon: "manage_search",
          title: "Schritt 2",
          text: "Bei Schritt 2 hast Du die Auswahl aus vielen verschiedenen Früchten.",
        },
        {
          icon: "check",
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
    deletePreset(presetName){
      axios.get(`/deletePreset/${presetName}`).then((response) => {
       this.getPresets();
      });
    },
    getPresets(){
      axios.get('/user-presets')
      .then(response => {
        this.presetNames = response.data.userPresets;
      })
      .catch(error => {
        console.log(error);
      });
    },
    choosePreset(presetName){
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
  },
  mounted() {
    this.getPresets();
    this.fadeInAnimation();
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

.seperate {
  margin-bottom: 15em !important;
  margin-top: 10em !important;
}

.item-icon {
  scale: 2.5;
}
</style>
