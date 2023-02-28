<template>
  <div class="mt-3">
    <div class="d-flex">
      <h5 class="font-weight-bold">Smoothie-Größe: {{ bottle.name }}</h5>
      <button class="showBottleSizes" @click="showBottleSizes">
        <v-icon small class="ml-3 mb-1">mdi-pencil</v-icon>
      </button>
    </div>

    <p>
      Aktuell hast du <b class="cart-count"> {{ cartCount }} </b> von
      <b>{{ bottle.amount }}</b> für Größe {{ bottle.name }} benötigte Zutaten
      ausgewählt.
    </p>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      cartCount: null,
      bottle: {},
    };
  },
  created() {},
  mounted() {
    this.getCartCount();
  },
  methods: {
    getCartCount() {
      axios
        .get("/cart/count")
        .then((response) => {
          this.cartCount = response.data.cartCount;
          this.bottle = response.data.bottle;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    showBottleSizes() {
      Swal.fire({
        title: "Bist du Dir sicher?",
        text: "Deine komplette Zusammenstellung wird bei Größenänderung unwiederruflich gelöscht!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#6D9E1F",
        cancelButtonColor: "#d33",
        confirmButtonText: "Andere Größe wählen!",
        cancelButtonText: "Abbrechen!",
      }).then((result) => {
        if (result.isConfirmed) {
          this.$router.push({ path: "/chooseBottleSize" });
        }
      });
    },
  },
};
</script>
  
<style scoped>
p {
  margin-bottom: 0;
}
h5 {
  margin-bottom: 0;
}
</style>