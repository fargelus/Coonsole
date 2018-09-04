<template>
  <div class="header-top">
    <div class="header-top__group">
      <img class="js-logo" alt="coonsole_logo" width="138" height="36">

      <div class="site-search header-top__search interact-element">
        <input type="text" class="site-search__input interact-element" :placeholder="Search_enter">
        <button type="button" class="button site-search__button interact-element">{{ Find }}</button>
      </div>

      <button @click="cityButtonClick" type="button" class="button button--logo-compass interact-element group-button-last transparent header-top__button">
        <img class="js-compass button__label-left">{{ City }}
      </button>
    </div>

    <div class="header-top__group header-top__group--buttons interact-element">
      <ui-button snow>{{ Sale }}</ui-button>
      <ui-button class="header-top__button" orange>{{ Sign_In }}</ui-button>
    </div>
  </div>
</template>

<script>
  import CitiesListModal from './CitiesListModal.vue';

  export default {
    data() {
      return {
        Sale: 'Продать',
        Sign_In: 'Войти',
        City: 'Санкт-Петербург',
        Find: 'Поиск',
        Search_enter: 'Введите запрос',
      };
    },

    methods: {
      cityButtonClick() {
        this.$emit('city-button-click');
      }
    },

    components: {
      CitiesListModal,
    }
  }
</script>

<style lang="styl" scoped>
  @require '../../styl/_variables'
  @require '../../styl/_mixins'

  .header-top
    font-size: 16px
    align-items: center
    padding: 16px 48px 14px

  .header-top, .header-top__group
    display: flex
    justify-content: space-between

  .header-top__group
    align-items: center
    flex: 2 1 auto

    &--buttons
      align-items: stretch
      flex: 1 1 auto
      justify-content: flex-end

  .header-top__search
    margin-left: 30px
    flex: 1 1 auto

  .header-top__button
    margin-left: 20px

  .site-search
    position: relative
    max-width: 420px

  input.site-search__input
    position: absolute
    left: 0
    line-height: 32px
    color: $masala
    outline: 0
    background-color: $gallery
    border: 0
    padding: 0 10px
    box-sizing: border-box
    margin: 0
    width: calc(100% - 73px)
    border-top-left-radius: 4px
    border-bottom-left-radius: 4px
    font-size: 14px

  .site-search__button
    position: absolute
    right: 5px
    background-color: $gallery
    border: 0
    border-radius: 0
    border-top-right-radius: 4px
    border-bottom-right-radius: 4px
</style>
