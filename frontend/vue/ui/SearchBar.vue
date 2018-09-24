<template>
    <div class="searchbar" v-click-outside="hideDropbox">
        <input type="text"
               class="search-input"
               v-model="userInput"
               :placeholder="inputPlaceholder"
               @input="setDropboxValues"
               @focus="setDropboxValues"
               @keydown="traverseDropboxItems">

        <span @click="reset" class="cross-shape searchbar-wrapper__cross-shape"></span>

        <DropBox v-if="filteredSearchContent.length"
                 :content="filteredSearchContent"
                 :startTraverseFromIndex="selectedDropboxItemIndex"
                 @item-clicked="searchDone"/>
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
                selectedDropboxItemIndex: -1,
            }
        },

        props: {
            searchBase: Array,

            inputPlaceholder: {
                type: String,
                default: 'Поиск'
            },

            userInputParser: Function,
        },

        methods: {
            /**
             * Сброс введенного значения
             */
            reset() {
                this.userInput = '';
                this.hideDropbox();
                this.filteredSearchContent = [];
                this.selectedDropboxItemIndex = -1;
            },

            traverseDropboxItems(evt) {
                const isIndexLowerLast = this.selectedDropboxItemIndex < this.filteredSearchContent.length - 1;
                const isIndexGreaterZero = this.selectedDropboxItemIndex > 0;

                if (evt.code === 'ArrowDown' && isIndexLowerLast) {
                    this.selectedDropboxItemIndex++;
                } else if (evt.code === 'ArrowUp' && isIndexGreaterZero) {
                    this.selectedDropboxItemIndex--;
                } else if (evt.code === 'Escape') {
                    this.reset();
                } else if (evt.code === 'Enter') {
                    this.searchDone(this.filteredSearchContent[this.selectedDropboxItemIndex]);
                } else if (evt.code === 'Backspace') {
                    this.filteredSearchContent = [];
                }
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
             * Заполним выпадающий список.
             * Города фильтруются на лету, в зависимости от ввода пользователя*
             */
            setDropboxValues() {
                if (!this.userInput) return;

                let correctUserInput = this.userInputParser(this.userInput);

                // Фильтруем
                this.filteredSearchContent = this.getFilteredSearchResults(correctUserInput);
            },

            /**
             * Прячем выпадающий список
             */
            hideDropbox() {
                this.filteredSearchContent = [];
            },

            searchDone(resultQuery) {
                this.hideDropbox();
                this.userInput = resultQuery;

                this.$emit('search-query', resultQuery);
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
