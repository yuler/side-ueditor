<template>
  <div class="width:100%;">
    <script id="editor" type="text/plain" style="height:100px;"></script>
  </div>
</template>

<script lang="js">
export default {
  name: 'UEditor',
  props: {
    value: {
      type: String,
      default: '',
    },
  },
  async mounted() {
    console.log(this.value)
    // Load UEditor script
    try {
      // load oss sdk
      loadScript('/libs/aliyun-oss-sdk-6.16.0.min.js')
        .then(() => {
          console.log('oss sdk loaded')
        })

      // Note: These scripts must be loaded in sequence
      await loadScript('/static/UEditorPlus/ueditor.config.js')
      await loadScript('/static/UEditorPlus/ueditor.all.js')

      await Promise.all([
        loadScript('/static/UEditorPlus/lang/zh-cn/zh-cn.js'),
        loadScript('/static/UEditorPlus/xiumi-ue-dialog-v5.js'),
        loadLink('/static/UEditorPlus/xiumi-ue-v5.css')
      ])

      this.initializeEditor()
    } catch (error) {
      console.error('Failed to load UEditor resources:', error)
    }
  },

  methods: {
    async initializeEditor() {
      const editor = window.UE.getEditor('editor', {
        initialContent: this.value,
        // refs: https://open-doc.modstart.com/ueditor-plus/manual.html
        UEDITOR_HOME_URL: '/static/UEditorPlus/',
        UEDITOR_CORS_URL: '/static/UEditorPlus/',
        serverUrl: '/php/handle.php',
        // loadConfigFromServer: false,
        toolbars: [
          [
            "bold",         // 加粗
            "italic",       // 斜体
            "underline",    // 下划线
            "fontborder",   // 字符边框
            "strikethrough",// 删除线
            "superscript",  // 上标
            "subscript",    // 下标
            "removeformat", // 清除格式
            "formatmatch",  // 格式刷
            "blockquote",   // 引用
            "|",
            "forecolor",    // 字体颜色
            "backcolor",    // 背景色
            "insertorderedlist",   // 有序列表
            "insertunorderedlist", // 无序列表
            "|",
            "rowspacingtop",// 段前距
            "rowspacingbottom",    // 段后距
            "lineheight",          // 行间距
            "paragraph",           // 段落格式
            "fontfamily",          // 字体
            "fontsize",            // 字号
            "justifyleft",         // 居左对齐
            "justifycenter",       // 居中对齐
            "justifyright",
            "justifyjustify",      // 两端对齐
            "|",
            "link",                // 超链接
            "unlink",              // 取消链接
            "simpleupload",        // 单图上传
            "insertimage",         // 多图上传
            "insertvideo",         // 视频
            "emotion",             // 表情
            "|",
            "horizontal",          // 分隔线
            "date",                // 日期
            "time",                // 时间
            "|",
            "inserttable",         // 插入表格
            "|",
            "xiumi-connect",       // 秀米
          ]
        ],
        // 快捷菜单
        shortcutMenu: [
          // "ai",           // AI智能
          // "fontfamily",   // 字体
          // "fontsize",     // 字号
          "bold",            // 加粗
          "italic",          // 斜体
          "underline",       // 下划线
          "strikethrough",   // 删除线
          "fontborder",      // 字符边框
          "forecolor",       // 字体颜色
          "backcolor",       // 背景色
        ],
        toolbarShow: {
          "ai": false,
        },
        imageConfig: {
          disableOnline: true,
        },
        videoConfig: {
          disableOnline: true,
        },
        catchRemoteImageEnable: true,
        // 底部左下腳元素提示
        elementPathEnabled: false,
        autoHeightEnabled: true,
        initialFrameHeight: 100,

        // 自动保存
        autoSaveEnable: true,
        autoSaveRestore: false,
        autoSaveKey: null,

        // 启用拖放上传
        enableDragUpload: true,
        enablePasteUpload: true,
        imageScaleEnabled: true,
        imagePopup: true,

        // 上传图片配置项
        uploadServiceEnable: true,
        uploadServiceUpload: async function(type, file, callback) {
          console.log({ file })
          console.log('uploadServiceUpload', type, file, callback)
          try {
            // TODO: 
            // const res = await fetch(`https://www.qiqucn.com/custom/oss/get_sts?reset=1&type=${type}`)
            const res = await fetch(`https://www.qiqucn.com/oss/get_sts?reset=1&type=${type}`)
            const data = await res.json()
            const ossConf = data.result
            const client = new window.OSS({
              region: ossConf.RegionId,
              accessKeyId: ossConf.AccessKeyId,
              accessKeySecret: ossConf.AccessKeySecret,
              stsToken: ossConf.SecurityToken,
              refreshSTSTokenInterval: ossConf.DurationSeconds,
              bucket: ossConf.BucketName,
            })
            const rawFile = file?.blob?.source || file;

            const result = await client.multipartUpload(rawFile.name, rawFile, {
              progress: (p) => {
                console.log('process =>', p)
                callback.progress(p)
              },
            })

            console.log({result})

            const url = (result?.res?.requestUrls[0] || '').split('?')[0]

            if (!url) {
              console.warn({result})
              callback.error(`http|500|上传失败`)
              return
            }

            callback.success({
              state: 'SUCCESS',
              url,
            })
          } catch (error) {
            console.error(error)
            callback.error(`http|500|${error}`)
          }
        },
      })
      editor.ready(() => {
        console.log('Editor is ready')
      })
      editor.addListener('contentChange', () => {
        console.log('Content changed:', editor.getContent())
        this.$emit('input', editor.getContent())
      })
      window.editor = editor
    }
  }
}

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
</script>

<style>
.edui-toolbar {
  text-align: left!important;
}
</style>