<template>
    <div class="justify-content-between align-items-center mt-2 mb-2 border-bottom">
        <h4 class="h2 mt-2">{{ task?.title ?? '-' }}</h4>

        <task-buttons :task="task" :retrieve-callback="getTaskData" />
    </div>

    <div class="row">
        <div class="col-md-9 col-12">
            <task-details :task="task" />

            <div class="mt-4">
                <task-file-manager :task="task" :files="task.files" :immediate="true" @retrieve-task="getTaskData" />
            </div>
        </div>

        <div class="d-none d-md-block col pb-4 pe-0 me-3">
            <div class="card p-3 pt-0 bg-light">
                <div class="mt-4">
                    <h5 class=" text-danger" style="font-size: 12px;">Due Date:</h5>

                    <p style="font-size: 12px;">{{ dueDate }}</p>
                </div>

                <div>
                    <h5 class="text-body-tertiary fw-light" style="font-size: 12px;">Date created:</h5>

                    <p style="font-size: 12px;">{{ createdDate }}</p>
                </div>

                <div class="mt-4">
                    <h5 class="text-body-tertiary fw-light" style="font-size: 12px;">Assignee</h5>

                    <p class="mb-0" style="font-size: 14px;">{{ task?.user?.name ?? '-' }}</p>
                    <small class="text-light-emphasis" style="font-size: 12px;">({{ task?.user?.email ?? '-' }})</small>
                </div>
            </div>
        </div>
    </div>

    <task-form
        modal-title="Updating task"
        modal-type="save"
        :task="task"
        :submitted="getTaskData" />
</template>

<script>
import { mapActions } from 'vuex';
import dayjs from 'dayjs';
import taskForm from './taskForm.vue';
import taskButtons from './view/taskButtons.vue';
import taskDetails from './view/taskDetails.vue';
import taskFileManager from './view/taskFileManager.vue';

export default {
    components: {
        taskButtons,
        taskDetails,
        taskFileManager,
        taskForm,
    },

    data() {
        return {
            task: {
                title: '',
                status: 0,
                type: 'normal',
                created_at: ''
            },
        }
    },

    computed: {
        createdDate() {
            return dayjs(this.task.created_at).format('YYYY-MM-DD HH:mm:ss');
        },

        dueDate() {
            if (!this.task.due_date) return '---'
            return dayjs(this.task.due_date).format('YYYY-MM-DD HH:mm:ss');
        }
    },

    methods: {
        ...mapActions([
            'getTask',
            'saveTask',
            'archiveTask',
        ]),

        getTaskData() {
            this.getTask(this.$route.params.id)
                .then(data => {
                    this.task = data;
                });
        },
    },

    mounted() {
        this.getTaskData();
    }
}
</script>
