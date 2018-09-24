<template>
    <ul class="dropbox">
        <li v-for="item in content"
            @click="itemClick"
            class="dropbox-item dropbox__item text-color--gray"
            :class="{'dropbox__item--selected': content.indexOf(item) === selectedItemIndex}">
            {{item}}
        </li>
    </ul>
</template>

<script>
    export default {
        name: 'DropBox',

        data() {
            return {
                selectedItemIndex: -1,
            };
        },

        props: {
            content: Array,
            startTraverseFromIndex: Number,
        },

        watch: {
            startTraverseFromIndex(traverseItemIndex) {
                if (traverseItemIndex > -1) {
                    this.selectedItemIndex = traverseItemIndex;
                }
            }
        },

        methods: {
            itemClick(evt) {
                const itemText = evt.target.innerHTML.trim();
                this.$emit('item-clicked', itemText);
            },
        }
    }
</script>

<style lang="styl" type="text/stylus">
@require '../../styl/_variables.styl'
@require '../../styl/modificators/_modifators.styl'

.dropbox
    background-color: $snow
    width: 100%
    position: absolute
    overflow-y: auto
    box-shadow: 0 1px 5px 0 rgba(50, 50, 50, 0.75)
    font-family: RobotoRegular

    &__item
        cursor: pointer

        &:hover, &--selected
            @extend .bg-theme--gallery
</style>
