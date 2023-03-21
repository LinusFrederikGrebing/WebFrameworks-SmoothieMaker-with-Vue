<template>
  <nav class="bg-thm-grey h-12">
    <div class="container mx-auto d-flex justify-space-between py-3">
      <!-- SmoothieMaker logo -->
      <router-link class="text-white mt-2" style="text-decoration: none" to="/">
        <h5>SmoothieMaker</h5>
      </router-link>

      <!-- Navigation items -->
      <div class="d-flex justify-end">
        <!-- Authentication Links -->
        <div class="d-flex mt-2">
          <div v-if="!isUserLoggedIn" class="ml-4">
            <router-link
              class="text-white"
              to="/login"
              style="text-decoration: none"
            >
              <h5>Login</h5>
            </router-link>
          </div>
          <div v-if="!isUserLoggedIn" class="ml-4">
            <router-link
              class="text-white"
              to="/register"
              style="text-decoration: none"
            >
              <h5>Register</h5>
            </router-link>
          </div>
          <div v-if="isUserLoggedIn" class="ml-4 relative">
            <button
              id="dropdown-btn"
              class="text-white"
              @click="isDropdownOpen = !isDropdownOpen"
            >
            <div class="d-flex">
               <h5 class="mr-1">{{ username }}</h5>
              <span class="material-symbols-outlined mb-1">
                 expand_more
              </span>
            </div>
             
            </button>

            <!-- Dropdown items -->
            <div v-if="isDropdownOpen" class="">
              <div class="dropdown">
                <div>
                  <v-btn class="w-100">
                    <router-link
                      class="text-black"
                      to="/home"
                      style="text-decoration: none"
                    >
                      Home
                    </router-link>
                  </v-btn>
                </div>
                <div>
                  <v-btn>
                    <a
                      class="text-black"
                      href="#"
                      @click.prevent="logoutUser"
                      style="text-decoration: none"
                    >
                      Logout
                    </a>
                  </v-btn>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>
  
<script>
export default {
  name: "HeaderTemplate",
  data() {
    return {
      username: null,
      isUserLoggedIn: false,
      isDropdownOpen: false,
    };
  },
  mounted() {
    this.checkLoggedInUser();
  },
  methods: {
    checkLoggedInUser() {
      axios.get(`/checkLoggedInUser`).then((response) => {
        this.isUserLoggedIn = response.data.loggedIn;
        if (this.isUserLoggedIn) {
          this.username = response.data.username;
        }
      });
    },
    logoutUser() {
      axios.post("/logout").then(() => {
        this.user = null;
        (this.isUserLoggedIn = false), this.$router.push("/");
      });
    },
  },
};
</script>
<style scoped>
.dropdown {
  position: absolute;
  margin-left: 10em;
  z-index: 2;
  color: black;
  text-decoration: none;
  padding: 10px;
}
</style>