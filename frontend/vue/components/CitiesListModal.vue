<template>
  <div class="modal cities-list-modal top-line--flamingo">
    <div class="cities-list-modal__search-input">
      <input type="text" name="" value="" placeholder="Введите город">
    </div>

    
  </div>
</template>

<script>
  export default {
    data() {
      return {
        name: 'CitiesListModal',
      }
    },
  }
</script>

<style lang="styl" scoped>
  .modal.cities-list-modal
    position: fixed
</style>
