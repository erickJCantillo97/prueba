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
                      <template >
                            <v-toolbar
                                flat
                            >
                                <v-toolbar-title>Post {{desserts.length}} results</v-toolbar-title>
                               
                                <v-spacer></v-spacer>
                                <v-btn
                                    color="yellow darken-1"
                                    dark
                                    class="mb-2 mx-12"
                                    @click="consumirApi"
                                    >
                                    Consume
                                    </v-btn>
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
                                    New Post
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
                                            v-model="editedItem.userId"
                                            label="User ID"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col
                                            cols="12"
                                            sm="12"
                                            md="12"
                                        >
                                            <v-text-field
                                            v-model="editedItem.title"
                                            label="Title"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col
                                            cols="12"
                                            sm="12"
                                            md="12"
                                        >
                                           <v-textarea
                                            name="input-7-1"
                                            label="Body"
                                            v-model="editedItem.body"
                                            hint="Write Body"
                                          ></v-textarea>
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
                                    <v-card-title class="text-h5">Are you sure you want to delete this Post?</v-card-title>
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
                        <template>
                        <v-container class="grey lighten-5">
                          <v-row >
                            <v-col
                              v-for="item in desserts"
                              :key="item.id"
                              cols="12"
                              md="4"
                              sm="6"
                            >
                              <template>
                                <v-card
                                  class="mx-auto"
                                  max-width="400"
                                >
                                
                                    <v-card-title>{{item.title}}</v-card-title>
                               

                                  <v-card-subtitle class="pb-0">
                                    User ID: {{item.userId}} 
                                  </v-card-subtitle>

                                  <v-card-text class="text--primary">
                                 

                                    <div>{{item.body}}</div>
                                  </v-card-text>

                                  <v-card-actions>
                                    <v-btn
                                      color="orange"
                                      text
                                      @click="editItem(item)"
                                    >
                                      Edit
                                    </v-btn>

                                    <v-btn
                                      color="red"
                                      text
                                      @click="deleteItem(item)"
                                    >
                                      Delete
                                    </v-btn>
                                  </v-card-actions>
                                </v-card>
                              </template>
                            </v-col>
                          </v-row>
                        </v-container>
                      </template>
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
          editedIndex: -1,
          desserts: [],
          editedItem: {
            id: '',
            title: '',
            userId: '',
            body: '',
          },
          defaultItem: {
            id: '',
            title: '',
            userId: '',
            body: '',
          },
      
        }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Post' : 'Edit Post'
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
          axios.get('api/posts').then(
              res => {
                  this.desserts = res.data.posts
              }
          )
      },

      consumirApi(){
        axios.get('cusumirApi').then(
          res => {
              Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'API consumed successfully',
                showConfirmButton: false,
                timer: 1500
              })
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
        axios.get('api/posts/'+ (this.editedItem.id)).then(
          res => {
              Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Post Delete successfully',
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
        if(this.editedIndex > -1){
             axios.post('/api/posts/'+this.editedItem.id, this.editedItem).then(
                res => {
                  Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: 'Post Updated successfully',
                  showConfirmButton: false,
                  timer: 1500
                })
                }
                ).catch(
                function (error){
                    Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'An error occurred while creating the Post',
                    showConfirmButton: false,
                    timer: 1500
                  })
                }
              )

        }else{
            axios.post('/api/posts', this.editedItem).then(
                res => {
                  Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: 'Post Created successfully',
                  showConfirmButton: false,
                  timer: 1500
                })
                }
                ).catch(
                function (error){
                    Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'An error occurred while creating the Post',
                    showConfirmButton: false,
                    timer: 1500
                  })
                }
              )
        }
          
          this.initialize()
          this.close()
      },
    },
    }
</script>