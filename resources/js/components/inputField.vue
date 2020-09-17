<template>
    <div class="relative pb-4">
        <label :for="name" class="text-blue-500 text-xs pt-2 uppercase font-bold absolute"> {{ label }}</label>
        <input type="text" :id="name"
               class="pt-8 text-gray-900 w-full border-b pb-2 focus:outline-none focus:border-blue-400"
               :placeholder="placeholder" :class="errorClassObject()" v-model="value" @input="update()">
        <p class="text-red-700 text-xs" v-text="errorMessage()"></p>
    </div>
</template>

<script>

    export default {
        name: "inputField",
        props: [
            'name', 'label', 'placeholder', 'errors' , 'watchDate'
        ],
        data() {
            return {
                value: ''
            }
        },
        methods: {
            update() {
                this.updateErrorMessage(this.name);
                this.$emit('updateInput', this.value)
            },
            errorMessage() {
                if (this.hasError) {
                    return this.errors[this.name][0]
                }
            },
            updateErrorMessage () {
                if (this.hasError) {
                    return this.errors[this.name] =  null;
                }
            },
            errorClassObject() {
                    return {
                        'error_field' : this.hasError
                    }
            }
        },
        computed : {
            hasError() {
                return this.errors && this.errors[this.name] && this.errors[this.name].length > 0
            }
        },
        watch : {
            watchDate : function (val) {
                this.value =  val
            }
        }
    }
</script>

<style scoped>
    .error_field {
        @apply .border-red-500 .border-b-2
    }
</style>
