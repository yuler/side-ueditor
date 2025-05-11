# side-ueditor

This repo is explore ueditor integration with Vue 2.x project.

## Quick Start

```bash
pnpm install
pnpm run php:server # Start PHP server first
pnpm run dev # Start Vue project
```

## TODO List

- [x] DEMO 目前支持图片视频上传
- [x] DEMO 目前支持表情选择
- [x] 集成 秀米 按钮
- [x] 支持 OSS 直传
- [ ] 支持 word 文档复制，图片的时候动态上传
- [ ] 秀米点击到处，直接写入到 ueditor 的内容

- 这个部署的时候需要 PHP Server 配合，目前 DEMO 是通过启动 PHP Server 来实现的。
- 目前前端项目是通过 dev server 做的 proxy, 由于 ueditor, 用大量使用了 iframe 和 jsonp, 需要部署到同源减少不必要的错误。线上环境需要使用 nginx 反向代理，或者其他相关的服务。

## Links

- [秀米编辑器](https://ent.xiumi.us/ueditor/index.html)
- [ueditor docs](https://fex-team.github.io/ueditor)
- [ueditor-plus](https://github.com/modstart-lib/ueditor-plus)

## PHP Server

```bash
cd php-server
php -S localhost:3000
```

<!--
## server

node.js server for ueditor

refs: <https://github.com/netpi/ueditor>

```bash
cd server
pnpm install
pnpm run dev
```
-->
