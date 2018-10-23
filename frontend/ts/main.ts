import Vue from 'vue';
import * as _ from 'underscore';
import router from './router';
// @ts-ignore
import App from '../vue/App.vue';
import '../styl/all.styl';
// @ts-ignore
import LogoIcon from '../assets/images/coonsole_logo.svg';
// @ts-ignore
import CompassIcon from '../assets/images/compass.svg';
import '../ts/ui';


// Привязывает путь к картинкам в бандле
function bindImagesSource(imagesObj: object) {
  _.each(imagesObj as any, (Image: string, selector: string) => {
    const elems = document.querySelectorAll(selector);

    _.each(elems as any, (HTMLElem: HTMLImageElement) => {
        HTMLElem.src = Image;
    });
  });
}

new Vue({
    router,
    render: h => h(App),
}).$mount('#app');

const DOMSelectorToImagesMap = {
  '.js-logo': LogoIcon,
  '.js-compass': CompassIcon,
};

bindImagesSource(DOMSelectorToImagesMap);
