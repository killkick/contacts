<template>

</template>

<script>
    export default {
        name: "logout",
        created() {
            axios.post('/logout' ,{ })
                .finally(error => {
                window.location = '/login'
            })
        }
    }
</script>

<style scoped>

</style>
