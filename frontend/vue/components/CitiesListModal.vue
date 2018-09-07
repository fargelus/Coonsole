<template>
  <div class="modal cities-list-modal top-line--flamingo">
    <input class="cities-list-modal__search-input" type="text" :placeholder="chooseCity">

    <div class="cities-list-modal__content">
      <div class="cities-list-modal__content-title bg-theme--gallery">
        {{ title }}
      </div>

      <div class="cols-wrapper cities-list-modal__cols-wrapper">
        <ul class="cols-wrapper__column">
          <li @click="cityItemClicked" class="cities-list-modal__city-item" v-for="city in mainCities.slice(0, 10)">
            {{ city }}
          </li>
        </ul>
        <ul class="cols-wrapper__column">
          <li @click="cityItemClicked" class="cities-list-modal__city-item" v-for="city in mainCities.slice(10, 20)">
            {{ city }}
          </li>
        </ul>
        <ul class="cols-wrapper__column">
          <li @click="cityItemClicked" class="cities-list-modal__city-item" v-for="city in mainCities.slice(20, 30)">
            {{ city }}
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
  import _ from 'underscore';

  export default {
    data() {
      return {
        name: 'CitiesListModal',
        chooseCity: 'Введите город',
        title: 'Введите город поиска или выберите город из списка популярных.',
        allCities: [],
        mainCities: [],
      }
    },

    props: {
      citiesListProp: Array
    },

    beforeMount() {
      // Для трансформации входных данных
      if (this.citiesListProp.length) {
        // Парсим входные данные на массивы:
        // 1. Получаем все названия городов.
        // 2. Получаем первые 30 названий городов с самым большим населением.
        this.parseCitiesListProp();
      }
    },

    methods: {
      parseCitiesListProp() {
        // Фильтрация городов по 1-му свойству
        const filterCitiesObjByProperty = (cities, prop) => {
          // Извлечем случайный объект и проверим у него наличие св-ва
          const testCityObject = _.sample(cities);

          if (testCityObject.hasOwnProperty(prop)) {
            return _.map(cities, (citiesObject) => citiesObject[prop]);
          }

          return [];
        };

        // Названия всех городов
        this.allCities = filterCitiesObjByProperty(this.citiesListProp, 'name');

        // Отсортируем города по возрастанию их населения
        const citiesSortedByPopulation = _.sortBy(this.citiesListProp, (citiesRaw) => citiesRaw.population);

        // Получим первые 30 городов с самым большим населением
        const bigCitiesInfo = _.first(citiesSortedByPopulation.reverse(), 30);

        // Из объекта нужно только название города
        this.mainCities = filterCitiesObjByProperty(bigCitiesInfo, 'name');
      },

      cityItemClicked(evt) {
        const choosedCityName = $(evt.currentTarget).text().trim();
        this.$emit('city-changed', choosedCityName);
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

    &__cols-wrapper
      font-family: RobotoRegular
      font-size: 14px
      line-height: 1.5

    &__city-item
      cursor: pointer

      &:hover
        text-decoration: underline
</style>
