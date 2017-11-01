<?php
namespace Home\Controller;
use OT\DataDictionary;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class InfomalessayController extends HomeController {
    private $documentModel;
    private $articleModel;
    //随笔    
    public function jottings(){
        $data = D("document")->field("id, title, cover_id, create_time")->where("status!=-1")->select();
        foreach($data as $key=>$val){
            $tempdata = D("document_article")->field("exp_station")->where("id=".$val["id"])->find();
            if($tempdata["exp_station"] != "0"){
                unset($data[$key]);
            }else{
                $data[$key]["create_time"] = date("Y-m-d H:i",$val["create_time"]);
                $map = array("id"=>$val["cover_id"]);
                $data[$key]["cover_path"] = D("picture")->field("path")->where($map)->find();
                $data[$key]["cover_path"] =  $data[$key]["cover_path"]["path"];
            }
        }
        $this->assign("data", $data);
        $this->display();
    }
    public function popup(){
        $this->display();
    }
    public function subpage($id){
        $document_data = D("document")->field("title, create_time")->where("id=".$id)->find();
        $article_data = D("document_article")->field("content, author, keyword")->where("id=".$id)->find();
        $data = array_merge($document_data, $article_data);
        $data["create_time"] = date("Y-m-d H:i",$data["create_time"]);
        $this->assign("data", $data);
        $this->display();
    }
}   
?>
