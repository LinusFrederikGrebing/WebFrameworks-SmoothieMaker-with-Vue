<template>
     <div class="auth-background mt-16">
      <div class="auth-green-background mx-auto rounded-box"></div>
      <v-container class="py-6 d-flex flex-column justify-center">
        <v-row class="justify-center">
          <v-col cols="12" class="mx-auto">
            <v-card elevation="10" width="800" height="570" class="mx-auto rounded-box">
              <v-card-text class="w-75 mx-auto">
                <h2 class="font-weight-bold mb-4 mt-8">Registrierung</h2>
                <v-form @submit.prevent="submitForm">
                  <label>Name:</label>
                  <v-text-field
                    v-model="form.name"
                    required
                  ></v-text-field>
                  <label>E-Mail:</label>
                  <v-text-field
                    v-model="form.email"
                    required
                    type="email"
                  ></v-text-field>
                  <label>Passwort:</label>
                  <v-text-field
                    v-model="form.password"
                    required
                    type="password"
                  ></v-text-field>
                  <label>Passwort wiederholen:</label>
                  <v-text-field
                    v-model="form.password_confirmation"
                    required
                    type="password"
                  ></v-text-field>
                  <v-row class="d-flex justify-end">
                    <v-col cols="auto">
                      <a class="mr-4 text-black">Bereits registriert?</a>
                      <v-btn type="submit" color="black">
                        Registrieren
                      </v-btn>
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
  export default {
    data() {
      return {
        form: {
          name: '',
          email: '',
          password: '',
          password_confirmation: ''
        }
      }
    },
    methods: {
      submitForm() {
        axios.post('/register', this.form)
          .then(() => {
            this.$router.push('/home').then(() => {
              location.reload();
            });
          })
          .catch(error => {
            this.warningAlert();
          });
      },
      warningAlert() {
        Swal.fire({
          title: "",
          text: "Deine Registrierung ist fehlgeschlagen. Überprüfe deine Anmeldedaten und probiere es erneut! ",
          icon: "warning",
          confirmButtonColor: "#6D9E1F",
          confirmButtonText: "Wiederholen!",
        })
    },
    }
  };
  </script>