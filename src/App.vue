<template>
  <div id="app">
    <UEditorPlus class="ueditor" v-model="content" />

    <h1>preivew</h1>
    <div v-html="content"></div>
  </div>
</template>

<script>
import UEditorPlus from './components/UEditorPlus.vue'

export default {
  name: 'App',
  components: {
    UEditorPlus
  },
  data() {
    return {
      content: '<p>Hi UEditorPlus</p>',
    }
  }
}
</script>

<style>
#app {
  /* font-family: Avenir, Helvetica, Arial, sans-serif; */
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  /* text-align: center; */
  /* color: #2c3e50; */
  margin: 0 auto;
  width: 1000px;
  margin-top: 60px;
}

body {
  margin: 0;
}
</style>
