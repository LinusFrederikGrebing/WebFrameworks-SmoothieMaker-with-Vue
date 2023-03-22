<template>
  <div class="container">
    <v-row>
      <v-col cols="12" sm="12" md="12" xl="7" lg="7" xs="12">
        <SizeComponent ref="sizeComponent" />
      </v-col>
      <v-col
        cols="12"
        sm="12"
        md="12"
        xl="5"
        lg="5"
        xs="12"
        v-if="isUserLoggedIn"
      >
      <v-row>
        <v-col cols="12" sm="12" md="12" xl="7" lg="7" xs="12">
          <v-text-field
            class="mt-3 shrink enrollField"
            v-model="presetName"
            type="text"
            placeholder="Preset-Name"
            required
          >
          </v-text-field>
        </v-col>
        <v-col cols="12" sm="12" md="12" xl="5" lg="5" xs="12">
          <v-btn class="mt-4" @click="storeAsPreset()" color="black">
            Preset erstellen!
          </v-btn>
        </v-col>
      </v-row>
      </v-col>
      </v-row>
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
            <div elevation="5" class="w-95 ml-5 mt-3 mb-3">
              <v-table density="compact">
                <thead>
                  <tr>
                    <th class="text-left text-black">Image</th>
                    <th class="text-left text-black">Name</th>
                    <th class="text-left text-black">Preis</th>
                    <th class="text-left text-black">Menge</th>
                    <th class="text-left text-black"></th>
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
                      <v-btn
                        class="mt-4"
                        @click="removeSpecificCart(cart)"
                        color="black"
                      >
                        Löschen!
                      </v-btn>
                    </td>
                  </tr>
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
                    <td>{{ cart.price }}€ / 50ml</td>
                    <td>
                      {{ cart.qty }}
                      <button @click="showStep3">
                        <v-icon small class="ml-3 mb-1">mdi-pencil</v-icon>
                      </button>
                    </td>
                    <td>
                      <v-btn
                        class="mt-4"
                        @click="removeSpecificCart(cart)"
                        color="black"
                      >
                        Löschen!
                      </v-btn>
                    </td>
                  </tr>
                </tbody>
              </v-table>
            </div>
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
  name: "ShopComponent",
  components: {
    MixerComponent,
    ProgressbarComponent,
    SizeComponent,
  },
  data() {
    return {
      isUserLoggedIn: "",
      presetName: "",
      cartContent: [],
      cartTotal: null,
      cartSubTotal: null,
      ingredienteContent: [],
      liquidContent: [],
      liquid: null,
      bottle: null,
    };
  },
  mounted() {
    this.checkLoggedInUser();
    this.getCartContent();
    this.getAktLiquid();
    this.getBottleContent();
  },
  beforeUnmount() {
    this.$refs.mixerComponent.clearInterval();
  },
  methods: {
    checkLoggedInUser() {
      axios.get(`/checkLoggedInUser`).then((response) => {
        this.isUserLoggedIn = response.data.loggedIn;
      });
    },
    storeAsPreset() {
      if (this.presetName == "") {
        this.showAlertError("Du hast kein Presetnamen gewählt!", "");
      } else {
        axios
          .post(`/storeAsPreset`, {
            name: this.presetName,
          })
          .then((response) => {
            console.log(response);
            if (response.data.auth == false) {
              this.showAlertError(
                "Du must angemeldet sein, um dir spezifische Presets erstellen zu können!",
                ""
              );
            } else {
              this.showAlertSuccess(
                "Das Preset wurde erfolgreich erstellt!",
                "Auf der Startseite kannst du das Preset auswählen und deine Zusammenstellung aufrufen!"
              );
            }
          })
          .catch((error) => {
            this.showAlertError(
              "Den Namen für das Preset gibt es bereits!",
              "Wähle einen anderen Namen, oder lösche das bestehende Preset!"
            );
          });
      }
    },
    getAktLiquid() {
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
    showStep3() {
      this.$router.push({ path: "/chooseLiquid" });
    },
    mixAnimation() {
      const ingredienteContentSum = this.ingredienteContent.reduce(
        (sum, ingredient) => sum + ingredient.qty,
        0
      );
      if (
        ingredienteContentSum == this.bottle.amount &&
        this.liquidContent.length == 1
      ) {
        this.$refs.mixerComponent.mixAnimation(this.bottle.amount);
      } else {
        var errorMessage = "";
        if (ingredienteContentSum !== this.bottle.amount) {
          const missingIngredients = this.bottle.amount - ingredienteContentSum;
          errorMessage = `Füge noch ${missingIngredients} Zutaten hinzu, um deine Zusammenstellung abzuschließen. `;
        }
        if (this.liquidContent.length == 0) {
          errorMessage =
            errorMessage +
            "Beachte, dass eine Flüssigkeit ausgewühlt sein muss!";
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
        this.cartContent = Object.values(response.data.cart);
        this.liquidContent = this.cartContent.filter(
          (cartItem) => cartItem.options.type === "liquid"
        );
        this.ingredienteContent = this.cartContent.filter(
          (cartItem) => cartItem.options.type !== "liquid"
        );
        this.$refs.mixerComponent.removeBall();
        this.ingredienteContent.forEach((ingrediente) => {
          console.log(ingrediente);
          this.$refs.mixerComponent.setImg(
            ingrediente.options.image,
            ingrediente.qty
          );
        });
        this.getCartTotal();
      });
    },
    getBottleContent() {
      axios.get("/getCurrentBottle").then((response) => {
        this.bottle = response.data.bottle;
      });
    },
    getCartTotal() {
      axios.get("/cartTotal").then((response) => {
        this.cartTotal = response.data.cartTotal;
        this.cartSubTotal = response.data.cartSubTotal;
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
      const response = await axios.post("/deleteCart/" + cart.rowId, {});
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
      const { stored, image } = response.data;
      if (stored) {
        this.$refs.mixerComponent.setImg(image, 1);
        this.resetComponents();
        this.setnewAmount(cart.rowId, 1);
        this.getCartTotal();
      } else {
        this.showAlertError("Du hast zu viele Zutaten ausgewählt!", "");
      }
    },
    async removeSpecificOne(cart) {
      const response = await axios.post("/decreaseCardQty/" + cart.rowId, {
        amount: 1,
      });
      const { newqty, image } = response.data;
      if (newqty > 0) {
        this.setnewAmount(cart.rowId, -1);
        this.getCartTotal();
      } else {
        this.getCartContent();
      }
      this.$refs.mixerComponent.removeSpecificOne(image);
      this.resetComponents();
    },
    setnewAmount(rowId, amount) {
      this.ingredienteContent.forEach(function (content) {
        if (content.rowId == rowId) {
          content.qty += amount;
        }
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
    showAlertSuccess(title, text) {
      Swal.fire({
        title: title,
        text: text,
        icon: "success",
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
.w-70 {
  width: 60%;
}
.w-30 {
  width: 40%;
}
.enrollField {
  margin-bottom: -3em;
  margin-right: 0em;
}
</style>

