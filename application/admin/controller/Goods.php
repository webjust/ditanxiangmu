<?php

namespace app\admin\controller;

use app\common\model\Goods as GoodsModel;
use think\Db;
use think\Exception;

class Goods extends Base
{
    // 列表页
    public function index()
    {
        $GoodsModel = new GoodsModel();
        $condition = [];
        list($goods, $page, $count) = $GoodsModel->getList($condition, 10);
        $this->assign('empty', "<tr><td colspan='8' align='center'>暂时没有数据</td></tr>");
        return $this->fetch('', compact('goods', 'page', 'count'));
    }

    // 添加产品
    public function add()
    {
        if (request()->isPost()) {
            $data = input('post.');
            // 数据校验

            Db::startTrans();

            if ($data['g_id']) {
                // 更新操作
                $g_id = $data['g_id'];
                unset($data['g_id']);
                $res1 = model('Goods')->allowField(true)->save($data, ['g_id' => $g_id]);
                //echo model('Goods')->getLastSql();
                $res2 = model('GoodsDes')->allowField(true)->save($data, ['g_id' => $g_id]);
                if ($res1 && $res2) {
                    Db::commit();
                    $this->success("更新成功", url('Goods/index'));
                } elseif ($res1) {
                    Db::commit();
                    $this->success("更新成功", url('Goods/index'));
                } elseif ($res2) {
                    Db::commit();
                    $this->success("更新成功", url('Goods/index'));
                } else {
                    Db::rollback();
                    $this->error("更新失败");
                }
            } else {
                // 添加操作
                $data['status'] = 1;
                $data['create_time'] = time();
                $g_id = model('Goods')->add($data);
                $postData = ['g_id' => $g_id, 'content' => $data['content'], 'create_time' => time()];
                $g_des_id = model('GoodsDes')->add($postData);

                if ($g_id && $g_des_id) {
                    Db::commit();
                    $this->success("提交成功");
                } else {
                    Db::rollback();
                    $this->error("添加失败");
                }
            }
        } else {
            return $this->fetch();
        }
    }

    // 编辑产品
    public function edit()
    {
        $id = input('param.id');
        $goods = GoodsModel::getGoodsById($id);
        return $this->fetch('', compact('goods'));
    }

    // 删除产品
    public function del()
    {
        $id = request()->param('id');
        Db::startTrans();
        $goodsModel = model('Goods')->where(['g_id' => $id])->find();
        $res = $goodsModel->delete();
        $goodsDesModel = model('GoodsDes')->where(['g_id' => $id])->find();
        $res2 = $goodsDesModel->delete();
        if ($res && $res2) {
            Db::commit();
            $this->success("删除成功");
        } else {
            Db::rollback();
            $this->error("删除失败");
        }
    }

    // 排序
    public function listorder()
    {
        if (request()->isAjax()) {
            $data = input('post.');
            $list = array();
            foreach ($data['listorder'] as $k => $v) {
                $list[] = ['g_id' => $k, 'listorder' => $v];
            }
        }
        $GoodsModel = new GoodsModel();
        $ret = $GoodsModel->saveListOrder($list);
        if ($ret) {
            return json(['status' => 1, 'info' => '排序成功', 'data' => '']);
        } else {
            return json(['status' => 0, 'info' => '排序失败', 'data' => '']);
        }
    }

    // 状态
    public function setstatus()
    {
        try {
            if (request()->isAjax()) {
                $data = input("post.");
                $GoodsModel = new GoodsModel();
                $ret = $GoodsModel->setStatus($data['id'], $data['status']);
                if ($ret) {
                    return json(['status' => 1, 'info' => '设置成功', 'data' => '']);
                } else {
                    return json(['status' => 0, 'info' => '设置成功', 'data' => '']);
                }
            }
        } catch (Exception $e) {
            return json(['status' => 0, 'info' => $e->getMessage(), 'data' => '']);
        }
    }
}
