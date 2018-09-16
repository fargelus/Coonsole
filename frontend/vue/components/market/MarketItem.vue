<template>
  <div class="market-item">
    <div class="poster-wrapper bg-theme--gallery"></div>
    <div class="market-item__caption top-line--masala border-theme--gallery">
      <h3 class="market-item__title">{{ itemTitle }}</h3>
      <div class="market-item__bottom">
        <span class="market-item__release-date">{{ itemReleaseDate }}</span>
        <span class="market-item__price">{{ itemCost }}&#8381;</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'MarketItem',
  data() {
    return {
      itemTitle: 'NAME',
      itemReleaseDate: '2 дня назад',
      itemCost: '0000'
    }
  }
}
</script>

<style lang="styl">
  .market-item
    max-width: 205px
    font-family: RobotoCondensed
    cursor: pointer

    &__caption
      padding: 12px
      border-bottom-left-radius: 4px
      border-bottom-right-radius: 4px

    &__title
      font-size: 18px
      font-family: inherit
      margin-top: 3px

    &__bottom
      display: flex
      margin-top: 10px
      justify-content: space-between
      align-items: center

    &__price
      font-size: 18px
      line-height: 1.16

    &__release-date
      font-size: 12px
      line-height: 1.16

  .market-item__caption
    &.top-line--masala
      position: relative
      &::before
        position: absolute
        width: 100%

  .poster-wrapper
    width: 100%
    min-height: 203px
</style>
