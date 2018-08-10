<template id="js-header" class="header-top">
    <div class="header-wrapper">
      <img class="js-logo" alt="coonsole_logo" width="54" height="48">

      <div class="site-search">
        <input type="text" class="site-search__input" :placeholder="Search_enter">
        <button type="button" class="site-search__button">{{ Find }}</button>
      </div>

      <!-- Пока поставим заглушки -->
      <button type="button" class="user-location">
        <!-- TODO CSS -->
        <img class="js-compass">{{ City }}
      </button>

      <div class="user-interaction-buttons">
        <button type="button">{{ Sale }}</button>
        <button type="button">{{ Sign_In }}</button>
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
