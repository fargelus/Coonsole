<template>
    <div class="header-filter interact-element bg-theme--gallery">
        <div class="header-filter__content">
            <HeaderPagination/>
        </div>
    </div>
</template>

<style lang="styl" scoped type="text/stylus">
  @require '../../styl/_variables.styl'

  .header-filter
      position: relative
      width: 100%

  .header-filter__content
      position: relative
      max-width: 940px
      margin: 0 auto
</style>

<script>
    import HeaderPagination from './HeaderPagination.vue';

    export default {
        components: {
            HeaderPagination,
        }
    }
</script>
