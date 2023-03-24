<template>
  <div class="auth-background seperate">
    <div class="auth-green-background mx-auto rounded-box"></div>
    <v-container class="py-6 d-flex flex-column justify-center mt-16">
      <v-row class="justify-center">
        <v-col cols="12" class="mx-auto">
          <v-card
            elevation="10"
            width="800"
            height="550"
            class="mx-auto rounded-box"
          >
            <v-card-text class="w-75 mx-auto">
              <h2 class="font-weight-bold mb-12 mt-16">Login</h2>
              <v-form @submit.prevent="submitForm">
                <label>Name:</label>
                <v-text-field
                  v-model="form.name"
                  type="name"
                  required
                ></v-text-field>
                <label>Passwort:</label>
                <v-text-field
                  v-model="form.password"
                  required
                  type="password"
                ></v-text-field>
                <v-row class="ml-1 mt-1">
                  <input
                    type="checkbox"
                    id="vehicle1"
                    name="vehicle1"
                    value="Bike"
                  />
                  <span class="ml-2 text-sm text-gray-600"
                    >Anmeldedaten merken</span
                  >
                </v-row>
                <v-row class="d-flex justify-end">
                  <v-col cols="auto">
                    <a @click="showRegister" class="mr-4 text-black"
                      >Noch nicht registriert?</a
                    >
                    <v-btn type="submit" color="black"> Log In </v-btn>
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
export default {
  name: "Login",
  data() {
    return {
      form: {
        name: "",
        password: "",
        remember_me: false,
      },
    };
  },
  methods: {
    showRegister() {
      this.$router.push("/register");
    },
    submitForm() {
      axios
        .post("/login", this.form)
        .then(() => {
          this.$router.push("/").then(() => {
            location.reload();
          });
        })
        .catch((error) => {
          this.warningAlert();
        });
    },
    warningAlert() {
      Swal.fire({
        title: "",
        text: "Deine Anmeldung ist fehlgeschlagen. Überprüfe deine Anmeldedaten und probiere es erneut! ",
        icon: "warning",
        confirmButtonColor: "#6D9E1F",
        confirmButtonText: "Wiederholen!",
      });
    },
  },
};
</script>