<template>
    <table-filter @submit-data="filterList" class="mt-3" />

    <div class="card mt-3">
        <div class="card-header">
            <div class="d-flex justify-content-end">
                <div class="btn-group">
                    <button class="btn btn-md btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#task-modal-save">
                        <i class="fa-solid fa-plus"></i> Create Task
                    </button>
                </div>
            </div>
        </div>

        <template v-if="tasks.length > 0">
            <div class="card-body p-0">
                <table-list :list="tasks" :task-redirect="true" v-slot="{item}">
                    <button @click.prevent="deleteTask(item.task_id)" class="btn btn-outline-danger btn-sm position-absolute top-0 end-0 me-3 mt-2">
                        <i class="fa-solid fa-box-archive"></i>
                    </button>
                </table-list>
            </div>

            <div class="card-footer">
                <table-pagination />
            </div>
        </template>

        <div v-else class="card-body">
            <p class="text-center h5 py-4">No Task</p>
        </div>
    </div>

    <task-form modal-title="Creating a task" modal-type="save"/>
</template>

<script>
import { mapMutations, mapActions, mapGetters } from 'vuex';
import tableFilter from '../../common/tableFilter.vue';
// import tableList from '../../list/tableList.vue';
import tableList from '../../common/tableList.vue';
import tablePagination from './list/tablePagination.vue';
import taskForm from './taskForm.vue';

export default {
    components: {
        tableFilter,
        tableList,
        tablePagination,
        taskForm,
    },

    computed: {
        ...mapGetters([
            'tasks',
            'taskFilter',
        ]),
    },

    methods: {
        ...mapMutations([
            'ASSIGN_TASK_FILTER',
        ]),

        ...mapActions([
            'getTasks',
            'archiveTask'
        ]),

        filterList(oFilterData) {
            let oFilter = {
                ...this.taskFilter,
            };

            Object.keys(oFilterData).forEach(sKey => {
                oFilter[sKey] = oFilterData[sKey];
            });

            this.ASSIGN_TASK_FILTER(oFilter);
            this.getTasks();
        },

        deleteTask(iTaskId) {
            if (!confirm('Do you want to archive this task ?')) {
                return;
            }

            this.archiveTask(iTaskId)
                .then(() => {
                    alert('Task was successfully archived.');
                    this.$router.push('/archives');
                });
        },
    },

    mounted() {
        this.getTasks();
    }
}
</script>
