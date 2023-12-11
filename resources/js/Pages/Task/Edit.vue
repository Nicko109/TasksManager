<template>
    <div class="max-w-screen-md w-full mx-auto">
        <div class="form-group mb-4">
            <Link :href="route('tasks.index')" class="inline-block bg-sky-600 px-3 py-2 text-white">Назад</Link>
        </div>
        <div class="mb-4">
            <div class=" mb-3">
                <input v-model="title" class="w-96 border p-2 border-slate-300" type="text" placeholder="Добавить наименование">
                <div v-if="errors.title" class="text-red-600 text-sm">{{ errors.title }}</div>
            </div>
            <div class="form-group">
                <label>Время выполнения</label>
                <div class="input-group">
                    <input v-model="deadline" @input="updateDeadline" type="datetime-local" class="form-control" name="deadline">
                </div>
                <div v-if="errors.deadline" class="text-red-600 text-sm">{{ errors.deadline }}</div>
            </div>
            <div class="my-4">
                <label for="file">Добавить файл</label>
                <div class=" mb-3">
                    <input @change="initFile" id="file" type="file">
                    <div v-if="errors.file" class="text-red-600 text-sm">{{ errors.file }}</div>
                </div>
            </div>
            <div class="form-group">
                <label>Выберите проект</label>
                <div class=" mb-3">
                    <select v-model="projectId" class="w-96 border p-2 border-slate-300">
                        <option v-for="project in projects" :value="project.id">{{ project.title }}</option>
                    </select>
                </div>
                <div v-if="errors.project_id" class="text-red-600 text-sm">{{ errors.project_id }}</div>
            </div>
            <div class="form-group">
                <label>Выберите исполнителя</label>
                <div class=" mb-3">
                    <select v-model="performerId" class="w-96 border p-2 border-slate-300">
                        <option v-for="user in users" :value="user.id">{{ user.name }}</option>
                    </select>
                </div>
                <div v-if="errors.performer_id" class="text-red-600 text-sm">{{ errors.performer_id }}</div>
            </div>
            <div class="form-group mb-4">
                <a @click.prevent="update" href="#" class="inline-block bg-green-600 px-3 py-2 text-white">Редактировать</a>
            </div>
        </div>
    </div>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import {router} from "@inertiajs/vue3";
import {Link} from "@inertiajs/vue3";

export default {
    name: "Edit",

    layout: MainLayout,

    components: {Link},

    props: ['errors', 'users', 'projects', 'task'],

    data() {
        return {
            title: this.task.title,
            file: this.task.file,
            deadline: this.task.deadline,
            performerId: this.task.performer_id,
            projectId: this.task.project_id,
        }
    },

    methods: {

        initFile(e) {
            this.file = e.target.files[0]
        },

        update() {
            let formData = new FormData();
            formData.append('title', this.title);
            formData.append('deadline', this.deadline);
            formData.append('file', this.file);
            formData.append('project_id', this.projectId);
            formData.append('performer_id', this.performerId);
            formData.append('_method', 'PATCH')
            router.post(`/tasks/${this.task.id}`,  formData,
                { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } })
        }
    }
}
</script>

