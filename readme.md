获取token
https://api.tudou.com/oauth2/authorize?client_id=af27d258c0792934&redirect_uri=http://vedio.xiaoma.tt/api.php

https://api.tudou.com/oauth2/access_token?code=40c2a1dcc0e3b6c4d99b62bae15654cb&client_id=af27d258c0792934&client_secret=1fe5f188934e537527adb6df31165314




http://api.tudou.com/v6/video/upload_url?app_key=af27d258c0792934&access_token=kwyoNy45gZTyNJ_4og54k_oZNeegZmTBpakBJyBN4wmJoBoZgp4NJJooo4op4_gmmpp5gNoJggBZN&format=json&title=标题&tags=标签&content=描述&channelId=99


获取access_token
curl -d "code=40c2a1dcc0e3b6c4d99b62bae15654cb&client_id=af27d258c0792934&client_secret=1fe5f188934e537527adb6df31165314" "https://api.tudou.com/oauth2/access_token"

{"access_token":"kwyoNy45gZTyNJ_4og54k_oZNeegZmTBpakBJyBN4wmJoBoZgp4NJJooo4op4_gmmpp5gNoJggBZN","expires_in":86400,"uid":857799989}

上传
curl -d "app_key=af27d258c0792934&access_token=kwyoNy45gZTyNJ_4og54k_oZNeegZmTBpakBJyBN4wmJoBoZgp4NJJooo4op4_gmmpp5gNoJggBZN&format=json&title=标题&tags=标签&content=描述&channelId=99" "http://api.tudou.com/v6/video/upload_url"

{"itemCode":"xM1PEGBYzg8","token":"182128792_251663402_202892731","uploadUrl":"http://bj1.b28.upload.tudou.com/?token=182128792_251663402_202892731&appKey=af27d258c0792934&sn=1459744545044"}


bslvLoXCRYY

xM1PEGBYzg8

JuT_051g8j8



