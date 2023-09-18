<template>
  <div class="mb-3">
    <label for="task-title" class="form-label text-sm">Task Title</label>
    <input
      v-model.trim="_task.title"
      type="text"
      name="task-title"
      id="task-title"
      class="form-control"
      placeholder="e.g. Create a cupcake"
    />
  </div>

  <div class="mb-3">
    <label for="task-description" class="form-label text-xs">Task Description</label>
    <textarea
      v-model.trim="_task.description"
      ref="textAreaField"
      class="form-control w-100"
      id="task-description"
      rows="1"
      placeholder="Describe the Task"
    ></textarea>
  </div>

  <p class="text-center mb-0 mt-2">
    <a
      href="#!"
      class="link-underline-primary"
      data-bs-toggle="collapse"
      data-bs-target=".multi-collapse"
      aria-expanded="false"
      aria-controls="multiCollapseExample1"
      >Advance options</a
    >
  </p>

  <div class="collapse multi-collapse mt-2" id="multiCollapseExample1">
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a
          @click="activeOption = 'urgency'"
          :class="['nav-link', { active: activeOption === 'urgency' }]"
          aria-current="page"
          href="#"
          >Urgency</a
        >
      </li>
      <li class="nav-item">
        <a
          @click="activeOption = 'labels'"
          :class="['nav-link', { active: activeOption === 'labels' }]"
          aria-current="page"
          href="#"
          >Labels</a
        >
      </li>
      <li class="nav-item">
        <a
          @click="activeOption = 'files'"
          :class="['nav-link', { active: activeOption === 'files' }]"
          aria-current="page"
          href="#"
          >Files</a
        >
      </li>
    </ul>

    <div v-if="activeOption === 'urgency'" class="mt-2">
      <div class="form-floating mb-2">
        <select
          v-model.trim="_task.type"
          class="form-select"
          id="slt_prio"
          aria-label="Task Priority Level"
        >
          <option value="urgent">Urgent</option>
          <option value="high">High</option>
          <option value="normal">Normal</option>
          <option value="low">Low</option>
        </select>
        <label for="slt_prio">Priority level</label>
      </div>

      <label for="task-duSET_TASK_FILTERe-date" class="form-label text-sm mb-0"
        ><small>Due date</small></label
      >
      <vue-date-picker v-model="_task.due_date" format="yyyy-MM-dd HH:mm:ss" />
    </div>

    <div v-if="activeOption === 'labels'" class="mt-2">
      <div class="mb-2">
        <input
          @keydown.enter.prevent="addLabel"
          v-model.trim="inputLabel"
          type="text"
          name="task-label"
          id="task-label"
          class="form-control"
          placeholder="development"
        />
      </div>

      <div class="d-flex flex-wrap">
        <span
          v-for="(label, index) in _labels"
          class="text-bg-secondary rounded px-2 me-1 mt-1"
        >
          <small>
            {{ label }}
            <span @click="removeLabel(index)" style="cursor: pointer">&#215;</span>
          </small>
        </span>
      </div>
    </div>

    <div v-if="activeOption === 'files'" class="mt-2">
      <task-file-manager ref="save_inputs" :immediate="false" @submit-data="getFiles" />
    </div>
  </div>
</template>

<script>
import VueDatePicker from "@vuepic/vue-datepicker";
import taskFileManager from "../view/taskFileManager.vue";

export default {
  props: {
    task: {
      type: Object,
      default: null,
    },
  },

  components: {
    VueDatePicker,
    taskFileManager,
  },

  watch: {
    task(val) {
      if (val === null) return;
      this._labels = val.labels ? val.labels.split(",") : [];
      this._task = { ...val };
    },
  },

  data() {
    return {
      _task: {
        type: "normal",
        title: "",
        description: "",
        due_date: "",
        labels: "",
        files: [],
      },
      inputLabel: "",
      _labels: [],
      activeOption: "urgency",
    };
  },

  methods: {
    getFiles(aFiles) {
      this._task.files = aFiles;
    },

    submitData() {
      if (this.$refs["save_inputs"]) {
        this.$refs["save_inputs"].submitData();
      }
      this._task.labels = this._labels.join(",");
      this.$emit("submit-data", this._task);
    },

    addLabel() {
      if (this.inputLabel === "") {
        return;
      }

      this._labels.push(this.inputLabel);
      this.inputLabel = "";
    },

    removeLabel(iIndex) {
      this._labels.splice(iIndex, 1);
    },
  },
};
</script>
