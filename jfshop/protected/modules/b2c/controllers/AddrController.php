<?php
/**
 * 会员地址管理
 *
 
 
 
 * @package       /protected/modules/b2c/controllers
 
 */

class AddrController extends B2cController
{
    public function init()
    {
        if (!$this->username) $this->redirect('/account/login');
    }
    
    /**
     * 收货地址
     */
    public function actionIndex()
    {
        //页面来源  1 来自 订单提交页面
        $f = (isset($_REQUEST['f']))? intval($_REQUEST['f']) :0;

        $Addr = new ModelAddr();
        $model['list'] = $Addr->AddrList($this->member_id);
        //给已选择的的地址标记
        $id = 'b2c-cart-product-set-'.$this->member_id;
        $cart_cache = Mod::app()->cache->get($id);
        if($f == 1 && !empty($model['list']) && !empty($cart_cache['addr'])){
            $addr_select_id = $cart_cache['addr']['addr_id'];
            foreach($model['list'] as $k=> $v){
                if($v['addr_id'] == $addr_select_id){
                    $model['list'][$k]['selected'] = '1';
                }else{
                    $model['list'][$k]['selected'] = '0';
                }
            }
        }else{
            foreach($model['list'] as $k=> $v){
                $model['list'][$k]['selected'] = '0';
            }
        }

        $this->render('index',array('model'=>$model,'f'=>$f));
    }

    /**
     * 收货地址新增
     */
    public function actionInsert()
    {
        //页面来源
        $f = (isset($_REQUEST['f']))? intval($_REQUEST['f']) :0;
        $Addr = new ModelAddr();
        if ($_POST) {
            $list = $Addr->AddrList($this->member_id);

            $param['member_id'] = $this->member_id;
            $param['name'] = Tool::getValidParam('consignee');
            $param['mobile'] = Tool::getValidParam('consigneeNo');
            $param['area'] = Tool::getValidParam('consigneeArea');
            $param['addr'] = Tool::getValidParam('consigneeAd');
            $param['zip'] = Tool::getValidParam('consigneePD');
            $default_check =  Tool::getValidParam('address_default_check');
            $address_default_check = empty($default_check)?'0':'1';
            $result = $Addr->AddrAdd($param,$address_default_check);

            if ($result){
                $id = 'b2c-cart-product-set-'.$this->member_id;
                $cart_cache = Mod::app()->cache->get($id);

                if(count($list)==0 && $f==1 && !empty($cart_cache)){
                    $this->redirect('/addr/index.html');
                }
                $this->redirect('/addr/index.html');

            }else{
                echo "<script>alert('地址添加失败，请稍后再试');location.href='javascript:history.go(-1)'</script>";
            }
        }
        $model['province'] = $Addr->Regions();
        $model['f'] = $f;
        $this->render('insert',array('model'=>$model));
    }

    /**
     * 收货地址编辑
     */
    public function actionUpdate()
    {
        $addr_id = Tool::getValidParam('addr_id');

        $f = (isset($_REQUEST['f']))? intval($_REQUEST['f']) :0;

        $Addr = new ModelAddr();
        if ($_POST) {
            $param['member_id'] = $this->member_id;
            $param['name'] = Tool::getValidParam('consignee');
            $param['mobile'] = Tool::getValidParam('consigneeNo');
            $param['area'] = Tool::getValidParam('consigneeArea');
            $param['addr'] = Tool::getValidParam('consigneeAd');
            $param['zip'] = Tool::getValidParam('consigneePD');

            $address_default_check = Tool::getValidParam('address_default_check');
            $address_default_old = Tool::getValidParam('address_default_old');
            $result = $Addr->AddrEdit($addr_id,$param,$address_default_check,$address_default_old);
            if($result){
                //清除如果是已经存在的地址缓存
                $id = 'b2c-cart-product-set-'.$this->member_id;
                $cart_cache = Mod::app()->cache->get($id);
                if( !empty($cart_cache['addr'])){
                    if($addr_id == $cart_cache['addr']['addr_id']){
                        $Addr->AddrSelect($this->member_id,$addr_id);
                    }
                }
            }
            $this->redirect('/addr/index.html?f='.$f);

        }
        $model = $Addr->AddrRow($addr_id);
        if(empty($model)){
            $this->redirect('/addr/index.html?f='.$f);
        }

        $model['f'] = $f;
        $model['province'] = $Addr->Regions();
        $this->render('update',array('model'=>$model));
    }

    /**
     * 收货地址删除
     */
    public function actionDelete()
    {
        $addr_id = Tool::getValidParam('addr_id','int');
        if(!$addr_id){
            echo json_encode(array('code'=>400,'msg'=>'请先选择地址'));
            die();
        }
        $Addr = new ModelAddr();
        if ($Addr->AddrDel($addr_id)){
            $id = 'b2c-cart-product-set-'.$this->member_id;
            $cart_cache = Mod::app()->cache->get($id);
            if(!empty($cart_cache['addr']) &&  $cart_cache['addr']['addr_id'] == $addr_id){
                unset($cart_cache['addr']);
                if(Mod::app()->cache->set($id,$cart_cache)){
                    echo json_encode(array('code'=>200,'msg'=>'删除地址成功'));
                    die();
                }else{
                    echo json_encode(array('code'=>400,'msg'=>'删除地址失败,请稍后再试'));
                    die();
                }
            }
            echo json_encode(array('code'=>200,'msg'=>'删除地址成功。'));
            die();
        }else{
            echo json_encode(array('code'=>400,'msg'=>'删除地址失败,请稍后再试'));
            die();
        }

    }

    /**
     * 订单详情地址
     */
    public function actionOrderaddr()
    {
        $this->registerJs('member_addr');

        $Addr = new ModelAddr();
        $model['list'] = $Addr->AddrList($this->member_id);

        $this->render('index',array('model'=>$model));
    }

    /**
     * 动态获取地址
     */
    public function actionRegion()
    {
        $region_id = Tool::getValidParam('region_id');
        $Addr = new ModelAddr();
        $region_list = $Addr->Regions($region_id);

        $region_str = '';
        foreach ($region_list as $v) {
            $region_str .= "<option value='{$v['region_id']}'>{$v['local_name']}</option>";
        }

        echo $region_str;
    }


    /**
     * 收货地址选择
     */
    public function actionAddrSelect()
    {
        $member_id = $this->member_id;
        $addr_id = Tool::getValidParam('addr_id','int');

        $Addr = new ModelAddr();
        $result = $Addr->AddrSelect($member_id,$addr_id);
        if($result){
            echo json_encode(array('code'=>200,'msg'=>'选择地址成功'));
            die();
        }
        echo json_encode(array('code'=>400,'msg'=>'选择地址失败'));
    }

    /**
     * 默认地址选择
     */
    public function actionAddressDefault()
    {
        $member_id = $this->member_id;
        $addr_id = Tool::getValidParam('addr_id','int');

        $Addr = new ModelAddr();
        $result = $Addr->addressDefault($member_id,$addr_id);

        if($result){
            echo json_encode(array('code'=>200,'msg'=>'设置默认地址成功'));
            die();
        }
        echo json_encode(array('code'=>400,'msg'=>'设置默认地址失败'));
        die();
    }



} 