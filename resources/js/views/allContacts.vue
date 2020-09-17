<template>
<div>
    <contact-list :endpoint="'/api/contacts/'"></contact-list>
</div>
</template>

<script>
    import UserCircle from "../components/UserCircle";
    import ContactList from "../components/ContactList";
    export default {
        name: "allContacts",
        components: {ContactList, UserCircle},
    }
</script>

<style scoped>

</style>
