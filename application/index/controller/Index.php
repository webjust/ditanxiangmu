<?php

namespace app\index\controller;

use app\common\model\Goods;

class Index extends Base
{
    public function index()
    {
        $this->title('地摊项目网 - 精选地摊创业项目');
        $Goods = new Goods();
        $condition = ['status' => 1];
        list($goods, $page, $count) = $Goods->getList($condition, 9);
        return $this->fetch('', compact('goods'));
    }

    public function detail()
    {
        $id = request()->param('id');

        // 更新阅读次数
        $GoodsModel = new Goods();
        $key = request()->ip();
        $GoodsModel->addViews($id, $key);
        $goods = $GoodsModel->with('detail')->where(['g_id' => $id])->find();
        if (empty($id) || empty($goods)) {
            $this->error("该项目不存在");
        }
        $this->title($goods->goods_name . "- 地摊项目网");
        return $this->fetch('', compact('goods'));
    }

    public function all()
    {
        $this->title('全部项目 - 地摊项目网');
        $Goods = new Goods();
        $condition = ['status' => 1];
        list($goods, $page, $count) = $Goods->getList($condition, 12);
        return $this->fetch('', compact('goods', 'page', 'count'));
    }

    public function logout()
    {
        session('ip', null);
        return $this->redirect("Index/error/index");
    }

    public function about()
    {
        $this->title("关于我们 - 地摊创业项目网");
        return $this->fetch();

    }

    public function ad()
    {
        $this->title("广告合作");
        return $this->fetch();
    }

    public function hr()
    {
        $this->title("招聘");
        return $this->fetch();
    }
}
