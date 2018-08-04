<?php

namespace app\admin\model;

use think\Model;

class Goods extends Model
{
    // 表名
    protected $name = 'goods';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    
    // 追加属性
    protected $append = [
        'type_text',
        'is_sale_text'
    ];
    

    
    public function getTypeList()
    {
        return ['1' => __('Type 1'),'2' => __('Type 2')];
    }     

    public function getIsSaleList()
    {
        return ['1' => __('Is_sale 1'),'2' => __('Is_sale 2')];
    }     


    public function getTypeTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['type'];
        $list = $this->getTypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getIsSaleTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['is_sale'];
        $list = $this->getIsSaleList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function category()
    {
        return $this->belongsTo('Category', 'category_id')->setEagerlyType(0);
    }


}
