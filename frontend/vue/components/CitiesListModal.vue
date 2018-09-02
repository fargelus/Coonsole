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
        method = 'citiesJSON',
        russianCitiesURL = `${serviceURL}/${method}?north=81.8616409300001&south=41.1853530000001&east=-169.05&west=19.25&lang=ru&username=${username}`;

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
