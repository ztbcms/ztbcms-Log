<?php

// +----------------------------------------------------------------------
// | 日志系统
// +----------------------------------------------------------------------

namespace Log\Service;

use Log\Model\LogLogModel;
use System\Service\BaseService;

class LogService extends BaseService{

    /**
     * 添加日志
     * string $category
     * string $msg
     */
    static function Log($category = '', $message = ''){

        $db = D('Log/Log');

        $data = [
            'category' => $category,
            'message' => $message,
            'inputtime' => time(),
            'ip' => get_client_ip()
        ];

        $insertid = $db->add($data);
        if($insertid > 0){
            self::createReturn(true, '', '添加日志成功');
        }else{
            self::createReturn(false, '', '添加日志失败');
        }
    }
}