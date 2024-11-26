<template>
  <div>
    <input class="form_field" v-model="newTask" @keyup.enter="addTask" placeholder="Add a new task"/>
    <ul>
      <li class="taskList" v-for="task in tasks" :key="task.id">
        <span :class="{ completed: task.completed }" @click="toggleTask(task)">
          {{ task.title }}
        </span>
        <button class="deleteButton" @click="deleteTask(task.id)">
          <span></span>
          <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="none" viewBox="0 0 24 24"
               stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
          </svg>
        </button>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      tasks: [],
      newTask: '',
    }
  },
  methods: {
    async fetchTasks() {
      try {
        const response = await axios.get('http://localhost:8888/')
        this.tasks = response.data
      } catch (error) {
        console.error('Error fetching tasks:', error)
      }
    },
    async addTask() {
      if (this.newTask.trim()) {
        try {
          const response = await axios.post('http://localhost:8888/', {
            title: this.newTask,
          })
          this.tasks.push(response.data)
          this.newTask = ''
        } catch (error) {
          console.error('Error adding task:', error)
        }
      }
    },
    async deleteTask(id) {
      try {
        await axios.delete(`http://localhost:8888/${id}`)
        this.tasks = this.tasks.filter((task) => task.id !== id)
      } catch (error) {
        console.error('Error deleting task:', error)
      }
    },
    async toggleTask(task) {
      try {
        const response = await axios.put(`http://localhost:8888/${task.id}`, {
          completed: !task.completed,
        })
        if (response.data.completed !== undefined) {
          task.completed = response.data.completed
        }
      } catch (error) {
        console.error('Error toggling task:', error)
      }
    },
  },
  mounted() {
    this.fetchTasks()
  },
}
</script>

<style>
.completed {
  text-decoration: line-through;
}
</style>
