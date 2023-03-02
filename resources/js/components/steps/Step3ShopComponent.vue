<template>
  <div class="container">
    <SizeComponent ref="sizeComponent" />
    <v-row class="mt-2">
      <v-col class="mb-2" cols="12">
        <div class="mx-auto d-flex flex-wrap">
          <button
            color="success"
            class="mx-auto flex-grow-1 green-bg custom-btn"
            @click="showIngrediente()"
          >
            Weitere Zutaten hinzufügen
          </button>
          <button
            color="error"
            class="mx-auto flex-grow-1 red-bg custom-btn"
            @click="removeAllAlert()"
          >
            Alles aus dem Warenkorb entfernen
          </button>
        </div>
      </v-col>
      <v-col cols="12" md="8" class="mb-5">
        <v-row>
          <v-table density="compact" class="w-100">
            <thead>
              <tr>
                <th class="text-left">Image</th>
                <th class="text-left">Name</th>
                <th class="text-left">Preis</th>
                <th class="text-left">Menge</th>
                <th class="text-left">Remove</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(cart, index) in cartContent" :key="index">
                <td>
                  <img
                    width="75"
                    height="75"
                    :src="'/images/' + cart.options.image"
                    class="mt-2 mb-2"
                  />
                </td>
                <td>{{ cart.name }}</td>
                <td>{{ cart.price }} €/g </td>
                <td>
                  <div class="d-flex align-center">
                    <v-icon color="black" @click="addSpecificOne(cart)"
                      >mdi-plus</v-icon
                    >
                    <p class="mt-3 mx-2" :id="'qty' + cart.id">{{ cart.qty }}</p>
                    <v-icon color="black" @click="removeSpecificOne(cart)"
                      >mdi-minus</v-icon
                    >
                  </div>
                </td>
                <td>
                  <v-btn @click="removeSpecificCart(cart)"
                    ><v-icon color="red">mdi-delete</v-icon></v-btn
                  >
                </td>
              </tr>
            </tbody>
          </v-table>
        </v-row>
        <v-row>
          <p class="mt-8">Total: {{ cartSubTotal }}</p>
        </v-row>
        <v-row>
          <h4>Total inkl. MwSt: {{ cartTotal }}</h4>
        </v-row>
        <v-row>
          <button class="green-bg custom-btn">Jetzt kaufen</button>
        </v-row>
      </v-col>
      <v-col cols="12" md="4">
        <div class="mb-1" max-width="400">
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
  name: "Step3Shop",
  components: {
    MixerComponent,
    ProgressbarComponent,
    SizeComponent,
  },
  data() {
    return {
      cartContent: [],
      cartTotal: null,
      cartSubTotal: null,
    };
  },
  created() {
    this.getCartContent();
  },
  beforeUnmount() {
    this.$refs.mixerComponent.clearInterval();
  },
  methods: {
    getCartContent() {
      this.cartContent = [];
      axios.get("/cartContent").then((response) => {
        this.cartTotal = response.data.cartTotal;
        this.cartSubTotal = response.data.cartSubTotal;
        for (let key in response.data.cart) {
          this.cartContent.push(response.data.cart[key]);
        }
      });
    },
    removeAllFromCart() {
      axios.get("/removeAll").then((response) => {
        this.getCartContent();
        this.$refs.mixerComponent.removeAll();
        this.$refs.sizeComponent.getCartCount();
        this.$refs.progressComponent.getProgress();
        sessionStorage.clear();
      });
    },
    removeSpecificCart(cart) {
      axios
        .post("/deleteCart/" + cart.rowId, {})
        .then((response) => {
          this.getCartContent();
          this.$refs.mixerComponent.removeSpecificAll(response.data.image);
          this.$refs.sizeComponent.getCartCount();
          this.$refs.progressComponent.getProgress();
        })
        .catch((error) => {
          console.error(error);
        });
    },
    addSpecificOne(cart) {
      axios
        .post("/increaseCardQty/" + cart.rowId, {
          amount: 1,
        })
        .then((response) => {
          if (response.data.stored) {
            this.$refs.mixerComponent.setImg(response.data.image, 1);
            this.$refs.sizeComponent.getCartCount();
            this.$refs.progressComponent.getProgress();
            this.setnewAmount(response.data.newqty, response.data.id);
          } else {
            this.showAlertTooMany();
          }
        });
    },
    removeSpecificOne(cart) {
      axios
        .post("/decreaseCardQty/" + cart.rowId, {
          amount: 1,
        })
        .then((response) => {
          if (response.data.newqty > 0) {
            this.setnewAmount(response.data.newqty, response.data.id);
          } else {
            this.getCartContent();
          }
          this.$refs.mixerComponent.removeSpecificOne(response.data.image);
          this.$refs.sizeComponent.getCartCount();
          this.$refs.progressComponent.getProgress();
        });
    },
    setnewAmount(newCounter, id) {
      $("#qty" + id).html(newCounter);
    },
    showIngrediente() {
      this.$router.push({ path: "/chooseIngrediente" });
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
    removeAllAlert() {
      Swal.fire({
        title: "Bist du Dir sicher?",
        text: "Deine komplette Zusammenstellung wird unwiederruflich gelöscht!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#6D9E1F",
        cancelButtonColor: "#d33",
        confirmButtonText: "Zusammenstellung löschen!",
        cancelButtonText: "Abbrechen!",
      }).then((result) => {
        if (result.isConfirmed) {
          this.removeAllFromCart();
        }
      });
    },
  },
  mounted() {},
};
</script>

