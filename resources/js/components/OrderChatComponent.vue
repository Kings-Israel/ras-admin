<template>
    <div class="chat">
        <!-- <div class="chat-header clearfix">
            <div class="chat-about">
                <div class="chat-with">Aiden Chavez</div>
                <div class="chat-num-messages">already 8 messages</div>
            </div>
        </div>
        <hr> -->
        <div class="chat-history clearfix" ref="refChatLogPS">
            <ul class="">
                <li v-for="log in conversation_log" :key="log.id" class="clearfix">
                    <div v-if="log.sender.id == sender_id" class="message-data text-right">
                        <span class="message-data-time">{{ log.created_at }}</span>
                    </div>
                    <div v-else class="message-data">
                        <span class="message-data-time">{{ log.created_at }}</span>
                    </div>
                    <div v-if="log.sender.id == sender_id" class="message text-right other-message float-right">
                        <div v-if="log.data && log.data.length > 0">
                            <div v-for="(data, index) in log.data" v-bind:key="index" class="d-flex" style="cursor: pointer;">
                                <p @click.prevent="downloadFile(data)" class="mr-2">{{ data.file_name }}</p> - <p class="">{{ formatBytes(data.file_size) }}</p>
                            </div>
                        </div>
                        <span v-if="log.body != 'files_only_message'">
                            {{ log.body }}
                        </span>
                    </div>
                    <div v-else class="message my-message">
                        <div v-if="log.data && log.data.length > 0">
                            <div v-for="(data, index) in log.data" v-bind:key="index" class="d-flex" style="cursor: pointer;">
                                <p @click.prevent="downloadFile(data)" class="mr-2">{{ data.file_name }}</p> - <p class="">{{ formatBytes(data.file_size) }}</p>
                            </div>
                        </div>
                        <span v-if="log.body != 'files_only_message'">{{ log.body }}</span>
                    </div>
                </li>
            </ul>
        </div>
        <hr>
        <div class="chat-message clearfix">
            <form action="#" method="post" id="send-message-form" enctype="multipart/form-data" ref="sendMessageForm">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Enter text here..." ref="refMessageTextInput" v-model="refMessageText">
                    <button type="submit" class="input-group-addon" @click.prevent="sendMessage"><i class="zmdi zmdi-mail-send"></i></button>
                </div>
                <input type="file" class="d-none" v-on:change="uploadFiles" multiple name="docs[]" id="docs-input" ref="docsInput">
            </form>
            <button class="btn btn-raised btn-info btn-round" @click.prevent="uploadFile"><i class="zmdi zmdi-file-text"></i></button>
            <div v-if="files.length > 0" class="">
                <div class="d-flex">
                    <span v-for="file in files" :key="file" class="mr-2">{{ file.name }}</span>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { onMounted, ref, nextTick, inject } from 'vue';
import moment from 'moment';
import axios from 'axios';
export default {
    name: 'OrderChatComponent',
    props: ['email', 'conversation', 'type', 'sender'],
    setup(props) {
        const active_conversation = ref('')
        const conversation_log = ref([])
        const receiver = ref(null)
        const files = ref([])
        const refChatLogPS = ref('')
        const refMessageTextInput = ref('')
        const refMessageText = ref('')
        const messagesBox = ref('')
        const docsInput = ref('')
        const email = ref('')
        const sender_id = ref('')

        const echo = inject('echo')

        onMounted(() => {
            email.value = props.email
            sender_id.value = props.sender
            getConversation(props.conversation, props.type, props.sender)
            echo
                .channel(email.value)
                .listen('.new.message', (e) => {
                    if (active_conversation.value && (Number(e.message.conversation_id) === Number(active_conversation.value))) {
                        conversation_log.value.push(e.message)
                        nextTick(() => {
                            var container = refChatLogPS.value
                            container.scrollTop = container.scrollHeight;
                        })
                    }
                });
        })

        const getConversation = async (id, type, sender) => {
            active_conversation.value = id
            const response = await axios.get('/messages/chat/'+id+'?type='+type+'&sender='+sender)
            conversation_log.value = response.data.conversations.messages
            nextTick(() => {
                var container = refChatLogPS.value
                container.scrollTop = container.scrollHeight;
                // refMessageTextInput.value.focus()
            })
        }

        const sendMessage = async () => {
            const formData = new FormData()
            formData.append('conversation_id', active_conversation.value)
            formData.append('message', refMessageText.value)
            // Read selected files
            Array.from(files.value).forEach((file, index) => {
                formData.append('files['+index+']', file)
            })
            const response = await axios.post('/messages/send?type='+props.type+'&sender='+props.sender, formData)
            conversation_log.value.push(response.data.data)
            refMessageText.value = ''
            files.value = []
            nextTick(() => {
                var container = refChatLogPS.value
                container.scrollTop = container.scrollHeight;
            })
        }

        const uploadFile = () => {
            docsInput.value.click()
        }

        const uploadFiles = (e) => {
            files.value = e.target.files
        }
        const downloadFile = (file) => {
            axios.get(file.file_url, { responseType: 'blob' })
                .then(response => {
                    const blob = new Blob([response.data], { type: file.file_type });
                    const link = document.createElement('a')
                    link.href = URL.createObjectURL(blob)
                    link.download = file.file_name
                    link.click()
                    URL.revokeObjectURL(link.href)
                }).catch(console.error)
        }
        const formatBytes = (bytes, decimals = 2) => {
            if (!+bytes) return '0 Bytes'

            const k = 1024
            const dm = decimals < 0 ? 0 : decimals
            const sizes = ['Bytes', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB']

            const i = Math.floor(Math.log(bytes) / Math.log(k))

            return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`
        }

        return {
            refChatLogPS,
            messagesBox,
            refMessageTextInput,
            refMessageText,
            docsInput,

            active_conversation,
            conversation_log,
            receiver,
            files,

            getConversation,
            sendMessage,
            uploadFile,
            uploadFiles,
            downloadFile,
            formatBytes,

            moment,

            sender_id,
        }
    }
}
</script>
