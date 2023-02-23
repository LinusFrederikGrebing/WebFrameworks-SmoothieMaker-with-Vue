<template>
    <div class="container">
        <ProgressbarComponent ref="progressComponent" />
        <SizeComponent ref="sizeComponent" />
        <v-row class="mt-5">
            <v-col class="mb-5" cols="12">
                <v-card class="mx-auto d-flex flex-wrap">
                    <v-btn color="success" class="mx-auto flex-grow-1" @click="showIngrediente()"> Weitere Zutaten hinzufügen </v-btn>
                    <v-btn color="error" class="mx-auto flex-grow-1" @click="removeAllFromCart()"> Alles aus dem Warenkorb entfernen </v-btn>
                </v-card>
            </v-col>
            <v-col cols="12" md="8" class="mb-5">
                <v-row>
                    <v-table density="compact">
                        <thead>
                            <tr>
                                <th class="text-left">Image</th>
                                <th class="text-left">Name</th>
                                <th class="text-left">Preis</th>
                                <th class="text-left">Menge</th>
                                <th class="text-left">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(cart, index) in cartContent" :key="index" >
                                <td><img :src="'/images/' + cart.options.image" class="mt-2 mb-2" ></td>
                                <td>{{ cart.name }}</td>
                                <td>{{ cart.price }}</td>
                                <td> <v-icon color="red" @click="addSpecificOne(cart)">mdi-plus</v-icon>{{ cart.qty }} <v-icon color="red" @click="removeSpecificOne(cart)">mdi-minus</v-icon></td>
                                <td><v-btn @click="removeSpecificCart(cart)"><v-icon color="red">mdi-delete</v-icon></v-btn> </td>
                            </tr>
                        </tbody>
                    </v-table>
                </v-row>
                <v-row>
                    <p class="mt-8">Total: {{ cartSubTotal }}</p>
                </v-row>
                <v-row>
                    <h4>Total inkl. MwSt: {{ cartTotal }}</h4>
                </v-row>
                <v-row>
                    <v-btn color="success">Jetzt kaufen</v-btn>
                </v-row>
            </v-col>
            <v-col cols="12" md="4">
                <div class="mb-5" max-width="400">
                    <MixerComponent ref="mixerComponent" />
                </div>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import MixerComponent from '../layouts/MixerComponent.vue'
import ProgressbarComponent from '../layouts/ProgressbarComponent.vue'
import SizeComponent from '../layouts/SizeComponent.vue'
export default {
    name: "ChooseBottleSize",
    components: {
        MixerComponent,
        ProgressbarComponent,
        SizeComponent
    },
    data() {
        return {
            cartContent: [],
            cartTotal: null,
            cartSubTotal: null
        }
    },
    created() {
        this.getCartContent()
    },
    beforeUnmount() {
        this.$refs.mixerComponent.clearInterval();
    },
    methods: {
        getCartContent(){
            this.cartContent = [];
            axios.get('/cartContent')
            .then(response => {
                this.cartTotal = response.data.cartTotal;
                this.cartSubTotal = response.data.cartSubTotal;
                for (let key in response.data.cart) {
                    this.cartContent.push(response.data.cart[key])
                }
            })
        },
        removeAllFromCart(){
            axios.get('/removeAll') .then(response => { 
                this.getCartContent()
                this.$refs.mixerComponent.removeAll();
                this.$refs.sizeComponent.getCartCount();
                this.$refs.progressComponent.getProgress();
                sessionStorage.clear();
            })
        },
        removeSpecificCart(cart){
            axios.post("/deleteCart/" + cart.rowId, {              
                })
                .then((response) => {
                    this.getCartContent()
                    this.$refs.mixerComponent.removeSpecificAll(response.data.image);
                    this.$refs.sizeComponent.getCartCount();
                    this.$refs.progressComponent.getProgress();
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        addSpecificOne(cart){
            axios.post("/increaseCardQty/" + cart.rowId, {
                    amount: 1,
                })
                .then((response) => {
                    this.getCartContent()
                    this.$refs.mixerComponent.setImg(response.data.image, 1);
                    this.$refs.sizeComponent.getCartCount();
                    this.$refs.progressComponent.getProgress();
                })
        },
        removeSpecificOne(cart){
            axios.post("/decreaseCardQty/" + cart.rowId, {
                    amount: 1,
                })
                .then((response) => {
                    this.getCartContent()
                    this.$refs.mixerComponent.removeSpecificOne(response.data.image);
                    this.$refs.sizeComponent.getCartCount();
                    this.$refs.progressComponent.getProgress();
                })
        },
        showIngrediente() {
            this.$router.push({path: '/chooseIngrediente'});
        },
    },
    mounted() { },
};
</script>
