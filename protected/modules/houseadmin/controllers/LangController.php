<?php

class LangController extends HaController {

    public function actionIndex() {
        //die('lang');

        $this->actionLists();
    }

    public function actionLists() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $where = array();

        $model = new lang();
        $criteria = new CDbCriteria();
        $criteria->condition = "";
        $criteria->order = 't.id DESC';
        $count = $model->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll($criteria);

        $data['pagebar'] = $pages;

        foreach ($result as $c) {
            $data['language'][] = $c->attributes;
        }



        $this->render('lang', $data);
    }

    public function actionAdd() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        if (!empty($_POST)) {
            $model = new Lang;
            $data = $_POST;

//不能直接把数组给attributes  但是可以单独的给key赋值
            foreach ($model->attributes as $k => $v) {
                isset($data[$k]) && $model->$k = $data[$k];
            }


            if ($model->save()) {
                $target_url = $this->createUrl('/admin/lang/');
                $this->admin_message('添加成功', $target_url);
                exit();
            }
        } else {



            $data['fun'] = 'add';
            $this->render('lang_edit', $data);
        }
    }

    public function actionEdit() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id = intval(isset($_GET['id']) ? $_GET['id'] : $_POST['id']);
        $model = Lang::model()->findbypk($id);
        if (!empty($_POST)) {
            $model->attributes = $_POST;
            if ($model->save()) {
                $target_url = $this->createUrl('/admin/lang/');
                $this->admin_message('添加成功', $target_url);
                exit();
            }
        } else {

            if (isset($model)) {
                $data['view'] = $model->attributes;
            }
            $data['fun'] = 'edit';

            


            $this->render('lang_edit', $data);
        }
    }

    public function actionDel() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id_str = Mod::app()->request->getParam('id');
        $id_arr = explode(',', $id_str);
        if (in_array(1, $id_arr)) {
            $mess = '删除失败！中文不允许被删除！';
            $state = 0;
        } else {
            if ($id_arr && !empty($id_arr)) {
                $res = '';
                $model = new Lang;
                $res = $model->deleteAll('id IN(' . $id_str . ')');
                if ($res) {
                    $mess = '删除成功！';
                    $state = 1;
                } else {
                    $mess = '删除失败！';
                    $state = 0;
                }
            }
        }

        echo json_encode(array('state' => $state, 'mess' => $mess));
    }

    public function actionOrder() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id_str = $_POST['id'];
        $order_str = $_POST['order'];
        $id_arr = explode(',', $id_str);
        $order_arr = explode(',', $order_str);
        if (count($id_arr) > 0 && count($id_arr) == count($order_arr)) {
            $model = new Lang;
            $res = $model->order_bat($id_arr, $order_arr);
            if ($res) {
                $mess = '更新成功！';
                $state = 1;
            } else {
                $mess = '更新失败！';
                $state = 0;
            }
        }
        echo json_encode(array('state' => $state, 'mess' => $mess));
    }

}
