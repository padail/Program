<template lang="">
    <div>
        <v-layout >
            <v-app-bar>

                <h4 class='ml-5'>MOBREN</h4>
                <v-icon class="ml-12" @click="sideMenu=!sideMenu">menu</v-icon>

                <template v-slot:append>
                    <v-btn  v-if="!user" color="blue" class="mr-8" variant='outlined' @click="modalLogin=true">login</v-btn>
                    <v-btn v-else color="blue" class="mr-8" variant='outlined' @click='logout'>Logout</v-btn>
                </template>
            </v-app-bar>
            <v-navigation-drawer class="pt-12" style="background-color:#252D43;" v-model='sideMenu'>
                <v-list class="d-flex align-center flex-column">
                    <!-- Profil -->
                    <div class="d-flex align-center">
                        <v-avatar
                            size="65"
                            color="grey"
                        >
                            <v-icon icon='mdi: mdi-account' size='60' />
                        </v-avatar>
                        <v-list-item
                        style="color:white;"
                        v-if="user"
                        :title='user.user_name'
                        :subtitle='user.level'>
                        </v-list-item>
                    </div>
                    <!-- End Profil -->
                    <!-- SideMenu -->
                    <v-list density="compact" class="mt-9 d-flex flex-column">
                        <v-list-subheader><h2 style='color:white;'>MENU</h2></v-list-subheader>
                        <v-list-item style="color:white;" @click='beranda'>
                            <template v-slot:prepend >
                            <v-icon icon="mdi: mdi-home"></v-icon>
                            </template>
                            <v-list-item-title >Beranda</v-list-item-title>
                        </v-list-item>
                        <v-list-item style="color:white;" v-if="user&&user.level=='admin'" @click="detailUser">
                            <template v-slot:prepend>
                            <v-icon icon="mdi: mdi-account"></v-icon>
                            </template>
                            <v-list-item-title>User</v-list-item-title>
                        </v-list-item>
                        <v-list-item style="color:white;"  v-if="user&&user.level=='admin'" @click='mobil'>
                            <template v-slot:prepend>
                                    <v-icon icon='mdi: mdi-car'></v-icon>
                            </template>
                            <v-list-item-title>Daftar Mobil</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-list>
                <template v-slot:append>
                        <v-footer class='d-flex justify-center' >
                            @CoppyRight2023
                        </v-footer>
                </template>
            </v-navigation-drawer>

            <v-main>
                <div class='mx-12 my-12'>
                    <v-alert
                        v-model="alert"
                        type="success"
                        title="Login Success"
                    ></v-alert>
                    <slot ></slot>
                </div>
            </v-main>
        </v-layout>
    </div>

    <!-- Login -->
    <v-dialog
        v-model="modalLogin"
        max-width="500px"
    >
        <v-sheet class='pa-12' rounded>
            <v-card-title primary-title class="text-center">
                <div>
                    <h3 class="headline mb-0" style='color:black;'>Selamat Datang</h3>
                </div>
            </v-card-title>
            <v-form>
                <div class="d-flex flex-column align-center py-8">
                    <v-card class="mx-auto px-6 py-8" width="344">
                        <v-text-field
                            v-model='form.user_name'
                            :rules='error'
                            prepend-icon = 'mdi: mdi-account'
                            label="UserName"
                        ></v-text-field>
                        <v-text-field
                            type="password"
                            v-model='form.password'
                            prepend-icon = "mdi: mdi-account-lock"
                            label="Password"
                        ></v-text-field>
                        <v-btn color="primary" variant='elevated' @click='login' block>Login</v-btn>
                        <p class="mt-4">belum punya akun? <v-btn color="blue" variant='text' @click='openDaftar'>Daftar</v-btn></p>
                    </v-card>
                </div>
            </v-form>
        </v-sheet>
    </v-dialog>
    <!-- End Login -->

    <!-- Daftar -->
    <v-dialog
        v-model="modalDaftar"
        max-width="500px"
    >
        <v-sheet class='pa-12' rounded>
            <v-card-title primary-title class="text-center">
                <div>
                    <h3 class="headline mb-0" style='color:black;'>Silahkan Daftar</h3>
                </div>
            </v-card-title>
            <v-form>
                <div class="d-flex flex-column align-center py-8">
                    <v-card class="mx-auto px-6 py-8" width="344">
                        <v-text-field
                            v-model='formDaftar.user_name'
                            :rules='error'
                            prepend-icon = 'mdi: mdi-account'
                            label="UserName"
                        ></v-text-field>
                        <v-text-field
                            type="password"
                            v-model='formDaftar.password'
                            prepend-icon = "mdi: mdi-account-lock"
                            label="Password"
                        ></v-text-field>
                        <v-checkbox label="yakin data sudah benar?" v-model='enable'></v-checkbox>
                        <v-btn color="primary" variant='elevated' @click='daftar' block :disabled='!enable'>Daftar</v-btn>
                    </v-card>
                </div>
            </v-form>
        </v-sheet>
    </v-dialog>
    <!-- End Daftar -->
</template>

<script>
import {ref, reactive,computed} from 'vue'
import {router, usePage} from '@inertiajs/vue3'
import axios from 'axios'
export default {
    setup(){
        const sideMenu = ref(true)
        const enable = ref(false)
        const modalLogin = ref(false)
        const modalDaftar = ref(false)
        const error = ref([])
        const alert = ref(false)
        const page = usePage()
        const user = computed(() => page.props.auth.user)
        const form = reactive({
            user_name:'',
            password:''
        })
        const formDaftar = reactive ({
            user_name:'',
            password:'',
            level:'user'
        })
        function beranda(){
            router.get('/')
        }
        function detailUser() {
        router.get('/admin/user')
        }
        function mobil(){
            router.get('/admin/daftar-mobil')
        }
        function login(){
            router.visit('/login',{
                method:'post',
                data:{
                    user_name:form.user_name,
                    password:form.password
                },
                onSuccess:()=>{
                    modalLogin.value = false
                    alert.value=true,
                    setTimeout( () => alert.value=false, 2000 );
                    form.user_name  =''
                    form.password   =''
                },
                onError:(er)=>{
                    console.log(er)
                    error.value = er
                }
            })
        }
        function logout()
        {
            router.get('/logout')
        }
        function openDaftar(){
            modalDaftar.value=true,
            modalLogin.value=false
        }
        function daftar(){
            axios.post('/daftar',formDaftar).then((res)=>{
                modalDaftar.value=false,
                modalLogin.value=true
            })
        }
        return {
            sideMenu,
            modalLogin,
            modalDaftar,
            enable,
            form,
            error,
            alert,
            page,
            user,
            formDaftar,
            detailUser,
            mobil,
            openDaftar,
            beranda,
            daftar,
            logout,
            login
        }
    }
}
</script>
<style>
    
</style>