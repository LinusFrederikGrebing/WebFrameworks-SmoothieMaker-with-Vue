<template>
  <div class="container">
    <div v-if="isAdmin"><EmployeeTemplate/></div>
    <div v-if="isCustomer"><CustomerTemplate/></div>
  </div>
</template>

<script>
import axios from "axios";
import CustomerTemplate from "./auth/CustomerTemplate";
import EmployeeTemplate from "./auth/EmployeeTemplate";
export default {
  name: "HomeTemplate",
  components: {
    CustomerTemplate,
    EmployeeTemplate
  },
  data() {
    return {
      isAdmin: false,
      isCustomer: false,
    };
  },
  mounted() {
    this.getUserRole();
  },
  methods: {
    getUserRole() {
      axios.get(`/getUserRole`).then((response) => {
        if(response.data.type == "kunde") {
          this.isCustomer = true;
        } else if(response.data.type == "mitarbeiter") {
          this.isAdmin = true;
        } else {
          this.$router.push({ path: "/login" });
        }
      });
    },
  },
};
</script>
