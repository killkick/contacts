<template>
    <div>
        <div>
            <a href="#" class="text-red-400" @click="$router.back()">
                < Back
            </a>
        </div>
        <form @submit.prevent="submitData()">
            <input-field name="name" :errors="errors" label="Contact name" placeholder="Contact Name" @updateInput="form.name = $event" :watchDate="form.name" ></input-field>
            <input-field name="email" :errors="errors" label="Contact email" placeholder="Contact Email" @updateInput="form.email = $event" :watchDate="form.email" ></input-field>
            <input-field name="company" :errors="errors" label="Contact company" placeholder="Company" @updateInput="form.company = $event" :watchDate="form.company" ></input-field>
            <input-field name="birthday" :errors="errors" label="Contact birthday"placeholder="MM/DD/YY" @updateInput="form.birthday = $event" :watchDate="form.birthday" ></input-field>
            <div class="flex justify-end">

                <button class="bg-red-500 py-2 px-4 rounded text-white hover:bg-red-400" >Edit</button>
            </div>
        </form>
    </div>
</template>

<script>
    import InputField from "../components/inputField";
    export default {

        name: "EditContact",
        components: {InputField},
        data() {
            return {
                form : {
                    'name'  :'',
                    'email'  :'',
                    'company'  :'',
                    'birthday' : ''
                },
                errors : null,
            }
        },
        mounted() {
            axios.get('/api/contacts/' + this.$route.params.id)
                .then(response => {
                    this.form = response.data.data
                    this.loading = false;
                }).catch(error => {
                this.loading = false;
            })
        },
        methods : {
            submitData() {
                axios.patch('/api/contacts/' + this.$route.params.id  , this.form)
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
