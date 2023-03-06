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
            v-for="(ingrediente, index) in ingredients"
            :key="index"
            cols="15"
            sm="6"
            md="3"
            lg="auto"
          >
            <v-card elevation="5" class="mx-auto" max-width="400">
             <div>
              <v-img
                class="white--text align-end ml-auto mr-auto mt-1 mb-1"
                height="60px"
                width="60px"
                :src="'/images/piece/' + ingrediente.image"
              >
              </v-img>
              <div class="d-flex justify-center">
                <hr>
                <p class="font-weight-bold ml-1 mr-1">
                  {{ ingrediente.name }}:
                </p>
                <hr>
                <p>{{ ingrediente.price }}€ / 50g</p>
              </div>
                <v-form enctype="multipart/form-data" method="post">
                  <div class="d-flex align-items-center mb-2">
                    <button
                      class="w-30px"
                      @click.prevent="increaseSelectedAmount(index)"
                      ><v-icon>mdi-plus</v-icon></button
                    >
                    <div width="15" :complete="false">
                      {{ selectedAmounts[index] }}
                    </div>
                    <button
                      class="w-30px"
                      @click.prevent="decreaseSelectedAmount(index)"
                      ><v-icon>mdi-minus</v-icon>
                    </button>
                    <button
                      class="white--text bg-white w-40px"
                      type="submit"
                      @click.prevent="
                        addToCart(ingrediente, selectedAmounts[index])
                      "
                    >
                      <i style="color: black" class="material-icons"
                        >shopping_cart</i
                      >
                    </button>
                  </div>
                </v-form>
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
                @click="removeAllAlert()"
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
  name: "Step2ChooseIngrediente",
  components: {
    MixerComponent,
    ProgressbarComponent,
    SizeComponent,
  },
  data() {
    return {
      categories: [
        {
          icon: "/images/fruitsicon.png",
          title: "Früchte",
          url: "/fruits",
          active: true,
        },
        {
          icon: "/images/vegetablesicon.png",
          title: "Gemüse",
          url: "/vegetables",
          active: false,
        }
      ],
      ingredients: [],
      selectedAmounts: [],
      liquid: null,
    };
  },
  beforeUnmount() {
    this.$refs.mixerComponent.clearInterval();
  },
  methods: {
    handleCategoryClick(category) {
      this.getIngredientsList(category.url);
      this.setCategoriesActive(category);
    },
    setCategoriesActive(category) {
      for (let i = 0; i < this.categories.length; i++) {
        if (this.categories[i] === category) {
          this.categories[i].active = true;
        } else {
          this.categories[i].active = false;
        }
      }
    },
    getIngredientsList(url) {
      axios
        .get(url)
        .then((response) => {
          this.ingredients = response.data.ingrediente;
          this.selectedAmounts = Array(this.ingredients.length).fill(1);
        })
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
      this.$router.push({ path: "/chooseLiquid" });
    },
    showBottleSize() {
      this.$router.push({ path: "/chooseBottleSize" });
    },
    addToCart(ingredient, amount) {
      axios
        .post(`/addCart/${ingredient.id}`, { amount })
        .then((response) => {
          if (response.data.stored) {
            const { image, reqCount } = response.data;
            this.$refs.mixerComponent.setImg(image, reqCount);
            this.$refs.sizeComponent.getCartCount();
            this.$refs.progressComponent.getProgress();
          } else {
            this.showAlertTooMany();
          }
        })
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
    removeAllAlert() {
      Swal.fire({
        title: "Bist du Dir sicher?",
        text: "Wenn du zurückgehst wird deine bisherige Zusammenstellung unwiederruflich gelöscht!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#6D9E1F",
        cancelButtonColor: "#d33",
        confirmButtonText: "Weiter zurück!",
        cancelButtonText: "Abbrechen!",
      }).then((result) => {
        if (result.isConfirmed) {
          this.$router.push({ path: "/chooseBottleSize" });
        }
      });
    },

    showAlertTooMany() {
      Swal.fire({
        title: "Du hast zu viele Zutaten ausgewählt!",
        text: "",
        icon: "error",
        showCancelButton: false,
        confirmButtonColor: "#6D9E1F",
        confirmButtonText: "Okay!",
      });
    },
  },
  created() {
    this.getIngredientsList("/fruits");
    this.getActLiquid();
  },
};
</script>
<style scoped>
p {
  margin-bottom: 0;
}
.w-30px {
  width: 39px
}
.w-40px {
  width: 60px
}
.item-list {
  height: 42em;
  overflow-y: scroll;
}
</style>
