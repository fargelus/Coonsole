<script>
import Vue from 'vue';

function setFocus(el) {
    el.focus();
}

// Регистрируем глобальную пользовательскую директиву `v-focus`
export default Vue.directive('focus', {
    inserted: setFocus,

    // Когда привязанный элемент показывается в DOM...
    update: setFocus,
});
</script>
