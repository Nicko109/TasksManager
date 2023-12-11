<template>
    <div class="max-w-screen-md w-full mx-auto">
        <div class="form-group mb-4">
            <Link :href="route('projects.index')" class="inline-block bg-sky-600 px-3 py-2 text-white">Назад</Link>
        </div>
        <div class="card-body table-responsive p-0">
            <p><b>Наименование проекта:</b> {{ project.title }}</p>
            <p><b>Заказчик:</b> {{ user.name }}</p>
            <p><b>Исполнитель:</b> {{ performer.name }}</p>
        </div>
        <div class="flex justify-between items-center mt-2">
            <p class="text-right text-sm text-slate-500">{{project.date}}</p>
        </div>
        <div  class="form-group my-4 flex items-center">
            <Link :href="route('projects.edit', project.id)" class="inline-block bg-green-600 px-3 py-2 text-white">
                Редактировать
            </Link>
            <Link as="button" method="delete" :href="route('projects.destroy', project.id)" class="inline-block bg-rose-600 px-3 py-2 text-white ml-2">
                Удалить
            </Link>
        </div>
    </div>

</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import {Link} from "@inertiajs/vue3";
import axios from "axios";

export default {
    name: "Show",

    props:['project', "isAdmin", 'user', 'performer'],
    data() {
        return {
            errors: [],
        };
    },

    components: {Link},


    layout: MainLayout
}
</script>

<style scoped>
.link-text {
    font-size: medium;
    transition: color 0.3s;
    cursor: pointer;
}

.link-text:hover {
    color: blue;
}
</style>
