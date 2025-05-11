<template>
  <div>
    <vue-ueditor-wrap
      v-model="content"
      editor-id="editor"
      :config="editorConfig"
      :editorDependencies="['ueditor.config.js', 'ueditor.all.js']"
      style="height: 500px"
    />
  </div>
</template>
<script>
import VueUeditorWrap from 'vue-ueditor-wrap'

export default {
  components: {
    VueUeditorWrap,
  },
  data() {
    return {
      content: '<p>Hello UEditorPlus</p>',
      editorConfig: {
        // 后端服务地址，后端处理参考
        // https://open-doc.modstart.com/ueditor-plus/backend.html
        serverUrl: '/handle.php',
        UEDITOR_HOME_URL: '/static/UEditorPlus/dist-min/',
        UEDITOR_CORS_URL: '/static/UEditorPlus/dist-min/',
      },
    }
  },
}
</script>
