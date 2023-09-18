<template>
    <div class="d-flex justify-content-between align-items-center mb-2 mt-3">
        <div class="d-flex">
            <button class="btn btn-light btn-sm me-2 border-secondary" data-bs-toggle="modal" data-bs-target="#task-modal-save">
                <i class="fa-solid fa-pencil"></i> Edit
            </button>

            <div class="btn-toolbar me-2">
                <div class="btn-group">
                    <button v-if="task?.status === 0" @click.prevent="updateStatus('On Going')" class="btn btn-sm btn-outline-secondary">Start Progress</button>
                    <button v-if="task?.status !== 0" @click.prevent="updateStatus('To Do')" class="btn btn-sm btn-outline-secondary">To Do</button>
                    <button v-if="task?.status === 1" @click.prevent="updateStatus('Completed')" class="btn btn-sm btn-outline-secondary">Complete Task</button>
                </div>
            </div>
        </div>

        <div class="d-flex">
            <button class="btn btn-danger btn-sm me-2" @click.prevent="deleteTask">
                <i class="fa-solid fa-box-archive"></i> Archive
            </button>

            <button @click.prevent="$router.push('/tasks')" class="btn btn-outline-secondary btn-sm me-2">
                <i class="fa-solid fa-arrow-left"></i> Back to List
            </button>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
import statusMixin from '@/mixins/statusMixin.js';

export default {
    props: {
        task: {
            type: Object,
            required: true,
        },
        retrieveCallback: {
            required: true,
        }
    },

    mixins: [statusMixin],

    methods: {
        ...mapActions([
            'saveTask',
        ]),

        updateStatus(sStatus) {
            let iStatusIndex = this.taskStatus.indexOf(sStatus);

            let oParamData = {
                task_id: this.task.task_id,
                title: this.task.title,
                description: this.task.description,
                status: iStatusIndex,
            };

            this.saveTask(oParamData)
                .then(() => {
                    this.retrieveCallback();
                });
        },

        deleteTask() {
            if (!confirm('Do you want to archive this task ?')) {
                return;
            }

            this.archiveTask(this.$route.params.id)
                .then(() => {
                    alert('Task was successfully archived.');
                    this.$router.push('/archives');
                });
        }
    }
}
</script>
