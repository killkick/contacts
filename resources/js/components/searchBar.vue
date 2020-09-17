<template>
    <div>
        <div v-if="focus" @click="focus = false" class="absolute bg-black opacity-25 z-10 top-0 right-0 left-0 bottom-0"></div>
        <div class="relative z-10">
            <div class="absolute flex items-center">
            </div>
            <input
                    class="w-64 mr-6 bg-gray-200 border border-gray-400 pl-8 pr-3 py-2 rounded-full  text-sm focus:outline-none focus:border-red-500  focus:bg-gray-100"
                    type="text" placeholder="Search..." id="searchTerm" v-model="searchTerm" @input="search" name="searchTerm" @click="focus = true">
            <div v-if="focus" class="w-96 absolute mt-2 bg-red-800 text-white w-64 rounded rounded-lg py-5 px-4 right-0 py-2 z-20">
                <div v-if="results.length === 0"> No result for '{{ searchTerm }}'</div>
                <div v-for="result in results" @click="focus = false">
                    <router-link :to="result.links.path" class="block py-2">
                        <div class="flex items-center">
                            <user-circle :name="result.data.name"></user-circle>
                            <div class="pl-3">
                                <p> {{ result.data.name}}</p>
                                <p>{{result.data.company }}</p>
                            </div>
                        </div>

                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import _ from 'lodash'
    import UserCircle from "./UserCircle";
    export default {

        name: "searchBar",
        components: {UserCircle},
        data() {
            return {
                focus : false,
                searchTerm : '',
                results :  [

                ]
            }
        },
        methods :{
            search :  _.debounce(function () {
                if( this.searchTerm.length <3 ) {
                    return;
                }else {
                    axios.post('/api/search', {searchTerm : this.searchTerm})
                        .then(response => {
                                this.results =  response.data.data
                            }
                        ).catch(error => {

                    })
                }
            }, 300)
        }
    }
</script>

<style scoped>

</style>
