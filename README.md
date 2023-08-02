composer create-project laravel/laravel example-app

server-side
$composer require inertiajs/inertia-laravel
$php artisan inertia:middleware
kernel web :
 \App\Http\Middleware\HandleInertiaRequests::class,

client-side
npm install @inertiajs/vue3
appjs :
import { createApp, h } from 'vue'
import { createInertiaApp, Link, Head } from '@inertiajs/vue3'
// Vuetify
import 'vuetify/styles'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import '@mdi/font/css/materialdesignicons.css'
import { createVuetify } from 'vuetify'
import { aliases, md } from 'vuetify/iconsets/md'
import { mdi } from 'vuetify/iconsets/mdi'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: 'md',
        aliases,
        sets: {
        md,
        sets: {
            mdi,
          },
        },
      },
   })

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .component('Link', Link)
      .component('Head', Head)
      .use(plugin)
      .use(vuetify)
      .mount(el)
  },
})

buat view : 
	@vite('resources/js/app.css')
    	@inertiaHead


tambahkan folder "Pages" dan buat file .vue didalamnya

buat controller home
pada route web.php
sambungkan dengan use App\Controller\nama_controller
buat routenya

controller home 
sambungkan inertia\inertia;
panggil dengan inertia::render('home');

add ext
Laravel Extension Pack	
vuetify snippets = gaiya
laravel snippet = minnie lin
vue vscode snippets
vue 3 snippet = hallowtree

selanjutnya install vue
terminal: npm install vue@next vue-loader@next
terminak: npm i @vitejs/plugin-vue
terminal: npm i material-design-icons-iconfont
terminal: npm i @mdi/js
terminal: npm i @mdi/font
 
tambahkan di vite.conf.js
import vue from '@vitejs/plugin-vue'
plugins: [
vue(), 
terimnal: npm run dev

install vuetify
terminal : npm inatall vuetify@^3.3.9

membuat middleware 
php spark make::middleware nama_middleware
isi middleware yg dibuat
public function handle(Request $request, Closure $next, $level): Response
    {
        $allowedLevel = explode ('|', $level);
        if  (in_array($request->user()->level, $allowedLevel)) {
            return $next($request);
        }
        return redirect('/');
    }
isi kernel
        'level' => \App\Http\Middleware\level::class
isi route 
	Route::middleware(['auth','level:admin'])->group(function(){})
isi controller
	 if (Auth::attempt(['user_name'=>$request->user_name,'password'=>$request->password, 'level'=>'admin'])){
            return redirect('/admin');
	}
usePage share
            return array_merge(parent::share($request), [
                'auth.user' => fn () => $request->user()
                    ? $request->user()->only('user_name', 'level','password')
                    : null,
            ]);

	const page = usePage()
        const user = computed(() => page.props.auth.user)


INSTALL PINIA
npm i pinia 
tambahkan app.js
	import { createPinia } from 'pinia'
const pinia = createPinia()

setup [ 
	.use(pinia)

buat folder state dan file state
tambahkan code pada file state.js
	import {defineStore} from "pinia"
import axios from "axios"
export const useKontrol = defineStore('kontrol',{
    state:()=>({
        dataMobil : []
    }),

    actions:{
        async getMobil(){
            await axios.get('/getMobil').then((res)=>{
                this.dataMobil=res.data
            })
        }
    }
})

scripct {
import {useKontrol} from 'tempat file nya'}
const state = useKontrol()
            onMounted(() => {
                state.getMobil()
            })
            
UPLOAD GAMBAR
	<v-file-input label="Gambar mobil" prepend-icon="mdi: mdi-camera" @input="form.gambar = $event.target.files[0]"></v-file-input>
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



relasi table
	$table->id();
	$table->bigInteger('data_mobil_id')->unsigned();
	$table->foreign('data_mobil_id')->references('id')->on('data_mobils')->onDelete('cascade')->onUpdate('cascade');

php ti create user 
User::create(["name"=> "larainfo","email"=>"larainfo@gmail.com","password"=>bcrypt("123456")]);

