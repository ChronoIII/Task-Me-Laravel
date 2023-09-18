<template>
    <nav class="navbar bg-dark border-bottom">
        <div class="container-fluid">
            <div>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars text-white"></i>
                </button>
                <a href="#" class="navbar-brand text-light ms-2">TaskMe</a>
            </div>

            <a @click.prevent="logoutUser" href="/logout" type="button" class="btn btn-outline-light me-2">Logout</a>

            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title text-primary" id="offcanvasNavbarLabel"><i class="fa-solid fa-thumbtack text-primary me-1"></i> TaskMe</h5>
                    <button ref="offcanvas_close" type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <div class="offcanvas-body">
                    <h5 style="font-size: 15px;">NAVIGATION</h5>
                    <hr class="my-1"/>
                    <ul class="navbar-nav d-flex justify-content-start flex-grow-1 pe-3 mt-2">
                        <li @click.prevent="navigateTo('/tasks')" :class="{active: $route.path === '/tasks'}" class="nav-item fs-5 px-3 py-2 rounded pointer"><a href="#" class="text-decoration-none">Tasks</a></li>
                        <li @click.prevent="navigateTo('/archives')" :class="{active: $route.path === '/archives'}" class="nav-item fs-5 px-3 py-2 rounded pointer"><a href="#" class="text-decoration-none">Archived</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
import axios from 'axios';

export default {
    methods: {
        navigateTo(sLocation) {
            this.$router.push(sLocation);
            this.$refs['offcanvas_close'].click();
        },

        logoutUser() {
            axios.get('/admin/api/logout')
                .then(() => {
                    location.replace('/login');
                });
        }
    }
}
</script>
