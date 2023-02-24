<template>
<v-container>
    <div class="text-center my-4 mx-4">
        <h1 class="">Wähle jetzt deine Smoothie-Größe!</h1>
    </div>
    <v-row class="mx-auto ml-16" no-gutters>
        <v-col sm="12" md="6" v-for="bottle in bottles" :key="bottle.id">
            <v-card class="my-4 mx-4" elevation="10">
                <v-row>
                    <v-col md="4" class="d-flex">
                        <div style="width: 100%; height: 100%;">
                            <img
                                class="my-2"
                                :src="'/images/' + bottle.image"
                                :alt="bottle.name"
                                style="max-width: 100%; max-height: 100%; object-fit: contain;"
                            />
                        </div>
                    </v-col>
                    <v-col md="8">
                        <div>
                            <h3 class="my-4 mx-8">Größe: {{ bottle.name }}</h3>
                            <p class="mx-8 my-4">{{ bottle.description }}</p>
                            <v-btn class="mx-4 my-4" @click="storeBottle(bottle)">Weiter</v-btn>
                        </div>
                    </v-col>
                </v-row>
            </v-card>
        </v-col>
    </v-row>
</v-container>
</template>

<script>
export default {
    name: "Step1ChooseBottleSize",
    data() {
        return {
            bottles: []
        };
    },
    created() {
        axios.get('/api/bottleSize')
            .then(response => {
               this.bottles = response.data.bottles;
            }).catch((err) => {
                console.log(err);
        });
    },
    methods: {
        storeBottle(bottle) {
            axios.get("/schritt1/" + bottle.id)
                .then((response) => {
                    this.$router.push({path: '/chooseIngrediente'});
                })
                .catch((error) => {
                console.error(error);
                });
            },
    },
    mounted() {},
};
</script>
