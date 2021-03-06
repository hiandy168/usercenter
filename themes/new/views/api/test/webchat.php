<?php
/**
 * Created by PhpStorm.
 * User: xiaoxindezhihui
 * Date: 2017/3/24
 * Time: 16:45
 */?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no" />
    <title>朋友圈</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="stylesheet" href="<?php echo $this->_theme_url; ?>assets/subassembly/webchat/styles/main.css">

  </head>
  <body>
    <!--[if lt IE 10]>
      <p class="">浏览器版本过低请更新<a href="http://browsehappy.com/"></p>
    <![endif]-->

      <div id="loaddiv" class="loading-div">
    <span>
      <img src="<?php echo $this->_theme_url; ?>assets/subassembly/webchat/images/loading.gif"/>
      <i>努力加载中...</i>
    </span>
      </div>
<div class="div-main">

    <div class="overplay hidden"></div>
    <div id="webchat" v-on:click.stop="appClick">
    <div class="user-bg">
      <img v-bind:src="userinfo.bgurl" alt="" width="100%">
    </div>
    <div class="inset hidden">
      <span class="icon-input"></span>
      <input type="text" placeholder="评论">
      <button class="input-button" v-on:click.stop="inputClick($event)">确认</button>
    </div>
      <div class="replybox hidden">
        <span class="icon-input"></span>
        <input type="text" placeholder="回复 {{replyUser}}">
        <button class="input-button" v-on:click.stop="replyClick($event)">回复</button>
      </div>
    <div class="container">
        <div class="user-self">
          <div class="username left">
            <h1>{{userinfo.username}}</h1>
          </div>
          <div class="user-icon">
            <img v-bind:src="userinfo.url" alt="">
          </div>
        </div>
        <div class="user-item">
          <div class="border" v-for="item in AllFeeds" track-by="$index">
            <div class="user-pic">
              <img v-bind:src="item.url" alt="">
            </div>
            <div class="user-content">
              <h2 class="spacing">{{item.name}}</h2>
              <p class="spacing">{{item.content}}</p>
              <img class="spacing-bottom" v-bind:src="item.picUrl" alt="">
              <span class="spacing time">{{item.time}}</span>
              <div class="commit" v-show="item.showComt">
                <a v-on:click.stop="likeClick($event,item)" class="btn btn-left" href="javascript:;">
                  <span class="icon-heart-empty"></span>{{item.like}}
                </a>
                <a v-on:click.stop="comtClick($event,item)" href="javascript:;" class="btn btn-comment">
                  <span class="icon-comment-alt"></span>评论
                </a>
              </div>
              <button class="btn-default" v-on:click.stop="showCommentClick($event,item)">
              </button>
            </div>
            <div class="repcomment">
              <div class="comments" v-show="item.userLike && item.userLike.length > 0 || item.comment && item.comment.length > 0">
                <div class="top">
                   <span class="triangle">
                   </span>
                  <div class="like" v-show="item.userLike && item.userLike.length > 0">
                    <p>
                      <span class="icon-heart-empty i-like"></span>
                      <span class="user" v-for="onelike in item.userLike" track-by="$index">{{onelike}}<span class="dh-black">,</span></span>
                    </p>
                  </div>
                  <div class="comment" v-show="item.comment && item.comment.length >0">
                      <div class="com-space" v-for="onecommet in item.comment" track-by="$index">
                        <div v-if="!(onecommet.reply)">
                          <a href="javascript:;" v-on:click.stop="replyComt($event,item,onecommet)" class="reply">
                            <span class="user">{{onecommet.name}}:</span>
                            {{onecommet.content}}
                          </a>
                        </div>
                        <div v-else>
                          <a href="javascript:;" v-on:click.stop="replyComt($event,item,onecommet)" class="reply">
                            <span class="user">{{userinfo.username}}</span>回复 <span class="user">{{replyUser}}:
                            <a href="javascript:;" class="reply">{{onecommet.content}}</a>
                          </span>
                          </a>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    </div>

    </div> 



    <script src="<?php echo $this->_theme_url; ?>assets/subassembly/webchat/scripts/jquery.min.js"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/subassembly/webchat/scripts/vue.js"></script>
     <script src="<?php echo $this->_theme_url; ?>assets/subassembly/webchat/scripts/main.js"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/subassembly/webchat/scripts/layout.js"></script>
  </body>
</html>
