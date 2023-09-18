<template>
    <div class="col-12 mx-auto">
        <span class="text-sm fw-bold"><small>Due Date</small></span>
        <div class="d-flex flex-wrap justify-content-between mb-2">
            <div class="btn-group pe-lg-2 col-12 col-lg-6" role="group" aria-label="Date range selection">
                <input v-model="dateRange" value="0-day" type="radio" class="btn-check" name="date-range" id="date-today" autocomplete="off">
                <label class="btn btn-outline-primary" for="date-today">Today</label>

                <input v-model="dateRange" value="1-week" type="radio" class="btn-check" name="date-range" id="date-week" autocomplete="off">
                <label class="btn btn-outline-primary" for="date-week">1 week</label>

                <input v-model="dateRange" value="1-month" type="radio" class="btn-check" name="date-range" id="date-month" autocomplete="off">
                <label class="btn btn-outline-primary" for="date-month">1 month</label>

                <input v-model="dateRange" value="6-month" type="radio" class="btn-check" name="date-range" id="date-6-month" autocomplete="off">
                <label class="btn btn-outline-primary" for="date-6-month">6 months</label>

                <input v-model="dateRange" value="1-year" type="radio" class="btn-check" name="date-range" id="date-year" autocomplete="off">
                <label class="btn btn-outline-primary" for="date-year">1 year</label>

                <input v-model="dateRange" value="all" type="radio" class="btn-check" name="date-range" id="date-all" autocomplete="off" checked>
                <label class="btn btn-outline-primary" for="date-all">All</label>
            </div>

            <div class="d-flex align-items-center mt-1 mt-lg-0 col-12 col-lg-6">
                <vue-date-picker v-model="filter.start_date" @update:model-value="selectFromCalendar" model-type="yyyy-MM-dd" format="yyyy-MM-dd" :enable-time-picker="false" auto-apply />
                <span class="fw-bold fs-4 mx-2">~</span>
                <vue-date-picker v-model="filter.end_date" @update:model-value="selectFromCalendar" model-type="yyyy-MM-dd" format="yyyy-MM-dd" :enable-time-picker="false" auto-apply />
            </div>
        </div>

        <span class="text-sm fw-bold"><small>Status</small></span>
        <div class="btn-group me-2 w-100 mb-2" role="group" aria-label="Task status filter">
            <input v-model="filter.status" value="" type="radio" class="btn-check" name="status" id="status-all" autocomplete="off" checked>
            <label class="btn btn-outline-primary" for="status-all">All</label>

            <input v-model="filter.status" value="0" type="radio" class="btn-check" name="status" id="status-todo" autocomplete="off">
            <label class="btn btn-outline-primary" for="status-todo">To Do</label>

            <input v-model="filter.status" value="1" type="radio" class="btn-check" name="status" id="status-ongoing" autocomplete="off">
            <label class="btn btn-outline-primary" for="status-ongoing">On Going</label>

            <input v-model="filter.status" value="2" type="radio" class="btn-check" name="status" id="status-complete" autocomplete="off">
            <label class="btn btn-outline-primary" for="status-complete">Completed</label>
        </div>

        <span class="text-sm fw-bold"><small>Priority</small></span>
        <div class="btn-group me-2 w-100 mb-2" role="group" aria-label="Task priority filter">
            <input v-model="filter.type" value="" type="radio" class="btn-check" name="priority" id="priority-all" autocomplete="off" checked>
            <label class="btn btn-outline-primary" for="priority-all">All</label>

            <input v-model="filter.type" value="urgent" type="radio" class="btn-check" name="priority" id="priority-urgent" autocomplete="off">
            <label class="btn btn-outline-primary" for="priority-urgent">Urgent</label>

            <input v-model="filter.type" value="high" type="radio" class="btn-check" name="priority" id="priority-high" autocomplete="off">
            <label class="btn btn-outline-primary" for="priority-high">High</label>

            <input v-model="filter.type" value="normal" type="radio" class="btn-check" name="priority" id="priority-normal" autocomplete="off">
            <label class="btn btn-outline-primary" for="priority-normal">Normal</label>

            <input v-model="filter.type" value="low" type="radio" class="btn-check" name="priority" id="priority-low" autocomplete="off">
            <label class="btn btn-outline-primary" for="priority-low">Low</label>
        </div>

        <span class="text-sm fw-bold"><small>Search Keyword</small></span>
        <div class="input-group w-100 mb-2">
            <label for="txt-search" l class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></label>

            <select v-model.trim="filter.search" class="form-select form-select-sm" aria-label=".form-select-sm example">
                <option value="title">By Title</option>
                <option value="description">By Description</option>
                <option value="labels">By Label</option>
            </select>

            <input v-model.trim="filter.keyword" type="text" name="search" id="txt-search" class="form-control w-50" placeholder="Search keyword...">
        </div>

        <div class="d-flex justify-content-center">
            <button @click.prevent="submitData()" class="btn btn-primary me-1">Search</button>
            <button @click.prevent="resetData()" class="btn btn-outline-primary">Reset</button>
        </div>
    </div>

</template>

<script>
import dayjs from 'dayjs';
import VueDatePicker from '@vuepic/vue-datepicker';

export default {
    components: {
        VueDatePicker,
    },

    watch: {
        dateRange(newVal) {
            if (!newVal) return;

            this.selectCustomDate = false;
            if (newVal === 'all') {
                this.filter.start_date = '';
                this.filter.end_date = '';
                return;
            }

            let aRange = newVal.split('-');
            let oToday = Date.now();
            let oDay = new Date(oToday);

            switch (aRange[1]) {
                case 'day':
                    oDay.setDate(oDay.getDate() - parseInt(aRange[0]));
                    break;

                case 'week':
                    oDay.setDate(oDay.getDate() - parseInt(aRange[0] * 7));
                    break;

                case 'month':
                    oDay.setMonth(oDay.getMonth() - parseInt(aRange[0]));
                    break;

                case 'year':
                    oDay.setFullYear(oDay.getFullYear() - parseInt(aRange[0]));
                    break;
            }

            this.filter.start_date = dayjs(oDay).format('YYYY-MM-DD');
            this.filter.end_date = dayjs(oToday).format('YYYY-MM-DD');
        },

        selectCustomDate(selectCustomDate) {
            if (selectCustomDate) {
                this.dateRange = null;
            }
        }
    },

    data() {
        return {
            dateRange: 'all',
            selectCustomDate: false,
            default: {
                start_date: '',
                end_date: '',
                status: '',
                type: '',
                search: 'title',
                keyword: '',
            },
            filter: {
                start_date: '',
                end_date: '',
                status: '',
                type: '',
                search: 'title',
                keyword: '',
            }
        }
    },

    methods: {
        fixDate(mDate) {
            return dayjs(mDate).format('YYYY-MM-DD')
        },

        resetData() {
            this.filter = {...this.default};
        },

        submitData() {
            this.$emit('submit-data', this.filter);
        },

        selectFromCalendar() {
            this.selectCustomDate = true;
        }
    }
}
</script>
