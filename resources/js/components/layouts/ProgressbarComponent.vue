<template>
    <div class="progress-div my-2">
      <div class="progress-bar" ref="progressbar"></div>
    </div>
</template>

  <script>
  export default {
    data() {
        return {
            cartCount: null,
            bottle: {}
        }
    },
    created() {
       this.getProgress();
    },
    methods: {
        getProgress(){
            axios.get('/cart/count')
            .then(response => {
                this.cartCount = response.data.cartCount;
                this.bottle = response.data.bottle;
                this.setNewProgress();
            })
        },
        setNewProgress(){
            const progressbar = this.$refs.progressbar;
            if (this.bottle.amount > 0) {
                const width = this.cartCount * 100 / this.bottle.amount;
                progressbar.style.width = `${width}%`;
            } else {
                progressbar.style.width = '0%';
            }
        }
    },
    mounted() {
    },
  }
  </script>