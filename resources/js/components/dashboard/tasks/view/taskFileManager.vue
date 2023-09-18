<template>
   <h5 class="text-body-tertiary fw-light fs-6"><small>Attachment</small></h5>

    <div>
        <div class="d-flex flex-column">
            <template v-for="file in aFiles">
                <div class="d-flex">
                    <i class="fa-solid fa-file me-2 text-primary"></i>

                    <a :href="'/storage/' + file.file_path ?? '#!'" target="_new" class="text-decoration-none hover-text">
                        <p class="text-body-tertiary text-center text-break mb-1" style="font-size: 12px;">{{ file.name ?? file.file_name }}</p>
                    </a>
                </div>
            </template>
        </div>

        <div @click.prevent="selectFiles" class="d-flex pointer align-items-center justify-content-center w-100">
            <div class="d-flex flex-column align-items-center justify-content-center w-100 border pt-3 border-2 rounded" style="border-style: dashed !important; cursor: pointer">
                <i class="bi bi-card-image text-body-tertiary"></i>
                <p class="pt-1 text-body-tertiary">
                    <i class="fa-solid fa-upload"></i> Upload a file
                </p>
            </div>
        </div>

        <input ref="file_manager" @change="saveImages" type="file" multiple class="opacity-0" style="display: none" />
    </div>
</template>

<script>
import { mapActions } from 'vuex';

export default {
    props: {
        task: {
            type: Object,
            required: true,
        },
        immediate: {
            type: Boolean,
            default: false,
        },
        files: {
            type: Array,
            default: [],
        }
    },

    watch: {
        files(val) {
            if (!val) return;
            this.aFiles = val;
        }
    },

    data() {
        return {
            aFiles: [],
        }
    },

    methods: {
        ...mapActions([
            'saveTask',
        ]),

        selectFiles() {
            this.$refs['file_manager'].click();
        },

        submitData() {
            this.$emit('submit-data', this.aFiles);
        },

        saveImages(evt) {
            let aFiles = evt.target.files;
            if (!this.immediate) {
                for (let i = 0; i < aFiles.length; i++) {
                    this.aFiles.push(aFiles[i]);
                }
                return;
            };

            let _task = {...this.task};
            _task['files'] = aFiles;

            this.saveTask(_task)
                .then(() => {
                    this.$emit('retrieveTask');

                    alert('File/s uploaded successfully');
                });
        },
    }
}
</script>

<style scoped>
.hover-text:hover > p {
    color: red !important;
}
</style>
