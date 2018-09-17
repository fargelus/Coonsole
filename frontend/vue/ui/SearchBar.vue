<template>
  <div class="searchbar-wrapper">
    <input v-model="userInput" @input="inputByUserHandler" @focus="onFocus" class="search-input" type="text" :placeholder="inputPlaceholder">
    <span @click="resetUserInput" class="cross-shape searchbar-wrapper__cross-shape"></span>
  </div>
</template>

<script>
export default {
  name: 'SearchBar',

  data() {
    return {
      userInput: ''
    }
  },

  props: {
    inputPlaceholder: {
      type: String,
      default: 'Поиск'
    },

    inputVal: {
      type: String,
      default: ''
    }
  },

  watch: {
    /**
     * Обновляем текстовое поле значением переданным из родительский компонента
     *
     * @param {String} newVal - обновленное значение вх.параметра inputVal
     */
    inputVal(newVal) {
      this.userInput = newVal;
    }
  },

  methods: {
      onFocus() {
          console.log('work?');
          this.$emit('focus');
      },

      /**
       * Сброс введенного значения
       */
      resetUserInput() {
          this.userInput = '';
          this.$emit('clear');
      },

    /**
     * Передаем введенное значение в родительский компонент
     */
    inputByUserHandler() {
      this.$emit('user-typing', this.userInput);
    }
  }
}
</script>

<style lang="styl">
  .search-input
    box-sizing: border-box
    display: block
    width: 100%

    &::placeholder
     color: $silver

  .searchbar-wrapper__cross-shape
    top: 18px
    right: 25px
</style>
