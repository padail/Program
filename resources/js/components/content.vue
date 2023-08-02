<template>
    <div>
        <v-row>
            <v-col cols="12" class="text-center hero d-flex flex-column align-center justify-center rounded-lg">
                <h1>SELAMAT DATANG DI WEBSITE MOBREN</h1>
                <h3>Lorem ipsum do aliquid rerum! Voluptatibus, porro quis. Fuga repellendus odit maiores excepturi, iure nulla. </h3>
                <h3>Lorem ipsum do aliquid rerum! Voluptatibus, porro quis. Fuga repellendus odit maiores excepturi, iure nulla. </h3>
                <v-btn variant="outlined" color="blue" class="mt-5"><a href="#rental">RENTAL SEKARANG</a></v-btn>
            </v-col>
        </v-row>
        <v-row >
            <v-col cols="12" class="text-center">
                <h1 id="rental">DAFTAR MOBIL</h1>
                <div>
                    <v-btn class="mr-5 mt-6"  @click="cari('semua')">Semua</v-btn>
                    <v-btn class="mr-5 mt-6"  @click="cari('car')">Car</v-btn>
                    <v-btn class="mr-5 mt-6"  @click="cari('mini car')">Mini Car</v-btn>
                    <v-btn class="mr-5 mt-6"  @click="cari('bus')">Bus</v-btn>
                </div>
                <!-- <v-responsive width="300">
                    <v-select
                    v-model="cari"
                    @update:modelValue="cariData"
                    label="Jenis Mobil"
                    :items="['semua','car','mini car','bus']">
                    </v-select>
                </v-responsive> -->
            </v-col>
            <v-col md='6' sm='12' v-for="row in data" :key="row">
                <v-card class='d-flex flex-column align-center py-8 rounded-lg' style="background-color:#252D43;" >
                    <v-card-title> <h1 class="img-content " style="color:white;">{{ row.nama }}</h1></v-card-title>
                    <v-card-subtitle class="text-h5" style="color:white;">{{ row.jenis }}</v-card-subtitle>
                    <v-card-subtitle class="text-h6 my-5" style="color:white;">{{row.status}}</v-card-subtitle>
                        <v-hover v-slot="{ isHovering, props }">
                            <v-sheet
                                class="mx-auto"
                                color="grey-lighten-4"
                                max-width="400"
                                v-bind="props"
                            >
                            <v-img
                            style="background-color:#252D43;"
                            :aspect-ratio="16/9"
                            cover
                            :width='300'
                            :src="'/storage/'+row.gambar"
                            >
                            <v-expand-transition>
                                <div
                                    v-if="isHovering"
                                    class="d-flex flex-column transition-fast-in-fast-out bg-blue-darken-3  v-card--reveal"
                                    style="height: 100%;"
                                    >
                                    <p class='font'>Rp.{{row.harga}} / hari</p>
                                    <template>
                                        <div>
                                            
                                        </div>
                                    </template>
                                    <p class='text-h5'>bahan bakar {{ row.bahan_bakar }}</p>
                                    <p class='text-h5'> jumlah kursi {{row.jumlah_kursi}}</p>
                                    <div class='mt-3'>
                                        <v-btn variant="outlined" color="white" class="mx-3">Sewa</v-btn>
                                        <v-btn variant="outlined" color="white" class="mx-3" @click="ulasan(row.id)">Ulasan</v-btn>
                                    </div>
                                </div>
                            </v-expand-transition>
                            </v-img>
                            </v-sheet>
                    </v-hover>                 
                </v-card>
            </v-col>
        </v-row>
    </div>
    <v-layout row justify-center>
        <v-dialog v-model="modalUlasan" persistent max-width="800px">
            <v-btn color="primary" dark >ULASAN</v-btn>
            <v-card>
                <v-table height="300px">
                    <thead>
                        <tr>

                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="row in dataUlasan" :key="row">
                            <td class="pt-7">
                                <v-list-item-title>
                                    <v-icon icon="mdi: mdi-account" size="50"></v-icon>
                                    {{ row.nama }}
                                </v-list-item-title>
                                <div class="d-flex ml-12">
                                    <v-rating
                                    :model-value="''+row.rate"
                                    color="orange"
                                    density="compact"
                                    readonly>
                                </v-rating>
                                </div>
                                <div style="height:120px; width:650px;" class="ml-12">
                                    <p class="flex-wrap pt-2">{{ row.ulasan }}</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>

                </v-table >
                <v-card-title class="mx-auto pt-3">
                    <span class="headline">Beri Ulasan</span>
                </v-card-title>
                <v-card-text>
                    <v-card class="px-6 py-7">
                        <v-list>
                            <v-list-item>
                                <v-text-field label="nama" v-model="form.nama" variant="solo-filled"></v-text-field>
                            </v-list-item>
                            <v-list-item>
                                <v-select
                                v-model="form.rate"
                                prepend-inner-icon="mdi: mdi-star"
                                :items="['1','2','3','4','5']" >
                                </v-select>
                            </v-list-item>
                            <v-list-item>
                                <v-textarea label="Ulasan Anda" v-model="form.ulasan" variant="solo-filled"></v-textarea>
                            </v-list-item>
                            <v-list-item v-if="!user">
                                <b>Login</b> Untuk Memberikan Ulasan
                            </v-list-item>
                        </v-list>
                    </v-card>
                    
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" flat @click="modalUlasan = false">Close</v-btn>
                    <v-btn v-if="user" color="blue darken-1" flat @click="simpanUlasan">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-layout>
