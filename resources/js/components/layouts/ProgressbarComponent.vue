<template>
    <div class="progress2 my-8">
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
       
        axios.get('/cart/count')
            .then(response => {
                this.cartCount = response.data.cartCount;
                this.bottle = response.data.bottle;
                this.setNewProgress();
            }).catch((err) => {
                console.log(err);
        });
    },
    methods: {
        setNewProgress(){
            const progressbar = this.$refs.progressbar;
            console.log("setNewProgress")
            console.log(this.bottle)
            console.log(this.cartCount)
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