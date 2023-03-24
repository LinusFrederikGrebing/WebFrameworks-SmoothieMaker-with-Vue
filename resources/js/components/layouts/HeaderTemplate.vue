
<template>
  <div>
    <v-app-bar short dense color="rgb(74, 92, 102)" app>
      <div class="app-bar-content">
        <router-link class="text-white mt-2 ml-16" style="text-decoration: none" to="/">
          <h5>SmoothieMaker</h5>
        </router-link>
        <div class="d-flex mt-2 mr-16">
          <div v-if="!isUserLoggedIn" class="ml-4 mt-1">
            <router-link
              class="text-white"
              to="/login"
              style="text-decoration: none"
            >
              <h6>Login</h6>
            </router-link>
          </div>
          <div v-if="!isUserLoggedIn" class="ml-4 mt-1">
            <router-link
              class="text-white"
              to="/register"
              style="text-decoration: none"
            >
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
    <v-navigation-drawer
      v-model="drawer"
      :temporary="false"
      disable-resize-watcher
      :mini-variant="!menuCompact.hidden"
      mini-variant-width="100"
      app
    >
      <div class="py-8" id="sidebar">
        <div class="sidebar-body">
          <div class="sidebar-links">
            <small class="my-8 text-white">Benuter: {{ username }}</small>
            <br>
            <small class="my-8 text-white">Rolle: {{ userRole }}</small>
            <hr class="divider" />
            <div class="links">
              <div v-if="userRole === 'mitarbeiter'">
                 <a 
                  v-for="link in adminLinks"
                  :key="link.title"
                  :href="link.path"
                  target="_blank"
                  @click.prevent="setLink(link.path)"
                >
                  <v-icon :title="link.title" class="icon"
                    >mdi-{{ link.icon }}</v-icon
                  >
                  <v-slide-x-transition mode="in-out" leave-absolute>
                    <div class="link-title" v-show="menuCompact.hidden">
                      {{ link.title }}
                    </div>
                  </v-slide-x-transition>
                </a>
              </div>
              <a
                v-for="link in menuLinks"
                :key="link.title"
                :href="link.path"
                target="_blank"
                @click.prevent="link.title === 'Logout' ? logoutUser() : setLink(link.path)"
              >
                <v-icon v-if="!(link.requiredRole == 'mitarbeiter' && userRole !== 'mitarbeiter')" :title="link.title" class="icon"
                  >mdi-{{ link.icon }}</v-icon
                >
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
    setLink(path){
      this.drawer = false;
      this.$router.push(path);
    },
    checkLoggedInUser() {
      axios.get(`/checkLoggedInUser`).then((response) => {
        this.isUserLoggedIn = response.data.loggedIn;
        if (this.isUserLoggedIn) {
          this.username = response.data.username;
        }
      });
    },
   getUserRole() {
      axios.get(`/getUserRole`).then((response) => {
        this.userRole = response.data.type;
      });
    },
    logoutUser() {
      axios.post("/logout").then(() => {
        this.user = null;
        this.drawer= false,
        (this.isUserLoggedIn = false), this.$router.push("/");
      });
    },
  },
}
</script>

<style>

.thmcolorgreen {
 color: rgba(128,186,36, 1);
}
#sidebar {
  margin: 0;
  top: 0;
  left: 0;
  background-color: rgb(74, 92, 102 );
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  box-shadow: 0px 0px 5px rgba(0,0,0, 0.6);
  user-select: none;
}

.sidebar-links {
  padding-inline: 15px;
}

.sidebar-links small {
  color: rgba(255,255,255,0.6);
  text-transform: uppercase;
  letter-spacing: 2px;
  font-size: 12px;
}

.divider {
  opacity: 0.25;
  border-radius: 100%;
  margin-bottom: 25px;
}

.sidebar-links .links {
  display: flex;
  flex-direction: column;
}

.sidebar-links a{
  text-decoration: none;
  background-color: rgba(255,255,255, 0.75);
  border-radius: 25px;
  padding-inline: 20px;
  padding-block: 15px;
  margin-block: 3px;
  font-weight: 900;
  border: 1px solid rgba(255,255,255, 0.85);
  transition: 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.sidebar-links a:hover {
  transform: scale(1.08);
  background-image: linear-gradient(to right, rgba(128,186,36, 1), rgb(76, 119, 7));
  box-shadow: 0px 0px 8px rgba(128,186,36, 0.85);
  border-color: rgb(198, 246, 121);
}

.sidebar-links a:nth-last-of-type(1):hover {
  background-image: linear-gradient(to right, red, rgb(100,0,0));
  box-shadow: 0px 0px 8px red;
  border-color: red;
}

.sidebar-links .links a {
  display: flex;
  flex-direction: row;
  align-items: center;
  color: rgba(0,0,0, 1);
}

.sidebar-links .link-title {
  margin-left: 10px;
}

.sidebar-links .icon {
  color: rgba(0,0,0, 0.9);
  margin-top:-1px;
  margin-left: 3px;
}

.app-bar-content {
  display: flex;
  align-items: center;
  width: 100%;
  justify-content: space-between;
}

.app-bar-content h2 {
  color: rgba(255,255,255,1);
}

.app-bar-content h2:hover {
  color: rgba(128,186,36, 1);
}

@media screen and (max-width: 600px) {
  .app-bar-content h2 {
      font-size: 18px;
  }
}</style>
