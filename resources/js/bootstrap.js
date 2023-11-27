import axios from 'axios';
import Pusher from 'pusher-js'
import Echo from 'laravel-echo'
import {createApp} from "vue/dist/vue.esm-bundler"
import OrderChatComponent from './components/OrderChatComponent.vue'

const EchoInstance = new Echo({
    broadcaster: 'pusher',
    key: 'cMtiHg.XV1L5g',
    wsHost: 'realtime-pusher.ably.io',
    wsPort: 443,
    disableStats: true,
    encrypted: true,
    cluster: 'eu',
})

const app = createApp({})

app.provide('echo', EchoInstance)

app.component('OrderChatComponent', OrderChatComponent)

app.mount("#app");
