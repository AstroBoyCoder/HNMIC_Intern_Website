<?php
namespace Home\Controller;
use OT\DataDictionary;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class ExperienceController extends HomeController {

	//系统首页
    public function index(){
        $this->display();
    }

    public function catalog($id){
        $station = array("随笔", "客户经理实习生", "运营管理实习生","前端实习生", "后端实习生", "UI实习生", "项目管理实习生");
        $article_data = D("document_article")->field("id, author")->where("exp_station=".$id)->select();
        // // $sql="select d.*,da.id as daid,da.content from mic_document as d inner join mic_document_article as da on da.id=d.id where da.exp_station='".$id."'";
        // // $result=M("document")->query($sql);
        // var_dump($result);exit;
        $ids = [];
        foreach($article_data as $key=>$val){
            $ids[] = $val["id"];
        }
        if(count($ids) !== 0){
            //条件
            $map["id"] = array("in", $ids);
            // $map["id"] = 5;
            
            $document_data = M("document")->field("id, title, create_time")->where($map)->select();
              // $document_data = D("document")->field("id, title, create_time")->where($map)->select();
            //合并数据
            $data = [];
            foreach($document_data as $key=>$val){
                $document_data[$key]["create_time"] = date("Y-m-d", $val["create_time"]);
                $data[] = array_merge($article_data[$key], $document_data[$key]);
            }
            $this->assign("data", $data);
            $this->assign("station", $station[$id]);
        }
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
