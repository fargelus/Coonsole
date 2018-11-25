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
                <input ref="fromPriceInput" type="number"
                       id="from-price-selector"
                       v-model="from"
                       :class="{'filter-item__element--active' : from.length > 0}"
                       class="filter-item__element filter-item__element--price-selector"
                       value="0"
                       min="0"
                       max="19999"
                       :placeholder="filterItem.price.from"
                       @change="validatePrice">

                <input ref="tillPriceInput" type="number"
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

<script lang="ts">
    import Vue from 'vue';

    interface IFilterCategory {
        title: string,
        items: string[],
        price?: object,
        active?: string,
    }

    export default Vue.extend({
        name: 'Filters',

        data() {
            const sortFilters: IFilterCategory = {
                title: 'Сортировать по',
                items: [
                    'Возрастанию цены',
                    'Убыванию цены',
                    'Дате добавления'
                ],
                active: 'Возрастанию цены',
            } as IFilterCategory;

            const consoleTypeFilters: IFilterCategory = {
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
            } as IFilterCategory;

            const priceFilters: IFilterCategory = {
                title: 'Цена',
                price: {
                    from: 'От',
                    till: 'До',
                }
            } as IFilterCategory;

            return {
                filterItems: [sortFilters, consoleTypeFilters, priceFilters],
                from: 0,
                till: 19999,
            };
        },

        methods: {
            /**
             * Меняем внешний вид текущего активного фильтра
             */
            filterSelectedByUser(evt: MouseEvent, selectedFilterItem: IFilterCategory): void {
                const target: HTMLElement = evt.target as HTMLElement;
                selectedFilterItem.active = target.innerHTML.trim() as string;
            },

            /**
             * Если зн-е цены больше/меньше порогового, то
             * ставим текущее зн-е цены максимальным или минимальным.
             */
            setPriceValueInRange(inputElement: HTMLInputElement): void {
                // Валидация граничных зн-й
                const currentValue: number = inputElement.valueAsNumber;
                const maxValue: number = +(inputElement.getAttribute('max') as string);
                const minValue: number = +(inputElement.getAttribute('min') as string);

                const isBeyond = this.checkIfInputValBeyond(minValue, maxValue, currentValue);

                if (isBeyond) {
                    const inputID = inputElement.getAttribute('id') as string;
                    const targetVal: number = isBeyond === -1 ? minValue : maxValue;

                    if (inputID.search(/from/) > -1) {
                        this.from = targetVal;
                    } else {
                        this.till = targetVal;
                    }
                }
            },

            /**
             * Возвращ.зн-я:
             * 1 - Больше максимального зн-я
             * 0 - В границах между максим. и миним.
             * -1 - Меньше миним.
            */
            checkIfInputValBeyond(min: number, max: number, current: number): number {
                return current > max ? 1 : current < min ? -1 : 0;
            },

            /**
             * Валидация цены: цена "от" не должна быть больше цены "до"
             */
            validatePrice(evt: MouseEvent): void {
                const inputElement = evt.target as HTMLInputElement;

                // Установка значения в пределах границ
                this.setPriceValueInRange(inputElement);

                // Выбираем оба инпута
                const isAnyHasValidError = this.checkIfAnyPriceInputHasValidError();

                // Если значение "от" больше зн-я "до"
                // вешаем на текущий инпут класс,
                // сообщающий об ошибке валидации
                const inputClasses: DOMTokenList = inputElement.classList;
                const isUserAlreadyFillModels: number = this.from && this.till;
                if (isUserAlreadyFillModels && this.from >= this.till) {
                    // Ошибка валидации должна быть одна
                    if (!isAnyHasValidError) {
                        inputClasses.add('validation-error');
                    }
                } else {
                    this.removeAllValidErrorsFromPriceInputs();
                }
            },

            checkIfAnyPriceInputHasValidError(): boolean {
                const { from, till } = this.getTypedHTMLInputsFromRef();
                const isFromPriceInputHasValidError: boolean = from.classList.contains('validation-error');
                const isTillPriceInputHasValidError: boolean = till.classList.contains('validation-error');

                return isFromPriceInputHasValidError || isTillPriceInputHasValidError;
            },

            getTypedHTMLInputsFromRef() {
                const from = this.$refs.fromPriceInput[0] as HTMLInputElement;
                const till = this.$refs.tillPriceInput[0] as HTMLInputElement;

                return { 'from': from, 'till': till };
            },

            removeAllValidErrorsFromPriceInputs(): void {
                const { from, till } = this.getTypedHTMLInputsFromRef();
                from.classList.remove('validation-error');
                till.classList.remove('validation-error');
            }
        },
    });
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

            &:hover
                background-color: $pinky
                color: $masala

            &:focus
                border-bottom: 2px solid $blaze-orange

            &--active
                border-bottom: 2px solid $masala

        &__title
            margin-top: 12px

        &__inner--price
            display: flex
            padding-left: 15px
</style>
