<template>
    <div>
        <form @submit.prevent="submitData()">
        <input-field name="name" :errors="errors" label="Contact name" placeholder="Contact Name" @updateInput="form.name = $event" ></input-field>
        <input-field name="email" :errors="errors" label="Contact email" placeholder="Contact Email" @updateInput="form.email = $event" ></input-field>
        <input-field name="company" :errors="errors" label="Contact company" placeholder="Company" @updateInput="form.company = $event" ></input-field>
        <input-field name="birthday" :errors="errors" label="Contact birthday"placeholder="MM/DD/YY" @updateInput="form.birthday = $event" ></input-field>
            <div class="flex justify-end">
                    <button class="py-2 px-4 rounded text-red-700 border mr-5 hover:border-red-700">Cancel</button>
                    <button class="bg-red-500 py-2 px-4 rounded text-white hover:bg-red-400">Add new contact</button>
            </div>
        </form>
    </div>
</template>

<script>

    import InputField from "../components/inputField";
    export default {
        name: "ContactCreate",
        components: {InputField},
        data() {
            return {
                 form : {
                     'name'  :'',
                     'email'  :'',
                     'company'  :'',
                     'birthday' : ''
                 },
                errors : null
            }
        },
        methods : {
             submitData() {
                axios.post('/api/contacts' , this.form)
                    .then(response => {
                        this.$router.push(response.data.links.path)
                    }).catch(errors => {
                        this.errors = errors.response.data.errors
             })
            }
        }
    }
</script>

<style scoped>

</style>
