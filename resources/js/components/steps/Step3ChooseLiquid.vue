<template>
  <div class="container">
    <div class="text-center my-4 mx-4">
      <h2 class="font-weight-bold">
        Wähle jetzt abschließend deine Flüssigkeit!
      </h2>
    </div>
    <v-row no-gutters>
      <v-col cols="12" md="8" class="mb-1 mt-1">
        <v-row class="item-list">
          <v-col
        sm="12"
        md="12"
        xl="6"
        lg="12"
        xs="12"
        v-for="liquid in liquids"
        :key="liquid.id"
      >
        <v-card
          :class="{ 'selected-card': liquid.id === selectedCard }"
          class="my-2 mx-2 card-color"
          elevation="10"
        >
          <div>
            <v-img
              class="white--text align-end ml-auto mr-auto mt-1 mb-1"
              height="60px"
              width="60px"
              :src="'/images/piece/' + liquid.image"
            >
            </v-img>
            <div class="d-flex justify-center">
              <hr />
              <p class="font-weight-bold ml-1 mr-1">{{ liquid.name }}:</p>
              <hr />
              <p>{{ liquid.price }}€ / 50g</p>
            </div>
            <div class="d-flex align-items-center mb-2">
              <button
                color="success"
                class="ml-4 mr-4 flex-grow-1 grey-active-bg custom-btn"
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
      liquids: [],
      selectedCard: null,
      liquid: {},
    };
  },
  computed: {
    selectedCardClass() {
      return {
        "selected-card": this.selectedCard !== null,
      };
    },
  },
  mounted() {
    this.getLiquidList();
    this.getActLiquid();
  },
  methods: {
    getLiquidList(){
      axios.get("/liquid").then((response) => { this.liquids = response.data.ingrediente; })
    },
    getActLiquid(){
      axios.get("/getAktLiquid").then((response) => { 
      var response = response.data.liquidItems;
      Object.keys(response).forEach((key) => {
        this.liquid = response[key];
        this.selectCard(this.liquid);
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
      if(this.liquid !== []) {
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
      axios.post(`/addLiquidToCart/${ingredient.id}`, { amount });
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