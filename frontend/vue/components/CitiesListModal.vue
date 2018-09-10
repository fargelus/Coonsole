<template>
  <div class="modal cities-list-modal top-line--flamingo">
    <SearchBar :inputVal="citySelectedFromDropdownList" v-on:user-typing="dropCitiesList" class="cities-list-modal__searchbar" :inputPlaceholder="chooseCityPlaceholder"/>

    <ul class="cities-list-modal__drop-box">
      <li @click="dropdownCityChoosedByUser" class="cities-list-modal__drop-box-item" v-for="filteredCity in citiesListFilteredByUserInput">
        {{ filteredCity }}
      </li>
    </ul>

    <div class="cities-list-modal__content">
      <div class="cities-list-modal__content-title bg-theme--gallery">
        {{ title }}
      </div>

      <div class="cols-wrapper cities-list-modal__cols-wrapper">
        <ul class="cols-wrapper__column">
          <li @click="finalSelectedCityItem = city" class="cities-list-modal__city-item" :class="{'bg-theme--black-n-white':finalSelectedCityItem === city}" v-for="city in mainCities.slice(0, 10)">{{ city }}</li>
        </ul>

        <ul class="cols-wrapper__column">
          <li @click="finalSelectedCityItem = city" class="cities-list-modal__city-item" :class="{'bg-theme--black-n-white':finalSelectedCityItem === city}" v-for="city in mainCities.slice(10, 20)">{{ city }}</li>
        </ul>

        <ul class="cols-wrapper__column">
          <li @click="finalSelectedCityItem = city" class="cities-list-modal__city-item" :class="{'bg-theme--black-n-white':finalSelectedCityItem === city}" v-for="city in mainCities.slice(20, 30)">{{ city }}</li>
        </ul>
      </div>
    </div>

    <div class="cities-list-modal__control-buttons">
      <button @click="cityItemChoosedByUser" class="button button-theme--orange cities-list-modal__control-button-item" :class="{ 'button--disabled': !!finalSelectedCityItem === false }" type="button">{{ acceptButtonText }}</button>
    </div>
  </div>
</template>

<script>
  import _ from 'underscore';
  import $ from 'jquery';
  import SearchBar from '../ui/SearchBar.vue';

  export default {
    data() {
      return {
        name: 'CitiesListModal',
        chooseCityPlaceholder: 'Введите город',
        title: 'Введите город поиска или выберите город из списка популярных.',
        allCities: [],
        mainCities: [],
        citiesListFilteredByUserInput: [],
        acceptButtonText: 'Принять',
        finalSelectedCityItem: '',
        citySelectedFromDropdownList: ''
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
      /**
       * Преобразуем список всех переданных городов.
       */
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

      /**
       * Окончательный выбор города и закрытие модалки
       */
      cityItemChoosedByUser() {
        if (!this.finalSelectedCityItem) return;
        this.$emit('city-changed', this.finalSelectedCityItem);
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

      /**
       * Заполним выпадающий список всех городов.
       * Города фильтруются на лету, в зависимости от ввода пользователя
       *
       * @param  {String} inputText - Значение введенное пользователем в текстовом поле поиска.
       */
      dropCitiesList(inputText) {
        const capitalizeString = (str) => str[0].toUpperCase() + str.slice(1);
        let correctUserInput = inputText;

        if (inputText) {
          const firstLetter = inputText[0];

          if (firstLetter.match(/[a-z]/)) {
            correctUserInput = '';
          } else if (firstLetter.match(/[а-я]/)) {
            // Приведём первую букву к верхнему регистру
            // Формат русскоязычных городов гарантируется
            correctUserInput = capitalizeString(inputText);
          }
        }

        this.citiesListFilteredByUserInput = this.getMatchedCitiesList(correctUserInput);
      },

      /**
       * 1). Пользователь выбрал город из выпадающего списка.
       * 2). Изменим соответствующее свойство, чтобы обновился
       *     атрибут value у дочернего компонента SearchBar
       *
       * @param  {Object} evt - Объект события клик
       */
      dropdownCityChoosedByUser(evt) {
        const selectedCity = evt.currentTarget.innerHTML.trim();
        // Скроем dropdown с городами
        this.citiesListFilteredByUserInput = [];

        // Обновляем value в компоненте SearchBar
        this.citySelectedFromDropdownList = selectedCity;

        // Сохраним результат как финальный на данном этапе
        this.finalSelectedCityItem = selectedCity;
      }
    },

    components: {
      SearchBar
    }
  }
</script>

<style lang="styl" scoped>
  @require '../../styl/_variables'

  .cities-list-modal
    &.modal
      position: relative

    &.top-line--flamingo
      &::before
        position: absolute
        width: 100%

    &__searchbar
      padding: 18px 24px 18px 23px
      font-size: 22px
      line-height: 1.18

    &__drop-box
        background-color: $snow
        width: 100%
        position: absolute
        /*left: 0
        top: 60px*/
        overflow-y: auto
        max-height: 174px

    &__drop-box-item
        font-size: 22px
        font-family: RobotoRegular
        line-height: 1.18
        color: $gray
        padding: 8px 0 8px 23px
        cursor: pointer

        &:hover
          background-color: $gallery

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
