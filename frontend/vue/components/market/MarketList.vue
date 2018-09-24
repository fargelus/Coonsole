<template>
  <div class="market-list">
    <!-- <router-link tag="li" to="/bar/"></router-link> -->
    <MarketItem class="market-list__item" v-for="n in 8" :key="n"/>
  </div>
</template>

<script>
  import MarketItem from './MarketItem.vue';

  export default {
    data() {
      return {
          name: 'Market'
      };
    },

    components: {
      MarketItem,
    },
  }
</script>

<style lang="styl">
    @require "../../../styl/_variables"

.market-list
    background-color: $snow

    display: flex
    flex-flow: row wrap

    &__item
      flex: 1 1 100%
      margin-top: 32px
      &:not(:nth-child(4n))
        margin-right: 12px

</style>
