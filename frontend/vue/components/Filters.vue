<template>
    <div class="filters bg-theme--gallery">
        <div class="filter-item filters__item" v-for="filterItem in filterItems">
            <h3 class="filter-item__title">{{ filterItem.title }}</h3>

            <ul class="filter-item__inner" v-if="filterItem.items">
                <li v-for="userSelectItem in filterItem.items"
                    @click="filterSelectedByUser($event, filterItem)"
                    class="filter-item__element filter-item__element--checkbox"
                    :class="{'bg-theme--white-orange': filterItem.active === userSelectItem}">
                    {{ userSelectItem }}
                </li>
            </ul>

            <div class="filter-item__inner filter-item__inner--price" v-else-if="filterItem.price">
                <input type="number"
                       id="from-price-selector"
                       v-model="from"
                       :class="{'filter-item__element--active' : from.length > 0}"
                       class="filter-item__element filter-item__element--price-selector"
                       value="0"
                       min="0"
                       max="19999"
                       :placeholder="filterItem.price.from"
                       @change="validatePrice">

                <input type="number"
                       id="till-price-selector"
                       v-model="till"
                       :class="{'filter-item__element--active' : till.length > 0}"
                       class="filter-item__element filter-item__element--price-selector"
                       value="20000"
                       min="1"
                       max="20000"
                       :placeholder="filterItem.price.till"
                       @change="validatePrice">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Filters',

        data() {
            return {
                filterItems: [
                    {
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
                from: '',
                till: '',
            };
        },

        methods: {
            /**
             * Меняем внешний вид текущего активного фильтра
             * @param {MouseEvent} evt - Объект события мыши
             * @param {Object} selectedFilterItem - Текущий объект фильтра(элемент filterItems)
             */
            filterSelectedByUser(evt, selectedFilterItem) {
                selectedFilterItem.active = evt.target.innerHTML.trim();
            },

            /**
             * Если зн-е цены больше/меньше порогового, то
             * ставим текущее зн-е цены максимальным или минимальным.
             *
             * @param {HTMLElement} inputElement - Инпут с ценой
             */
            setPriceValueInRange(inputElement) {
                // Возвращ.зн-я:
                // 1 - Больше максимального зн-я
                // 0 - В границах между максим. и миним.
                // -1 - Меньше миним.
                const isValueBeyond = (current, min, max) => {
                    if (current > max) return 1;
                    if (current < min) return -1;
                    return 0;
                };

                // Валидация граничных зн-й
                const currentValue = inputElement.valueAsNumber;
                const maxValue = inputElement.getAttribute('max');
                const minValue = inputElement.getAttribute('min');
                const isBeyond = isValueBeyond(currentValue, minValue, maxValue);

                if (isBeyond) {
                    const inputID = inputElement.getAttribute('id');
                    const targetVal = isBeyond === -1 ? minValue : maxValue;

                    if (inputID.match(/from/)) {
                        this.from = targetVal;
                    } else {
                        this.till = targetVal;
                    }
                }
            },

            /**
             * Валидация цены: цена "от" не должна быть больше цены "до"
             * @param {MouseEvent} evt - Объект события мыши
             */
            validatePrice(evt) {
                const inputElement = evt.target;

                // Установка значения в пределах границ
                this.setPriceValueInRange(inputElement);

                // Выбираем оба инпута
                const fromPriceInputElement = document.getElementById('from-price-selector');
                const tillPriceInputElement = document.getElementById('till-price-selector');

                // Проверяем валидны ли поля на тек.момент
                const isFromPriceInputHasValidError = fromPriceInputElement.classList.contains('validation-error');
                const isTillPriceInputHasValidError = tillPriceInputElement.classList.contains('validation-error');
                const isAnybodyHasValidError = isFromPriceInputHasValidError || isTillPriceInputHasValidError;

                // Если значение "от" больше зн-я "до"
                // вешаем на текущий инпут класс,
                // сообщающий об ошибке валидации
                const inputClasses = inputElement.classList;
                const isUserAlreadyFillModels = this.from && this.till;
                if (isUserAlreadyFillModels && +this.from >= +this.till) {
                    // Ошибка валидации должна быть одна
                    if (!isAnybodyHasValidError) {
                        inputClasses.add('validation-error');
                    }
                } else {
                    fromPriceInputElement.classList.remove('validation-error');
                    tillPriceInputElement.classList.remove('validation-error');
                }
            }
        },
    }
</script>

<style lang="styl" type="text/stylus">
    @require "../../styl/_variables"
    @require "../../styl/modificators/_modifators"

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
                width: 65px
                border-bottom: 2px solid $silver
                padding-left: 3px

                &:not(:last-child)
                    margin-right: 20px

                // Спрячем стрелки(только для webkit)
                &::-webkit-outer-spin-button, &::-webkit-inner-spin-button
                    appearance: none

                // Стрелки для FF
                -moz-appearance: textfield

            &:hover
                background-color: $pinky
                color: $masala

            &:focus
                border-bottom: 2px solid $blaze-orange

            &--active
                border-bottom: 2px solid $masala
        &__title
            margin-top: 12px
            font-weight: 500

        &__inner--price
            display: flex
            padding-left: 15px
</style>
