<?php

// +----------------------------------------------------------------------
// | 日志系统
// +----------------------------------------------------------------------

namespace Log\Service;

use Log\Model\LogLogModel;
use System\Service\BaseService;

/**
 * 日志服务
 */
class LogService extends BaseService{

    /**
     * 添加日志
     *
     * @param string $category
     * @param string $message
     */
    static function log($category = '', $message = ''){
        $db = D('Log/Log');

        $data = [
            'category' => $category,
            'message' => $message,
            'inputtime' => time(),
        ];

        $insertid = $db->add($data);
        if($insertid > 0){
            self::createReturn(true, '', '添加日志成功');
        }else{
            self::createReturn(false, '', '添加日志失败');
        }
    }
}