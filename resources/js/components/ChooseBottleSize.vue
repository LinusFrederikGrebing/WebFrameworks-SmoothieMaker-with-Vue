<template>
    <v-container>
        <div class="text-center">
            <h1 class="">Wähle jetzt deine Smoothie-Größe!</h1>
        </div>
        <v-row class="mx-auto ml-16" no-gutters>
            <v-col sm="12" md="6" v-for="bottle in bottles" :key="bottle.id">
                <v-card class="my-4 mx-4" elevation="10">
                    <div class="d-flex">
                        <img
                            width="250"
                            height="250"
                            class="my-2"
                            :src="'/images/' + bottle.image"
                            :alt="bottle.name"
                        />

                        <div>
                            <h3>Größe: {{ bottle.name }}</h3>
                            <p class="mx-8 my-4">{{ bottle.description }}</p>
                            <v-btn @click="showInhalt">Click me!</v-btn>
                            <button class="" @click="showInhalt(bottle)">
                                Weiter
                            </button>
                        </div>
                    </div>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: "ChooseBottleSize",
    props: {
        bottles: Object,
    },
    data() {
        return {};
    },
    methods: {
        showInhalt(bottle) {
            window.location = "/schritt1/" + bottle.id;
        },
    },
    mounted() {},
};
</script>
