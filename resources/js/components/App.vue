<template>
    <div class="content-container">
        <router-view />
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
}
</style>