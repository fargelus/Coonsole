<template>
    <button type="button" class="button"
            :class="{
                'button-theme--snow': snow,
                'button-theme--orange': orange,
                'button-theme--light-orange': light_orange,
                'button-theme--sky': sky,
                'button-theme--masala': masala,
            }"
            :disabled="disabled"
            :type="type"
            @click="onClick">
        <slot></slot>
    </button>
</template>

<script lang="ts">
    import Vue from 'vue';
    import * as _ from 'underscore';

    const btnProps = {
        type: {
            type: String,
            default: 'button',
        },

        disabled: {
            type: Boolean,
            default: false,
        },

        href: {
            type: String,
            default: null,
        },
    };

    _.each(['snow', 'orange', 'light_orange', 'sky', 'masala'], (btnTheme: string) => {
        btnProps[btnTheme] = {
           type: Boolean,
           default: false,
       };
    });

    export default Vue.extend({
        name: 'ui-button',
        props: btnProps,

        methods: {
            onClick(event: string): void {
                this.href ? window.open(this.href) : this.$emit('click', event);
            }
        },
    });
</script>

<style lang="styl" type="text/stylus">
    @require '../../styl/_variables'

    .button
        overflow: hidden
        text-overflow: ellipsis
        cursor: pointer
        display: inline-block
        border-radius: 4px
        color: $masala
        padding: 0 12px
        font-size: 16px
        max-width: 160px
        white-space: nowrap

        &__label-left
            position: relative
            top: 3px
            margin-right: 7px

    .button.button-theme
        &--orange, &--light-orange, &--sky, &--masala
            color: $snow
            border: 0
</style>
