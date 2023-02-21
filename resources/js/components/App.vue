<template>
    <div>
        <router-view />
        <FooterTemplate />
    </div>
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