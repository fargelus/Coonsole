<template>
    <div class="header-filter interact-element">
        <div class="header-filter__content">
            <HeaderPagination/>
        </div>
    </div>
</template>

<style lang="styl" scoped>
  @require '../../styl/_variables.styl'

  .header-filter
      position: relative
      width: 100%
      background-color: $gallery

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
