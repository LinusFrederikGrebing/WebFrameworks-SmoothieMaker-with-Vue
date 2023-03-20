<template>
    <HeaderTemplate />
    <v-card elevation="24" class="content-container ml-auto mr-auto">
        <router-view />
    </v-card> 
    <FooterTemplate />
</template>

<script>
import FooterTemplate from '../components/layouts/FooterTemplate'
import HeaderTemplate from '../components/layouts/HeaderTemplate'
export default {
    components: {
        FooterTemplate,
        HeaderTemplate
    },
}
</script>
<style>
.content-container {
    min-height: 840px;
    width: 90%;
}
</style>