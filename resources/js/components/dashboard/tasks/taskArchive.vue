<template>
    <div class="alert alert-danger mt-3" role="alert">
        Archived tasks will permanently be deleted 7 days after task being archived.
    </div>

    <table-filter @submit-data="filterList" class="mt-3" />

    <div class="card mt-3">
        <template v-if="archives.length > 0">
            <div class="card-body p-0">
                <table-list :list="archives" v-slot="{item}">
                    <button @click.prevent="restoreArchive(item.task_id)" class="btn btn-outline-success btn-sm position-absolute top-0 end-0">
                        <i class="fa-solid fa-trash-can-arrow-up"></i>
                    </button>
                </table-list>
            </div>

            <div class="card-footer">
                <archive-pagination :archives="archives" />
            </div>
        </template>

        <div v-else class="card-body">
            <p class="text-center h5 py-4">No Task</p>
        </div>
    </div>

    <task-form modal-type="confirm" confirm-message="Do you want to restore this task ?" />
</template>

<script>
import { mapMutations, mapActions, mapGetters } from 'vuex';
import priorityMixin from '@/mixins/priorityMixin.js';
import statusMixin from '@/mixins/statusMixin.js';
import taskForm from './taskForm.vue';
import tableFilter from '../../common/tableFilter.vue';
import archivePagination from './archive/archivePagination.vue';
import tableList from '../../common/tableList.vue';

export default {
    components: {
        taskForm,
        archivePagination,
        tableFilter,
        tableList,
    },

    mixins: [priorityMixin, statusMixin],

    computed: {
        ...mapGetters([
            'archives'
        ]),
    },

    methods: {
        ...mapMutations([
            'ASSIGN_ARCHIVE_FILTER',
        ]),

        ...mapActions([
            'getArchivedTasks',
            'restoreTask',
        ]),

        filterList(oFilterData) {
            let oFilter = {
                ...this.taskFilter,
            };

            Object.keys(oFilterData).forEach(sKey => {
                oFilter[sKey] = oFilterData[sKey];
            });

            this.ASSIGN_ARCHIVE_FILTER(oFilter);
            this.getArchivedTasks();
        },

        restoreArchive(iArchiveId) {
            if (!confirm('Do you want to restore this task ?')) {
                return;
            }

            this.restoreTask(iArchiveId)
                .then(() => {
                    alert('Task was successfully restored.');

                    this.$router.push('/tasks');
                })
        }
    },

    mounted() {
        this.getArchivedTasks();
    }
}
</script>
