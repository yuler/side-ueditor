<template>
  <div id="app">
    <UEditor class="ueditor" />
  </div>
</template>

<script>
import UEditor from './components/UEditor.vue'

export default {
  name: 'App',
  components: {
    UEditor
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin: 0 auto;
  width: 1000px;
  margin-top: 60px;
}

.ueditor {
  width: 1000px;
}
</style>
