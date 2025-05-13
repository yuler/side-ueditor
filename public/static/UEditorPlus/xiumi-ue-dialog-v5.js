window.UE.registerUI('xiumi-connect', (editor, uiName) => {
    console.log('registerUI', editor, uiName)
    console.log(window.innerWidth, window.innerHeight)
    const dialog = new window.UE.ui.Dialog({
        // 注意：这是 xiumi-ue-dialog-v5.html 文件的访问链接，这个页面会通过 iframe 的方式嵌入到弹窗里
        iframeUrl: '/static/UEditorPlus/xiumi-ue-dialog-v5.html',
        editor,
        name: uiName,
        title: '秀米图文消息助手',
        cssRules: 'width: ' + (window.innerWidth - 60) + 'px; height: ' + (window.innerHeight - 60) + 'px;',
    });

    const btn = new window.UE.ui.Button({
        name: 'xiumi-connect',
        title: '秀米',
        cssRules: ``,
        onclick() {
            dialog.render();
            dialog.open();
        },
    });

    return btn;
});
