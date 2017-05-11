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
        $start_date = I('start_date');
        $end_date = I('end_date');
        $page = I('page', 1);
        $limit = I('limit', 20);
        $message = I('message');

        $where = array();
        if (!empty($category)) {
            $where['category'] = array('LIKE', "%'.$category.'%");
        }
        if (!empty($start_date) && !empty($end_date)) {
            $start_date = strtotime($start_date);
            $end_date = strtotime($end_date) + 24 * 60 * 60 - 1;
            $where['inputtime'] = array(array('EGT', $start_date), array('ELT', $end_date), 'AND');
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