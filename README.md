# MyFunction(MF)

### 简介
PHP常用函数封装

### 技术支持
1. Qrcode

### Composer安装
[packagist 访问](https://packagist.org/packages/mdzz/my-function)
```shell
composer require mdzz/my-function
```

### 使用文档
1. 文件处理类
    + saveFile 保存文件
      ```php
      // $file $_FILE，必填
      // $path 保存路径，必填
      // $filename 文件名命名规则，可选，默认为原文件名
      // $suffix 文件后缀，可选，默认为原文件后缀
      File::saveFile($file, $path, $filename, $suffix);
      ``` 
    + getFileSize 获取文件大小
      ```php
      // $file 必填, 可以是本地文件也可以是远程文件
      // $unit 单位，可选，默认为KB
      // $compare 比较值，可选，默认为false不比较
      // 比较模式，$compare填 eg: '<200'
      File::getFileSize($file, $unit, $compare);
      ``` 
2. 图片处理类
    + compressImage 压缩图片
      ```php
      // $img 图片路径，必填
      // $max_width 最大宽度，可选，默认为原图宽度
      // $max_height 最大高度，可选，默认为原图高度
      // $quality 图片质量，可选，默认为75
      Image::compressImage($img, $max_width, $max_height, $quality);
      ```
3. 请求处理类
   + curlRequest curl请求
      ```php
      // $url 请求地址，必填
      // $method 请求方式，可选，默认为GET
      // $data 请求数据，可选，默认为空数组
      // $headers 请求头，可选，默认为空数组
      File::curlRequest($url, $method = 'GET', $data = [], $headers = []);
      ```
4. QRCode类
   + createQRCode 生成二维码
      ```php
      // $text 二维码内容，必填
      // $path 二维码保存路径和名称，可选，默认为二进制输出到浏览器
      // $level 二维码容错级别，可选，默认为 3
      // $size 二维码大小，可选，默认为10
      // $margin 二维码外边距，可选，默认为1
      Qr::createQRCode($text, $path, $level, $size, $margin);
      ```
   + 自主选择输出方式
      ```php
      // $text 二维码内容，必填
      // $level 二维码容错级别，可选，默认为 3
      // $size 二维码大小，可选，默认为10
      // $margin 二维码外边距，可选，默认为1
     $qr = new Qr();
     $qr->createQr($text, $level, $size, $margin)
            ->logo($logo)  // 添加LOGO
            ->save($path); // 保存到目录
     $qr = new Qr();
     $qr->createQr($text, $level, $size, $margin)
            ->logo($logo)  // 添加LOGO
            ->base64();    // base64输出, 传参 false 不携带头部
      ```
5. Redis 服务类




### 后续计划丰富
1. 图片转换格式
2. 图片添加水印
3. 图片转换base64

    