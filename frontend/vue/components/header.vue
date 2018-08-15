<template>
  <div id="js-header" class="header-top">
    <div class="header-top__group">
      <img class="js-logo" alt="coonsole_logo" width="54" height="48">

      <div class="site-search header-top__search interact-element">
        <input type="text" class="site-search__input interact-element" :placeholder="Search_enter">
        <button type="button" class="button site-search__button interact-element">{{ Find }}</button>
      </div>

      <!-- Пока поставим заглушки -->
      <button type="button" class="button interact-element site-city__button transparent header-top__button">
        <!-- TODO CSS -->
        <img class="js-compass">{{ City }}
      </button>
    </div>

    <div class="header-top__group interact-element">
      <button type="button" class="button button-theme--snow">{{ Sale }}</button>
      <button type="button" class="button button-theme--orange header-top__button">{{ Sign_In }}</button>
    </div>
  </div>
</template>

<style lang="styl" scoped>
  @require '../../styl/_variables.styl'

  .header-top
    margin: 0 auto
    margin-bottom: 8px
    max-width: 940px
    font-size: 16px
    align-items: center

  .header-top, .header-top__group
    display: flex
    justify-content: space-between

  .header-top__search
    margin-left: 45px

  .header-top__button
    margin-left: 20px

  .site-search
    position: relative
    width: 280px
    margin-top: 8px

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

  .site-search__button
    position: absolute
    right: 0
    background-color: $gallery
    border: 0
    border-radius: 0
    border-top-right-radius: 4px
    border-bottom-right-radius: 4px

  .site-city__button
    margin-top: 8px
</style>

<script>

  export default {
    data() {
      return {
        Sale: 'Продать',
        Sign_In: 'Войти',
        City: 'Санкт-Петербург',
        Find: 'Найти',
        Search_enter: 'Введите запрос'
      };
    }
  }
</script>
