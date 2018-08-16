import Vue from 'vue';
import Router from './router';
import App from '../vue/App.vue';
import '../styl/all.styl';
import LogoIcon from '../assets/images/coonsole_logo.svg';
import CompassIcon from '../assets/images/compass.svg';

// Привязывает путь к картинкам в бандле
function bindImagesSource(imagesObj) {
  Object.keys(imagesObj).forEach((selector) => {
    const imagePath = imagesObj[selector];
    const HTMLCollection = document.querySelectorAll(selector);

    HTMLCollection.forEach((singleElem) => {
      singleElem.src = imagePath;
    });
  });
}

const vm = new Vue({
    el: '#app',
    template: '<router-view></router-view>',
    Router,
    render: h => h(App),
});

const DOMSelectorToImagesMap = {
  '.js-logo': LogoIcon,
  '.js-compass': CompassIcon,
};

bindImagesSource(DOMSelectorToImagesMap);
