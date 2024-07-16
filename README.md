# wp-replace-cdn-for-china

替换Google CDN文件、Gravatar头像链接，加快WordPress打开速度，为WordPress中国用户提供加速。

## 此插件/扩展可以将以下的 CDN 资源替换
- ajax.googleapis.com - 前端公共库，替换为 ajax.loli.net
- fonts.googleapis.com - 免费字体库，替换为 fonts.font.im (fonts.googleapis.cn)
- themes.googleusercontent.com - fonts 有时会使用到这个里面的资源，替换为themes.loli.net
- fonts.gstatic.com - 免费字体库，替换为 fonts.gstatic.cn
- secure.gravatar.com - gravatar 头像，替换为 gravatar.loli.net

## Installation
1. Upload `wp-replace-cdn-for-china` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

## 参考资料
1. https://github.com/soulteary/Replace-Google-Libs
2. https://soulteary.com/2014/06/15/replace-google-libs.html
3. https://github.com/Lomu/wp-acceleration-for-china
4. https://github.com/wp-plugins/wp-acceleration-for-china
5. https://github.com/justjavac/ReplaceGoogleCDN
