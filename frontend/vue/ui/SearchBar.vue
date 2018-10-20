<template>
    <div class="searchbar" v-click-outside="hideDropbox" @keydown="onKeyDown">
        <input type="text"
               class="search-input"
               v-model="userInput"
               :placeholder="inputPlaceholder"
               @input="setDropboxValues"
               @focus="setDropboxValues">

        <span @click="reset" v-if="userInput.length" class="cross-shape searchbar-wrapper__cross-shape"></span>

        <DropBox v-if="filteredSearchContent.length"
                 :content="filteredSearchContent"
                 :startTraverse="isDropboxStartTraverse"
                 @item-clicked="searchDone"
                 @item-changed="updateSearchInput"/>
    </div>
</template>

<script>
    import _ from 'underscore';
    import ClickOutside from 'vue-click-outside';
    import DropBox from './DropBox.vue';

    export default {
        name: 'SearchBar',

        data() {
            return {
                userInput: '',
                filteredSearchContent: [],
                isDropboxStartTraverse: false,
            }
        },

        props: {
            searchBase: Array,

            inputPlaceholder: {
                type: String,
                default: 'Поиск'
            },
            deliveredInputVal: {
                type: String,
                default: '',
            },

            userInputParser: Function,
        },

        watch: {
            deliveredInputVal(newVal) {
                if (newVal) {
                    this.userInput = newVal;
                }
            }
        },

        methods: {
            onKeyDown(evt) {
                if (!this.userInput) return;

                if (evt.code === 'ArrowDown') {
                    this.isDropboxStartTraverse = true;
                } else if (evt.code !== 'ArrowUp') {
                    this.isDropboxStartTraverse = false;
                    this.$el.querySelector('.search-input').focus();

                    if (evt.code === 'Escape') {
                        this.reset();
                    }

                    if (evt.code === 'Enter') {
                        this.emitCheckValidSignal();
                    }

                    if (evt.code === 'Backspace') {
                        this.filteredSearchContent = [];
                    }
                }
            },

            /**
             * Сброс введенного значения
             */
            reset() {
                this.userInput = '';
                this.hideDropbox();
                this.filteredSearchContent = [];
                this.selectedDropboxItemIndex = -1;
                this.userInputParser('');
            },

            /**
             * Прячем выпадающий список
             */
            hideDropbox() {
                this.filteredSearchContent = [];
            },

            /**
             * Уведомляем родительский компонент, что поиск завершен
             *
             * @param {String} resultQuery - Результат поиска
             */
            searchDone(resultQuery) {
                this.hideDropbox();
                this.userInput = resultQuery !== this.userInput ? resultQuery : this.userInput;

                this.$emit('search-query', this.userInput);
            },

            /**
             * Заполним выпадающий список.
             * Города фильтруются на лету, в зависимости от ввода пользователя
             */
            setDropboxValues() {
                let correctUserInput = this.userInputParser(this.userInput);

                // Фильтруем
                this.filteredSearchContent = this.getFilteredSearchResults(correctUserInput);

                this.hideDropboxIfUserTypedCity(correctUserInput);
                this.emitCheckValidSignal();
            },

            /**
             * Прячет дропбокс, если пользователь уже набрал город
             *
             * @param {String} userInput -- текущее зн-е поиска
             */
            hideDropboxIfUserTypedCity(userInput) {
                const isOneItemLeft = this.filteredSearchContent.length === 1;
                const isFilteredSearchContainsUserInput = this.filteredSearchContent.includes(userInput);
                if (isOneItemLeft && isFilteredSearchContainsUserInput) {
                    this.searchDone(this.userInput);
                }
            },
            
            emitCheckValidSignal() {
                const validationSet = {
                    'content': this.filteredSearchContent,
                    'value': this.userInput,
                };

                this.$emit('check-valid', validationSet);
            },

            /**
             * Поисковая фильтрация по пользовательскому вводу
             *
             * @param  {String} pattern - Значение введенное пользователем.
             * @return {Array} Отфильтрованный список поисковых данных
             */
            getFilteredSearchResults(pattern) {
                // Получим длину введенных символов
                const patternLen = pattern.length;
                if (!patternLen) return [];

                // Небольшая эвристика:
                // избыточно на каждой итерации фильтровать весь список
                // достаточно отфильтровать последний результат
                const filteredArray = this.filteredSearchContent.length
                                      ? this.filteredSearchContent
                                      : this.searchBase;

                if (filteredArray.length === 1) return filteredArray;

                return _.filter(filteredArray, (filterItem) => {
                    const slicedFilterItem = filterItem.slice(0, patternLen);
                    return slicedFilterItem === pattern;
                });
            },

            /**
             * Обновляет поисковой запрос текущим значением из дропбокса.
             *
             * @param {String} newVal - Значение подставляется из дропбокса
             */
            updateSearchInput(newVal) {
                this.userInput = newVal;
            }
        },

        components: {
            DropBox
        },

        directives: {
            ClickOutside,
        }
    }
</script>

<style lang="styl" type="text/stylus">
@require '../../styl/_variables'

.search-input
    box-sizing: border-box
    display: block
    width: 100%

    &::placeholder
        color: $silver

.searchbar-wrapper__cross-shape
    top: 18px
    right: 25px
</style>
