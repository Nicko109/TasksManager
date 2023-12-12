<template>
    <div class="max-w-screen-md w-full mx-auto">
        <div class="form-group mb-4 flex items-center justify-between mb-6 pb-6 border-b border-gray-400">
            <Link :href="route('tasks.index')" class="inline-block bg-green-600 px-3 py-2 text-white">Задачи</Link>

            <Link :href="route('tasks.create')" class="inline-block bg-sky-600 px-3 py-2 text-white">Добавить</Link>
        </div>
        <div class="mb-6 pb-6 border-b border-gray-400" v-for="task in tasks">
            <Link :href="route('tasks.show', task.id)">
                <h1 class="pb-4 text-xl link-text"><b>Наименование задачи:</b> {{ task.title }}</h1>
            </Link>
            <p><b>Дата выполнения:</b> {{ task.formattedDeadline }}</p>
            <p v-if="task.file"><b>Документы:</b> {{ task.file }}</p>
            <p><b>Заказчик:</b> {{ task.user.name }}</p>
            <p><b>Исполнитель:</b> {{ task.performer.name }}</p>
            <p><b>Наименование проекта:</b> {{ task.project.title }}</p>
            <p><b>Статус:</b> {{ getStatus(task.status) }}</p>
            <div class="flex justify-between items-center mt-2">
                <p class="text-right text-sm text-slate-500">{{ task.date }}</p>
            </div>
            <div v-if="task.comments_count > 0" class="mt-4">
                <p class="pb-4 text-xl link-text" v-if="!isShowed" @click="getComments(task)">Показать
                    {{ task.comments_count }} комментарий</p>
                <p class="pb-4 text-xl link-text" v-if="isShowed" @click="isShowed = false">Закрыть</p>
                <div v-if="comments && isShowed">
                    <div v-for="comment in comments" class="mt-4 pt-4 border-t border-gray-300">
                        <p class="text-sm">{{ comment.user.name }}</p>
                        <p style="word-break: break-word;">{{ comment.body }}</p>
                        <p class="text-right text-sm text-slate-500">{{ comment.date }}</p>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <div class=" mb-3">
                    <input v-model="commentsData[task.id]" class="w-96 border p-2 border-slate-300" type="text"
                           placeholder="Добавить комментарий">
                </div>
                <div class="mb-3" v-if="errors[task.id] && errors[task.id].body">
                    <p v-for="error in errors[task.id].body" class="text-sm mt-2 text-red-500">{{ error }}</p>
                </div>
                <div class="form-group mb-4">
                    <a @click.prevent="storeComment(task)" href="#"
                       class="inline-block bg-sky-600 px-3 py-2 text-white">Комментировать</a>
                </div>
            </div>
            <div class="form-group my-4 flex items-center">
                <Link :href="route('tasks.edit', task.id)" class="inline-block bg-green-600 px-3 py-2 text-white">
                    Редактировать
                </Link>
                <Link as="button" method="delete" :href="route('tasks.destroy', task.id)" class="inline-block bg-rose-600 px-3 py-2 text-white ml-2">
                    Удалить
                </Link>
            </div>
        </div>
    </div>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import {Link} from "@inertiajs/vue3";
import axios from "axios"; // добавлен импорт

export default {
    name: "Index",
    props: ['tasks', "isAdmin"],
    data() {
        return {
            commentsData: {},
            comments: [],
            errors: [],
            isShowed: false,
        }
    },
    components: { Link },
    methods: {
        storeComment(task) {
            axios.post(`/tasks/${task.id}/comment`, { body: this.commentsData[task.id] || "" })
                .then(res => {
                    this.commentsData[task.id] = "";
                    this.comments.unshift(res.data.data)
                    task.comments_count++
                    this.isShowed = true
                })
                .catch(e => {
                    this.errors = { ...this.errors, [task.id]: e.response.data.errors };
                })
        },
        getComments(task) {
            axios.get(`/tasks/${task.id}/comment`)
                .then(res => {
                    this.commentsData[task.id] = "";
                    this.comments = res.data.data
                    this.isShowed = true
                })
        },
        getStatus(status) {
            const statusMap = {
                0: 'В работе',
                1: 'На проверке',
                2: 'Выполнено',
            };
            return statusMap[status];
        },

    },
    layout: MainLayout
    // ... остальной ваш код ...
}
</script>

<style scoped>
.link-text {
    font-size: medium;
    transition: color 0.3s; /* добавлен переход для плавного изменения цвета */
    cursor: pointer;
}

.link-text:hover {
    color: blue; /* цвет при наведении */
}
</style>
