<template>
    <select class="dropbox"
            :style="toggleSelectStyle"
            :disabled="isSelectDisabled"
            :size="selectMaxSize"
            @change="onChange">
        <option class="dropbox-item dropbox__item text-color--gray"
                @click="itemClick"
                v-for="item in content">
            {{item}}
        </option>
    </select>
</template>

<script>
    export default {
        name: 'DropBox',

        data() {
            return {
                selectDefaultSize: 1,

                // Для расчета в методе calculateSelectSize должно быть > 1
                selectMaxSize: 2,
            }
        },

        props: {
            content: {
                type: Array,
                default: [],
            },
            startTraverse: false,
        },

        mounted() {
            this.calculateSelectSize();
            // Уберем подсветку первого элемента
            this.$el.selectedIndex = -1;
        },

        methods: {
            calculateSelectSize() {
                this.calculateInitialSelectSize();
                this.setSelectSizeBelowOrEqualToContent();
            },

            /**
             * Расчет начального значения атрибута size селекта.
             * Начальное значение берем исходя из размера потомков(option):
             * пытаемся отобразить как можно больше элементов
             */
            calculateInitialSelectSize() {
                const selectMaxHeight = parseInt( getComputedStyle(this.$el).maxHeight, 10 );

                const firstOption = this.$el.children[0];
                const optionHeight = firstOption.clientHeight;

                this.selectMaxSize = Math.floor(selectMaxHeight / optionHeight);
                this.selectDefaultSize = this.selectMaxSize;
            },

            /**
             * Сопоставляем размер селекта с размером вх.данных
             */
            setSelectSizeBelowOrEqualToContent() {
                const contentItemsCounter = this.content.length;

                this.selectMaxSize = contentItemsCounter > this.selectMaxSize
                                     ? this.selectDefaultSize
                                     : contentItemsCounter;

                /* Граничный случай: contentItemsCounter < this.selectDefaultSize */
                if (contentItemsCounter < this.selectMaxSize) {
                    this.selectMaxSize = contentItemsCounter;
                }
            },

            itemClick(evt) {
                const itemText = this.extractTextFromHTML(evt.target);
                this.$emit('item-clicked', itemText);
            },

            /**
             * Возвращает текстовое содержимое HTML элемента.
             *
             * @param {HTMLElement} HTMLElem
             * @return {String} - текстовый контент HTML элемента.
             */
            extractTextFromHTML(HTMLElem) {
                return HTMLElem.innerHTML.trim();
            },

            /**
             * Пользователь увидит, что выбран самый первый элемент из селекта
             */
            triggerChangeEvent() {
                const ev = new Event('change');
                this.$el.dispatchEvent(ev);
            },

            onChange() {
                const selectedOption = this.extractSelectedOption();
                const changedItem = this.extractTextFromHTML(selectedOption);
                this.$emit('item-changed', changedItem);
            },

            /**
             * Возвращает текущую активную опцию выбора
             *
             * @return {HTMLOptionElement} - текущая выбранная опция.
             */
            extractSelectedOption() {
                const selectedOptionIndex = this.$el.selectedIndex;
                return this.$el.options[selectedOptionIndex];
            },
        },

        computed: {
            toggleSelectStyle() {
                if (this.isSelectDisabled) {
                    const childOption = this.$el.children[0];
                    return 'padding: ' + getComputedStyle(childOption).padding;
                }

                return '';
            },

            isSelectDisabled() {
                return this.selectMaxSize === 1;
            },
        },

        watch: {
            content() {
                this.setSelectSizeBelowOrEqualToContent();
            },

            startTraverse(isUserWantsToStartTraverse) {
                if (isUserWantsToStartTraverse) {
                    this.$el.focus();
                    this.$el.selectedIndex = 0;
                    this.triggerChangeEvent();
                }
            },
        },
    }
</script>

<style lang="styl" type="text/stylus">
@require '../../styl/_variables.styl'
@require '../../styl/modificators/_modifators.styl'

.dropbox
    width: 100%
    position: absolute
    cursor: pointer
    overflow-y: auto
    box-shadow: 0 1px 5px 0 rgba(50, 50, 50, 0.75)
    font-family: RobotoRegular

    &__item
        cursor: pointer
        background-color: $snow

        &:hover:not(:checked)
            @extend .box-shadow--gallery

    &:not(:checked)
        @extend .bg-theme--gallery
</style>
