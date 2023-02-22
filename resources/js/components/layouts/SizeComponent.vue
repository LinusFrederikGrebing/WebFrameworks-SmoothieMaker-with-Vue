<template>
    <div>
     <v-divider class="w-75"></v-divider>
        <v-row class="d-flex align-center">
            <v-col cols="9">
                <h4> Smoothie-Größe: {{ bottle.name }}</h4>
            </v-col>
            <v-col cols="3" class="text-right">
                <v-btn text class="showBottleSizes" @click="showBottleSizes">
                    <v-icon small class="mr-1">mdi-pencil</v-icon>
                </v-btn>
            </v-col>
        </v-row>
        <p> Aktuell hast du <b class="cart-count"> {{ cartCount }} </b> von
            <b>{{ bottle.amount }}</b> für Größe {{ bottle.name }} benötigte
            Zutaten ausgewählt.
        </p>
        <v-divider class="w-75"></v-divider>
    </div>
</template>

<script>
import axios from 'axios';

export default { 
    data() {
        return {
            cartCount: null,
            bottle: {}
        }
    },
    created() {
        
    }, 
    mounted() {
        this.getCartCount();
    },
    methods: {
        getCartCount(){
            axios.get('/cart/count')
            .then(response => {
                this.cartCount = response.data.cartCount;
                this.bottle = response.data.bottle;
            }).catch((err) => {
                console.log(err);
            });
        },
        showBottleSizes() {
            const self = this;
            Swal.fire({
                title: 'Bist du Dir sicher?',
                text: 'Deine komplette Zusammenstellung wird bei Größenänderung unwiederruflich gelöscht!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#6D9E1F',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Andere Größe wählen!',
                cancelButtonText: 'Abbrechen!'
            }).then((result) => {
                if (result.isConfirmed) {
                    self.$router.push({ name: 'showBottleSizes' });
                }
            });
        }
    }
};
</script>
  
<style scoped>
</style>