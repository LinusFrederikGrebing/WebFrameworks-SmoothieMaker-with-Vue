<template>
  <div class="progress-div bg-thm-grey my-2">
    <div class="progress-bar" ref="progressbar"></div>
  </div>
</template>

<script>
export default {
  name: "ProgressbarComponent",
  data() {
    return {
      cartCount: null,
      bottle: {},
    };
  },
  mounted() {
    this.getProgress();
  },
  methods: {
    // fetches the cart count and bottle information from the server and sets the progress bar accordingly.
    getProgress() {
      axios.get("/cart/count").then((response) => {
        this.cartCount = response.data.cartCount;
        this.bottle = response.data.bottle;
        this.setNewProgress();
      });
    },
    // calculates the width of the progress bar based on the cart count and the bottle amount.
    setNewProgress() {
      const progressbar = this.$refs.progressbar;
      if (this.bottle.amount > 0) {
        const width = (this.cartCount * 100) / this.bottle.amount;
        progressbar.style.width = `${width}%`;
      } else {
        progressbar.style.width = "0%";
      }
    },
  },
};
</script>