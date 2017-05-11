<?php

// +----------------------------------------------------------------------
// | Author: Jayin Ton <tonjayin@gmail.com>
// +----------------------------------------------------------------------

namespace Log\Controller;


use Common\Controller\AdminBase;
use Log\Service\LogService;

class TestController extends AdminBase{

    public function test(){
        LogService::Log(__CLASS__.'::'.__FUNCTION__,'测试数据...');
        LogService::Log('tst','ffff.');
    }

}