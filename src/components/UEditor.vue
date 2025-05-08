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

    const loadLink = (href) => {
      return new Promise((resolve, reject) => {
        const link = document.createElement('link')
        link.rel = 'stylesheet'
        link.href = href
        link.onload = resolve
        link.onerror = reject
        document.head.appendChild(link)
      })
    }


    try {
      // await loadScript('/libs/ueditor/ueditor.config.js')
      // await loadScript('/libs/ueditor/ueditor.all.min.js')
      // await loadScript('/libs/ueditor/lang/zh-cn/zh-cn.js')

      await loadScript('http://localhost:8080/php-server/ueditor.config.js')
      await loadScript('http://localhost:8080/php-server/ueditor.all.min.js')

      await Promise.all([
        loadScript('http://localhost:8080/php-server/lang/zh-cn/zh-cn.js'),
        loadScript('http://localhost:8080/php-server/xiumi-ue-dialog-v5.js'),
        loadLink('http://localhost:8080/php-server/xiumi-ue-v5.css')
      ])

      this.initializeEditor()
    } catch (error) {
      console.error('Failed to load UEditor resources:', error)
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

      // Interupter file upload
      // eslint-disable-next-line no-unused-vars
      // editor.addListener('beforeInsertImage', (editor, imgUrls, url, opt) => {
      //   console.log('即将插入图片：', imgUrls);
      // })
      // editor.addListener('beforeUpload', (editor, files, type) => {
      //   console.log('即将上传的文件类型：', type, '文件列表：', files);
      // })
      // editor.addListener('beforePaste', (editor, pasteData) => {
      //   console.log('即将粘贴的内容：', pasteData);
      // })
    }
  }
}
</script>
