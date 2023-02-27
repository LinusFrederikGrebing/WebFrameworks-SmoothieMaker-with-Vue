<template>
  <v-container>
    <div class="text-center my-4 mx-4">
      <h2 class="font-weight-bold">Wähle jetzt deine Smoothie-Größe!</h2>
    </div>
    <v-row class="mx-auto ml-16 mb-8 w-70" no-gutters>
      <v-col sm="12" md="12" xl="6" lg="12" xs="12" v-for="bottle in bottles" :key="bottle.id">
        <v-card class="my-4 mx-4 card-color" elevation="10" min-height="300">
          <v-row>
            <div class="d-flex">
                <img
                  class="size-image"
                  :src="'/images/' + bottle.image"
                  :alt="bottle.name"
                  style="width: 17em; height: 100%; object-fit: contain"
                />
              <div class="mt-8">
                <h4 class="mr-8 font-weight-bold">Größe: {{ bottle.name }}</h4>
                <p class="mr-8 mb-4">{{ bottle.description }}</p>
                <button class="mr-4 my-4 green-bg custom-btn" @click="storeBottle(bottle)">
                  Weiter
                </button>
              </div>
            </div>
          </v-row>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "Step1ChooseBottleSize",
  data() {
    return {
      bottles: [],
    };
  },
  async created() {
    try {
      const response = await axios.get("/bottleSize");
      this.bottles = response.data.bottles;
      this.clearMixer();
    } catch (error) {
      console.log(error);
    }
  },
  methods: {
    clearMixer(){
      sessionStorage.setItem("ingredientsArray", JSON.stringify([]))
    },
    async storeBottle(bottle) {
      try {
        await axios.get("/schritt1/" + bottle.id);
        this.$router.push({ path: "/chooseIngrediente" });
      } catch (error) {
        console.error(error);
      }
    },
  },
};
</script>
<style scoped>
.w-70{
  width: 65%;
}
.size-image{
  margin-left: -1em;
}
.card-color{
  background-color: rgb(229 231 235);
}
</style>