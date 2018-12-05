import Vue from "vue";
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faUser } from '@fortawesome/free-solid-svg-icons';
import { library } from "@fortawesome/fontawesome-svg-core";
import { faFacebookF, faGooglePlus, faVk, faTwitter } from '@fortawesome/free-brands-svg-icons';

const icons = [
    faUser,
    faFacebookF,
    faGooglePlus,
    faVk,
    faTwitter,
];

library.add(...icons);

Vue.component('font-awesome-icon', FontAwesomeIcon);
