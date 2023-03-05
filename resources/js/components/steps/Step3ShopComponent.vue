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
        <div class="item-list">
        <v-row>
         <v-card elevation="5" class="w-95 ml-5 mt-3">
          <v-table density="compact">
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
                <tr
                  v-for="(cart, cartIndex) in ingredienteContent"
                  :key="cartIndex"
                >
                  <td>
                    <img
                      width="75"
                      height="75"
                      :src="'/images/piece/' + cart.options.image"
                      class="mt-2 mb-2"
                    />
                  </td>
                  <td>{{ cart.name }}</td>
                  <td>{{ cart.price }}€ / 50g</td>
                  <td>
                    <div class="d-flex align-center">
                      <v-icon color="black" @click="addSpecificOne(cart)"
                        >mdi-plus</v-icon
                      >
                      <p class="mt-3 mx-2" :id="'qty' + cart.id">
                        {{ cart.qty }}
                      </p>
                      <v-icon color="black" @click="removeSpecificOne(cart)"
                        >mdi-minus</v-icon
                      >
                    </div>
                  </td>
                  <td>
                    <v-btn @click="removeSpecificCart(cart)">
                      <v-icon color="red">mdi-delete</v-icon>
                    </v-btn>
                  </td>
                </tr>
            </tbody>
          </v-table>
          </v-card>
        </v-row>
        <v-row>
           <button
            color="success"
            class="ml-3 mr-8 mb-3 mt-5 w-95 flex-grow-1 green-bg custom-btn"
            @click="showStep3()"
          >
            Flüssigkeit ändern
          </button>
        </v-row>
        <v-row>
         <v-card elevation="5" class="w-95 ml-5 mt-3 mb-3">
          <v-table density="compact">
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
                <tr
                  v-for="(cart, cartIndex) in liquidContent"
                  :key="cartIndex"
                >
                  <td>
                    <img
                      width="75"
                      height="75"
                      :src="'/images/piece/' + cart.options.image"
                      class="mt-2 mb-2"
                    />
                  </td>
                  <td>{{ cart.name }}</td>
                  <td>{{ cart.price }}€ / 50g</td>
                  <td>   
                        {{ cart.qty }}
                  </td>
                  <td>
                    <v-btn @click="removeSpecificCart(cart)">
                      <v-icon color="red">mdi-delete</v-icon>
                    </v-btn>
                  </td>
                </tr>
            </tbody>
          </v-table>
         </v-card>
        </v-row>
      </div>   
        <v-row>
          <p class="mt-8">Total: {{ cartSubTotal }}</p>
        </v-row>
        <v-row>
          <h4>Total inkl. MwSt: {{ cartTotal }}</h4>
        </v-row>
        <v-row>
          <button class="green-bg custom-btn" @click="mixAnimation()">
            Jetzt kaufen
          </button>
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
      ingredienteContent: [],
      liquidContent: [],
      liquid: null,
    };
  },
  created() {
    this.getCartContent();
    axios.get("/getAktLiquid").then((response) => { 
      var response = response.data.liquidItems; 
      Object.keys(response).forEach((key) => {
        this.liquid = response[key];
        this.$refs.mixerComponent.liquidAnimation(this.liquid.options.image);
      });
    })
  },
  beforeUnmount() {
    this.$refs.mixerComponent.clearInterval();
  },
  methods: {
    showStep3() {
      this.$router.push({ path: "/chooseLiquid" });
    },
    getCartOfType(type) {
      return this.cartContent.filter((cart) => {
        return cart.options.type === type;
      });
    },
    mixAnimation() {
      this.$refs.mixerComponent.mixAnimation();
    },
    getCartContent() {
      this.cartContent = [];
      this.ingredienteContent = [];
      this.liquidContent = [];
      axios.get("/cartContent").then((response) => {
        this.cartTotal = response.data.cartTotal;
        this.cartSubTotal = response.data.cartSubTotal;
        for (let key in response.data.cart) {
          this.cartContent.push(response.data.cart[key]);
        }
        this.cartContent.forEach((cart) => {
        if(cart.options.type === 'liquid') {
          this.liquidContent.push(cart);
        } else {
          this.ingredienteContent.push(cart);
        }});
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
          if(response.data.wasLiquid == true){
            this.$refs.mixerComponent.clearLiquid();
          }
          this.getCartContent();
          this.$refs.mixerComponent.removeSpecificAll(response.data.image);
          this.$refs.sizeComponent.getCartCount();
          this.$refs.progressComponent.getProgress();
        })
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
};
</script>
<style>
.item-list {
  height: 35em;
  overflow-y: scroll;
  overflow-x: hidden;
}

.w-95 {
  width: 95%;
}
</style>

