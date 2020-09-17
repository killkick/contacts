<template>
    <div>
        <div v-if="loading">Loading..</div>
        <div v-else>
            <div v-if="contacts.length === 0">
                <p>Not contacts yet.</p>
            </div>
            <div v-for="contact in contacts">
                <router-link :to="'/contacts/' + contact.data.contact_id" class="flex flex-center border-b p-4  border-gray-400 hover:border-gray-100">
                    <user-circle :name="contact.data.name"></user-circle>
                    <div class="ml-2">
                        <p class="text-red-400 text-bold"> {{ contact.data.name }}</p>
                        <p class="text-gray-600 text-bold"> {{ contact.data.company }}</p>
                    </div>
                </router-link>
            </div>
        </div>

    </div>
</template>

<script>
    import UserCircle from "./UserCircle";
    export default {
        components: {UserCircle},
        props : [
            'endpoint'
        ],
        name: "ContactList",data() {
            return {
                loading : true,
                contacts : null
            }
        },
        mounted() {
            axios.get(this.endpoint)
                .then(response => {
                    this.contacts =  response.data.data
                    this.loading  = false
                }).catch(error => {
                this.loading  = false

            })
        }
    }
</script>

<style scoped>

</style>
