<template>
  <div class="container">
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
              :id="'liquid-card'+index"
            >
              <div>
                <v-img
                  class="white--text align-end ml-auto mr-auto mt-1 mb-1"
                  height="60px"
                  width="60px"
                  :src="'/images/piece/' + liquid.image"
                >
                </v-img>
                <div class="d-flex justify-center align-center flex-column">
                  <p class="font-weight-bold ml-1 mr-1">{{ liquid.name }}:</p>
                  <p>{{ liquid.price }}€ / 50ml</p>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <button
                    color="success"
                    class="ml-4 mr-4 flex-grow-1 green-bg custom-btn"
                    @click="selectCard(liquid)"
                  >
                    Wählen!
                  </button>
                </div>
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
    liquids() {
      setTimeout(() => {
        this.enterGrid();
      }, 0);
    },
  },
  computed: {
    selectedCardClass() {
      return {
        "selected-card": this.selectedCard !== null,
      };
    },
  },
  beforeUnmount() {
    this.$refs.mixerComponent.clearInterval();
  },
  mounted() {
    this.getLiquidList();
    this.getActLiquid();
  },
  methods: {
    hoverEnter(obj) {
      gsap.to(obj.target, {
        duration: 0.2,
        scale: 1.05,
        opacity: 1,
      });
    },
    hoverLeave(obj) {
      gsap.to(obj.target, { duration: 0.2, scale: 1, opacity: 1 });
    },
    getLiquidList() {
      axios.get("/api/liquid").then((response) => {
        this.liquids = response.data.ingredientsList;
      });
    },
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
    liquidAnimation(liquid) {
      this.$refs.mixerComponent.liquidAnimation(liquid.image);
    },
    selectCard(liquid) {
      this.liquidAnimation(liquid);
      this.liquid = liquid;
      this.selectedCard = liquid.id;
    },
    showStep3() {
      this.$router.push({ path: "/shop" });
      if (Object.keys(this.liquid).length !== 0) {
        this.addToCart(this.liquid, 1);
      }
    },
    showStep2() {
      this.$router.push({ path: "/chooseIngrediente" });
    },
    clearMixer() {
      sessionStorage.setItem("ingredientsArray", JSON.stringify([]));
    },
    addToCart(ingredient, amount) {
      axios.post(`/addCart/${ingredient.id}`, { amount });
    },
    enterGrid() {
      for (let i = 0; i < this.liquids.length; i++) {
        let element = document.getElementById("liquid-card" + i);
        gsap.fromTo(
          element,
          {
            y: -1000,
            x: -1000,
          },
          {
            delay: Math.random() / 2,
            duration: 2,
            y: 0,
            x: 0,
          }
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
.size-image {
  margin-left: -1em;
}
.item-list {
  height: 42em;
  overflow-y: scroll;
}
.card-color {
  background-color: rgb(229 231 235);
}
.selected-card {
  border: 4px solid #80ba24;
}
</style>