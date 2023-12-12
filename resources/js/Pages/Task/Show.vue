<template>
    <div class="max-w-screen-md w-full mx-auto">
        <div class="form-group mb-4">
            <Link :href="route('tasks.index')" class="inline-block bg-sky-600 px-3 py-2 text-white">Назад</Link>
        </div>
        <div class="card">
            <div class="card-body table-responsive p-0">
                <p><b>Наименование задачи:</b> {{ task.title }}</p>
                <p><b>Дата выполнения:</b> {{ task.formattedDeadline }}</p>
                <p v-if="task.file"><b>Документы:</b> {{ task.file }}</p>
                <p><b>Заказчик:</b> {{ user.name }}</p>
                <p><b>Исполнитель:</b> {{ performer.name }}</p>
                <p><b>Наименование проекта:</b> {{ project.title }}</p>
                <p><b>Статус:</b> {{ getStatus(task.status) }}</p>
            </div>
            <div class="flex justify-between items-center mt-2">
                <p class="text-right text-sm text-slate-500">{{task.date}}</p>
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
        </div>
        <div class="mt-4">
            <div class=" mb-3">
                <input v-model="body" class="w-96 border p-2 border-slate-300" type="text"
                       placeholder="Добавить комментарий">
            </div>
            <div class="mb-3" v-if="errors.body">
                <p v-for="error in errors.body" class="text-sm mt-2 text-red-500">{{ error }}</p>
            </div>
            <div class="form-group mb-4">
                <a @click.prevent="storeComment(task)" href="#"
                   class="inline-block bg-sky-600 px-3 py-2 text-white">Комментировать</a>
            </div>
        </div>
        <div  class="form-group my-4 flex items-center">
            <Link :href="route('tasks.edit', task.id)" class="inline-block bg-green-600 px-3 py-2 text-white">Редактировать</Link>
            <Link as="button" method="delete" :href="route('tasks.destroy', task.id)" class="inline-block bg-rose-600 px-3 py-2 text-white ml-2">Удалить</Link>
            <button v-if="isCustomer" @click="handleWork(task)" class="inline-block bg-yellow-500 px-3 py-2 text-white ml-2">
                Отклонить
            </button>
            <button v-if="isPerformer" @click="handleReview(task)" class="inline-block bg-blue-500 px-3 py-2 text-white ml-2">
                На проверку
            </button>
            <button v-if="isCustomer" @click="handleComplete(task)" class="inline-block bg-green-500 px-3 py-2 text-white ml-2">
                Подтвердить
            </button>
        </div>
    </div>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import {Link} from "@inertiajs/vue3";
import axios from "axios";

export default {
    name: "Show",

    props:['task', "isAdmin", 'user', 'performer', 'project', 'isCustomer', 'isPerformer'],
    data() {
        return {
            body: '',
            comments: [],
            errors: [],
            isShowed: false,
        }
    },

    components: {Link},

    methods: {

        storeComment(task) {
            axios.post(`/tasks/${task.id}/comment`, {body: this.body})
                .then(res => {
                    this.body = ''
                    this.comments.unshift(res.data.data)
                    task.comments_count++
                    this.isShowed = true
                })
                .catch(e => {
                    this.errors = e.response.data.errors
                })
        },

        getComments(task) {
            axios.get(`/tasks/${task.id}/comment`)
                .then(res => {
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
        handleReview(task) {
            axios.patch(`/tasks/${task.id}/review`)
                .then((res) => {
                    this.task.status = 1
                })
                .catch((error) => {
                    console.error(error);
                    // Обработка ошибок, если необходимо
                });
        },

        handleComplete(task) {
            axios.patch(`/tasks/${task.id}/complete`)
                .then((res) => {
                    this.task.status = 2
                })
        },

        handleWork(task) {
            axios.patch(`/tasks/${task.id}/work`)
                .then((res) => {
                    this.task.status = 0
                })
        },




    },

    layout: MainLayout
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
