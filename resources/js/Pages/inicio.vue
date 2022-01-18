<template>
<v-app>
    <app-layout>
        <template #header>
            <div class="flex">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Home
                </h2>
                
                <v-spacer></v-spacer>
                <inertia-link :href="route('home')">
                  <v-btn class="mx-12" color="primary">
                      Users
                  </v-btn>
                </inertia-link>
                <inertia-link :href="route('posts')">
                  <v-btn color="success">
                      Posts
                  </v-btn>
                </inertia-link>
            </div>
           
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                   <template>
                        <v-data-table
                            :headers="headers"
                            :items="desserts"
                            sort-by="calories"
                            class="elevation-1"
                        >
                         <template v-slot:item.profile_photo_url="{ item }">
                          <v-img
                          class="rounded-full"
                            :lazy-src="item.profile_photo_url"
                            max-height="40"
                            max-width="40"
                            :src="item.Gravatar"
                            ></v-img>
                            </template>
                            <template v-slot:top>
                            <v-toolbar
                                flat
                            >
                                <v-toolbar-title>Users</v-toolbar-title>
                               
                                <v-spacer></v-spacer>
                                <v-dialog
                                v-model="dialog"
                                max-width="500px"
                                >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn
                                    color="primary"
                                    dark
                                    class="mb-2"
                                    v-bind="attrs"
                                    v-on="on"
                                    >
                                    New User
                                    </v-btn>
                                </template>
                                <v-card>
                                    <v-card-title>
                                    <span class="text-h5">{{ formTitle }}</span>
                                    </v-card-title>

                                    <v-card-text>
                                    <v-container>
                                        <v-row>
                                        <v-col
                                            cols="12"
                                            sm="12"
                                            md="12"
                                        >
                                            <v-text-field
                                            v-model="editedItem.name"
                                            label="User Name"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col
                                            cols="12"
                                            sm="12"
                                            md="12"
                                        >
                                            <v-text-field
                                            v-model="editedItem.email"
                                            label="User Email"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col
                                            cols="12"
                                            sm="12"
                                            md="12"
                                        >
                                            <v-text-field
                                            v-model="editedItem.city"
                                            label="User City"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col
                                            cols="12"
                                            sm="6"
                                            md="6"
                                        >
                                            <v-text-field
                                            v-model="editedItem.company_name"
                                            label="Company Name"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col
                                            cols="12"
                                            sm="6"
                                            md="6"
                                        >
                                            <v-text-field
                                            v-model="editedItem.desing"
                                            label="Desing (Optional)"
                                            ></v-text-field>
                                        </v-col>
                                        </v-row>
                                    </v-container>
                                    </v-card-text>

                                    <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        color="blue darken-1"
                                        text
                                        @click="close"
                                    >
                                        Cancel
                                    </v-btn>
                                    <v-btn
                                        color="blue darken-1"
                                        text
                                        @click="save"
                                    >
                                        Save
                                    </v-btn>
                                    </v-card-actions>
                                </v-card>
                                </v-dialog>
                                <v-dialog v-model="dialogDelete" max-width="500px">
                                <v-card>
                                    <v-card-title class="text-h5">Are you sure you want to delete this User?</v-card-title>
                                    <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                                    <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                                    <v-spacer></v-spacer>
                                    </v-card-actions>
                                </v-card>
                                </v-dialog>
                            </v-toolbar>
                            </template>
                            <template v-slot:item.actions="{ item }">
                            <v-icon
                                small
                                class="mr-2"
                                @click="editItem(item)"
                            >
                                mdi-pencil
                            </v-icon>
                            <v-icon
                                small
                                @click="deleteItem(item)"
                            >
                                mdi-delete
                            </v-icon>
                            </template>
                         
                        </v-data-table>
                    </template>
                </div>
            </div>
        </div>
    </app-layout>
</v-app>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import Swal from 'sweetalert2'
    export default {
        components: {
            AppLayout,
            Welcome,
        },
         data: () => ({
      dialog: false,
      dialogDelete: false,
      headers: [
        {
          text: 'Icon',
          align: 'start',
          sortable: false,
          value: 'profile_photo_url',
        },
        {
          text: 'name',
          
          value: 'name',
        },
        { text: 'Email', value: 'email' },
        { text: 'City', value: 'city' },
        { text: 'Company Name', value: 'company_name' },
        { text: 'Desing', value: 'desing' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      desserts: [],
      editedIndex: -1,
      editedItem: {
        id: '',
        name: '',
        email: '',
        company_name: '',
        city: '',
        desing: ''
      },
      defaultItem: {
        id: '',
        name: '',
        email: '',
        company_name: '',
        city: '',
        desing: ''
      },
   
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New User' : 'Edit User'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
      dialogDelete (val) {
        val || this.closeDelete()
      },
    },

    created () {
      this.initialize()
    },

    methods: {
      initialize () {
          axios.get('api/users').then(
              res => {
                  this.desserts = res.data.users
              }
          )
      },

      editItem (item) {
        this.editedIndex = this.desserts.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.desserts.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        axios.post('api/users/'+ (this.editedItem.id)).then(
          res => {
              Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'User Delete successfully',
                showConfirmButton: false,
                timer: 1500
              })
          })
          this.initialize()
        this.closeDelete()
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      save () {
       axios.post('/api/users', this.editedItem).then(
         res => {
           Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'User Created successfully',
            showConfirmButton: false,
            timer: 1500
          })
         }
       )
       this.initialize()
        this.close()
      },
    },
    }
</script>