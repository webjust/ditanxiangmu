<?php

namespace app\admin\controller;

use app\common\model\Admin;
use think\Db;

class Site extends Base
{
    // 修改关于我们页面
    public function about()
    {
        return $this->fetch();
    }

    // 修改密码
    public function repass()
    {
        $user = $this->getLoginUser()->username;
        $user_password = $this->getLoginUser()->password;   // 旧密码
        if (request()->isPost()) {
            $data = input('post.');
            // 校验
            $old_password = trim($data['old_password']);
            $password = trim($data['password']);
            $repassword = trim($data['repassword']);
            if (empty($old_password) || empty($password) || empty($repassword))
                $this->error("密码不能为空");

            if ($user_password != md5($old_password . config('pre_md5'))) {
                $this->error("原始密码输入错误");
            }
            if ($password != $repassword) {
                $this->error("两次输入的新密码不一致");
            }
            if (strlen($password) < 5) {
                $this->error("密码长度至少为5位数");
            }

            $newpass['password'] = md5($password . config('pre_md5'));
            $ret = model('Admin')->where(['username' => $user])->update($newpass);
            if ($ret) {
                session('admin', null);
                $this->success("新密码修改成功，请重新登录", url('admin/login/index'));
            } else {
                $this->error("新密码修改失败");
            }
        } else {
            return $this->fetch();
        }
    }

    // 屏蔽IP
    public function ip()
    {
        $ips = model('Ip')->select();
        return $this->fetch('', ['ips' => $ips]);
    }

    // 提交屏蔽IP
    public function doIp()
    {
        if (request()->isPost()) {
            $data = input('post.');
            // 校验

            Db::startTrans();
            $ip_id = model('Ip')->add($data);
            $arr_ip_address = $this->getIpAddress($data['ip_address_start'], $data['ip_address_end'], $ip_id);
            $num = count($arr_ip_address);
            $ret = model('IpAddress')->saveAll($arr_ip_address);
            if ($ip_id && $ret) {
                Db::commit();
                $this->success("添加成功, 新增屏蔽网段{$num}个");
            } else {
                Db::rollback();
                $this->error("添加失败，屏蔽网段{$num}个，试着减少网段数量试试");
            }
        }
    }

    // 删除IP
    public function delIp()
    {
        $id = input('param.id');
        $del_ip = model("Ip")->where(["ip_id" => $id])->delete();
        $del_ip_address = model("IpAddress")->where(["ip_id" => $id])->delete();
        if ($del_ip && $del_ip_address) {
            $this->success("删除成功", url("admin/site/ip"));
        } else {
            $this->error("删除失败");
        }
    }

    /**
     * 生成屏蔽的网段
     * @param $a 开始网段
     * @param $b 结束网段
     * @param $ip_id 屏蔽IP网段的主键ID
     * @return array
     */
    public function getIpAddress($a, $b, $ip_id)
    {
        $start_ip = explode('.', $a);
        $end_ip = explode('.', $b);
        $arr = array();
        for ($i = $start_ip[0]; $i <= $end_ip[0]; $i++) {
            for ($j = $start_ip[1]; $j <= $end_ip[1]; $j++) {
                for ($k = $start_ip[2]; $k <= $end_ip[2]; $k++) {
                    $ip = ['ip1' => $i, 'ip2' => $j, 'ip3' => $k, 'ip_id' => $ip_id];
                    $arr[] = $ip;
                }
            }
        }
        return $arr;
        //$model = new IpAddress();
        //$ret = $model->saveAll($arr);
        //dump($ret);
    }
}
