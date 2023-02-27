<template>
  <div class="container">
    <ProgressbarComponent ref="progressComponent" />
    <SizeComponent ref="sizeComponent" />
    <v-row class="mt-5">
      <v-col class="mb-5" cols="12">
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
      <v-col cols="12" md="8" class="mb-2 mt-2">
        <v-row>
          <v-col
            v-for="(ingrediente, index) in ingredients"
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
                :src="'/images/' + ingrediente.image"
              >
                <v-card-title>
                  <span class="font-weight-bold">{{ ingrediente.name }}</span>
                  <div>Preis: {{ ingrediente.price }}€</div>
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
                              addToCart(ingrediente, selectedAmounts[index])
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
          active: true
        },
        {
          icon: "/images/vegetablesicon.png",
          title: "Gemüse",
          url: "/vegetables",
          active: false
        },
        {
          icon: "/images/liquidicon.png",
          title: "Flüssigkeit",
          url: "/liquid",
          active: false
        },
      ],
      ingredients: [],
      selectedAmounts: [],
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
      for(let i = 0; i < this.categories.length; i++){
        if(this.categories[i] === category){
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
        .catch((error) => {
          console.error(error);
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
  },
};
</script>
