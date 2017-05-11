<?php

// +----------------------------------------------------------------------
// | Author: Jayin Ton <tonjayin@gmail.com>
// +----------------------------------------------------------------------

namespace Log\Controller;


use Common\Controller\AdminBase;
use Log\Service\LogService;
use Log\Model\LogLogModel;

class IndexController extends AdminBase{

    // 日志列表
    public function index(){
        $this->display();
    }

    // ajax 获取日志列表信息
    public function getLogs(){
        $category = I('category');
        $start_time = I('start_time');
        $end_time = I('end_time');
        $ip = I('ip');
        $page = I('page', 1);

        $where = array();
        if (!empty($category)) {
            $where['category'] = array('like', "%{$category}%");
        }
        if (!empty($start_time) && !empty($end_time)) {
            $start_time = strtotime($start_time);
            $end_time = strtotime($end_time) + 24*60*60-1;
            $where['inputtime'] = array(array('EGT', $start_time), array('ELT', $end_time), 'AND');
        }
        if (!empty($ip)) {
            $where['ip'] = array('like', "%{$ip}%");
        }

        $count = D('Log/Log')->where($where)->count();
        $limit = 10;
        $total_page = ceil( $count / $limit );
        $Logs = D('Log/Log')->where($where)->page($page, $limit)->order(array("id" => "desc"))->select();
        $data = [
            'logs' => $Logs,
            'page' => $page,
            'total_page' => $total_page,
        ];
        $this->ajaxReturn(self::createReturn(true, $data, ''));
    }

}