# Luff
这是一个简单的博客程序。
基于 `Laravel 5.4.*`

## 项目概述
* 产品名称：「Luff - A simple blog」
* 项目代码：https://github.com/luffluo/luff
* 官方地址：https://github.com/luffluo/luff

## 基本特性
* 单用户
* 标签
* 文章 - 文章只有标签，无分类概念
* 支持 Markdown

## 运行环境要求
* Nginx 1.8+
* PHP 7.0+
* Mysql 5.7+
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension

## 安装
1. Clone the source code or create new project.

`git clone https://github.com/luffluo/luff.git`
Or
`composer create luffluo/luff`

2. Install the extended package dependency.

`php composer install`

3. Run the blog install command, or

在浏览器输入预设好的域名 `luff.blog`
Or
`php artisan luff:install`
通过命令行安装，可以选择是否填充假数据

## How can you help?
欢迎 `star`，欢迎反馈