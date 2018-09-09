<template>
  <div class="modal cities-list-modal top-line--flamingo">
    <input @input="dropCitiesList" class="cities-list-modal__search-input" type="text" :placeholder="chooseCityPlaceholder">

    <ul class="cities-list-modal__drop-box js-cities-drop-box">
      {{ citiesListFilteredByUserInput }}
    </ul>

    <div class="cities-list-modal__content">
      <div class="cities-list-modal__content-title bg-theme--gallery">
        {{ title }}
      </div>

      <div class="cols-wrapper cities-list-modal__cols-wrapper">
        <ul class="cols-wrapper__column">
          <li @click="selectedCityID = id" class="cities-list-modal__city-item" :class="{'bg-theme--black-n-white':id === selectedCityID}" v-for="id in sliceMainCitiesObj(0, 10)">
            {{ mainCities[id] }}
          </li>
        </ul>

        <ul class="cols-wrapper__column">
          <li @click="selectedCityID = id" class="cities-list-modal__city-item" :class="{'bg-theme--black-n-white':id === selectedCityID}" v-for="id in sliceMainCitiesObj(10, 20)">
            {{ mainCities[id] }}
          </li>
        </ul>

        <ul class="cols-wrapper__column">
          <li @click="selectedCityID = id" class="cities-list-modal__city-item" :class="{'bg-theme--black-n-white':id === selectedCityID}" v-for="id in sliceMainCitiesObj(20, 30)">
            {{ mainCities[id] }}
          </li>
        </ul>
      </div>
    </div>

    <div class="cities-list-modal__control-buttons">
      <button @click="cityItemChoosedByUser" class="button button-theme--orange cities-list-modal__control-button-item" :class="{ 'button--disabled': !!selectedCityID === false }" type="button">{{ acceptButtonText }}</button>
    </div>
  </div>
</template>

<script>
  import _ from 'underscore';
  import $ from 'jquery';

  export default {
    data() {
      return {
        name: 'CitiesListModal',
        chooseCityPlaceholder: 'Введите город',
        title: 'Введите город поиска или выберите город из списка популярных.',
        allCities: [],
        mainCities: {},
        citiesListFilteredByUserInput: [],
        acceptButtonText: 'Принять',
        selectedCityID: undefined
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
        const mainCityName = filterCitiesObjByProperty(bigCitiesInfo, 'name');

        // Заполним объект id:имя города,
        // чтобы гарантировать уникальность каждого города при отрисовке
        _.each(mainCityName, (cityName, index) => {
          this.mainCities[index] = cityName;
        });
      },

      cityItemChoosedByUser(evt) {
        if (!this.selectedCityID) return;

        const choosedCityName = this.mainCities[this.selectedCityID];
        this.$emit('city-changed', choosedCityName);
      },

      /**
      * Фильтрует названия всех городов по пользовательскому вводу
      *
      * @param  {String} pattern - Значение введенное пользователем.
      * @return {Array} Список всех городов, названия которых совпадают с pattern
      */
      getMatchedCitiesList(pattern) {
        // Получим длину введенных символов
        const patternLen = pattern.length;
        if (!patternLen) return [];

        // Небольшая эвристика:
        // избыточно на каждой итерации фильтровать весь список городов
        // достаточно отфильтровать последний результат
        const filteredArray = this.citiesListFilteredByUserInput.length
                              ? this.citiesListFilteredByUserInput
                              : this.allCities;

        if (filteredArray.length === 1) return filteredArray;

        return _.filter(filteredArray, (cityName) => {
          const slicedCityName = cityName.slice(0, patternLen);
          return slicedCityName === pattern;
        });
      },

      dropCitiesList(evt) {
        const elem = evt.currentTarget,
              capitalizeString = (str) => str[0].toUpperCase() + str.slice(1);

        let userInput = $(elem).val(),
            correctUserInput = userInput;

        if (userInput) {
          const firstLetter = userInput[0];

          if (firstLetter.match(/[a-z]/)) {
            correctUserInput = '';
          } else if (firstLetter.match(/[а-я]/)) {
            // Приведём первую букву к верхнему регистру
            // Формат русскоязычных городов гарантируется
            correctUserInput = capitalizeString(userInput);
          }
        }

        this.citiesListFilteredByUserInput = this.getMatchedCitiesList(correctUserInput);
      },

      sliceMainCitiesObj(start, stop) {
        return _.keys(this.mainCities).slice(start, stop);
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

    &__drop-box
        background-color: $snow
        width: 100%
        overflow-y: scroll

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

    &__control-buttons
      display: flex
      justify-content: flex-end
      margin-top: 30px

    &__control-button-item
      text-transform: capitalize
      font-family: RobotoRegular
      font-size: 16px
      line-height: 1.18
      width: 170px
      height: 30px
</style>
