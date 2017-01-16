<?php $this->load->view('header.php');?>
        <div class='bgf clearfix'>
            
            <div class="center_top clearfix">
                <ul>
                    <?php if( $fun =='add'){ ?>
                         <li class="btn"><a  href="<?php echo admin_url('permission/add') ?>">添加</a></span></li>
                    <?php  }else {?>
                         <li class="btn"><a  href="<?php echo admin_url('permission/add') ?>">编辑</a></span></li>
                         <li> ----   <?php echo lang($item['class']).lang('model')?></li> 
                    <?php } ?>
                </ul>

            </div>


            <div class="form_list">
                <form name="formview" id="formview" action="<?php echo admin_url('permission') . '/' . $fun; ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo isset($item['id']) ? $item['id'] : ''; ?>">
                    <table width="100%" cellspacing="0" class="content_view">  
                        <tbody>
                            <tr>
                                <td width="120" align="right">菜单<em style="color:#ff0000">*</em>&nbsp;:</td>
                                <td>
                                    <select name="fid" >
                                        <option value="0" <?php if (isset($view['fid']) && 0 == $view['fid']): ?>selected<?php endif; ?>>顶级分类</option>
                                        <?php foreach ($type_arr as $type): ?>
                                        <option value="<?php echo  $type['id'] ?>" <?php if ( (isset($item['fid']) && $type['id'] == $item['fid']) ){ ?>selected<?php } ?>><?php echo  lang($type['class']).lang('model') ?></option>
                                        <?php endforeach; ?>
                                   </select>
                                </td>
                            </tr>
                            <tr>
                                <td width="120" align="right">功能<em style="color:#ff0000">*</em>&nbsp;:</td>
                                <td>
                                    <input type="text" value="<?php echo isset($item['class']) ? $item['class'] : '' ?>" id="class" name="class" class="required"> 
                                </td>
                            </tr>
                            <tr>
                                <td width="120" align="right">方法<em style="color:#ff0000">*</em>&nbsp;:</td>
                                <td>
                                    <textarea name="fun"  id="fun" class="required"  style='padding:5px;width:300px;height:100px'><?php echo isset($item['fun']) ? $item['fun'] : '' ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td width="120" align="right">状态<em style="color:#ff0000">*</em>&nbsp;:</td>
                                <td> 
                                    <label> <?php echo lang('yes') ?></label>
                                    <input type="radio" name="status" value="1" <?php
                                    if (!isset($view['status']) || $view['status'] == 1) {
                                        echo 'checked';
                                    }
                                    ?> />
                                    <label> <?php echo lang('no') ?></label>
                                    <input type="radio" name="status" value="0" <?php
                                    if (isset($view['status']) && $view['status'] == 0) {
                                        echo 'checked';
                                    }
                                    ?>  />
                                </td>
                            </tr>

                            <tr>
                                <td width="120" align="right">排序<em style="color:#ff0000">*</em>&nbsp;:</td>
                                <td>
                                    <input type="text" value="<?php echo isset($item['order']) ? $item['order'] : '99'; ?>" id="order" name="order"> 
                                </td>
                            </tr>


                            <tr>
                                <td width="120" align="right" style="border:none"></td>
                                <td style="border:none"><input type="submit" class="btn" value="提交"></td>
                            </tr>
                        </tbody></table>              
                </form>
            </div>
        </div>
    </body>
</html>
