<template>
  <div>
    <script id="editor" type="text/plain" style="width:1024px;height:500px;"></script>
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
      await loadScript('/libs/ueditor/ueditor.config.js')
      await loadScript('/libs/ueditor/ueditor.all.min.js')
      await loadScript('/libs/ueditor/lang/zh-cn/zh-cn.js')
      this.initializeEditor()
    } catch (error) {
      console.error('Failed to load UEditor scripts:', error)
    }
  },

  methods: {
    initializeEditor() {
      const editor = window.UE.getEditor('editor', {
        initialFrameWidth: 800,
        initialFrameHeight: 400,
        autoHeightEnabled: false,
        autoFloatEnabled: true
      })
      editor.ready(() => {
        console.log('Editor is ready')
      })
      editor.addListener('contentChange', () => {
        console.log('Content changed:', editor.getContent())
      })
    }
  }
}
</script>
