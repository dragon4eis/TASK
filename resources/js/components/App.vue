<template>
    <router-view></router-view>
</template>

<script>
export default {
    name: "single-page-app",
    mounted(){
        this.$store.dispatch('todoLists/all')
    }
}
</script>

<style scoped>

</style>
