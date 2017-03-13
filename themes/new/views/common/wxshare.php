<?php if (Tool::is_weixin()) {
    $this->_siteUrl = Mod::app()->request->hostInfo.Mod::app()->request->baseUrl;


    echo '<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>';

    if (!isset($info['share_switch']) || $info['share_switch'] == 1) {
        if (isset($info['share_url'])) {
            $url = $info['share_url'];
        } else {
            $url2 = $url = $this->createAbsoluteUrl('/activity/scratchcard/view', array('id' => $info['id']));
        }
        ?>


        <script>
            wx.config({
                debug: false,
                appId: '<?php echo $signPackage["appId"];?>',
                timestamp: <?php echo $signPackage["timestamp"];?>,
                nonceStr: '<?php echo $signPackage["nonceStr"];?>',
                signature: '<?php echo $signPackage["signature"];?>',
                jsApiList: [
                    // 所有要调用的 API 都要加到这个列表中
                    'checkJsApi',
                    'onMenuShareTimeline',
                    'onMenuShareAppMessage',
                    'onMenuShareQQ',
                    'onMenuShareQZone',
                    'onMenuShareWeibo'
                ]
            });
            wx.ready(function () {

                // 在这里调用 API
                var  thisurl="<?php echo $url;?>";
                var  thisurl2="<?php echo $url2;?>";

                if(thisurl.indexOf('http')==0 ){
                   var links = '<?php echo $url; ?>';
                }else{
                   var links = '<?php echo $url2; ?>';
                }

                wx.onMenuShareTimeline({
                    title: '<?php echo $info["title"];?>', // 分享标题
                    link:links,// 分享链接
                    imgUrl: '<?php echo $this->_siteUrl.JkCms::show_img(isset($info["share_img"])?$info["share_img"]:$info["img"]);?>', // 分享图标
                    desc: '<?php echo  isset($info["share_desc"])?$info["share_desc"]:$info["remark"];?>', // 分享描述
                  success: function () {
                        // 用户确认分享后执行的回调函数
                        alert("分享成功!");
                    },
                    cancel: function () {
                        // 用户取消分享后执行的回调函数
                    }
                });

                wx.onMenuShareAppMessage({
                    title: '<?php echo $info["title"];?>', // 分享标题
                    link:links,// 分享链接
                    imgUrl: '<?php echo $this->_siteUrl.JkCms::show_img(isset($info["share_img"])?$info["share_img"]:$info["img"]);?>', // 分享图标
                    desc: '<?php echo  isset($info["share_desc"])?$info["share_desc"]:$info["remark"];?>', // 分享描述                    success: function () {
                    type: '', // 分享类型,music、video或link，不填默认为link
                    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                    success: function () {
                        // 用户确认分享后执行的回调函数
                        alert("分享成功!");
                    },
                    cancel: function () {
                        // 用户取消分享后执行的回调函数
                    }

                });

                wx.onMenuShareQQ({
                    title: '<?php echo $info["title"];?>', // 分享标题
                    link:links,// 分享链接
                    imgUrl: '<?php echo $this->_siteUrl.JkCms::show_img(isset($info["share_img"])?$info["share_img"]:$info["img"]);?>', // 分享图标
                    desc: '<?php echo  isset($info["share_desc"])?$info["share_desc"]:$info["remark"];?>', // 分享描述                    success: function () {
                    success: function () {
                        // 用户确认分享后执行的回调函数
                        alert("分享成功!");
                    },
                    cancel: function () {
                        // 用户取消分享后执行的回调函数
                    }
                });

                wx.onMenuShareQZone({
                    title: '<?php echo $info["title"];?>', // 分享标题
                    link:links,// 分享链接
                    imgUrl: '<?php echo $this->_siteUrl.JkCms::show_img(isset($info["share_img"])?$info["share_img"]:$info["img"]);?>', // 分享图标
                    desc: '<?php echo  isset($info["share_desc"])?$info["share_desc"]:$info["remark"];?>', // 分享描述                    success: function () {
                  success: function () {
                        // 用户确认分享后执行的回调函数
                        alert("分享成功!");
                    },
                    cancel: function () {
                        // 用户取消分享后执行的回调函数
                    }
                });

                wx.onMenuShareWeibo({
                    title: '<?php echo $info["title"];?>', // 分享标题
                    link:links,// 分享链接
                    imgUrl: '<?php echo $this->_siteUrl.JkCms::show_img(isset($info["share_img"])?$info["share_img"]:$info["img"]);?>', // 分享图标
                    desc: '<?php echo  isset($info["share_desc"])?$info["share_desc"]:$info["remark"];?>', // 分享描述                    success: function () {
                    success: function () {
                        // 用户确认分享后执行的回调函数
                    },
                    cancel: function () {
                        // 用户取消分享后执行的回调函数
                    }
                });
            });

        </script>

    <?php } else {
        ?>
        <script>
            wx.config({
                debug: false,
                appId: '<?php echo $signPackage["appId"];?>',
                timestamp: <?php echo $signPackage["timestamp"];?>,
                nonceStr: '<?php echo $signPackage["nonceStr"];?>',
                signature: '<?php echo $signPackage["signature"];?>',
            });

            wx.ready(function () {
                wx.hideOptionMenu();

            })

        </script>
    <?php } ?>
<?php } ?>

