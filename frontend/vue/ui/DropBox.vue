<template>
    <select class="dropbox"
            :style="toggleSelectStyle"
            :disabled="isSelectDisabled"
            :size="selectMaxSize"
            @change="onChange">
        <option class="dropbox-item dropbox__item text-color--gray"
                @click="optionClick"
                v-for="item in content">
            {{item}}
        </option>
    </select>
</template>

<script lang="ts">
    import Vue from 'vue';

    declare module 'vue/types/vue' {
        interface Vue {
            // data
            selectDefaultSize: number,
            selectMaxSize: number,

            // props
            content: string[],

            // methods
            calculateInitialSelectSize: () => void,
            setSelectSizeLessOrEqualToContent: () => void,
            extractTextFromHTML: (elem: HTMLElement) => string,
            getSelectedOption: () => HTMLOptionElement,
        }
    }

    export default Vue.extend({
        name: 'DropBox',

        data(): object {
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
            startTraverse: {
                type: Boolean,
                default: false,
            },
        },

        mounted() {
            this.calculateSelectSize();
            // Уберем подсветку первого элемента
            (this.$el as HTMLSelectElement).selectedIndex = -1;
        },

        methods: {
            calculateSelectSize(): void {
                this.calculateInitialSelectSize();
                this.setSelectSizeLessOrEqualToContent();
            },

            /**
             * Расчет начального значения атрибута size селекта.
             * Начальное значение берем исходя из размера потомков(option):
             * пытаемся отобразить как можно больше элементов
             */
            calculateInitialSelectSize(): void {
                const computedMaxHeight: string = getComputedStyle(this.$el).maxHeight as string;
                const selectMaxHeight: number = parseInt(computedMaxHeight, 10);

                const firstOption: HTMLOptionElement = this.$el.children[0] as HTMLOptionElement;
                const optionHeight: number = firstOption.clientHeight;

                this.selectMaxSize = Math.floor(selectMaxHeight / optionHeight);
                this.selectDefaultSize = this.selectMaxSize;
            },

            /**
             * Сопоставляем размер селекта с размером вх.данных
             */
            setSelectSizeLessOrEqualToContent(): void {
                const contentItemsCounter: number = this.content.length;

                this.selectMaxSize = contentItemsCounter > this.selectMaxSize
                                     ? this.selectDefaultSize
                                     : contentItemsCounter;

                /* Граничный случай: contentItemsCounter < this.selectDefaultSize */
                if (contentItemsCounter < this.selectMaxSize) {
                    this.selectMaxSize = contentItemsCounter;
                }
            },

            optionClick(evt: MouseEvent): void {
                const targetElem = evt.target as HTMLElement;
                const itemText: string = this.extractTextFromHTML(targetElem);
                this.$emit('item-clicked', itemText);
            },

            /**
             * Возвращает текстовое содержимое HTML элемента.
             */
            extractTextFromHTML(HTMLElem: HTMLElement): string {
                return HTMLElem.innerHTML.trim();
            },

            /**
             * Пользователь увидит, что выбран самый первый элемент из селекта
             */
            triggerChangeEvent(): void {
                const ev: Event = new Event('change');
                this.$el.dispatchEvent(ev);
            },

            onChange(): void {
                const selectedOption: HTMLOptionElement = this.getSelectedOption();
                const optionText: string = this.extractTextFromHTML(selectedOption);
                this.$emit('item-changed', optionText);
            },

            /**
             * Возвращает текущую активную опцию выбора
             */
            getSelectedOption(): Element {
                const selectElem: HTMLSelectElement = this.$el as HTMLSelectElement;

                const selectedOptionIndex: number = selectElem.selectedIndex;
                return selectElem.options[selectedOptionIndex];
            },
        },

        computed: {
            toggleSelectStyle(): string {
                if (this.isSelectDisabled) {
                    const childOption: Element = this.$el.children[0];
                    return 'padding: ' + getComputedStyle(childOption).padding;
                }

                return '';
            },

            isSelectDisabled(): Boolean {
                return this.selectMaxSize === 1;
            },
        },

        watch: {
            content(): void {
                this.setSelectSizeLessOrEqualToContent();
            },

            startTraverse(isUserWantsToStartTraverse: Boolean): void {
                if (isUserWantsToStartTraverse) {
                    this.$el.focus();
                    (this.$el as HTMLSelectElement).selectedIndex = 0;
                    this.triggerChangeEvent();
                }
            },
        },
    });
</script>

<style lang="styl" type="text/stylus">
@require '../../styl/_variables.styl'
@require '../../styl/modificators/_modifators.styl'

.dropbox
    background-color: $snow
    width: 100%
    position: absolute
    cursor: pointer
    overflow-y: auto
    box-shadow: 0 1px 5px 0 $mine-shaft-transparent
    font-family: RobotoRegular

    &__item:hover:not(:checked)
        @extend .bg-theme--gallery

</style>
