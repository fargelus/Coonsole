<template>
  <div>
    <h1>Hello Console!</h1>
    <TodoList/>
  </div>
</template>

<script>
  import TodoList from './view.vue';

  export default {
    components: {
      TodoList
    }
  }
</script>