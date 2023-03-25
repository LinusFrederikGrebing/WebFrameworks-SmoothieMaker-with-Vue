<template>
  <div>
    <v-app-bar short dense color="rgb(74, 92, 102)" app>
      <div class="app-bar-content">
        <router-link class="text-white mt-2 ml-16" style="text-decoration: none" to="/">
          <h5>SmoothieMaker</h5>
        </router-link>
        <div class="d-flex mt-2 mr-16">
          <div v-if="!isUserLoggedIn" class="ml-4 mt-1">
            <router-link class="text-white" to="/login" style="text-decoration: none">
              <h6>Login</h6>
            </router-link>
          </div>
          <div v-if="!isUserLoggedIn" class="ml-4 mt-1">
            <router-link class="text-white" to="/register" style="text-decoration: none">
              <h6>Register</h6>
            </router-link>
          </div>
        </div>
        <v-btn class="mr-16" v-if="isUserLoggedIn" @click="drawer = !drawer">
          <v-icon class="text-white" title="Menu">mdi-menu</v-icon>
          <div class="text-white">Menu</div>
        </v-btn>
      </div>
    </v-app-bar>
    <v-navigation-drawer v-model="drawer" :temporary="false" disable-resize-watcher :mini-variant="!menuCompact.hidden"
      mini-variant-width="100" app>
      <div class="py-8" id="sidebar">
        <div class="sidebar-body">
          <div class="sidebar-links">
            <small class="my-8 text-white">Benuter: {{ username }}</small>
            <br>
            <small class="my-8 text-white">Rolle: {{ userRole }}</small>
            <hr class="divider" />
            <div class="links">
              <div v-if="userRole === 'mitarbeiter'">
                <a v-for="link in adminLinks" :key="link.title" :href="link.path" target="_blank"
                  @click.prevent="setLink(link.path)">
                  <v-icon :title="link.title" class="icon">mdi-{{ link.icon }}</v-icon>
                  <v-slide-x-transition mode="in-out" leave-absolute>
                    <div class="link-title" v-show="menuCompact.hidden">
                      {{ link.title }}
                    </div>
                  </v-slide-x-transition>
                </a>
              </div>
              <a v-for="link in menuLinks" :key="link.title" :href="link.path" target="_blank"
                @click.prevent="link.title === 'Logout' ? logoutUser() : setLink(link.path)">
                <v-icon v-if="!(link.requiredRole == 'mitarbeiter' && userRole !== 'mitarbeiter')" :title="link.title"
                  class="icon">mdi-{{ link.icon }}</v-icon>
                <v-slide-x-transition mode="in-out" leave-absolute>
                  <div class="link-title" v-show="menuCompact.hidden">
                    {{ link.title }}
                  </div>
                </v-slide-x-transition>
              </a>
            </div>
          </div>
        </div>
      </div>
    </v-navigation-drawer>
  </div>
</template>

<script>
export default {
  name: "HeaderTemplate",
  data() {
    return {
      username: null,
      userRole: null,
      isUserLoggedIn: false,
      isDropdownOpen: false,
      drawer: false,
      menuCompact: {
        hidden: true,
      },
      adminLinks: [
        { path: "/employeeTemplate", title: "Admin-Ansicht", icon: "checkbox-multiple-marked-outline" },
      ],
      menuLinks: [
        { path: "/", title: "Startseite", icon: "home" },
        { path: "/customerTemplate", title: "Kunden-Ansicht", icon: "information-variant" },
        { path: "/logout", title: "Logout", icon: "logout-variant" },
      ],
    };
  },
  mounted() {
    this.checkLoggedInUser();
    this.getUserRole();
  },
  methods: {
    // sets the router path based on the clicked items and closes the drawer menu.
    setLink(path) {
      this.drawer = false;
      this.$router.push(path);
    },
    // makes a GET request to check if the user is logged in and updates the isUserLoggedIn and username variables accordingly.
    checkLoggedInUser() {
      axios.get(`/checkLoggedInUser`).then((response) => {
        this.isUserLoggedIn = response.data.loggedIn;
        if (this.isUserLoggedIn) {
          this.username = response.data.username;
        }
      });
    },
    // makes a GET request to get the user's role and updates the userRole variable accordingly.
    getUserRole() {
      axios.get(`/getUserRole`).then((response) => {
        this.userRole = response.data.type;
      });
    },
    // Logs the user out by making a POST request to the server, resetting variables, and navigating to the home page.
    logoutUser() {
      axios.post("/logout").then(() => {
        this.user = null;
        this.drawer = false,
          (this.isUserLoggedIn = false), this.$router.push("/");
      });
    },
  },
}
</script>
