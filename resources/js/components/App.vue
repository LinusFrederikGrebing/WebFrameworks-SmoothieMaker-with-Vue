<template>
    <div class="bg-color1">
        <v-card elevation="24" class="content-container ml-auto mr-auto">
            <router-view />
        </v-card> 
    </div>
   
    <FooterTemplate />
</template>

<script>
import FooterTemplate from '../components/layouts/FooterTemplate'
import HeaderTemplate from './HeaderTemplate'
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
    width: 80%;
}

</style>