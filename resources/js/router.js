import Vue from 'vue'
import vueRouter from  'vue-router'
import ExampleComponent from "./components/ExampleComponent";
import ContactCreate from "./views/ContactCreate";
import SingleContact from "./views/SingleContact";
import EditContact from "./views/EditContact";
import allContacts from "./views/allContacts";
import birthdayContacts from "./views/birthdayContacts";
import logOut from "./actions/logout";

Vue.use(vueRouter)

export default new vueRouter({
    routes : [
        {
            path : '/',
            component : ExampleComponent,
            meta :  {
                title : 'Welcome'
            }
        },
        {
            path : '/contact/create',
            component : ContactCreate,
            meta :  {
                title : 'Contact Create'
            }
        },
        {
            path : '/contacts/:id',
            component : SingleContact,
            meta :  {
                title : 'Single Contact'
            }
        },
        {
            path : '/contacts/:id/edit',
            component : EditContact,
            meta :  {
                title : 'Edit'
            }
        } ,
        {
            path : '/contacts',
            component : allContacts,
            meta :  {
                title : 'Contacts'
            }
        } ,
        {
            path : '/birthdays',
            component : birthdayContacts,
            meta :  {
                title : 'Birthdays'
            }
        },
        {
            path : '/logout',
            component : logOut,

        },
    ],
    mode : 'history'
})
