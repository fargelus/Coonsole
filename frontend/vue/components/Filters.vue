<template>
  <div class="filters bg-theme--gallery">
    <div class="filter-item filters__item" v-for="filterItem in filterItems">
      <h3>{{ filterItem.title }}</h3>
      <ul class="filter-item__inner" v-if="filterItem.items">
        <li v-for="userSelectItem in filterItem.items">{{ userSelectItem }}</li>
      </ul>
      <div class="filter-item__inner" v-else-if="filterItem.price">
        <input type="text" class="filter-item__price-selector" :placeholder="filterItem.price.from">
        <input type="text" class="filter-item__price-selector" :placeholder="filterItem.price.till">
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
  }
}
</script>

<style lang="styl">
</style>
