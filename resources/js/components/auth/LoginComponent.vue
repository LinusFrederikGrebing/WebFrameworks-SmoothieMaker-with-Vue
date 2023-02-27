<template>
    <v-app>
      <v-container class="py-6 d-flex flex-column justify-center">
        <v-row class="justify-center">
          <v-col cols="12" sm="8" md="6">
            <h1 class="text-center mb-6">Login</h1>
            <v-card>
              <v-card-text>
                <v-form @submit.prevent="submitForm">
                  <v-text-field
                    v-model="form.email"
                    label="E-Mail"
                    type="email"
                    required
                  ></v-text-field>
                  <v-text-field
                    v-model="form.password"
                    label="Passwort"
                    required
                    type="password"
                  ></v-text-field>
                  <v-row class="d-flex justify-center">
                    <v-col cols="auto">
                      <v-btn type="submit" color="primary">
                        Log In
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
  import axios from "axios";
  export default {
    name: 'Login',
    data() {
      return {
        form: {
          email: '',
          password: '',
          remember_me: false,
        },
      };
    },
    methods: {
      submitForm() {
        axios.post('/login', this.form)
          .then(response => {
            this.$router.push('/home').then(() => {
            location.reload();
            });
          })
          .catch(error => {
            console.log(error);
          });
      },
    },
  };
  </script>