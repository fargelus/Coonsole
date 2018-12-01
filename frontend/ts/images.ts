import * as _ from 'underscore';

import LogoIcon from '../assets/images/coonsole_logo.svg';
import CompassIcon from '../assets/images/compass.svg';
import LeftArrow from '../assets/images/arrow_left.png';

const DOMSelectorToImagesMap = {
    '.js-logo': LogoIcon,
    '.js-compass': CompassIcon,
    '.js-arrow-left': LeftArrow,
};

// Привязывает путь к картинкам в бандле
function bindImagesSource(imagesObj: object) {
    _.each(imagesObj as any, (Image: string, selector: string) => {
        const elems = document.querySelectorAll(selector);

        _.each(elems as any, (HTMLElem: HTMLImageElement) => {
            HTMLElem.src = Image;
        });
    });
}

bindImagesSource(DOMSelectorToImagesMap);

