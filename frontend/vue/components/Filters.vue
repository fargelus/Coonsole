<template>
  <div class="filters bg-theme--gallery">
    <div class="filter-item filters__item" v-for="filterItem in filterItems">
      <h3 class="filter-item__title">{{ filterItem.title }}</h3>
      <ul class="filter-item__inner" v-if="filterItem.items">
        <li @click="filterSelectedByUser($event, filterItem)" class="filter-item__element filter-item__element--checkbox" :class="{'bg-theme--white-orange': filterItem.active === userSelectItem}" v-for="userSelectItem in filterItem.items">{{ userSelectItem }}</li>
      </ul>
      <div class="filter-item__inner filter-item__inner--price" v-else-if="filterItem.price">
        <input type="text" class="filter-item__element filter-item__element--price-selector" :placeholder="filterItem.price.from">
        <input type="text" class="filter-item__element filter-item__element--price-selector" :placeholder="filterItem.price.till">
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Filters',
  data() {
    return {
      filterItems: [{
        title: 'Сортировать по',
        items: [
          'Возрастанию цены',
          'Убыванию цены',
          'Дате добавления'
        ],
        active: 'Возрастанию цены',
      },
      {
        title: 'Консоль',
        items: [
          'PlayStation 4',
          'PlayStation 3',
          'XBOX ONE',
          'XBOX 360',
          'Nintendo Switch',
          'Nintendo WiiU',
        ],
        active: 'PlayStation 4',
      },
      {
        title: 'Цена',
        price: {
          from: 'От',
          till: 'До',
        }
      },
      ],
    };
  },

  methods: {
    filterSelectedByUser(evt, selectedFilterItem) {
      const filterItemName = evt.target.innerHTML;
      selectedFilterItem.active = filterItemName;
    }
  },
}
</script>

<style lang="styl">
  @require "../../styl/_variables"
  @require "../../styl/modificators/_mixes"

  .filters
    &__item
      padding: 8px 0 0 24px

  .filter-item
    &__inner
      padding-top: 12px

    &__element
      padding: 6px 0 6px 15px
      opacity: 0.8

      &--checkbox
        border-top-left-radius: 15px
        border-bottom-left-radius: 15px
        cursor: pointer

        &:hover
          @extend .bg-theme--white-orange

      &--price-selector
        background-color: transparent
        max-width: 72px
        border-bottom: 2px solid $silver
        padding-left: 3px

        &:not(:last-child)
          margin-right: 20px

      &:hover
        opacity: 1

    &__title
      margin-top: 12px

    &__inner--price
      display: flex
      padding-left: 15px
</style>
