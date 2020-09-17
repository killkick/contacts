<template>
    <div class="rounded-full text-white bg-red-400 w-10 h-10 flex justify-center items-center border border-gray-400">
        {{ userCircle }}
    </div>
</template>

<script>
    export default {
        name: "UserCircle",
        props : [
            'name'
        ],
        computed : {
            userCircle() {
                return this.name.match(/[А-ЯA-Z]/g).slice(0,2).join('')
            }
        }
    }
</script>

<style scoped>

</style>
