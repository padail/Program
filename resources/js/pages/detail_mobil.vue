<template>
    <div>
        <v-row>
            <v-col cols="12">
                <v-sheet class="mx-7" style="background-color: whitesmoke;">
                    <v-btn color="success" variant="elevated" @click="modalMobil=true"> Tambah Mobil</v-btn>
                    <v-card class="my-7 py-7" v-for="row in data" :key="row">
                        <v-row>
                            <v-col md="6" class="pl-12">
                                <v-img
                                :src="'/storage/'+ row.gambar"
                                :aspect-ratio="4/3"
                                :width="400"
                                ></v-img>
                            </v-col>
                            <v-col md="6" class="d-flex flex-column justify-center align-lg-end px-12">
                                <h2 style="color: blue;">Rp.{{ row.harga }} / Hari</h2>
                                <h3 style="color: black;">Pemilik = {{row.user_name }}</h3>
                                <h3 style="color: black;">Nama = {{row.nama }}</h3>
                                <h3 style="color: black;">jenis = {{ row.jenis }}</h3>
                                <h3 style="color: black;">bahan bakar = {{row.bahan_bakar}}</h3>
                                <h3 style="color: black;">Jumlah kursi = {{row.jumlah_kursi}}</h3>
                                <div class="my-7">
                                    <v-btn color="warning" class="mr-5" @click="editMobil(row.id)">edit</v-btn>
                                    <v-btn color="red" @click="hapusMobil(row.id)">hapus</v-btn>
                                </div>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-sheet>
            </v-col>
        </v-row>
    </div>

    <!-- Modal Mobil -->
    <v-dialog
        v-model="modalMobil"
        max-width="500px"
    >
        <v-sheet class="px-7 py-7 bg-blue-darken-4 rounded-shaped" >
            <v-card class="text-center py-5">
                <v-card-title><h2>Tambah Mobil</h2></v-card-title>
                <v-card-item>
                    <v-text-field v-model="form.nama" label="Nama"></v-text-field>
                    <v-select
                    v-model="form.jenis" label="Jenis"
                    :items="['mini car', 'car', 'bus']">
                    </v-select>
                    <v-select
                    v-model="form.bahan_bakar" label="Bahan bakar"
                    :items="['Bensin', 'Solar']">
                    </v-select>
                    <v-text-field v-model="form.jumlah_kursi" label="Jumlah kursi"></v-text-field>
                    <v-text-field v-model="form.harga" label="Harga"></v-text-field>
                    <v-file-input label="Gambar mobil" prepend-icon="mdi: mdi-camera" @input="form.gambar = $event.target.files[0]"></v-file-input>
                    <v-select
                    v-model="form.status"
                    label="Status"
                    :items="['Tersedia','Tidak Tersedia']">
                    </v-select>
                    <v-select
                    v-model="form.id_user"
                    label="Sales"
                    :items="[namaUser]">
                    </v-select>
                    <v-btn v-for="row in namaUser" :key="row">{{ row.user_name }}</v-btn>
                    <v-btn color="success" block @click="addMobil">Tambah</v-btn>
                </v-card-item>
            </v-card>
        </v-sheet>
    </v-dialog>
    <!-- End Modal Mobil -->
</template>
<script>
import { router } from '@inertiajs/vue3'
import layout from '../layout/layout.vue'
import {ref, reactive, onMounted} from 'vue'
import axios from 'axios'
export default {
    layout:layout,
    setup(){
        const modalMobil = ref(false)
        const form = reactive({
            id:'',
            id_user:'',
            nama:'',
            jenis:'',
            harga:'',
            status:'',
            bahan_bakar:'',
            jumlah_kursi:'',
            gambar:null
        })
        
        function addMobil(){
            router.visit('/admin/mobil',
            {
                method:'post',
                data:{
                    id:form.id,
                    nama:form.nama,
                    jenis:form.jenis,
                    bahan_bakar:form.bahan_bakar,
                    harga:form.harga,
                    jumlah_kursi:form.jumlah_kursi,
                    status:form.status,
                    gambar:form.gambar
                    },
                    forceFormData: true,
                    preserveScroll: true,
                    preserveState:true, 
                    onSuccess:()=>{
                        getMobil()
                        modalMobil.value=false
                    }
            })
        }
        const namaUser= ref([])
        function getUser(){
            axios.get('/getUser').then((res)=>{
                namaUser.value = res.data
                console.log(namaUser)
            })
        }
        const data = ref([])
        function getMobil(){
            axios.get('/mob').then((res)=>{
                data.value = res.data
                // console.log(res.data)
            })
        }
        onMounted(() => {
            getMobil()
            getUser()
        })
        function editMobil($id){
            axios.get('/admin/mobil/'+$id).then((res)=>{
                form.id = $id,
                form.nama = res.data.nama,
                form.jenis = res.data.jenis,
                form.harga = res.data.harga,
                form.status = res.data.status,
                form.bahan_bakar = res.data.bahan_bakar,
                form.jumlah_kursi = res.data.jumlah_kursi,
                form.gambar = res.data.gambar,
                modalMobil.value=true
            })
        }
        function hapusMobil($id){
            axios.delete('/admin/mobil/'+$id).then((res)=>{
                getMobil()
            })
        }
        return {
            modalMobil,
            form,
            data,
            namaUser,
            editMobil,
            hapusMobil,
            addMobil, 
            getMobil,
            addMobil,
        }
    }
}
</script>
<style>
    
</style>