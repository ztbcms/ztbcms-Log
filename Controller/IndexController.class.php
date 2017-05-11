<?php

// +----------------------------------------------------------------------
// | Author: Jayin Ton <tonjayin@gmail.com>
// +----------------------------------------------------------------------

namespace Log\Controller;


use Common\Controller\AdminBase;
use Log\Service\LogService;
use Log\Model\LogLogModel;

class IndexController extends AdminBase {

    // 日志列表
    public function index() {
        $this->display();
    }

    /**
     * 获取日志列表信息
     */
    public function getLogs() {
        $category = I('category');
        $start_time = I('start_time');
        $end_time = I('end_time');
        $page = I('page', 1);
        $limit = I('limit', 20);
        $message = I('message');

        $where = array();
        if (!empty($category)) {
            $where['category'] = array('LIKE', "%'.$category.'%");
        }
        if (!empty($start_time) && !empty($end_time)) {
            $start_time = strtotime($start_time);
            $end_time = strtotime($end_time) + 24 * 60 * 60 - 1;
            $where['inputtime'] = array(array('EGT', $start_time), array('ELT', $end_time), 'AND');
        }
        if (!empty($message)) {
            $where['message'] = array('LIKE', '%' . $message . '%');
        }

        $count = D('Log/Log')->where($where)->count();
        $total_page = ceil($count / $limit);
        $Logs = D('Log/Log')->where($where)->page($page)->limit($limit)->order(array("id" => "desc"))->select();
        $data = [
            'items' => $Logs,
            'page' => $page,
            'limit' => $limit,
            'total_page' => $total_page,
        ];
        $this->ajaxReturn(self::createReturn(true, $data));
    }

}