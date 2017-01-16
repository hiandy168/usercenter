<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

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
        console.log(location.host);
        // 在这里调用 API
        wx.onMenuShareTimeline({
            title: '<?php echo $info["title"];?>', // 分享标题
            link: 'http://'+location.host+'<?php echo $url; ?>', // 分享链接
            imgUrl: 'http://'+location.host+'<?php echo JkCms::show_img(isset($info["share_img"])?$info["share_img"]:$info["img"]);?>', // 分享图标
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
            desc: '<?php echo  isset($info["share_desc"])?$info["share_desc"]:$info["remark"];?>', // 分享描述
            link: 'http://'+location.host+'<?php echo $url; ?>', // 分享链接
            imgUrl: 'http://'+location.host+'<?php echo JkCms::show_img(isset($info["share_img"])?$info["share_img"]:$info["img"]);?>', // 分享图标
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
            desc: '<?php echo  isset($info["share_desc"])?$info["share_desc"]:$info["remark"];?>', // 分享描述
            link: 'http://'+location.host+'<?php echo $url; ?>', // 分享链接
            imgUrl: 'http://'+location.host+'<?php echo JkCms::show_img(isset($info["share_img"])?$info["share_img"]:$info["img"]);?>', // 分享图标
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
            desc: '<?php echo  isset($info["share_desc"])?$info["share_desc"]:$info["remark"];?>', // 分享描述
            link: 'http://'+location.host+'<?php echo $url; ?>', // 分享链接
            imgUrl: 'http://'+location.host+'<?php echo JkCms::show_img(isset($info["share_img"])?$info["share_img"]:$info["img"]);?>', // 分享图标
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
            desc: '<?php echo isset($info["share_desc"])?$info["share_desc"]:$info["remark"];?>', // 分享描述
            link: 'http://'+location.host+'<?php echo $url; ?>', // 分享链接
            imgUrl: 'http://'+location.host+'<?php echo JkCms::show_img(isset($info["share_img"])?$info["share_img"]:$info["img"]);?>', // 分享图标
            success: function () {
                // 用户确认分享后执行的回调函数
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });
    });

</script>