</template>
<script>
import layout from '../layout/layout.vue'
import { usePage } from '@inertiajs/vue3'
import axios from 'axios'
import {ref, onMounted,computed,reactive,watch} from 'vue'
export default {
    name:'content',
    layout:layout,
    setup(){
        const data = ref([])
        const modalUlasan = ref(false)
        const form = reactive({
            id:'',
            id_mobil:'',
            nama:'',
            rate:'',
            ulasan:''
        })
        const jenis = ref('semua')
        function cari($param){
            jenis.value = $param
            getMobil()
            
        }
        function ulasan($id){
            form.id_mobil = $id
            modalUlasan.value = true
            getUlasan()
        }
        const dataUlasan= ref([])
        function getUlasan(){
            const id_mobil = form.id_mobil
            axios.get('/ulasan/'+id_mobil).then((res)=>{
                dataUlasan.value = res.data
            })
        }
        function simpanUlasan(){
            axios.post('/user/ulasan',form).then((res)=>{
                getUlasan()
                form.nama = '',
                form.rate ='',
                form.ulasan=''
            })
        }
        function getMobil(){
            // console.log()
            axios.get('/daftar-mobil/'+jenis.value).then((res)=>{
                data.value = res.data
                
            })
        }
        // watch(()=> cari,()=>{
            //     getMobil()
            // })
            
            onMounted(() => {
                getMobil()
            })
        const page = usePage()
        const user = computed(() => page.props.auth.user)
        return {
            getMobil,
            ulasan,
            simpanUlasan,
            getUlasan,
            cari,
            dataUlasan,
            modalUlasan,
            data,
            form,
            page,
            user
        }
    }
}
</script>
<style>

    html {
        scroll-behavior: smooth;
        background-color: #F1F6F9;
    }

    .hero {
        height: 90vh;
        background-image: url('/assets/mobil.jpg');
        background-size: cover;
        background-position-y: -50px ;
    }

    .hero h1,h3 {
        color: aliceblue;
    }

    .hero a {
        text-decoration: none;
        color: white;
    }

    .font {
        font-size: 2rem;
    }

    .v-card--reveal {
    align-items: center;
    bottom: 0;
    justify-content: center;
    opacity: .9;
    position: absolute;
    width: 100%;
    }


</style>