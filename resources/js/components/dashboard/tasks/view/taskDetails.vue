<template>
    <table>
        <colgroup>
            <col style="width: 60px;">
            <col>
            <col style="width: 50px;">
            <col style="width: 60px;">
            <col>
        </colgroup>
        <tbody>
            <tr>
                <td>
                    <h5 class="text-body-tertiary fw-light fs-6"><small>Priority</small></h5>
                </td>
                <td>
                    <p class="fs-6 pt-2 text-uppercase">
                        <i :class="(priorityIcon[task.type])" :style="'color:' + priorityColor[task.type]"></i> {{ task.type }}
                    </p>
                </td>
                <td></td>
                <td>
                    <h5 class="text-body-tertiary fw-light fs-6"><small>Status</small></h5>
                </td>
                <td>
                    <p class="mb-2">
                        <span class="text-bg-primary px-2 rounded" :style="'background:' + statusColor[task.status] + '!important'">
                            {{ taskStatus[task.status] }}
                        </span>
                    </p>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="mt-1">
        <h5 class="text-body-tertiary fw-light fs-6"><small>Labels</small></h5>

        <div class="d-flex flex-wrap">
            <template v-if="labels.length > 0">
                <span v-for="label in labels" class="text-bg-secondary rounded px-2 me-1 mt-1">
                    <small>
                        {{ label }}
                    </small>
                </span>
            </template>
            <i v-else><small>No label</small></i>
        </div>
    </div>

    <div class="mt-4">
        <h5 class="text-body-tertiary fw-light fs-6"><small>Description</small></h5>
        <p class="fs-5 text-break">{{ task.description ?? '-' }}</p>
    </div>
</template>

<script>
import statusMixin from '@/mixins/statusMixin.js';
import priorityMixin from '@/mixins/priorityMixin.js';

export default {
    props: {
        task: {
            type: Object,
            required: true,
        }
    },

    mixins: [statusMixin, priorityMixin],

    computed: {
        labels() {
            return this.task.labels ? this.task.labels.split(',') : [];
        }
    }
}
</script>
