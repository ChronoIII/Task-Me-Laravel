<template>
    <h3 class="fw-normal mb-3">Log in</h3>
    <form>
        <div class="form-floating mb-3">
            <input v-model.trim="credentials.email" :disabled="loading" type="email" class="form-control rounded-0" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
        </div>

        <div class="input-group has-validation">
            <div class="form-floating is-invalid">
                <input v-model.trim="credentials.password" :disabled="loading" :type="showPassword ? 'text' : 'password'" class="form-control rounded-0" id="txt_password" placeholder="password" required>
                <label for="txt_password">Password</label>
            </div>
            <span @click.prevent="showPassword = !showPassword" class="input-group-text border-start-0" role="button" title="View password">
                <i :class="[showPassword ? 'fa-eye-slash' : 'fa-eye', 'fa-regular']"></i>
            </span>
        </div>

        <div class="form-check mt-3">
            <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
            <label class="form-check-label" for="form2Example3">
            Remember me
            </label>
        </div>

        <button @click.prevent="attemptLogin()" :disabled="loading" class="btn btn-primary btn-block shadow w-100 mt-3">
            <div v-if="loading" class="rotate" style="display: inline-block;">
                <i class="fa-solid fa-spinner"></i>
            </div>
            <span v-else>Login</span>
        </button>

        <p class="mt-5">Don't have an account? <a @click.prevent="$router.push('/register')" href="#!" class="link-info">Register here</a></p>
    </form>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            credentials: {
                email: '',
                password: '',
                remember: false,
            },
            showPassword: false,
            loading: false,
        }
    },

    methods: {
        attemptLogin() {
            if (this.loading) {
                return;
            }

            this.updateLoadingStatus(true);

            axios.post('/admin/api/login', this.credentials)
                .then((res) => {
                    this.enterDashboard();
                })
                .catch(() => {
                    this.$toast.error('Incorrect credentials. Please try again.');
                })
                .finally(() => {
                    this.updateLoadingStatus(false);
                });
        },

        enterDashboard() {
            window.location.href = '/';
        },

        updateLoadingStatus(bLoadingStatus) {
            this.loading = bLoadingStatus;
            this.$emit('updateLoading', bLoadingStatus);
        }
    }
}
</script>

<style>
.rotate {
    animation: rotate 2s infinite;
}

@keyframes rotate {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(359deg); }
}
</style>
