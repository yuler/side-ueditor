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

function getBuffer(file) {
  // Some browsers do not support Blob.prototype.arrayBuffer, such as IE
  if (file.arrayBuffer) return file.arrayBuffer();
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.onload = function (e) {
      resolve(e.target.result);
    };
    reader.onerror = function (e) {
      reject(e);
    };
    reader.readAsArrayBuffer(file);
  });
}


export default {
  components: {
    VueUeditorWrap,
  },
  data() {
    return {
      content: '<p>Hello UEditorPlus</p>',
      editorConfig: {
        // refs: https://open-doc.modstart.com/ueditor-plus/manual.html
        UEDITOR_HOME_URL: '/static/UEditorPlus/',
        UEDITOR_CORS_URL: '/static/UEditorPlus/',
        serverUrl: '/php/handle.php',
        // loadConfigFromServer: false,
        toolbars: [
          [
            "fullscreen",   // 全屏
            "source",       // 源代码
            "|",
            // "undo",         // 撤销
            // "redo",         // 重做
            // "|",
            "bold",         // 加粗
            "italic",       // 斜体
            "underline",    // 下划线
            "fontborder",   // 字符边框
            "strikethrough",// 删除线
            "superscript",  // 上标
            "subscript",    // 下标
            "removeformat", // 清除格式
            "formatmatch",  // 格式刷
            "autotypeset",  // 自动排版
            "blockquote",   // 引用
            "pasteplain",   // 纯文本粘贴模式
            "|",
            "forecolor",    // 字体颜色
            "backcolor",    // 背景色
            "insertorderedlist",   // 有序列表
            "insertunorderedlist", // 无序列表
            "selectall",    // 全选
            "cleardoc",     // 清空文档
            "|",
            "rowspacingtop",// 段前距
            "rowspacingbottom",    // 段后距
            "lineheight",          // 行间距
            "|",
            // "customstyle",         // 自定义标题
            "paragraph",           // 段落格式
            "fontfamily",          // 字体
            "fontsize",            // 字号
            // "|",
            // "directionalityltr",   // 从左向右输入
            // "directionalityrtl",   // 从右向左输入
            // "indent",              // 首行缩进
            "|",
            "justifyleft",         // 居左对齐
            "justifycenter",       // 居中对齐
            "justifyright",
            "justifyjustify",      // 两端对齐
            "|",
            // "touppercase",         // 字母大写
            // "tolowercase",         // 字母小写
            // "|",
            // "link",                // 超链接
            // "unlink",              // 取消链接
            // "anchor",              // 锚点
            // "|",
            // "imagenone",           // 图片默认
            // "imageleft",           // 图片左浮动
            // "imageright",          // 图片右浮动
            // "imagecenter",         // 图片居中
            // "|",
            "simpleupload",        // 单图上传
            // "insertimage",         // 多图上传
            "emotion",             // 表情
            "scrawl",              // 涂鸦
            "insertvideo",         // 视频
            "attachment",          // 附件
            "insertframe",         // 插入Iframe
            "insertcode",          // 插入代码
            "pagebreak",           // 分页
            "template",            // 模板
            "background",          // 背景
            "formula",             // 公式
            "|",
            "horizontal",          // 分隔线
            "date",                // 日期
            "time",                // 时间
            "spechars",            // 特殊字符
            "wordimage",           // Word图片转存
            "|",
            "inserttable",         // 插入表格
            // "deletetable",         // 删除表格
            // "insertparagraphbeforetable",     // 表格前插入行
            // "insertrow",           // 前插入行
            // "deleterow",           // 删除行
            // "insertcol",           // 前插入列
            // "deletecol",           // 删除列
            // "mergecells",          // 合并多个单元格
            // "mergeright",          // 右合并单元格
            // "mergedown",           // 下合并单元格
            // "splittocells",        // 完全拆分单元格
            // "splittorows",         // 拆分成行
            // "splittocols",         // 拆分成列
            "contentimport",       // 内容导入（支持Word、Markdown）
            "|",
            // "ai",                  // AI智能
            // "|",
            "print",               // 打印
            "preview",             // 预览
            "searchreplace",       // 查询替换
            // "help",                // 帮助
          ]
        ],
        toolbarShow: {
          "ai": false,
        },
        shortcutMenuShow :{
          ai: false,
        },

        // 上传图片配置项
        imageActionName: 'image',
        imageFieldName: 'file',
        imageMaxSize: 1024 * 1024 * 10,
        imageAllowFiles: ['.jpg', '.png', '.jpeg', '.gif'],
        imageCompressEnable: true,
        imageCompressBorder: 5000,
        imageInsertAlign: 'none',
        imageUrlPrefix: '',

        // 涂鸦图片上传配置项
        scrawlActionName: 'crawl',
        scrawlFieldName: 'file',
        scrawlMaxSize: 1024 * 1024 * 10,
        scrawlUrlPrefix: '',
        scrawlInsertAlign: 'none',

        // 截图工具上传
        snapscreenActionName: 'snap',
        snapscreenUrlPrefix: '',
        snapscreenInsertAlign: 'none',

        // 抓取
        catcherLocalDomain: [
            '127.0.0.1',
            'localhost',
        ],
        catcherActionName: 'catch',
        catcherFieldName: 'source',
        catcherUrlPrefix: '',
        catcherMaxSize: 1024 * 1024 * 10,
        catcherAllowFiles: ['.jpg', '.png', '.jpeg'],

        // 上传视频配置
        videoActionName: 'video',
        videoFieldName: 'file',
        videoUrlPrefix: '',
        videoMaxSize: 1024 * 1024 * 100,
        videoAllowFiles: ['.mp4'],

        // 上传音频配置
        audioActionName: 'audio',
        audioFieldName: 'file',
        audioUrlPrefix: '',
        audioMaxSize: 1024 * 1024 * 100,
        audioAllowFiles: ['.mp3'],

        // 上传文件配置
        fileActionName: 'file',
        fileFieldName: 'file',
        fileUrlPrefix: '',
        fileMaxSize: 1024 * 1024 * 100,
        fileAllowFiles: ['.zip', '.pdf', '.doc'],

        // 列出图片
        imageManagerActionName: 'listImage',
        imageManagerListSize: 20,
        imageManagerUrlPrefix: '',
        imageManagerInsertAlign: 'none',
        imageManagerAllowFiles: ['.jpg', '.png', '.jpeg'],

        // 列出指定目录下的文件
        fileManagerActionName: 'listFile',
        fileManagerUrlPrefix: '',
        fileManagerListSize: 20,
        fileManagerAllowFiles: ['.zip', '.pdf', '.doc'],

        
        // imageConfig: {
        //   disableUpload: true,
        //   disableOnline: true,
          // 自定义选择按钮
          // selectCallback: null,
          // selectCallback: function(editor,cb){
          //     console.log('selectCallback',cb);
          //     setTimeout(function(){
          //       cb({
          //         path:'https://www.baidu.com/img/PCtm_d9c8750bed0b3c7d089fa7d55720d6cf.png',
          //         name:'测试图片'
          //       });
          //     },1000);
          // }
        // },
        // refs: https://open-doc.modstart.com/ueditor-plus/manual.html#uploadserviceupload
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
            // the file is WUFile object
            const rawFile = file?.blob || file;
            // console.log(typeof rawFile)
            // console.log({ rawFile })
            // console.log('instanceof File', rawFile instanceof window.File)
            // console.log('instanceof Blob', rawFile instanceof window.Blob)
            // console.log({client})

            const result = await client.multipartUpload(rawFile.name, rawFile, {
              progress: (p) => {
                console.log('process =>', p)
                callback.progress(p)
              },
            })

            console.log({result})

            const url = result?.res?.requestUrls[0] || ''

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
    let script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = '/libs/aliyun-oss-sdk-6.16.0.min.js';
            document.body.appendChild(script) 
  }
}
</script>
