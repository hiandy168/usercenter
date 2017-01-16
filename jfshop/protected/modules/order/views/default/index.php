<?php
$this->breadcrumbs=array(
    '订单管理',
    '订单列表'=>array('/order/default/index'),
);
?>
<!--<form action="?r=order/default/index"  method="GET">-->
    <div style="margin-bottom: 5px;">
        <label class="control-label no-padding-right"> 开始日期: <input type="date"  value="<?php echo $start_date;?>"name="start_date" id="start_date"/></label>
        <label class="control-label no-padding-right"> 结束日期: <input type="date" value="<?php echo $over_date;?>" name="over_date" id="over_date" /></label>
        <label class="control-label no-padding-right"> 商品:
            <select name="goods_id" id="goods_id">
                <option value="0">请选择</option>
                <?php foreach ($goods_all as $k=>$v){?>
                    <option <?php if($v['goods_id']==$goods_id){echo "selected='selected'";}?> value="<?php echo $v['goods_id']?>"><?php echo $v['name']?></option>
                <?php }?>
            </select>
        </label>
        <label class="control-label no-padding-right"> 状态:
            <select name="view" id="view">
                <option  <?php if($view==0){echo "selected='selected'";}?>value="0">待发货</option>
                <option  <?php if($view==1){echo "selected='selected'";}?>value="1">已发货</option>
                <option <?php if($view==2){echo "selected='selected'";}?>value="2">待支付</option>
                <option <?php if($view==4){echo "selected='selected'";}?>value="4">已支付</option>
                <option <?php if($view==5){echo "selected='selected'";}?>value="5">货到付款</option>
                <option <?php if($view==6){echo "selected='selected'";}?>value="6">活动</option>
                <option <?php if($view==7){echo "selected='selected'";}?>value="7">已作废</option>
                <option <?php if($view==8){echo "selected='selected'";}?>value="8">已完成</option>
                <option <?php if($view==9){echo "selected='selected'";}?>value="9">全部</option>
            </select>
        </label>
        <a  class="btn btn-sm" onclick="submit_select()">查询</a>
        <a  onclick="test_export()" class="btn btn-sm">导出</a>
    </div>
<!--</form>
<ul class="nav nav-tabs" style="margin-bottom: 1px;height: 40px;">
    <li <?php if ($view == 0):?>class="active"<?php endif;?>>
        <a href="?r=order/default/index&view=0">待发货</a>
    </li>
    <li <?php if ($view == 1):?>class="active"<?php endif;?>>
        <a href="?r=order/default/index&view=1">已发货</a>
    </li>
    <li <?php if ($view == 2):?>class="active"<?php endif;?>>
        <a href="?r=order/default/index&view=2">待支付</a>
    </li>
    <li <?php if ($view == 4):?>class="active"<?php endif;?>>
        <a href="?r=order/default/index&view=4">已支付</a>
    </li>
    <li <?php if ($view == 5):?>class="active"<?php endif;?>>
        <a href="?r=order/default/index&view=5">货到付款</a>
    </li>
    <li <?php if ($view == 6):?>class="active"<?php endif;?>>
        <a href="?r=order/default/index&view=6">活动</a>
    </li>
    <li <?php if ($view == 7):?>class="active"<?php endif;?>>
        <a href="?r=order/default/index&view=7">已作废</a>
    </li>
    <li <?php if ($view == 8):?>class="active"<?php endif;?>>
        <a href="?r=order/default/index&view=8">已完成</a>
    </li>
    <li <?php if ($view == 9):?>class="active"<?php endif;?>>
        <a href="?r=order/default/index&view=9">全部</a>
    </li>
</ul>-->
<div class="row">
    <div class="col-xs-12">
        <div class="table-responsive">
            <div role="grid" class="dataTables_wrapper" id="content">
                <table class="table table-striped table-bordered table-hover dataTable" id="goods-list" aria-describedby="sample-table-2_info">
                    <thead>
                    <tr role="row">
                        <th class="center sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 71px;" aria-label="">
                            <label>
                                <span class="lbl"></span>
                            </label>
                        </th>
                        <!--<th>操作</th>-->
                        <th>订单号</th>
                        <th>会员名</th>
                        <th>下单时间</th>
                        <th>更新时间</th>
                        <th>收货人</th>
                        <th>收货手机</th>
                        <th>收货地区</th>
                        <th>订单总额</th>
                        <th>付款状态</th>
                        <th>支付方式</th>
                        <th>发货方式</th>
                        <th>来源</th>
                    </tr>
                    </thead>

                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                        <?php foreach ($dataProvider as $v):?>
                        <tr class="odd">
                            <td class="center sorting_1">
                                <label>
                                    <input type="checkbox" class="ace" name="order_id" data="<?php echo $v['order_id'];?>" value="<?php echo $v['order_id'];?>">
                                    <span class="lbl"></span>
                                </label>
                            </td>
                           <!-- <td>
                                <a href="javascript:;" data="<?php /*echo $v['order_id'];*/?>" class="view">
                                    <button class="btn btn-xs btn-info">查看/操作</button>
                                </a>
                            </td>-->
                            <td><?php echo $v['order_id'];?></td>
                            <td><?php echo $v['member_info']['phone'];?></td>
                            <td><?php echo date('Y-m-d H:i:s',$v['createtime']);?></td>
                            <td><?php echo date('Y-m-d H:i:s',$v['updatetime']);?></td>
                            <td><?php echo $v['ship_name'];?></td>
                            <td><?php echo $v['ship_mobile'];?></td>
                            <td><?php echo $v['ship_area'];?></td>
                            <td><?php echo $v['score_u']."积分";?></td>
                            <td><?php echo $v['pay_status_name'];?></td>
                            <td><?php echo $v['payment'];?></td>
                            <td><?php echo $v['ship_status_name'];?></td>
                            <td><?php echo $v['source'];?></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>


                <div class="row">
                    <?php $this->widget(
                        'bootstrap.widgets.TbLinkPager',
                        array(
                            'pages' => $pages,
                            'currentPage'=>$pageIndex,
                            'pageSize'=>$this->pagesize
                        )
                    );?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function submit_select(){
        var view= $("#view").val();
        var goods_id= $("#goods_id").val();
        var start_date= $("#start_date").val();
        var over_date= $("#over_date").val();

        location.href='?r=order/default/index&view='+view+'&goods_id='+goods_id+'&start_date='+start_date+'&over_date='+over_date;
    }
    function  test_export() {
        var view= $("#view").val();
        var goods_id= $("#goods_id").val();
        var start_date= $("#start_date").val();
        var over_date= $("#over_date").val();
        var page= <?php echo $page;?>;

        location.href='?r=order/default/ExportCsv&view='+view+'&goods_id='+goods_id+'&start_date='+start_date+'&over_date='+over_date+'&page='+page;
    }
</script>
