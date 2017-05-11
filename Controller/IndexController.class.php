<?php

// +----------------------------------------------------------------------
// | Author: Jayin Ton <tonjayin@gmail.com>
// +----------------------------------------------------------------------

namespace Log\Controller;


use Common\Controller\AdminBase;
use Log\Service\LogService;
use Log\Model\BaseModel;

class IndexController extends AdminBase{

    // 日志列表
    public function index(){
        if(IS_POST){
            $userid = I('userid');
            $category = I('category');
            $start_time = I('start_time');
            $end_time = I('end_time');
            $ip = I('ip');
            $page = I('page', 1);

            $where = array();
            if (!empty($userid)) {
                $where['userid'] = array('eq', $userid);
            }
            if (!empty($category)) {
                $where['category'] = array('like', "%{$category}%");
            }
            if (!empty($start_time) && !empty($end_time)) {
                $start_time = strtotime($start_time);
                $end_time = strtotime($end_time) + 86399;
                $where['inputtime'] = array(array('GT', $start_time), array('LT', $end_time), 'AND');
            }
            if (!empty($ip)) {
                $where['ip'] = array('like', "%{$ip}%");
            }

            $count = M(BaseModel::DB_NAME)->where($where)->count();
            $limit = 10;
            $total_page = ceil( $count / $limit );
            $Logs = M(BaseModel::DB_NAME)->where($where)->page($page, $limit)->order(array("id" => "desc"))->select();
            $data = [
                'logs' => $Logs,
                'page' => $page,
                'total_page' => $total_page,
            ];
            $this->ajaxReturn(self::createReturn(true, $data, ''));
        }

        $this->display();
    }

    public function test(){
        LogService::Log(__CLASS__.'\\'.__FUNCTION__,'test');
    }

}