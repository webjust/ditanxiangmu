<?php

namespace app\common\model;

use think\Cache;
use think\Exception;

class Goods extends BaseModel
{
    protected $pk = 'g_id';

    public function detail()
    {
        return $this->hasOne('GoodsDes', 'g_id', 'g_id')->field('g_id,content');
    }

    public function add($data)
    {
        $this->allowField(true)->save($data);
        return $this->g_id;
    }

    public static function hot()
    {
        $res = self::limit(10)->where(['status' => 1])->select();
        return $res;
    }

    /*添加访问次数*/
    public function addViews($id, $key)
    {
        $cacheKey = $id . $key;
        $cache = Cache::get($cacheKey);
        if (!$cache) {
            $this->where('g_id=' . $id)->setInc("view_count", 1);
            Cache::set($cacheKey, 1, 60);
        }
    }

    /*更新排序*/
    public function saveListOrder($list)
    {
        $ret = $this->saveAll($list);
        return $ret;
    }

    // 修改状态
    public function setStatus($id, $status)
    {
        if (!$id || !is_numeric($id))
            throw new Exception("ID值非法");
        if (!is_numeric($status))
            throw new Exception("状态值非法");

        $data['status'] = ($status + 1) % 2;
        //$data['g_id'] = $id;
        return $this->where('g_id=' . $id)->update($data);
    }

    /*产品列表*/
    public function getList($condition = array(), $size = 10, $order = 'listorder desc, g_id desc')
    {
        $list = $this->where($condition)->order($order)->paginate($size);
        $page = $list->render();
        $count = $this->where($condition)->count();
        return [$list, $page, $count];
    }

    /*获取状态的人性化显示*/
    public function getStatusTextAttr($value, $data)
    {
        $status = [0 => '关闭', 1 => '显示'];
        return $status[$data['status']];
    }

    /*根据ID获取产品信息*/
    public static function getGoodsById($g_id)
    {
        if (!$g_id) {
            throw new Exception("ID非法值");
        }
        $ret = self::where(['g_id' => $g_id])->with('detail')->find();
        return $ret;
    }
}