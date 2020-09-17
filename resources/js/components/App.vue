<template>
    <div class="h-screen bg-white">
        <div class="flex">
            <div class="w-48 h-screen border-r-2 border-gray-400 pl-6">
                <nav class="pt-4">
                    <router-link to="/" class="">
                        Home
                    </router-link>
                    <p class="text-gray-500 uppercase font-bold pt-12 text-xs">Create</p>
                    <router-link to="/contact/create" class="flex items-center py-2 hover:text-red-700 text-sm">
                        <div class="tracking-wide pl-3">Add new</div>
                    </router-link>
                    <p class="text-gray-500 uppercase font-bold pt-12 text-xs">General</p>
                    <router-link to="/contacts" class="flex items-center py-2 hover:text-red-700 text-sm">

                        <div class="tracking-wide pl-3">Contacts</div>
                    </router-link>
                    <router-link to="/birthdays" class="flex items-center py-2 hover:text-red-700">

                        <div class="tracking-wide pl-3">Birthdays</div>
                    </router-link>
                    <p class="text-gray-500 uppercase font-bold pt-12 text-xs">Settings</p>
                    <router-link to="/logout" class="flex items-center py-2 hover:text-red-700 text-sm">
                        <div class="tracking-wide pl-3">Logout</div>
                    </router-link>

                </nav>
            </div>
            <div class="flex-1 flex flex-col h-screen overflow-y-hidden">
                <div class="px-6 h-16 border-gray-400 border-b flex items-center justify-between">
                    <div>
                         {{ title }}
                    </div>
                    <div class="flex items-center">
                        <search-bar></search-bar>
                        <user-circle :name="user.name"></user-circle>
                    </div>

                </div>

                <div class=" flex flex-col flex-1 overflow-y-hidden">
                    <router-view class="overflow-x-hidden p-6"></router-view>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import UserCircle from "./UserCircle";
    import SearchBar from "./searchBar";
    export default {
        name: "App",
        components: {SearchBar, UserCircle},
        props: [
          'user'
        ],

        created() {
            this.title = this.$route.meta.title
                window.axios.interceptors.request.use(
                    (config) => {
                        if(config.method === 'get') {
                            config.url  = config.url + '?api_token=' + this.user.api_token
                        } else {
                            config.data = {
                                ...config.data,
                                'api_token' : this.user.api_token
                            };
                        }
                        return config
                    }
                )
        },
        data() {
            return {
                title : ''
            }
        },
        watch : {
            $route(to, from) {
                this.title = to.meta.title
            },
            title() {
                document.title =  this.title + ' | the SPA App'
            }
        }
    }
</script>

<style scoped>

</style>
