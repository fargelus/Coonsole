<template>
  <div>
    {{this.name}}
    <router-link tag="li" to="/bar/"></router-link>
    dsdsda
  </div>
</template>

<script>
  export default {
      data() {
          return {
              name: 'Market'
          };
      },
  }
</script>
