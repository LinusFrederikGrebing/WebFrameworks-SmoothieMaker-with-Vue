<template>
  <div class="auth-background seperate">
    <div class="auth-green-background mx-auto rounded-box"></div>
    <v-container class="py-6 d-flex flex-column justify-center">
      <v-row class="justify-center">
        <v-col cols="12" class="mx-auto">
          <v-card elevation="10" width="800" height="550" class="mx-auto rounded-box">
            <v-card-text class="w-75 mx-auto">
              <h2 class="font-weight-bold mt-8">
                Informationen zur Zutat {{ ingrediente.name }} hinzufügen:
              </h2>
              <v-form @submit.prevent="updateIngrediente" enctype="multipart/form-data">
                <v-row>
                  <v-col>
                    <v-text-field class="enrollField" id="info" label="Info" v-model="ingredientInfo.info" required />
                  </v-col>
                  <v-col>
                    <v-text-field class="enrollField" id="energie" label="Energie" v-model="ingredientInfo.energie"
                      required />
                  </v-col>
                </v-row>
                <v-row>
                  <v-col>
                    <v-text-field class="enrollField" id="fett" label="Fett" v-model="ingredientInfo.fett" required />
                  </v-col>
                  <v-col>
                    <v-text-field class="enrollField" id="fett" label="Fett" v-model="ingredientInfo.fattyacids"
                      required />
                  </v-col>
                </v-row>
                <v-row>
                  <v-col>
                    <v-text-field class="enrollField" id="fettacid" label="davon Fettsäuren:"
                      v-model="ingredientInfo.carbohydrates" required />
                  </v-col>
                  <v-col>
                    <v-text-field class="enrollField" id="carbohydrates" label="Kohlenhydrate"
                      v-model="ingredientInfo.fruitscarbohydrates" required />
                  </v-col>
                </v-row>
                <v-row>
                  <v-col>
                    <v-text-field class="enrollField" id="protein" label="Protein" v-model="ingredientInfo.protein"
                      required />
                  </v-col>
                  <v-col>
                    <v-text-field class="enrollField" id="salt" label="Salz" v-model="ingredientInfo.salt" required />
                  </v-col>
                </v-row>
                <v-row class="d-flex justify-end mt-8">
                  <v-col cols="auto">
                    <a @click="showHome" class="mr-4 text-black">Zurück</a>
                    <v-btn color="black" type="submit">Zutat hinzufügen</v-btn>
                  </v-col>
                </v-row>
              </v-form>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import axios from "axios";
import { showAlertSuccess } from '../steps/alerts'
export default {
  props: ["id"],
  data() {
    return {
      ingrediente: {},
      ingredientInfo: {
        info: "",
        energie: "",
        fattyacids: "",
        carbohydrates: "",
        fett: "",
        carbohydrates: "",
        fruitscarbohydrates: "",
        protein: "",
        salt: ""
      },
    };
  },
  mounted() {
    this.getIngrediente(this.id);
  },
  methods: {
    // redirect back to the employeeTemplate
    showHome() {
      this.$router.push("/employeeTemplate");
    },
    // retrieves ingredient data from the server.
    getIngrediente() {
      axios.get(`/ingredientinfo/getIngredient/${this.id}`, {}).then((response) => {
        this.ingrediente = response.data.ingrediente;
      });
    },
    // sends a post request with ingredient information to update the ingredient and redirects to the employeeTemplate page upon success.
    updateIngrediente() {
      const config = {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      };
      const data = new FormData();
      data.append("info", this.ingredientInfo.info);
      data.append("energie", this.ingredientInfo.energie);
      data.append("fett", this.ingredientInfo.fett);
      data.append("fattyacids", this.ingredientInfo.fattyacids);
      data.append("carbohydrates", this.ingredientInfo.carbohydrates);
      data.append("fruitscarbohydrates", this.ingredientInfo.fruitscarbohydrates);
      data.append("protein", this.ingredientInfo.protein);
      data.append("salt", this.ingredientInfo.salt);
      axios
        .post(`/ingredienteInfo/create/${this.id}`, data, config)
        .then(() => {
          showAlertSuccess("Die Zutat-Informationen wurden erfolgreich aktualisiert!", "");
          this.$router.push({ path: "/employeeTemplate" });
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
};
</script>
