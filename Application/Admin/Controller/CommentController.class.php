<?php

namespace Admin\Controller;

/*
*后台评论管理控制器
*@author 徐炜 <m18768185752@163.com>
*/
class CommentController extends AdminController{
    public $model_id = 4;
    public $model_name = "comment";

    /*
    *评论管理首页
    *@author
    */
    public function index($module=3){
        
        $model=$this->model_name;
        $model || $this->error('模型名标识必须！');
       
        $page = intval($p);
     
        $page = $page ? $page : 1; //默认显示第一页数据

         //获取模型信息
            $model = M('Model')->getByName($model);
            $model || $this->error('模型不存在！');

            //解析列表规则
            $fields = array();
            $grids  = preg_split('/[;\r\n]+/s', trim($model['list_grid']));
       
            foreach ($grids as &$value) {
                if(trim($value) === ''){
                    continue;
                }
                // 字段:标题:链接
                $val      = explode(':', $value);
                // 支持多个字段显示
                $field   = explode(',', $val[0]);
                $value    = array('field' => $field, 'title' => $val[1]);
                if(isset($val[2])){
                // 链接信息
                    $value['href']	=	$val[2];
                // 搜索链接信息中的字段信息
                    preg_replace_callback('/\[([a-z_]+)\]/', function($match) use(&$fields){$fields[]=$match[1];}, $value['href']);
                }
                if(strpos($val[1],'|')){
                // 显示格式定义
                    list($value['title'],$value['format'])    =   explode('|',$val[1]);
                }
                foreach($field as $val){
                    $array	=	explode('|',$val);
                    $fields[] = $array[0];
                }
            }
        // 过滤重复字段信息
            $fields =   array_unique($fields);
        // 关键字搜索
            $map	=	array();
            $module = intval($module);
            if($module === 3 || $module === 2){
                $map["status"] = array("neq","-1");
            }
            if($module === 1){
                $map["status"] = array("eq", 1);
            }
            if($module === 0){
                $map["status"] = array("eq", 0);
            }
            $map["pid"] = array("eq", 0);
            $key	=	$model['search_key']?$model['search_key']:'title';
            if(isset($_REQUEST[$key])){
                $map[$key]	=	array('like','%'.$_GET[$key].'%');
                unset($_REQUEST[$key]);
            }
            // 条件搜索
            foreach($_REQUEST as $name=>$val){
                if(in_array($name,$fields)){
                    $map[$name]	=	$val;
                }
            }
            $row    = empty($model['list_row']) ? 10 : $model['list_row'];

            //读取模型数据列表
            if($model['extend']){
                $name   = get_table_name($model['id']);
                $parent = get_table_name($model['extend']);
                $fix    = C("DB_PREFIX");

                $key = array_search('id', $fields);
                if(false === $key){
                    array_push($fields, "{$fix}{$parent}.id as id");
                } else {
                    $fields[$key] = "{$fix}{$parent}.id as id";
                }

                /* 查询记录数 */
                $count = M($parent)->join("INNER JOIN {$fix}{$name} ON {$fix}{$parent}.id = {$fix}{$name}.id")->where($map)->count();

            // 查询数据
                $data   = M($parent)
                ->join("INNER JOIN {$fix}{$name} ON {$fix}{$parent}.id = {$fix}{$name}.id")
                /* 查询指定字段，不指定则查询所有字段 */
                ->field(empty($fields) ? true : $fields)
                // 查询条件
                ->where($map)
                /* 默认通过id逆序排列 */
                ->order("{$fix}{$parent}.id DESC")
                /* 数据分页 */
                ->page($page, $row)
                /* 执行查询 */
                ->select();

            } else {
                if($model['need_pk']){
                    in_array('id', $fields) || array_push($fields, 'id');
                }
                $name = parse_name(get_table_name($model['id']), true);
                $data = M($name)
                /* 查询指定字段，不指定则查询所有字段 */
                ->field(empty($fields) ? true : $fields)
                // 查询条件
                ->where($map)
                /* 默认通过id逆序排列 */
                ->order($model['need_pk']?'id DESC':'')
                /* 数据分页 */
                ->page($page, $row)
                /* 执行查询 */
                ->select();

                /* 查询记录总数 */
                $count = M($name)->where($map)->count();
            }

        //分页
            if($count > $row){
                $page = new \Think\Page($count, $row);
                $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
                $this->assign('_page', $page->show());
            }

            $data   =   $this->parseDocumentList($data,$model['id']);
            $this->assign('model', $model);
            $this->assign('list_grids', $grids);
            $this->assign('list_data', $data);
            $this->meta_title = $model['title'].'列表';
            $this->display();
    }

    /*
    *更改评论状态评论
    *-1：已删除 1：已通过审核 0:已屏蔽
    */
    public function setStatus($ids=null, $status=null){
        $model = M($this->model_name);
        $model || $this->error("模型不存在");

        if(is_array($ids)){
            $ids = array_unique( (array)I("ids", 0));
            if(empty($ids) || $ids[0] == 0){
                $this->error("请选择要操作的数据！");
            }
            $map = array("id" => array("in", $ids));
        }else{
            $map = array("id" => $ids);
        }
      
        $result=$model->where($map)->save(array("status" => $status));
        
        switch($status){
            case 1:
                $msg_success = "审核通过";
                $msg_error = "审核失败";
                break;
            case 0:
                $msg_success = "屏蔽成功";
                $msg_error = "屏蔽失败";
                break;
            case -1:
                $msg_success = "删除成功";
                $msg_error = "删除失败";
                break;
        }


        if($result){
            $this->success($msg_success);
        }else{
            $this->error($msg_error);
        }
      
    }

    /*
    *查看回复
    */
    public function viewRes($pid=null){
        $model = M($this->model_name);
        $model || $this->error("模型不存在");
        if(!$pid){
            $this->error("请选择要操作的数据");
        }
        // 筛选条件
        $map["pid"] = array("eq", $pid);
        $map["status"] = array("neq", -1);

        $data = $model->where($map)->select();
        // header("content-type:text/html; charset=utf8;");
        // var_dump($data);
        // die();
        $this->assign("data", $data);
        $this->display();
    }

    /*
    *新增实习生资料
    */
    public function add(){
        //获取左边菜单
        $this->getMenu();

        $cate_id    =   I('get.cate_id',0);
        $model_id   =   I('get.model_id',0);
		$group_id	=	I('get.group_id','');

        empty($cate_id) && $this->error('参数不能为空！');
        empty($model_id) && $this->error('该分类未绑定模型！');

        //检查该分类是否允许发布
        $allow_publish = check_category($cate_id);
        !$allow_publish && $this->error('该分类不允许发布内容！');

        // 获取当前的模型信息
        $model    =   get_document_model($model_id);

        //处理结果
        $info['pid']            =   $_GET['pid']?$_GET['pid']:0;
        $info['model_id']       =   $model_id;
        $info['category_id']    =   $cate_id;
		$info['group_id']		=	$group_id;

        if($info['pid']){
            // 获取上级文档
            $article            =   M('Document')->field('id,title,type')->find($info['pid']);
            $this->assign('article',$article);
        }

        //获取表单字段排序
        $fields = get_model_attribute($model['id']);
        $this->assign('info',       $info);
        $this->assign('fields',     $fields);
        $this->assign('type_list',  get_type_bycate($cate_id));
        $this->assign('model',      $model);
        $this->meta_title = '新增'.$model['title'];
        $this->display();
    }
}

?>