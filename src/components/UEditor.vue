<template>
  <div>
    <script id="editor" type="text/plain" style="width:100%;"></script>
  </div>
</template>

<script lang="js">
export default {
  name: 'UEditor',
  async mounted() {
    // Load UEditor script
    const loadScript = (src) => {
      return new Promise((resolve, reject) => {
        const script = document.createElement('script')
        script.src = src
        script.onload = resolve
        script.onerror = reject
        document.body.appendChild(script)
      })
    }

    try {
      // await loadScript('/libs/ueditor/ueditor.config.js')
      // await loadScript('/libs/ueditor/ueditor.all.min.js')
      // await loadScript('/libs/ueditor/lang/zh-cn/zh-cn.js')

      await loadScript('http://localhost:8080/php-server/ueditor.config.js')
      await loadScript('http://localhost:8080/php-server/ueditor.all.min.js')
      await loadScript('http://localhost:8080/php-server/lang/zh-cn/zh-cn.js')
      
      this.initializeEditor()
    } catch (error) {
      console.error('Failed to load UEditor scripts:', error)
    }
  },

  methods: {
    // refs: https://fex-team.github.io/ueditor/#start-config
    initializeEditor() {
      const serverUrl = 'http://localhost:8080/php-server/php/controller.php'
      const editor = window.UE.getEditor('editor', {
        autoHeightEnabled: false,
        autoFloatEnabled: true,
        serverUrl,
      })
      editor.ready(() => {
        console.log('Editor is ready')
      })
      editor.addListener('contentChange', () => {
        console.log('Content changed:', editor.getContent())
      })
      window.editor = editor
    }
  }
}
</script>
