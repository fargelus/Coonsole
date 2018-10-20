<template>
    <div class="modal cities-list-modal top-line--flamingo">
        <SearchBar class="cities-list-modal__searchbar"
                   @search-query="setCity"
                   @check-valid="toggleAcceptButtonState"
                   :deliveredInputVal="finalSelectedCityItem"
                   :inputPlaceholder="chooseCityPlaceholder"
                   :searchBase="allCities"
                   :userInputParser="getParsedUserInput"/>

        <div class="cities-list-modal__content">
            <div class="cities-list-modal__content-title bg-theme--gallery">
                {{ contentTitle }}
            </div>

            <div class="cols-wrapper cities-list-modal__cols-wrapper">
                <ul class="cols-wrapper__column">
                    <li @click="setCity(city)" class="cities-list-modal__city-item" :class="{'bg-theme--black-n-white':finalSelectedCityItem === city}" v-for="city in mainCities.slice(0, 10)">{{ city }}</li>
                </ul>

                <ul class="cols-wrapper__column">
                    <li @click="setCity(city)" class="cities-list-modal__city-item" :class="{'bg-theme--black-n-white':finalSelectedCityItem === city}" v-for="city in mainCities.slice(10, 20)">{{ city }}</li>
                </ul>

                <ul class="cols-wrapper__column">
                    <li @click="setCity(city)" class="cities-list-modal__city-item" :class="{'bg-theme--black-n-white':finalSelectedCityItem === city}" v-for="city in mainCities.slice(20, 30)">{{ city }}</li>
                </ul>
            </div>
        </div>

        <div class="cities-list-modal__control-buttons">
            <ui-button orange @click="cityItemChoosedByUser" class="cities-list-modal__control-button-item" :class="{ 'button--disabled': !finalSelectedCityItem }">{{ acceptButtonText }}</ui-button>
        </div>
    </div>
</template>

<script>
    import _ from 'underscore';
    import SearchBar from '../ui/SearchBar.vue';

    export default {
        data() {
            return {
                name: 'CitiesListModal',
                chooseCityPlaceholder: 'Введите город',
                contentTitle: 'Введите город поиска или выберите город из списка популярных.',
                allCities: [],
                mainCities: [],
                acceptButtonText: 'Принять',
                finalSelectedCityItem: '',
                supposedCity: undefined,
            }
        },

        // Список всех городов
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
             * Устанавливает состояние кнопки "Принять" в зависимости от введенного значения.
             * @param {Object} checkingEntity - { Значение ввода: список городов для подстановки }
             */
            toggleAcceptButtonState(checkingEntity) {
                const {citiesList, typedVal} = checkingEntity;
                if (citiesList.length) {
                    this.changeSupposedCity(citiesList);
                    this.finalSelectedCityItem = this.supposedCity === typedVal ? this.supposedCity : '';
                }
            },

            /**
             * Сохраняет город, который пользователь хочет ввести.
             * @param {Array} citiesList - Список текущих автодополняемых городов
             */
            changeSupposedCity(citiesList) {
                this.supposedCity = citiesList.length === 1 ? citiesList[0] : undefined;
            },

            /**
             * Фильтруем в дропбоксе только города начинающиеся с русской заглавной буквы
             * @param {String} inputText - Первый символ ввода в текстовом поле
             * @return {String} correctUserInput - Исправленный символ
             */
            getParsedUserInput(inputText) {
                if (!inputText) {
                    // Отключим кнопку "Принять"
                    this.finalSelectedCityItem = '';
                    return inputText;
                }

                const capitalizeString = (str) => {
                    if (str[0].charCodeAt(0) >= 65 && str[0].charCodeAt(0) <= 90) {
                        return str;
                    }

                    return str[0].toUpperCase() + str.slice(1);
                };

                let correctUserInput = inputText;

                if (inputText) {
                    const firstLetter = inputText[0];

                    // Приведём первую букву к верхнему регистру
                    // Формат русскоязычных городов гарантируется
                    correctUserInput = firstLetter.match(/[А-Яа-я]/)
                                       ? capitalizeString(inputText)
                                       : '';
                }

                return correctUserInput;
            },

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

                // Отсортируем города по убыванию их населения
                const citiesSortedByPopulation = _.sortBy(this.citiesListProp, (citiesRaw) => citiesRaw.population).reverse();

                // Названия всех городов
                this.allCities = filterCitiesObjByProperty(citiesSortedByPopulation, 'name');

                // Получим первые 30 городов с самым большим населением
                const bigCitiesInfo = _.first(citiesSortedByPopulation, 30);

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
             * Либо клик на город из списка популярных, либо из дропбокса
             * @param {String} cityName - Выбранный город пользователем
             */
            setCity(cityName) {
                // Сохраним результат как финальный на данном этапе
                this.finalSelectedCityItem = cityName;
            },
        },

        components: {
            SearchBar,
        },
    }
</script>

<style lang="styl" type="text/stylus">
@require '../../styl/_variables'

.cities-list-modal

    // ******* General *******
    &__cols-wrapper, &__content
        font-size: 14px

    &__cols-wrapper, &__control-button-item, &__searchbar .dropbox__item
        font-family: RobotoRegular

    &__searchbar input, &__control-button-item, &__searchbar .dropbox__item
        line-height: 1.18
    // ******* End Of General *******

    &.modal
        background-color: $snow
        top: 70px
        height: 460px

    &.top-line--flamingo
        &::before
            position: absolute
            width: 100%

    &__searchbar
        input
            padding: 18px 24px 18px 23px
            font-size: 22px

        .dropbox
            max-height: 174px
            font-size: 22px
            color: $gray

            &__item
                padding: 8px 0 8px 23px

    &__content-title
        line-height: 1.14
        padding: 8px 24px

    &__cols-wrapper
        line-height: 1.5

    &__city-item
        cursor: pointer

        &:hover
            text-decoration: underline

    &__control-buttons
        display: flex
        justify-content: flex-end
        margin: 30px 24px 0 24px

    &__control-button-item
        text-transform: capitalize
        font-size: 16px
        width: 170px
        height: 30px
</style>
