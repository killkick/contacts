<template>
<div>
    <div v-if="loading">loading</div>
    <div v-else>
        <div class="flex justify-between">
            <a href="#" class="text-blue-400" @click="$router.back()">
                < Back
            </a>
            <div class="relative">
                <router-link :to="'/contacts/' +  contact.contact_id + '/edit'"
                             class="px-4 py-2 rounded text-sm text-green-500 border-green-500 border font-bold mr-2">Edit</router-link>
                <a class="px-4 py-2 border-red-500 border rounded text-sm font-bold text-red-500" href="" @click.prevent="modal = !modal">Delete</a>
                <div class="absolute bg-blue-800 text-white w-64 rounded rounded-lg py-5 px-4 right-0 py-2 z-20" v-if="modal">
                  <p class="px-4 py-2">
                      Are you sure to delete this contact?
                  </p>
                    <div class="flex justify-end mt-5">
                        <button class="mr-3" @click="modal = !modal" >Cancel</button>
                        <button class="px-4 py-2 ronded rounded-lg bg-red-500 text-white" @click="destroy">Delete</button>
                    </div>
                </div>

            </div>
            <div class="absolute bg-black opacity-25 right-0 bottom-0 left-0 top-0 z-10" v-if="modal" @click="modal = !modal"></div>
        </div>
        <div class="flex items-center pt-6">
            <UserCircle :name="contact.name"></UserCircle>
            <p class="pl-5 text-xl">{{ contact.name }}</p>
        </div>
        <p  class="pt-6 text-gray-600 font-bold uppercase font-sm">Contact</p>
        <p class="pt-2 text-blue-400">{{contact.email }}</p>
        <p  class="pt-6 text-gray-600 font-bold uppercase font-sm">Company</p>
        <p class="pt-2 text-blue-400">{{contact.company }}</p>
        <p class="pt-6 text-gray-600 font-bold uppercase font-sm">Birthday</p>
        <p class="pt-2 text-blue-400">{{contact.birthday }}</p>
    </div>
</div>
</template>

<script>
    import UserCircle from "../components/UserCircle";
    export default {
        name: "SingleContact",
        components: {UserCircle},
        data() {
            return {
                contact : null,
                loading :true,
                modal :  false,
            }
        },
        mounted() {
            axios.get('/api/contacts/' + this.$route.params.id)
                .then(response => {

                    this.contact = response.data.data
                    this.loading = false;
                }).catch(error => {
                this.loading = false;
            })
        },
        methods : {
            destroy() {
                axios.delete('/api/contacts/' + this.$route.params.id)
                    .then(response => {
                        this.$router.push('/contacts')
                    })
                    .catch( error => {

                    }
                )
            }
        }

    }
</script>

<style scoped>

</style>
