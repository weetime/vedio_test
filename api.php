<?php 
    define('CLIENT_ID','af27d258c0792934'); # app_key
    define('CLIENT_SECRET', '1fe5f188934e537527adb6df31165314'); # app_secret
    define('REDIRECT_URI','http://vedio.xiaoma.tt/api.php'); # 回调地址
    define('AUTHIRUZE','https://api.tudou.com/oauth2/authorize'); # 请求授权
    define('GET_ACCESS_TOKEN_URI','https://api.tudou.com/oauth2/access_token'); # 获取access_token
    define('UPLOAD_URI','http://api.tudou.com/v6/video/upload_url');
    if(!empty($_GET['code'])){
        $code = $_GET['code'];
        // 获取access_token
        $accessParams = array(
            'code' => $code,
            'client_id' => CLIENT_ID,
            'client_secret' => CLIENT_SECRET
        );
        // print_r($accessParams);exit();
        $access = send_post(GET_ACCESS_TOKEN_URI,$accessParams);
        if(!empty($access['access_token'])){
            // 上传视频
            $uploadParams = array(
               'app_key'  => CLIENT_ID,
               'access_token' => $access['access_token'],
               'format' => 'json',
               'title' => '标题',
               'tags' => '标签',
               'content' => '描述',
               'channelId' => 99
            );
            $upload = send_post(UPLOAD_URI,$uploadParams);
            myLog('This is access return,'.var_export($access,true));
            myLog('This is upload return,'.var_export($upload,true));
        }else{
            header('Location:/api.php');
        }
    } 

    /** 
     * 发送post请求 
     * @param string $url 请求地址 
     * @param array $post_data post键值对数据 
     * @return string 
     */  
    function send_post($url, $post_data) {  
      $postdata = http_build_query($post_data);  
      $options = array(  
        'http' => array(  
          'method' => 'POST',  
          'header' => 'Content-type:application/x-www-form-urlencoded',  
          'content' => $postdata,  
          'timeout' => 15 * 60 // 超时时间（单位:s）  
        )  
      );  
      $context = stream_context_create($options);  
      $result = file_get_contents($url, false, $context); 
      return json_decode($result,true);  
    }  

    // curl 模拟post请求
    function curl_post($uri='',$params=array()){
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $uri );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $params );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不验证证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //不验证证书
        $output = curl_exec ( $ch );
        curl_close ( $ch );
        print_r($output);exit();
        return json_decode($output,true);
    }

    function myLog($data){
        file_put_contents('api.log',date('Y-m-d H:i:s').PHP_EOL.$data.PHP_EOL,FILE_APPEND);
    }

?>
<!DOCTYPE html5>
<html>
<head>
    <meta charset="utf-8"/>
    <title>土豆上传视频api</title>
    <link rel="stylesheet" type="text/css" href="/public/bootstrap/dist/css/bootstrap.min.css"/>
    <script type="text/javascript" src="/public/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="/public/bootstrap/dist/js/bootstrap.min.js"></script>    
    <script type="text/javascript" src="/public/jquery.form.js"></script>
    <script type="text/javascript" src="/public/layer/layer.js"></script> 
</head>
<body>
    <div class="container">
        <p>&nbsp;</p>
        <?php if(empty($code)):?>
        <a class="btn btn-primary btn-sm" href="<?php echo AUTHIRUZE;?>?client_id=<?php echo CLIENT_ID;?>&redirect_uri=<?php echo REDIRECT_URI;?>">上传视频</a>
        <?php endif;?>

        <?php if(!empty($upload['uploadUrl'])):?>
            <form id="uploadForm" action="<?php echo $upload['uploadUrl'];?>" enctype="multipart/form-data" method="post">
                <input type="file" name="file" id="upFile">
                <input type="submit" value="上传视频" />
            </form>
        <?php endif;?>
    </div>
    <iframe src="http://www.tudou.com/programs/view/html5embed.action?code=JuT_051g8j8&autoPlay=false&playType=AUTO" width="300px" height="300px" frameborder="0" scrolling="no"></iframe>


    <script type="text/javascript">
    +(function($){
        var layerIndex;
        $('#uploadForm').ajaxForm({
            dataType: 'json',
            beforeSubmit:function(){
                layerIndex = layer.load(1, { shade: [0.1,'#fff'] });            
            },
            success: processJson
        });
        function processJson(data){
            layer.close(layerIndex);
            $("#uploadForm").hide();
            var code = "<?php echo empty($upload['itemCode'])?'':$upload['itemCode'];?>";
            if(data.result == 'ok' && code!=''){
                // var url = 'http://www.tudou.com/programs/view/html5embed.action?code='+code+'&autoPlay=false&playType=AUTO';
                //  $('iframe').attr('src',url);
                 layer.alert('上传成功，视频编号code='+code);    
            }
        }
    })(jQuery);
    </script>
</body>
</html>