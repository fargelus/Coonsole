<template>
    <div class="header-pagination">
        <!--<div class="pagination-button interact-element"><-</div>-->
        <span v-for="page in maxPages">{{ page }}</span>
        <!--<div class="pagination-button interact-element">-></div>-->
    </div>
</template>

<style lang="styl" scoped type="text/stylus">
  .header-pagination
      position: absolute;
      height: 32px;
      right: 0;

  .pagination-button
      position: relative;
      width: 20px;
</style>

<script>
    export default {

        props: {
            maxPages: {
                type: Number,
                default: 1,
            },

            currentPage: {
                type: Number,
                default: 1,
            },
        },

        data() {
            return {};
        }
        //name: "HeaderFilter"
    }
</script>
