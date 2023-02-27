<template>
    <v-app>
      <v-container class="py-6 d-flex flex-column justify-center">
        <v-row class="justify-center">
          <v-col cols="12" sm="8" md="6">
            <h1 class="text-center mb-6">Registrierung</h1>
            <v-card>
              <v-card-text>
                <v-form @submit.prevent="submitForm">
                  <v-text-field
                    v-model="form.name"
                    label="Name"
                    required
                  ></v-text-field>
                  <v-text-field
                    v-model="form.email"
                    label="E-Mail"
                    required
                    type="email"
                  ></v-text-field>
                  <v-text-field
                    v-model="form.password"
                    label="Passwort"
                    required
                    type="password"
                  ></v-text-field>
                  <v-text-field
                    v-model="form.password_confirmation"
                    label="'Passwort wiederholen"
                    required
                    type="password"
                  ></v-text-field>
                  <v-row class="d-flex justify-center">
                    <v-col cols="auto">
                      <v-btn type="submit" color="primary">
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
    </v-app>
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
          .then(response => {
            this.$router.push('/home').then(() => {
              location.reload();
            });
          })
          .catch(error => {
            console.log(error);
          });
      }
    }
  };
  </script>