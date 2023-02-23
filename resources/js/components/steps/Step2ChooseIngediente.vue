<template>
  <div class="container">
    <ProgressbarComponent ref="progressComponent" />
    <SizeComponent ref="sizeComponent" />
    <v-row class="mt-5">
      <v-col class="mb-5" cols="12">
        <v-card class="mx-auto d-flex flex-wrap">
          <v-btn
            class="mx-auto flex-grow-1"
            v-for="(category, index) in categories"
            :key="index"
          >
            <img
              width="20"
              height="20"
              class="my-2"
              :src="category.icon"
              :alt="category.title"
            />
            {{ category.title }}
          </v-btn>
        </v-card>
      </v-col>
      <v-col cols="12" md="8" class="mb-2 mt-2">
        <v-row>
          <v-col
            v-for="(zutat, index) in zutaten"
            :key="index"
            cols="12"
            sm="6"
            md="4"
            lg="3"
          >
            <v-card class="mx-auto mb-4" max-width="400">
              <v-img
                class="white--text align-end"
                height="150px"
                :src="'/images/' + zutat.image"
              >
                <v-card-title>
                  <span class="font-weight-bold">{{ zutat.name }}</span>
                  <div>Preis: {{ zutat.price }}€</div>
                </v-card-title>
              </v-img>
              <v-card-actions>
                <v-form enctype="multipart/form-data" method="post">
                  <v-container>
                    <v-row>
                      <v-input v-model="selectedAmounts[index]">
                        <div class="d-flex align-items-center">
                          <v-btn
                            icon
                            width="45"
                            @click.prevent="increaseSelectedAmount(index)"
                            ><v-icon>mdi-plus</v-icon></v-btn
                          >
                          <div width="15" :complete="false">
                            {{ selectedAmounts[index] }}
                          </div>
                          <v-btn
                            icon
                            width="45"
                            @click.prevent="decreaseSelectedAmount(index)"
                            ><v-icon>mdi-minus</v-icon>
                          </v-btn>
                          <v-btn
                            class="white--text"
                            color="primary"
                            type="submit"
                            @click.prevent="
                              addToCart(zutat, selectedAmounts[index])
                            "
                          >
                            <i style="color: black" class="material-icons"
                              >shopping_cart</i
                            >
                          </v-btn>
                        </div>
                      </v-input>
                    </v-row>
                  </v-container>
                </v-form>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
        <v-row>
          <v-col class="mb-5" cols="12">
            <v-card class="mx-auto d-flex flex-wrap">
              <v-btn
                color="error"
                class="mx-auto flex-grow-1"
                @click="showBottleSize()"
              >
                Zurück
              </v-btn>
              <v-btn
                color="success"
                class="mx-auto flex-grow-1"
                @click="showStep3()"
              >
                Weiter
              </v-btn>
            </v-card>
          </v-col>
        </v-row>
      </v-col>
      <v-col cols="12" md="4">
        <div class="mb-5" max-width="400">
          <MixerComponent ref="mixerComponent" />
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
  name: "ChooseBottleSize",
  components: {
    MixerComponent,
    ProgressbarComponent,
    SizeComponent,
  },
  data() {
    return {
      categories: [
        {
          route: 1,
          icon: "/images/fruitsicon.png",
          title: "Früchte",
        },
        {
          route: 1,
          icon: "/images/vegetablesicon.png",
          title: "Gemüse",
        },
        {
          route: 1,
          icon: "/images/liquidicon.png",
          title: "Flüssigkeit",
        },
      ],
      zutaten: {},
      selectedAmounts: null,
    };
  },
  beforeUnmount() {
    this.$refs.mixerComponent.clearInterval();
  },
  created() {
   this.getIngredientsList();
  },
  methods: {
    getIngredientsList(){
       axios.get("/ingrediente")
        .then((response) => {
            this.zutaten = response.data.zutaten;
            this.selectedAmounts = Array(this.zutaten.length).fill(1);
        })
        .catch((err) => {
            console.log(err);
        });
    },
    increaseSelectedAmount(index) {
      if (this.selectedAmounts[index] < 20) {
        this.selectedAmounts[index]++;
      }
    },
    decreaseSelectedAmount(index) {
      if (this.selectedAmounts[index] > 1) {
        this.selectedAmounts[index]--;
      }
    },
    showStep3() {
      this.$router.push({ path: "/shop" });
    },
    showBottleSize() {
      this.$router.push({ path: "/chooseBottleSize" });
    },
    addToCart(zutat, amount) {
      axios.post("/addCart/" + zutat.id, {
          amount: amount,
        })
        .then((response) => {
          this.$refs.mixerComponent.setImg(response.data.image, response.data.reqCount);
          this.$refs.sizeComponent.getCartCount();
          this.$refs.progressComponent.getProgress();
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
  mounted() {},
};
</script>
