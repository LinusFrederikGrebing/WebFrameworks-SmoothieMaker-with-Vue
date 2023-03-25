<template>
  <div>
    <div id="tipsheader" class="seperate">
      <div elevation="10" class="d-flex flex-column justify-center text-center my-6 mx-6">
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
      <v-row v-for="(item, index) in smoothieItems" :key="index" class="tip mx-16">
        <v-col cols="12" md="6" :order="index % 2 === 0 ? 1 : 2">
          <div class="rounded-lg">
            <v-img :src="item.src" alt="" height="400" contain class="rotate-x-2 rotate-y-11 rotate--2"></v-img>
          </div>
        </v-col>
        <v-col cols="12" md="6" :order="index % 2 === 0 ? 2 : 1" class="d-flex flex-column align-center justify-center">
          <v-card elevation="5" class="rounded-lg">
            <v-card-text>
              <div>
                <h4 class="my-6 mx-6 text-h4 font-weight-bold" v-text="item.title"></h4>
                <p class="my-6 mx-6" v-text="item.text"></p>
                <v-row class="d-flex justify-end mx-6">
                  <v-col cols="auto">
                    <a @click="storeExistingPreset(item.title)" class="mr-4 text-black">Speichern?</a>
                    <v-btn @click="choosePreset(item.title)" color="black">
                      Wählen!
                    </v-btn>
                  </v-col>
                </v-row>
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
  </div>
</template>
  
<script>
import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";
gsap.registerPlugin(ScrollTrigger);
import { showAlertSuccess, showAlertError } from '../steps/alerts';

export default {
  name: "SmoothieTipsComponent",
  data() {
    return {
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
  mounted() {
    // gsap scrolltrigger-Animation
    const tips = document.querySelectorAll(".tip");
    tips.forEach((tip, index) => {
      gsap.fromTo(tip,
        { y: 0, x: index % 2 === 0 ? 1000 : -1000, opacity: 0 },
        { opacity: 1, x: 0, scrollTrigger: 
          {
            trigger: tip, start: "top 90%", end: "bottom 95%", scrub: true, id: "scrub" 
          },
        }
      );
    });
  },
  methods: {
    // sends an axios GET request to check if a preset with the given name exists, then pushes the user to the "/shop" page if it does.
    choosePreset(presetName) {
      axios.get(`/checkPreset/${presetName}`).then(() => {
        this.$router.push({ path: "/shop" });
      });
    },
    // Sends an axios GET request to store a preset with the given name. If the user is not authenticated, it shows an error message, and if successful, it shows a success message. 
    // If the name already exists, it shows an error message with a suggestion to choose a different name. Names are unique for specific users
    storeExistingPreset(presetName) {
      axios.get(`/storeExistingPreset/${presetName}`)
        .then((response) => {
          if (response.data.auth == false) {
            showAlertError("Du must angemeldet sein, um dir das Preset abspeichern zu können!","");
          } else {
            showAlertSuccess("Das Preset wurde erfolgreich gespeichert!", "Wenn du auf dein Profilnamen klickst und zur Homepage gehst, kannst du das Preset auswählen und deine Zusammenstellung abfrufen!");
          }
        })
        .catch(() => {
          showAlertError("Den Namen für das Preset gibt es bereits!", "Wähle einen anderen Namen, oder lösche das bestehende Preset!");
        });
    },
  }
};
</script>

  