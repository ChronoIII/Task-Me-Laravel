<template>
    <ul class="list-group list-group-flush">
        <template v-for="item in list" :key="item.task_id">
            <li class="list-group-item" :class="({'task-item' : taskRedirect})">
                <div @click.prevent="navigateTo('/task/' + item.task_id)" class="col-md-12 d-flex position-relative">
                    <div class="col-md-8 d-flex align-items-center">
                        <div class="d-flex flex-column align-items-center me-4">
                            <i :class="(priorityIcon[item.type])" :style="'color: ' + priorityColor[item.type] + '; font-size: 1.4rem'"></i>
                            <span class="text-uppercase"><small>{{ item.type }}</small></span>
                        </div>

                        <div class="col-md-9">
                            <h5 class="card-title fw-bold">{{ item.title }}</h5>
                            <p class="card-text text-break mb-2">{{ item.description }}</p>
                            <div class="d-flex flex-wrap">
                                <span v-for="label in item.labels ? item.labels.split(',') : []" class="text-bg-dark rounded px-2 me-1 mt-1">
                                    <small>{{ label }}</small>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <p class="mb-1"><small>Status:</small> <span class="px-2 rounded text-bg-primary" :style="'background:' + statusColor[item.status] + '!important'">{{ taskStatus[item.status] }}</span></p>
                        <p class="mb-0"><small>Due Date: {{ shortDate(item.due_date) }}</small></p>
                        <p class="mb-0"><small>Date created: {{ shortDate(item.created_at) }}</small></p>
                    </div>

                    <slot :item="item"></slot>
                </div>
            </li>
        </template>
    </ul>
</template>

<script>
import dayjs from 'dayjs';
import priorityMixin from '@/mixins/priorityMixin.js';
import statusMixin from '@/mixins/statusMixin.js';

export default {
    props: {
        list: {
            type: Array,
            required: true,
        },

        taskRedirect: {
            type: Boolean,
            default: false,
        }
    },

    mixins: [priorityMixin, statusMixin],

    methods: {
        shortDate(sDate) {
            if (sDate === null) {
                return '---';
            }
            return dayjs(sDate).format('YYYY-MM-DD');
        },

        navigateTo(sLocation) {
            if (!this.taskRedirect) return;
            this.$router.push(sLocation);
        }
    }
}
</script>

<style scoped>
.task-item {
    cursor: pointer;
}

.task-item:hover {
    background: #0001;
}
</style>
