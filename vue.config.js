const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  transpileDependencies: true,
  devServer: {
    proxy: {
      '/php-server': {
        target: 'http://localhost:3000', // 目标服务器地址
        changeOrigin: true, // 是否跨域
        pathRewrite: {
          '^/php-server': '' // 重写路径
        }
      },
      '/ueditor': {
        target: 'http://localhost:3000', // 目标服务器地址
        changeOrigin: true, // 是否跨域
      },
      '/xiumi-ue-dialog-v5': {
        target: 'http://localhost:3000', // 目标服务器地址
        changeOrigin: true, // 是否跨域
      }
    }
  }
})
