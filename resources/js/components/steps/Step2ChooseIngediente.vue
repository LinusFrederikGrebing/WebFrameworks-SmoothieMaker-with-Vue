<template>
    <div class="container">
        <ProgressbarComponent ref="progressComponent" />
        <SizeComponent ref="sizeComponent" />
        <v-row class="mt-5">
            <h2 class="sr-only">Steps</h2>
            <v-col class="mb-5" cols="12">
                <v-card class="mx-auto d-flex flex-wrap">
                    <v-btn class="mx-auto flex-grow-1" v-for="(category, index) in categories" :key="index">
                        <img width="20" height="20" class="my-2" :src="category.icon" :alt="category.title" />
                        {{ category.title }}
                    </v-btn>
                </v-card>
            </v-col>
            <v-col cols="12" md="8" class="mb-5">
                <v-row>
                    <v-col v-for="(zutat, index) in zutaten" :key="index" cols="12" sm="6" md="4" lg="3">
                        <v-card class="mx-auto mb-4" max-width="400">
                            <v-img class="white--text align-end" height="150px" :src="'/images/' + zutat.image">
                                <v-card-title>
                                    <span class="font-weight-bold">{{
                                        zutat.name
                                    }}</span>
                                    <div>Preis: {{ zutat.price }}€</div>
                                </v-card-title>
                            </v-img>
                            <v-card-actions>
                                <v-form enctype="multipart/form-data" method="post">
                                    <v-container>
                                        <v-row class="d-flex align-items-center">

                                            <v-stepper v-model="amount" min="1" max="20">
                                                <v-stepper-header>
                                                    <v-btn icon width="40" @click.prevent="
                                                        amount++
                                                    "><v-icon>mdi-plus</v-icon></v-btn>
                                                    <v-stepper-step width="15" :complete="false">{{
                                                        amount
                                                    }}</v-stepper-step>
                                                    <v-btn icon width="40" @click.prevent="
                                                        amount--
                                                    "><v-icon>mdi-minus</v-icon>
                                                    </v-btn>

                                                </v-stepper-header>
                                            </v-stepper>

                                            <v-btn class="white--text" color="primary" type="submit" @click.prevent="
                                                addToCart(zutat, amount)
                                            ">
                                                <i style="color: black" class="material-icons">shopping_cart</i>
                                            </v-btn>


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
                            <v-btn color="error" class="mx-auto flex-grow-1" @click="showBottleSize()">
                                Zurück
                            </v-btn>
                            <v-btn color="success" class="mx-auto flex-grow-1" @click="showInhalt()">
                                Weiter
                            </v-btn>
                        </v-card>
                    </v-col>
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
import MixerComponent from "../layouts/MixerComponent.vue";
import ProgressbarComponent from "../layouts/ProgressbarComponent.vue";
import SizeComponent from "../layouts/SizeComponent.vue";
export default {
    name: "ChooseBottleSize",
    components: {
        MixerComponent,
        ProgressbarComponent,
        SizeComponent,
    },
    data() {
        return {
            amount: 1,
            categories: [
                {
                    route: 1,
                    icon: "/images/fruitsicon.png",
                    title: "Früchte",
                },
                {
                    route: 1,
                    icon: "/images/vegetablesicon.png",
                    title: "Gemüse",
                },
                {
                    route: 1,
                    icon: "/images/liquidicon.png",
                    title: "Flüssigkeit",
                },
            ],
            zutaten: {},
        };
    },
    beforeUnmount() {
        this.$refs.mixerComponent.clearInterval();
    },
    created() {
        axios
            .get("/ingrediente")
            .then((response) => {
                this.zutaten = response.data.zutaten;
            })
            .catch((err) => {
                console.log(err);
            });
    },
    methods: {
        showInhalt() {
            this.$router.push({ path: "/shop" });
        },
        showBottleSize() {
            this.$router.push({ path: "/chooseBottleSize" });
        },
        addToCart(zutat, amount) {
            axios
                .post("/addCart/" + zutat.id, {
                    amount: amount,
                })
                .then((response) => {
                    this.$refs.mixerComponent.setImg(
                        response.data.image,
                        response.data.reqCount
                    );
                    this.$refs.sizeComponent.getCartCount();
                    this.$refs.progressComponent.getProgress();
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
    mounted() { },
};
</script>
