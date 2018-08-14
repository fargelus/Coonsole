<template>
    <div class="header-filter interact-element">
        <div class="header-filter__content">
            <HeaderPagination/>
        </div>
    </div>
</template>

<style>
    .header-filter {
        position: relative;
        width: 100%;
        background-color: #EDEDED;
    }

    .header-filter__content {
        position: relative;
        max-width: 940px;
        margin: 0 auto;
    }


</style>

<script>
    import HeaderPagination from './HeaderPagination.vue';

    export default {
        components: {
            HeaderPagination,
        }
    }
</script>
