<template>
  <div class="modal cities-list-modal top-line--flamingo">
    <div class="cities-list-modal__search-input">
      <input type="text" name="" value="" placeholder="Введите город">
    </div>


  </div>
</template>

<script>
  const serviceURL = 'http://api.geonames.org';
  const username = 'fargelus';
  let method = 'countryInfo';

  const countryInfoURL = `${serviceURL}/${method}?lang=ru&country=RU&username=${username}`;
  const coords = {};

  // Получим координаты РОССИИ
  $.get(countryInfoURL, (xmlData) => {
    coords.west = $(xmlData).find('west').text();
    coords.east = $(xmlData).find('east').text();
    coords.north = $(xmlData).find('north').text();
    coords.south = $(xmlData).find('south').text();
  }).then(() => {
    method = 'citiesJSON';
    const citiesListURL = `${serviceURL}/?north=${coords.north}&south=${coords.south}&east=${coords.east}&west=${coords.west}&lang=ru&username=${username}`;

    $.getJSON(citiesListURL, (citiesList) => {
      console.dir(citiesList);
    });
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
