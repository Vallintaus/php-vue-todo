<template>
  <div id="app">
    <h1>Todo List</h1>
    <TaskList />
  </div>
</template>

<script>
import TaskList from './components/TaskList.vue'

export default {
  components: {
    TaskList,
  },
}
</script>
