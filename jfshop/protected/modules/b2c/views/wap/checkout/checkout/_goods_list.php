<div class="order-detail">
			<table class="table">
				<thead>
				<tr>
                                        <th class="image"  style='width:50px;'>图片</th>
					<th class="name">名称</th>
					<th class="num">数量</th>
					<th class="total">单价</th>
				</tr>
				</thead>
				<tbody>
                                      <?php foreach ($item as $v){?>
                                            <tr>
                                            <td class="image" style='width:50px;'>
                                            <span style="float:left;">
                                           <img style="width: 50px;height: 50px;" src="<?php echo $this->_siteUrl.'/'.$v['image'];?>" alt="Berry Lace Dress">
                                            </span>
                                            </td>
                                            <td class="name">
                                            <span style="float:left;">
                                                <a href="<?php echo $this->_siteUrl;?>/b2c/wap/product/detail/id=<?php echo $v['product_id'];?>" target="_blank"><?php echo $v['product_name'];?></a>
                                            </span>
                                            </td>
                                            <td class="num"><?php echo $v['quantity'];?></td>
                                            <td class="total">
                                            <span style="display: none;"><?php echo $v['quantity'];?></span>				
                                            <span class="goodsprice"><?php if($v['paytype']==3){?>
                                            <?php echo $v['price_jifen']?><br>积分
                                            <?php }else{?>
                                            <span>￥</span><?php echo $v['price']?>
                                            <?php } ?></span>
                                            <span style="display: none;">
                                            <?php if($v['paytype']==3){?>
                                                <?php echo $v['price_jifen']?>
                                            <?php }else{?>
                                                <?php echo $v['price']?>
                                            <?php } ?></span>
                                            </td>
                                            </tr>
                                    <?php } ?>
								</tbody>
			</table>
			<div class="order-detail-hd">
				<span class="pull-right" style="color:#E74C3C;">
					[合计：<span id="totalprice"><span>￥</span><?php  echo $amount['amount_price'];?>&nbsp;&nbsp;&nbsp;<span>积分</span><?php echo $amount['amount_price_jifen'];?></span>]
				</span>
			</div>
			<div style="clear:both;"></div>
</div>




