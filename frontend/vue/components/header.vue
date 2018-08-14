<template>
  <div id="js-header" class="header-top">
    <div class="header-top__group">
      <img class="js-logo" alt="coonsole_logo" width="54" height="48">

      <div class="site-search header-top__search interact-element">
        <input type="text" class="site-search__input" :placeholder="Search_enter">
        <button type="button" class="button site-search__button">{{ Find }}</button>
      </div>

      <!-- Пока поставим заглушки -->
      <button type="button" class="button interact-element transparent header-top__button">
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

<style scoped>
  .header-top {
    align-items: center;
  }

  .header-top, .header-top__group {
    display: flex;
    justify-content: space-between;
  }

  .header-top__search {
    margin-left: 45px;
  }

  .header-top__button {
    margin-left: 20px;
  }
</style>
