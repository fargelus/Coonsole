<template>
  <div class="modal cities-list-modal top-line--flamingo">
    <input class="cities-list-modal__search-input" type="text" :placeholder="choose_city">

    <div class="cities-list-modal__content">
      <div class="cities-list-modal__content-title bg-theme--gallery">
        {{ title }}
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        name: 'CitiesListModal',
        choose_city: 'Введите город',
        title: 'Введите город поиска или выберите город из списка популярных.'
      }
    },
    methods: {
      setData(citiesListJSON) {
        console.dir(citiesListJSON);
      }
    }
  }
</script>

<style lang="styl" scoped>
  @require '../../styl/_variables'

  .cities-list-modal
    &.modal
      position: relative

    &__search-input
      box-sizing: border-box
      display: block
      font-size: 22px
      padding: 18px 24px 18px 23px
      line-height: 1.18
      width: 100%

      &::placeholder
       color: $silver

    &__content
      font-size: 14px

    &__content-title
      line-height: 1.14
      padding: 8px 24px
</style>
