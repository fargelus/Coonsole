<template>
  <div class="modal cities-list-modal top-line--flamingo">
    <div class="cities-list-modal__search-input">
      <input type="text" name="" value="" placeholder="Введите город">
    </div>


  </div>
</template>

<script>
  import $ from 'jquery';

  const serviceURL = 'http://api.geonames.org',
        username = 'fargelus',
        method = 'searchJSON',
        russianCitiesURL = `${serviceURL}/${method}?username=${username}&country=ru&maxRows=20&lang=ru&style=SHORT`;

  $.ajax({
    url: russianCitiesURL,
    datatype: 'jsonp',
    success: (russianCitiesJSON) => {
      console.dir(citiesList);
    }
  });

  export default {
    data() {
      return {
        name: 'CitiesListModal',
      }
    },
  }
</script>

<style lang="styl" scoped>
  .modal.cities-list-modal
    position: fixed
</style>
