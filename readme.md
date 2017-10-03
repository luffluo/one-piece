# Luff - A simple blog
一个简单的博客程序。基于 `Laravel 5.5.*` 开发。

## 预览
![luff-front](http://wx4.sinaimg.cn/large/006fVPCvly1fjri6ju7yuj31400p0q56.jpg)

![luff-admin](http://wx2.sinaimg.cn/large/006fVPCvly1fjri75enimj31400p0dhx.jpg)

## 基本特性
* 用户
* 标签
* 文章 - 只有标签，无分类概念
* 自定义站点导航
* 支持 Markdown
* 支持简单的外观设置

## 运行环境要求
* PHP 7.0+
* Mysql 5.7+
* OpenSSL PHP Extension
* PDO_MYSQL PHP Extension
* Mbstring PHP Extension

## 安装
1. 获取程序
```
composer create luffluo/luff-blog
```
Or
```
git clone https://git.coding.net/luffluo/luff-blog.git
```
2. 安装程序依赖扩展包
```
php composer install
```
3. 命令行安装 or 浏览器安装
```
在浏览器输入预设好的域名，如 `luff.blog`
```
Or
```
php artisan luff:install 通过命令行安装，可以选择是否填充假数据
```

## Todo
* 文章评论

## How can you help?
欢迎 `star`，欢迎反馈
