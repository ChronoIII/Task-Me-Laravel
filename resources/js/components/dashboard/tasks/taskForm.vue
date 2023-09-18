<template>
    <div class="modal fade" :id="'task-modal-' + modalType" tabindex="-1" aria-labelledby="task-modal-title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 id="task-modal-title" class="modal-title fs-5">{{ modalTitle }}</h1>

                    <button ref="closeButton" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div v-if="modalType === 'save'">
                        <save-task-input ref="save_inputs" :task="_task" @submit-data="applyChanges"/>
                    </div>

                    <div v-if="modalType === 'confirm'">
                         <p class="mb-0">{{ confirmMessage ?? '' }}</p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button @click.prevent="saveNewTask()" v-if="modalType === 'save' || modalType === 'create-subtask'" type="button" class="btn btn-primary px-3">Save</button>
                    <button @click.prevent="confirmButton()" v-if="modalType === 'confirm'" class="btn btn-primary px-3" type="button">Confirm</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
import dayjs from 'dayjs';
import saveTaskInput from './modal/saveTaskInput.vue';

export default {
    props: {
        modalType: {
            type: String,
            required: true,
        },
        modalTitle: {
            type: String,
            required: true,
        },
        task: {
            default: null,
        },
        confirmMessage: {
            default: null,
        },
        submitted: {
            default: null,
        }
    },

    components: {
        saveTaskInput
    },

    watch: {
        task(val) {
            if (val === null) return;
            this._task = {...val};
        }
    },

    data() {
        return {
            _task: {
                task_id: '',
                title: '',
                description: '',
                type: 'normal',
                due_date: null,
            }
        }
    },

    methods: {
        ...mapActions([
            'saveTask',
        ]),

        applyChanges(data) {
            this._task = data;
        },

        saveNewTask() {
            this.$refs['save_inputs'].submitData();

            if (this._task.due_date) this._task.due_date = dayjs(this._task.due_date).format('YYYY-MM-DD HH:mm:ss');
            this.saveTask(this._task)
                .then(() => {
                    if (this.submitted) {
                        this.submitted();
                    }

                    this._task = {
                        task_id: '',
                        title: '',
                        description: '',
                        type: 'normal',
                        due_date: null,
                    };

                    this.$refs.closeButton.click();
                });
        },

        confirmButton() {
            this.submitted();

            this.$refs.closeButton.click();
        }
    },
}
</script>
