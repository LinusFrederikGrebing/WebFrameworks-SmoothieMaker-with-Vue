<template>
  <div class="container">
    <div class="text-center mx-4 mt-8">
      <h3 class="font-weight-bold">Admin-Ansicht</h3>
      <p>Hier können alle Zutaten eingesehen und verwaltet werden!</p>
    </div>
    <v-container class="mb-16">
      <v-row>
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
      </v-row>
      <v-row
        ><v-col cols="12" sm="6" md="3" lg="2">
          <v-card
            class="mx-auto"
            max-width="400"
            height="175"
            color="success"
            @click="changeRouteCreate"
          >
            <div class="text-center">
              <v-icon size="172">mdi-plus</v-icon>
            </div>
          </v-card>
        </v-col>
        <v-col
          v-for="(ingrediente, index) in ingredients"
          :key="index"
          cols="12"
          sm="6"
          md="3"
          lg="2"
        >
          <v-card
            @mouseenter="hoverEnter($event)"
            @mouseleave="hoverLeave($event)"
            :id="'ingrediente-card' + index"
            elevation="5"
            class="mx-auto ingrediente-item"
            max-width="400"
          >
            <div>
              <v-img
                class="white--text align-end ml-auto mr-auto mt-2 mb-1"
                height="60px"
                width="60px"
                :src="'/images/piece/' + ingrediente.image"
              >
              </v-img>
              <button
                style="position: absolute; top: 0; right: 0; opacity: 0.4"
                @click="showAlertInfo(ingrediente.id, ingrediente.name)"
              >
                <span class="material-symbols-outlined"> info </span>
              </button>
              <div class="text-center mb-3">
                <p class="font-weight-bold ml-1 mr-1">
                  {{ ingrediente.name }}:
                </p>
                <p>{{ ingrediente.price }}€ / 50g</p>
              </div>
              <div class="mx-auto d-flex flex-wrap">
                <v-btn
                  class="flex-grow-1"
                  @click="changeRouteUpdate(ingrediente)"
                >
                  <span class="material-symbols-outlined">edit</span>
                </v-btn>
                <v-btn
                  width="45"
                  class="flex-grow-1"
                  @click="deleteIngrediente(ingrediente.id)"
                >
                  <span class="material-symbols-outlined">delete</span>
                </v-btn>
              </div>
            </div>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>
  
<script>
import { showInfo } from '../steps/alerts'
import axios from "axios";
import gsap from "gsap";
const categories = [
  {
    icon: "/images/fruitsicon.png",
    title: "Früchte",
    list: "fruitsList",
    active: true,
  },
  {
    icon: "/images/vegetablesicon.png",
    title: "Gemüse",
    list: "vegetablesList",
    active: false,
  },
  {
    icon: "/images/liquidicon.png",
    title: "Flüssigkeit",
    list: "liquidList",
    active: false,
  },
];

export default {
  name: "EmployeeTemplate",
  data() {
    return {
      ingredients: [],
      categories,
      vegetablesList: null,
      fruitsList: null,
      liquidList: null,
    };
  },
  mounted() {
    this.getIngredientsList().then(() => {
      this.getActiveIngredienteList();
    });
  },
  methods: {
    showAlertInfo(ingredientId, ingredintName) {
    // Implementierung der showInfo-Methode
    axios.get(`/getIngredientInfo/${ingredientId}`, {}).then((response) => {
        console.log(response);
        var ingredientInfo = response.data.ingredientInfo;
        // Build the table HTML
        if (ingredientInfo == null) {
            var tableHTML =
                "<p>Zu dieser Zutat gibt es keine Inhaltstoff-Informationen</p>";
        } else {
            var tableHTML =
                `
          <table class="alert-table">
          <tbody>
              <tr>
                  <th class="test"><p>Info</p></th>
                  <td>` +
                ingredientInfo.info +
                `</td>
              </tr>
              <tr>
                  <th  class="test"><p>Energie</p></th>
                  <td>` +
                ingredientInfo.energie +
                `</td>
              </tr>
              <tr>
                  <th  class="test">Fett</th>
                  <td>` +
                ingredientInfo.fett +
                `</td>
              </tr>
              <tr>
                  <td  class="test">davon Fettsäuren:</td>
                  <td>` +
                ingredientInfo.fattyacids +
                `</td>
              </tr>
              <tr>
                  <th class="test">Kohlenhydrate</th>
                  <td>` +
                ingredientInfo.carbohydrates +
                `</td>
              </tr>
              <tr>
                  <td  class="test">davon Fruchtzucker:</td>
                  <td>` +
                ingredientInfo.fruitscarbohydrates +
                `</td>
              </tr>
              <tr>
                  <th  class="test"><p>Protein</p></th>
                  <td>` +
                ingredientInfo.protein +
                `</td>
              </tr>
              <tr>
                  <th  class="test"><p>Salz</p></th>
                  <td>` +
                ingredientInfo.salt +
                `</td>
              </tr>
          </tbody>
          </table>
        `;
        }
        // Show the SweetAlert with the table
        Swal.fire({
            title: "Inhaltsstoffe - " + ingredintName,
            html: tableHTML,
            showCloseButton: true,
            showConfirmButton: true,
            confirmButtonColor: "#000000",
            confirmButtonText: "Bearbeiten!",
        }).then((result) => {
            if (result.isConfirmed) {
                this.$router.push({ path: `/update/IngredientList/${ingredientId}` });
            }
        });
    });
    },
    hoverEnter(obj) {
      gsap.to(obj.target, {
        duration: 0.2,
        scale: 1.05,
      });
    },
    hoverLeave(obj) {
      gsap.to(obj.target, { duration: 0.2, scale: 1 });
    },
    changeRouteCreate() {
      this.$router.push({ path: "/create" });
    },
    changeRouteUpdate(ingrediente) {
      this.$router.push({ path: `/update/ingrediente/${ingrediente.id}` });
    },
    handleCategoryClick(category) {
      this.changeIngredientsList(category.list);
      this.setCategoriesActive(category);
    },
    setCategoriesActive(category) {
      this.categories.forEach((c, i) => (c.active = c === category));
    },
    deleteIngrediente(id) {
      axios.post(`api/delete/ingrediente/${id}`);
      this.getIngredientsList().then(() => {
        this.getActiveIngredienteList();
      });
    },
    getActiveIngredienteList() {
      for (let i = 0; i < this.categories.length; i++) {
        if (this.categories[i].active) {
          this.ingredients = this[categories[i].list];
        }
      }
    },
    getIngredientsList() {
      return new Promise((resolve, reject) => {
        axios.get("/api/getIngredientsList").then((response) => {
          this.fruitsList = response.data.ingredientsList.filter(
            (cartItem) => cartItem.type === "fruits"
          );
          this.vegetablesList = response.data.ingredientsList.filter(
            (cartItem) => cartItem.type === "vegetables"
          );
          this.liquidList = response.data.ingredientsList.filter(
            (cartItem) => cartItem.type === "liquid"
          );
          resolve();
        });
      });
    },
    changeIngredientsList(list) {
      this.ingredients = this[list];
    },
  },
};
</script>
<style scoped>
.v-card__title {
  justify-content: center;
}
p {
  margin-bottom: 0;
}
</style> 