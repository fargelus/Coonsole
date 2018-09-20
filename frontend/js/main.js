import Vue from 'vue';
import _ from 'underscore';
import router from './router';
import App from '../vue/App.vue';
import '../styl/all.styl';
import LogoIcon from '../assets/images/coonsole_logo.svg';
import CompassIcon from '../assets/images/compass.svg';
import './ui';


// Привязывает путь к картинкам в бандле
function bindImagesSource(imagesObj) {
  _.each(imagesObj, (Image, selector) => {
    const elems = document.querySelectorAll(selector);

    _.each(elems, (HTMLElem) => {
        HTMLElem.src = Image;
    });
  });
}

const vm = new Vue({
    el: '#app',
    template: '<router-view></router-view>',
    router,
    render: h => h(App),
}).$mount('#app');

const DOMSelectorToImagesMap = {
  '.js-logo': LogoIcon,
  '.js-compass': CompassIcon,
};

bindImagesSource(DOMSelectorToImagesMap);
