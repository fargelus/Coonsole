<template>
  <div class="searchbar-wrapper">
    <input v-model="userInput" @input="inputByUserHandler" class="search-input" type="text" :placeholder="inputPlaceholder">
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
    inputVal(newVal) {
      this.userInput = newVal;
    }
  },

  methods: {
    resetUserInput() {
      this.userInput = '';
    },

    inputByUserHandler(evt) {
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
