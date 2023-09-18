<template>
    <div class="d-flex flex-column justify-content-between min-vh-100">
        <div>
            <nav-bar />

            <div class="mx-3 mt-2">
                <div class="row">
                    <div class="col-sm-6">
                        <h4 class="m-0">{{ $route.name }}</h4>
                    </div>

                    <div class="col-sm-6 d-sm-flex justify-content-end">
                        <ol class="breadcrumb my-auto">
                            <template v-for="breadcrumb in breadCrumbs">
                                <li class="breadcrumb-item"><small>{{ breadcrumb }}</small></li>
                            </template>
                        </ol>
                    </div>
                </div>

                <router-view></router-view>
            </div>
        </div>

        <footer-bar />
    </div>
</template>

<script>
import navBar from '../common/navBar.vue';
import footerBar from '../common/footerBar.vue';

export default {
    components: {
        navBar,
        footerBar,
    },

    computed: {
        breadCrumbs() {
            return this.$route.meta.breadcrumbs;
        },
    },
}
</script>
