<template>
    <button type="button" class="button"

            :class="{
                'button-theme--snow': snow,
                'button-theme--orange': orange
            }"
            :disabled="disabled"
            :type="type"
            @click="onClick">
        <slot></slot>
    </button>
</template>

<style lang="styl" scoped>
    @require '../../styl/_variables'

    .button
        overflow: hidden
        text-overflow: ellipsis

    .button.button-theme--orange
        color: white
</style>

<script>
    export default {
        name: "ui-button",

        props: {
            type: {
                type: String,
                default: 'button',
            },

            snow: {
                type: Boolean,
                default: false,
            },

            orange: {
                type: Boolean,
                default: false,
            },

            href: {
                type: String,
                default: null,
            },

            disabled: {
                type: Boolean,
                default: false,
            },
        },

        methods: {
            onClick(event) {
                this.href ? window.open(this.href) : this.$emit('click', event);
            }
        },
    }
</script>
