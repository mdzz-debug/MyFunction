# MyFunction(MF)

### 简介
PHP常用函数封装

### 技术支持
1. Qrcode


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
    + compressImage 压缩图片
      ```php
      // $img 图片路径，必填
      // $max_width 最大宽度，可选，默认为原图宽度
      // $max_height 最大高度，可选，默认为原图高度
      // $quality 图片质量，可选，默认为75
      File::compressImage($img, $max_width, $max_height, $quality);
      ```
2. 请求处理类
   + curlRequest curl请求
      ```php
      // $url 请求地址，必填
      // $method 请求方式，可选，默认为GET
      // $data 请求数据，可选，默认为空数组
      // $headers 请求头，可选，默认为空数组
      File::curlRequest($url, $method = 'GET', $data = [], $headers = []);
      ```
3. QRCode类
   + createQRCode 生成二维码
      ```php
      // $text 二维码内容，必填
      // $path 二维码保存路径和名称，可选，默认为二进制输出
      // $level 二维码容错级别，可选，默认为 3
      // $size 二维码大小，可选，默认为10
      // $margin 二维码外边距，可选，默认为1
      QRCode::createQRCode($text, $path, $level, $size, $margin);
      ```