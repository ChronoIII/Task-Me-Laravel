<template>
    <h3 class="fw-normal mb-3">Register</h3>
    <form v-if="!success">
        <p v-if="errors !== null && errors?.name !== undefined" class="mb-0 ms-1 text-danger fw-light">{{ errors.name[0] }}</p>
        <input
            type="text"
            :class="{'border-danger': errors !== null && errors?.name !== undefined}"
            v-model.trim="user.name"
            class="form-control text-capitalize mb-3"
            :disabled="loading"
            placeholder="Name">

        <p v-if="errors !== null && errors?.email !== undefined" class="mb-0 ms-1 text-danger fw-light">{{ errors?.email[0] }}</p>
        <input
            type="text"
            :class="{'border-danger': errors !== null && errors?.email !== undefined}"
            v-model.trim="user.email"
            class="form-control"
            :disabled="loading"
            placeholder="Email address">

        <div class="row mt-3">
            <p v-if="errors !== null && errors?.password !== undefined" class="mb-0 ms-1 text-danger fw-light">{{ errors?.password[0] }}</p>
            <div class="col input-group">
                <input
                    :type="showPassword ? 'text' : 'password'"
                    :class="{'border-danger': errors !== null && errors?.password !== undefined}"
                    v-model="user.password"
                    class="form-control"
                    :disabled="loading"
                    placeholder="Password">
                <span @click.prevent="showPassword = !showPassword" class="input-group-text border-start-0" role="button" title="View password">
                    <i :class="[showPassword ? 'fa-eye-slash' : 'fa-eye', 'fa-regular']"></i>
                </span>
            </div>

            <div class="col input-group">
                <input
                    :type="showPassword ? 'text' : 'password'"
                    :class="{'border-danger': errors !== null && errors?.password !== undefined}"
                    v-model="user.password_confirmation"
                    class="form-control"
                    :disabled="loading"
                    placeholder="Confirm password">
                <span @click.prevent="showPassword = !showPassword" class="input-group-text border-start-0" role="button" title="View password">
                    <i :class="[showPassword ? 'fa-eye-slash' : 'fa-eye', 'fa-regular']"></i>
                </span>
            </div>
        </div>

        <button @click.prevent="attemptRegister()" :disabled="loading" class="btn btn-primary shadow w-100 mt-3">
            <div v-if="loading" class="rotate" style="display: inline-block;">
                <i class="fa-solid fa-spinner"></i>
            </div>
            <span v-else>Register</span>
        </button>

        <div class="text-center mt-3">
            <a @click.prevent="$router.push('/login')" href="#!" class="link-info">Back to login</a>
        </div>

    </form>

    <template v-else>
        <p class="mb-0 pt-3">You can now login to the app.</p>
        <button @click.prevent="$router.push('/login')" :disabled="loading" class="btn btn-primary shadow w-100 mt-3">
            Go to Log in
        </button>
    </template>
</template>

<script>

export default {
    data() {
        return {
            user: {
                name: '',
                email: '',
            },
            loading: false,
            showPassword: false,
            success: false,
        }
    },

    methods: {
        attemptRegister() {
            if (this.loading) {
                return;
            }

            this.updateLoadingStatus(true);

            axios.post('/admin/api/register', this.user)
                .then(() => {
                    this.errors = null;

                    this.enterDashboard();
                })
                .catch(error => {
                    let aErrorData = error.response.data;
                    this.errors = aErrorData.errors;
                })
                .finally(() => {
                    this.updateLoadingStatus(false);
                });
        },

        enterDashboard() {
            this.success = true;
        },

        updateLoadingStatus(bLoadingStatus) {
            this.loading = bLoadingStatus;
            this.$emit('updateLoading', bLoadingStatus);
        }
    }
}
</script>
