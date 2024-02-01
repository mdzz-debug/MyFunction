# MyFunction(MF)

### 简介
PHP常用函数封装

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