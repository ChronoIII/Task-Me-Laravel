<template>
    <div class="d-flex justify-content-between w-full">
        <select @change="triggerSearch('count', $event.target.value)" class="form-select w-auto">
            <option value="10" :selected="archivePageCount === 10">Show records of 10</option>
            <option value="20" :selected="archivePageCount === 20">Show records of 20</option>
            <option value="30" :selected="archivePageCount === 30">Show records of 30</option>
            <option value="50" :selected="archivePageCount === 50">Show records of 50</option>
            <option value="100" :selected="archivePageCount === 100">Show records of 100</option>
        </select>

        <nav aria-label="Page navigation example">
            <ul class="pagination mb-0">
                <li @click="pageCommand(archiveCurrentPage - 1)" :class="['page-item', {'disabled': (archiveCurrentPage <= 1)}]">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <template v-for="index in archiveLastPage" :key="index">
                    <li @click="triggerSearch('page', index)" :class="['page-item', {'active': archiveCurrentPage === index}]">
                        <a href="#" class="page-link">
                            <span aria-hidden="true">{{ index }}</span>
                        </a>
                    </li>
                </template>
                <li @click="pageCommand(archiveCurrentPage + 1)" :class="['page-item', {'disabled': (archiveCurrentPage >= archiveLastPage)}]">
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
            'archiveCurrentPage',
            'archivePageCount',
            'archiveLastPage',
        ])
    },

    methods: {
        ...mapMutations([
            'SET_ARCHIVE_FILTER',
        ]),

        ...mapActions([
            'getArchivedTasks',
        ]),

        triggerSearch(sKey, mValue) {
            this.SET_ARCHIVE_FILTER({
                key: sKey,
                value: mValue,
            });
            this.getArchivedTasks();
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
