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
      bottle: null,
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
    });
  },
  beforeUnmount() {
    this.$refs.mixerComponent.clearInterval();
  },
  methods: {
    showStep3() {
      this.$router.push({ path: "/chooseLiquid" });
    },
    mixAnimation() {
      const ingredienteContentSum = this.ingredienteContent.reduce((sum, ingredient) => sum + ingredient.qty, 0);
      if(ingredienteContentSum == this.bottle.amount && this.liquidContent.length == 1){
        this.$refs.mixerComponent.mixAnimation(this.bottle.amount);
      } else {
        var errorMessage = "";
        if(ingredienteContentSum !== this.bottle.amount) {
          const missingIngredients = this.bottle.amount - ingredienteContentSum;
          errorMessage = `Füge noch ${missingIngredients} Zutaten hinzu, um deine Zusammenstellung abzuschließen. `;
        }
        if(this.liquidContent.length == 0) {
          errorMessage =  errorMessage + "Beachte, dass eine Flüssigkeit ausgewühlt sein muss!"
        }
        this.showAlertError("Nicht genug Zutaten ausgewählt!", errorMessage);
      }
    },
    async removeAllFromCart() {
      await this.removeCartItems();
      this.resetComponents();
      this.clearSessionStorage();
    },
    getCartContent() {
      axios.get("/cartContent").then((response) => {
        const { cartTotal, cartSubTotal, cart, bottle } = response.data;
        this.cartTotal = cartTotal;
        this.cartSubTotal = cartSubTotal;
        this.bottle = bottle;
        this.cartContent = Object.values(cart);
        this.liquidContent = this.cartContent.filter((cartItem) => cartItem.options.type === "liquid");
        this.ingredienteContent = this.cartContent.filter((cartItem) => cartItem.options.type !== "liquid");
      });
    },
    async removeCartItems() {
      await axios.get("/removeAll");
      await this.getCartContent();
      this.$refs.mixerComponent.removeAll();
    },
    resetComponents() {
      this.$refs.sizeComponent.getCartCount();
      this.$refs.progressComponent.getProgress();
    },
    clearSessionStorage() {
      sessionStorage.clear();
    },
    async removeSpecificCart(cart) {
      const response  = await axios.post("/deleteCart/" + cart.rowId, {});
      const { wasLiquid, image } = response.data;
      if (wasLiquid) {
        this.$refs.mixerComponent.clearLiquid();
      }
      this.$refs.mixerComponent.removeSpecificAll(image);
      await this.getCartContent();
      this.resetComponents();
    },
    async addSpecificOne(cart) {
      const response = await axios.post("/increaseCardQty/" + cart.rowId, {
        amount: 1,
      });
      const { stored, image, newqty, id} = response.data;
      if (stored) {
        this.$refs.mixerComponent.setImg(image, 1);
        this.resetComponents();
        this.setnewAmount(cart.rowId, 1)
      } else {
        this.showAlertError("Du hast zu viele Zutaten ausgewählt!", "");
      }
    },
    async removeSpecificOne(cart) {
      const response = await axios.post("/decreaseCardQty/" + cart.rowId, {
        amount: 1,
      });
      const {newqty, image, id} = response.data;
      if (newqty > 0) {
        this.setnewAmount(cart.rowId, -1)
      } else {
        await this.getCartContent();
      }
      this.$refs.mixerComponent.removeSpecificOne(image);
      this.resetComponents();
    },
    setnewAmount(rowId, amount) {
      this.ingredienteContent.forEach(function(content) {
        if(content.rowId == rowId) {
          content.qty += amount;
        };
      });
    },
    showIngrediente() {
      this.$router.push({ path: "/chooseIngrediente" });
    },
    showAlertError(title, text) {
      Swal.fire({
        title: title,
        text: text,
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

