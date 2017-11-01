<?php
namespace Home\Controller;
use OT\DataDictionary;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class PersonalController extends HomeController {

	//系统首页
    public function index(){
        global $handler;

        $list = D("partner")->select();
        foreach($list as $key=>$val){
            $list[$key]["p_img"] = M("picture")->field("path")->select($val['p_img'])[0]["path"];
            $list[$key]["p_small_img"] = M("picture")->field("path")->select($val['p_small_img'])[0]["path"];
        }
        $data = array();
        foreach($list as $key=>$val){
            $index = intval($key/4);
            $i = intval($key%4);
            $data[$index][$i] = $val;
        }
        $handler->debug($data);
        $this->assign("list", $data);
        $this->display();
    }
}   
?>
