
        <div class='bgf clearfix'>
          
            <div class="center_top clearfix">
                <ul>
                    <li><span class="btn btn-primary">大楚通行证管理</span></li>
<!--                    <li><a class="btn btn-primary" href="<?php /*echo $this->createUrl('member/add') */?>"><?php /*echo Mod::t('admin', 'add') */?></a></li>

           <li> <a class="btn btn-primary" href="<?php echo $this->createUrl('member/pclists/status/1') ?>">已审核</a></li>
                    <li><a class="btn btn-primary" href="<?php echo $this->createUrl('member/pclists/status/2') ?>">未审核</a></li>
                --></ul>
               <!-- <div class="center_search">
                    <form name="search_frm" action="<?php /*echo $this->createUrl("member/pclists") */?>" id="SearchFrm" method="post">
                        <input type="text" name="phone"  placeholder="输入手机号码"  value="<?php /*echo $phone?$phone:'' */?>" />
                        <input type="submit" name="search" class="btn btn-success"  value="搜索" />
                    </form>

                </div>-->
            </div>


            <div class="clearfix"></div>
            <div class="list">
                <form name="list_frm" id="ListFrm" action="" method="post">
                    <table width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>名称</th>
                                <th>appid</th>
                                <th>secret</th>
                                <th>回调地址</th>
                                <th>创建时间</th>
                                <th>描述</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>	
                            <?php foreach ($datalist as $k => $item) { ?>
                                <tr id="list_<?php echo $item['id'] ?>">
                                    <td><?php echo $item->id ?></td>
                                    <td><?php echo $item->name ?></td>
                                    <td><?php echo $item->agentid ?></td>
                                    <td><?php echo $item->secret ?></td>
                                    <td><?php echo $item->url ?></td>
                                    <td><?php echo date('Y-m-d H:i:s', $item->createtime) ?></td>
                                    <td><?php echo $item->description ?></td>

                                    <td>
                                        <a  class='a_edit' href="<?php echo $this->createUrl("member/ssoadd/",array('id'=>$item['id']) ) ?>"><?php echo Mod::t('admin', 'edit') ?></a>
                                       <!-- //pc 端注册的用户才能被删除-->
                                        <a   class='a_del'  onclick="del('<?php echo $this->createUrl("member/ssodel") ?>', '<?php echo $item->id ?>')" href="javascript:;"><?php echo Mod::t('admin', 'del') ?></a>
                                    </td>
                                </tr>	
                            <?php } ?>
                        </tbody>
                    </table>


                    <div class="pages clearfix"> 
                        <?php
                        $this->widget('JumpLinkPager', array('pages' => $pagebar,
                                                        'cssFile' => false,
                                                        'header'=>'',
                                                        'firstPageLabel' => '首页', //定义首页按钮的显示文字
                                                        'lastPageLabel' => '尾页', //定义末页按钮的显示文字
                                                        'nextPageLabel' => '下一页', //定义下一页按钮的显示文字
                                                        'prevPageLabel' => '前一页',
                                                            )
                        );
                        ?></div>
                </form>
            </div>

        </div>   

