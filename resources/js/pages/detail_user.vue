<template>
    <div>
        <v-btn color="success" class="mb-7" @click="ModalUser=true">Tambah User</v-btn>

        <div class="mb-5 d-flex align-center" width="100vw">
            <v-btn @click="cariLevel('semua')" class="mr-5" >Semua</v-btn>
            <v-btn @click="cariLevel('admin')" class="mr-5" >Admin</v-btn>
            <v-btn @click="cariLevel('user')"  class="mr-5" >User</v-btn>
        </div>
        <!-- <v-select
        v-model="cari"
        @update:modelValue="cariLevel"
        label="LEVEL"
        :items="['semua','admin','user']"
        >
        </v-select> -->
        <v-row>
            <v-col xs="12" md='12' lg="4" v-for="row in data" :key="row">
                <v-card style="background-color: #252D43;">
                    <v-card-title class="text-center" style="color:white;">
                        <b>STATUS USER</b>
                    </v-card-title>
                    <div class="text-center">
                        <v-card-item>
                            <v-avatar
                                size="120"
                                color="grey"
                            >
                                <v-icon icon="mdi: mdi-account" size="120"></v-icon>
                                
                            </v-avatar>
                        </v-card-item>
                        <v-card-title style="color:white;">{{row.user_name}}</v-card-title>
                        <v-card-subtitle class="mt-n3" style="color:white;">{{row.level}}</v-card-subtitle>
                        <div class="py-7">
                            <v-btn class="mr-4" variant="elevated" color="warning" @click="editUser(row.id)">Edit</v-btn>
                            <v-btn variant="elevated" color="red" @click="deleteUser(row.id)">Delete</v-btn>
                        </div>
                    </div>
                </v-card>
            </v-col>
        </v-row>
    </div>
    <v-dialog
        v-model="ModalUser"
        scrollable 
        max-width="500px"
    >
        <v-sheet class="px-12 py-12">
            <v-card>
                <v-card-title class="text-center"><b>Tambahkan User</b></v-card-title>
                <v-form>
                    <v-card-item>
                        <v-text-field
                        v-model="form.username"
                        prepend-inner-icon="mdi: mdi-account"
                        label="userName">
                        </v-text-field>
                        <v-text-field
                        type="password"
                        v-model="form.password"
                        prepend-inner-icon="mdi: mdi-account-lock"
                        label="Password">
                        </v-text-field>
                        <v-select
                        v-model="form.level"
                        :items="['admin','user']"
                        label="Level">
                        </v-select>
                        <v-checkbox label="yakin data sudah benar?" v-model="yakin"></v-checkbox>
                        <v-btn color="success" block 
                        :disabled="!yakin" @click="simpan">simpan</v-btn>
                    </v-card-item>
                </v-form>
            </v-card>
        </v-sheet>
    </v-dialog>
</template>

<script>
import axios from 'axios';
import layout from '../layout/layout.vue';
import {ref,reactive, onMounted} from 'vue'
    export default {
        layout:layout,
        setup(){
            // const modalEdit = ref(false)
            const ModalUser = ref(false)
            const yakin = ref('')
            const level = ref('semua')
            const form = reactive({
                id:'',
                username:'',
                password:'',
                level:''
            })
            // console.log(cari)
            function cariLevel($level){
                level.value = $level
                getUser()
            }
            // console.log(cari)
            function simpan(){
                axios.post('/admin/user',form).then((res)=>{
                    getUser()
                    ModalUser.value = false
                    form.username=''
                    form.password=''
                })
            }
            const data = ref([])
            function getUser(){
                axios.get('/admin/data-user/'+level.value).then((res)=>{
                    data.value = res.data
                })
            }
            function editUser($id) {
                axios.post('/admin/user/'+$id).then((res)=>{
                    form.id = res.data.id
                    form.username = res.data.user_name
                    form.level =res.data.level
                    ModalUser.value = true
                })
            }
            function deleteUser($id){
                axios.delete('/admin/delete/'+$id).then((res)=>{
                    getUser()
                })
            }
            onMounted(() => {
                getUser()
            })
            return {
                ModalUser,
                level,
                yakin,
                form,
                data,
                simpan,
                cariLevel,
                deleteUser,
                editUser,
                getUser
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>