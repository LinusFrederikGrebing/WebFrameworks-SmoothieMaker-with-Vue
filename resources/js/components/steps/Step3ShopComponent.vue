<template>
    <div class="container">
        <ProgressbarComponent />
        <SizeComponent />
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
                                <td>{{ cart.qty }}</td>
                                <td><v-icon>mdi:trash-can</v-icon></td>
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
                console.log(response)
            })
        },
        removeAllFromCart(){
            axios.get('/removeAll') .then(response => { 
                this.getCartContent()
                console.log(response)
            })
        },
        showIngrediente() {
            this.$router.push({path: '/chooseIngrediente'});
        },
    },
    mounted() { },
};
</script>
