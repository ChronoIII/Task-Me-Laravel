<template>
    <div class="d-flex justify-content-between w-full">
        <select @change="triggerSearch('count', $event.target.value)" class="form-select w-auto">
            <option value="10" :selected="taskPageCount === 10">Show records of 10</option>
            <option value="20" :selected="taskPageCount === 20">Show records of 20</option>
            <option value="30" :selected="taskPageCount === 30">Show records of 30</option>
            <option value="50" :selected="taskPageCount === 50">Show records of 50</option>
            <option value="100" :selected="taskPageCount === 100">Show records of 100</option>
        </select>

        <nav aria-label="Page navigation example">
            <ul class="pagination mb-0">
                <li @click="pageCommand(taskCurrentPage - 1)" :class="['page-item', {'disabled': (taskCurrentPage <= 1)}]">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <template v-for="index in taskLastPage" :key="index">
                    <li @click="triggerSearch('page', index)" :class="['page-item', {'active': taskCurrentPage === index}]">
                        <a href="#" class="page-link">
                            <span aria-hidden="true">{{ index }}</span>
                        </a>
                    </li>
                </template>
                <li @click="pageCommand(taskCurrentPage + 1)" :class="['page-item', {'disabled': (taskCurrentPage >= taskLastPage)}]">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
import { mapMutations, mapActions, mapGetters } from 'vuex';

export default {
    props: {
        archives: {
            type: Object,
            required: true,
        }
    },

    computed: {
        ...mapGetters([
            'taskCurrentPage',
            'taskPageCount',
            'taskLastPage',
        ])
    },

    methods: {
        ...mapMutations([
            'SET_TASK_FILTER',
        ]),

        ...mapActions([
            'getTasks',
        ]),

        triggerSearch(sKey, mValue) {
            this.SET_TASK_FILTER({
                key: sKey,
                value: mValue,
            });
            this.getTasks();
        },

        pageCommand(iNewPage) {
            if (iNewPage < 1 || iNewPage > this.products.last_page) {
                return;
            }
            this.triggerSearch('page', iNewPage);
        },
    }
}
</script>
