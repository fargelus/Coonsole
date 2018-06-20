<template>
  <div>
    <ul v-if="todos.length">
      <TodoListItem
              v-for="todo in todos"
              :key="todo.id"
              :todo="todo"
              @remove="removeTodo"
      />
    </ul>
    <p v-else>
      Nothing left in the list. Add a new todo in the input above.
    </p>
  </div>
</template>

<script>
  //import BaseInputText from './BaseInputText.vue'
  import TodoListItem from './item.vue';
  import axios from 'axios';

  let nextTodoId = 1;

  export default {
    components: {
      TodoListItem
    },
    data () {
      return {
        newTodoText: '',
        todos: [
          {
            id: nextTodoId++,
            name: 'Learn Vue'
          },
          {
            id: nextTodoId++,
            name: 'Learn about single-file components'
          },
          {
            id: nextTodoId++,
            name: 'Fall in love'
          }
        ]
      }
    },
    created () {
      axios.get('/items/page/1')
        .then(response => {
          console.log(response.data.news);
          this.todos = response.data.news;
        })
        .catch(e => {
          this.errors.push(e);
        })
    },
    methods: {
      /*addTodo () {
        const trimmedText = this.newTodoText.trim();
        if (trimmedText) {
          this.todos.push({
            id: nextTodoId++,
            text: trimmedText
          });
          this.newTodoText = ''
        }
      },*/
      removeTodo (idToRemove) {
        this.todos = this.todos.filter(todo => {
          return todo.id !== idToRemove
        })
      }
    }
  }
</script>