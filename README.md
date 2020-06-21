HulaCWMS V2.0
===============

>系统安装步骤
>hula_data.sql为数据库文件，请手动新建数据库并导入该文件。
>/config/database.php 为数据库链接配置文件，可以在此填写您的数据库链接配置信息。
      
呼啦企业网站管理系统专注于企业、政府单位网站建设，以免费开源的方式，帮助广大站长、个人或企业开发者大大降低了开发成本和维护成本。快速锁定意向客户，培养长线营收。目前呼啦企业网站管理系统的资源下载站已制作了上百套不同行业的网站模板，欢迎下载试用。

因为专注所以专业，呼啦企业网站管理系统后台界面清爽美观，自适应的布局符合新时代的审美观和用户体验。本着系统就是给客户使用的设计原则，后台菜单做减法，通俗易懂。让您不再为了培训客户如何使用后台而烦恼！

 + 文章管理
 + 分类管理
 + 友情链接
 + 留言管理
 + 权限管理
 + 行为日志
 + 配置管理
 + 数据库管理
 + SEO友好
 + 多模板机制
 + 开发者模式
 + 动态模板


> HulaCWMS的运行环境要求PHP5.6以上。

## 官方网站
[灼灼文化](http://www.zhuopro.com)

## 演示地址
+ [前台地址](http://hula.demo.zhuopro.com/) 
+ [后台地址](http://hula.demo.zhuopro.com/admin.php)

## 免费网站模板
[呼啦资源网](http://www.hulaxz.com)

## 目录结构

初始的目录结构如下：

~~~
www  WEB部署目录（或者子目录）
├─application           应用目录
├─config                应用配置目录
│  ├─app.php            应用配置
│  ├─cache.php          缓存配置
│  ├─cookie.php         Cookie配置
│  ├─database.php       数据库配置
│  ├─log.php            日志配置
│  ├─session.php        Session配置
│  ├─template.php       模板引擎配置
│  └─trace.php          Trace配置
│
├─route                 路由定义目录
│  ├─route.php          路由定义
│  └─...                更多
├─thinkphp              框架系统目录
├─extend                扩展类库目录
├─runtime               应用的运行时目录
├─vendor                第三方类库目录（Composer依赖库）
├─template                模板目录
├─theme                主题风格目录（后台脚本、样式）
├─index.php          入口文件
├─admin.php          后台入口文件
└─.htaccess          用于apache的重写
~~~


> 上面的目录结构和名称是可以改变的，这取决于你的入口文件和配置参数。

## 版权信息

HulaCWMS遵循Apache2开源协议发布，并提供免费使用。

本项目包含的第三方源码和二进制文件之版权信息另行标注。

版权所有Copyright © 2019 by 灼灼文化 (http://www.zhuopro.com)

All rights reserved。
