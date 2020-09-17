<template>
    <div>
        <div v-if="focus" @click="focus = false" class="absolute bg-black opacity-25 z-10 top-0 right-0 left-0 bottom-0"></div>
        <div class="relative z-10">
            <div class="absolute flex items-center">
                <svg viewBox="0 0 24 24" class="w-5 h-5 mt-2 ml-2">
                    <path fill-rule="evenodd" d="M20.2 18.1l-1.4 1.3-5.5-5.2 1.4-1.3 5.5 5.2zM7.5 12c-2.7 0-4.9-2.1-4.9-4.6s2.2-4.6 4.9-4.6 4.9 2.1 4.9 4.6S10.2 12 7.5 12zM7.5.8C3.7.8.7 3.7.7 7.3s3.1 6.5 6.8 6.5c3.8 0 6.8-2.9 6.8-6.5S11.3.8 7.5.8z" clip-rule="evenodd"/>
                </svg>
            </div>
            <input
                    class="w-64 mr-6 bg-gray-200 border border-gray-400 pl-8 pr-3 py-2 rounded-full  text-sm focus:outline-none focus:border-blue-500  focus:bg-gray-100"
                    type="text" placeholder="Search..." id="searchTerm" v-model="searchTerm" @input="search" name="searchTerm" @click="focus = true">
            <div v-if="focus" class="w-96 absolute mt-2 bg-blue-800 text-white w-64 rounded rounded-lg py-5 px-4 right-0 py-2 z-20">
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
