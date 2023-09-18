<template>
    <div class="d-md-flex min-vh-100">
        <div class="w-100 px-5">
            <div class="mb-5">
                <i class="fa-solid fa-thumbtack fa-2x me-3 pt-5 mt-xl-4 text-primary"></i>
                <h2 class="h2 fw-bold mb-0 d-inline">TaskMe</h2>
            </div>

            <div class="">
                <router-view v-slot="{ Component, route }">
                    <transition name="fade">
                        <component :is="Component" :key="route.name"></component>
                    </transition>
                </router-view>
            </div>
        </div>

        <div class="w-100 side"></div>
    </div>
</template>

<script>

export default {

}
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity .4s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}

.side {
    background: url('/images/productive.png');
    background-size: cover;
    opacity: .9;
    position: relative;
}

.side::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    opacity: .6;
    background-color: #3f5751;
    z-index: 999;
}
</style>
