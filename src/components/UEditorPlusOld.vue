<template>
  <vue-ueditor-wrap
    v-model="content" :config="editorConfig" editor-id="editor"
    :editorDependencies="['ueditor.config.js', 'ueditor.all.js']"
    @ready="onReady"
  />
</template>

<script>
import VueUeditorWrap from 'vue-ueditor-wrap'

export default {
  components: {
    VueUeditorWrap,
  },
  props: {
    height: {
      type: Number,
      default: 300,
    },
    value: {
      type: String,
      default: '<p>Hello UEditorPlus</p>',
    },
  },
  data() {
    return {
      content: this.value,
      editorConfig: {
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
        // 底部左下腳元素提示
        elementPathEnabled: false,

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
            const res = await fetch('https://www.qiqucn.com/oss/get_sts?reset=1')
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
      },
    }
  },
  created() {
    // Note: this sdk url is change `isFile` function for hack
    // Because the webuploader wrap a WUFile object is not a File object
    let script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = '/libs/aliyun-oss-sdk-6.16.0.min.js';
    document.body.appendChild(script)
  },
  methods: {
    onReady(editor) {
      console.log('editor', editor)
      window.editor = editor
      // editor.setHeight(200)
      // editor.
    },
  },
}
</script>
