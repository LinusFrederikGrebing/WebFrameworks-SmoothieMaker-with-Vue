<template>
    <div class="container">
        <progressbar-component />
        <size-component />
       
        <v-row class="mt-5">
            <h2 class="sr-only">Steps</h2>
            <v-col class="mb-5" cols="12">
                <v-card class="mx-auto d-flex flex-wrap">
                    <v-btn class="mx-auto flex-grow-1" v-for="(category, index) in categories" :key="index"
                       >
                        <img width="25" height="25" class="my-2" :src=category.icon :alt="category.title" />
                        {{ category.title }}
                    </v-btn>
                </v-card>
            </v-col>
            <v-col cols="12" md="8" class="mb-5">
                <v-row>
                    <v-col v-for="(zutat, index) in zutaten" :key="index" cols="12" sm="6" md="4" lg="3">
                        <v-card class="mx-auto mb-4" max-width="344">
                            <v-img class="white--text align-end" height="150px" :src="'/images/' + zutat.image">
                                <v-card-title>
                                    <span class="font-weight-bold">{{ zutat.name }}</span>
                                    <div>Preis: {{ zutat.price }}€</div>
                                </v-card-title>
                            </v-img>
                            <v-card-actions>
                                <v-form @click.prevent="addToCart(zutat)" enctype="multipart/form-data" method="post">
                                    <v-container>
                                        <v-row class="d-flex align-items-center">
                                            <v-col cols="6">
                                                <v-text-field v-model="zutat.amount" type="number" step="1" min="1" max="20"
                                                    class="mr-4"></v-text-field>
                                            </v-col>
                                            <v-col cols="6">
                                                <v-btn class="white--text" color="primary" type="submit">
                                                    wa
                                                </v-btn>
                                            </v-col>
                                        </v-row>
                                    </v-container>
                                </v-form>
                            </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col class="mb-5" cols="12">
                        <v-card class="mx-auto d-flex flex-wrap">
                            <v-btn color="error" class="mx-auto flex-grow-1" @click="showBottleSize()"> Zurück </v-btn>
                            <v-btn color="success" class="mx-auto flex-grow-1" @click="showInhalt()"> Weiter </v-btn>
                        </v-card>
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="12" md="4">
                <div class="mb-5" max-width="400">
                    <mixer-component ref="mixerComponent" />
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
            amount: 1,
            categories: [
                {
                    route: 1,
                    icon: '/images/fruitsicon.png',
                    title: "Früchte",
                },
                {
                    route: 1,
                    icon: '/images/vegetablesicon.png',
                    title: "Gemüse",
                },
                {
                    route: 1,
                    icon: '/images/liquidicon.png',
                    title: "Flüssigkeit",
                }
            ],
            zutaten: {}
        }
    },
    created() {
        axios.get('/ingrediente')
            .then(response => {
                
                this.zutaten = response.data.zutaten;
            }).catch((err) => {
                console.log(err);
            });
    },
    methods: {
        showInhalt() {
            this.$router.push({path: '/shop'});
        },
        showBottleSize() {
            this.$router.push({ path: "/chooseBottleSize" })
        },
        addToCart(zutat) {
            axios.post("/addCart/" + zutat.id, {
                amount: 1
            })
                .then(response => {
                    console.log("imAddToCard")
                    this.$refs.mixerComponent.setImg(response.data.image, response.data.reqCount);
                })
                .catch(error => {
                    console.error(error);
                });
        }
    },
    mounted() { },
};
</script>
