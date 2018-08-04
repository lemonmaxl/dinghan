<?php

namespace app\admin\controller\goods;

use app\common\controller\Backend;

/**
 * 商品基本信息管理
 *
 * @icon fa fa-circle-o
 */
class Index extends Backend
{
    
    /**
     * Goods模型对象
     * @var \app\admin\model\Goods
     */
    protected $model = null;

    protected $relationSearch = true; // 开启关联查询

    protected $modelValidate = true; //是否开启Validate验证，默认是false关闭状态
    protected $modelSceneValidate = true; //是否开启模型场景验证，默认是false关闭状态

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('Goods');
        $this->view->assign("typeList", $this->model->getTypeList());
        $this->view->assign("isSaleList", $this->model->getIsSaleList());
    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    
    /**
     * 查看
     */
    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->with("category")
                ->where($where)
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->with("category")
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }



    /**
     * 添加
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                    $params[$this->dataLimitField] = $this->auth->id;
                }
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = basename(str_replace('\\', '/', get_class($this->model)));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : true) : $this->modelValidate;
                        $this->model->validate($validate);
                    }

                    
                    // 组合数据
                    if(!empty($params['third']) ){
                        $params['category_id'] = $params['third'];
                        $params['cate_tree'] = $params['first'] . '>' . $params['second'] . '>' . $params['third'];
                    }elseif(empty($params['third']) && !empty($params['second']) ){
                        $params['category_id'] = $params['second'];
                        $params['cate_tree'] = $params['first'] . '>' . $params['second'];
                    }elseif(empty($params['third']) && empty($params['second']) && !empty($params['first'])){
                        $params['category_id'] = $params['first'];
                        $params['cate_tree'] = $params['first'];
                    }
                    var_dump($params);
                    // $result = $this->model->allowField(true)->save($params);
                    if ($result !== false) {
                        $this->success();
                    } else {
                        $this->error($this->model->getError());
                    }
                } catch (\think\exception\PDOException $e) {
                    $this->error($e->getMessage());
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        return $this->view->fetch();
    }

    /**
     * 编辑
     */
    public function edit($ids = NULL)
    {
        $row = $this->model->get($ids);//获取数据根据主键Id

        if (!$row)
            $this->error(__('No Results were found'));

        $adminIds = $this->getDataLimitAdminIds(); //获取数据限制的管理员ID,禁用数据限制时返回的是null
        
        if (is_array($adminIds)) {
            if (!in_array($row[$this->dataLimitField], $adminIds)) {
                $this->error(__('You have no permission'));
            }
        }

        // post提交逻辑
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a"); //强制转换为数组

            if ($params) {
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = basename(str_replace('\\', '/', get_class($this->model)));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : true) : $this->modelValidate;
                        $row->validate($validate);
                    }
                    // 组合数据
                    if(!empty($params['third']) ){
                        $params['category_id'] = $params['third'];
                        $params['cate_tree'] = $params['first'] . '>' . $params['second'] . '>' . $params['third'];
                    }elseif(empty($params['third']) && !empty($params['second']) ){
                        $params['category_id'] = $params['second'];
                        $params['cate_tree'] = $params['first'] . '>' . $params['second'];
                    }elseif(empty($params['third']) && empty($params['second']) && !empty($params['first'])){
                        $params['category_id'] = $params['first'];
                        $params['cate_tree'] = $params['first'];
                    }
                    // dump($params);
                    $result = $row->allowField(true)->save($params);
                    if ($result !== false) {
                        $this->success();
                    } else {
                        $this->error($row->getError());
                    }
                } catch (\think\exception\PDOException $e) {
                    $this->error($e->getMessage());
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        // 获取类别联动数据
        if($row->cate_tree != ''){

            $cate_tree_array = explode('>', $row->cate_tree);
            $cate_tree_num = count($cate_tree_array);

            if ( is_array($cate_tree_array) && !empty($cate_tree_array) ) {
                if ($cate_tree_num == 3) {
                    $row->first = $cate_tree_array[0];
                    $row->second = $cate_tree_array[1];
                    $row->third = $cate_tree_array[2];
                }elseif ($cate_tree_num == 2) {
                    $row->first = $cate_tree_array[0];
                    $row->second = $cate_tree_array[1];
                    $row->third = '';
                }elseif ($cate_tree_num == 1) {
                    $row->first = $cate_tree_array[0];
                    $row->second = '';
                    $row->third = '';
                }
                
            }
        }else{
            $row->first = '';
            $row->second = '';
            $row->third = '';
        }
        // 模板赋值
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }


    public function getFormatInfo()
    {
        
        $data = $this->request->post();
        unset($data['row']);
        //根据第一规格组织数据
        // dump($data);
        if ( !empty($data['attrk1']) && !isset($data['attrk2']) && isset($data['attrv1']) && !isset($data['attrv2']) ) {
            // dump($data);
            if ( $data['attrk1'][0] != '' ) {

                $k = explode('-', $data['attrk1'][0])[1];

                for ($i=0; $i <count($data['attrv1']) ; $i++) { 
                    if ($data['attrv1'][$i] != '') {
                        return ['k'=>$k , 'v'=>$data['attrv1']];
                    }
                }
            }
            
        }elseif(!empty($data['attrk1']) && !empty($data['attrk2']) && isset($data['attrv1']) && isset($data['attrv2']) ){
            
            if( ($data['attrk1'][0] != '') && ($data['attrk2'][0] != '') ){
                $k = explode('-', $data['attrk1'][0])[1];
                $k2 = explode('-', $data['attrk2'][0])[1];

                for ($i=0; $i <count($data['attrv1']) ; $i++) { 
                    for ($j=0; $j <count($data['attrv2']) ; $j++) { 
                        if ( ($data['attrv1'][$i] != '') && ($data['attrv2'][$j] != '') ) {
                            return ['k'=>$k , 'v'=>$data['attrv1'] ,'k2'=>$k2 , 'v2'=>$data['attrv2'] ];
                        }
                    }
                    
                }
            }
            
            
        }elseif(!empty($data['attrk1']) && !empty($data['attrk2']) && !isset($data['attrv1']) && !isset($data['attrv2'])){
            return ['code'=>404 , 'msg'=>'数据错误'];
        }elseif( !empty($data['attrk1']) && !empty($data['attrk2']) && isset($data['attrv1']) && !isset($data['attrv2']) ){
            if ( $data['attrk1'][0] != '' ) {

                $k = explode('-', $data['attrk1'][0])[1];

                for ($i=0; $i <count($data['attrv1']) ; $i++) { 
                    if ($data['attrv1'][$i] != '') {
                        return ['k'=>$k , 'v'=>$data['attrv1']];
                    }
                }
            }
        }elseif( !empty($data['attrk1']) && !empty($data['attrk2']) && !isset($data['attrv1']) && isset($data['attrv2']) ){
            if ( $data['attrk2'][0] != '' ) {

                $k = explode('-', $data['attrk2'][0])[1];

                for ($i=0; $i <count($data['attrv2']) ; $i++) { 
                    if ($data['attrv2'][$i] != '') {
                        return ['k'=>$k , 'v'=>$data['attrv2']];
                    }
                }
            }
        }
        
    }

}
