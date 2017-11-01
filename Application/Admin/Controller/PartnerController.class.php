<?php
namespace Admin\Controller;
class PartnerController extends AdminController{
        public $model_id = 5;
        public $model_name = "partner";

    public function index($p="", $year=0){
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
            $map["p_year"] = $year;
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
            $this->assign("page", $page);
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

    // 增加数据
    public function add(){
           
            $model=$this->model_id;
            //获取模型信息
            
            $model = M('Model')->where(array('status' => 1))->find($model);
            $model || $this->error('模型不存在！');
            if(IS_POST){
                $model = M("partner");
              
                if($model->create() && $model->add()){
                    $this->success('添加成功！',U("partner/index"));
                } else {
                    $this->error($model->getError());
                }
            } else {
                $fields = get_model_attribute($model['id']);
                $this->assign('model', $model);
                $this->assign('fields', $fields);
                $this->meta_title = '新增'.$model['title'];
                $this->display();
            }
    }
    
    public function setStatus(){
        $model = M("Partner");
        $ids    =   I('request.ids');
        if(empty($ids)){
            $this->error('请选择要操作的数据');
        }
        $map['id'] = array('in',$ids);
        if($model->where($map)->delete()){
            $this->success("删除成功", U("index"));
        }else{
            $this->error("删除失败", U("index"));
        }
        
    }
    
    public function edit($model = null, $id = 0){
        //获取模型信息
        $model = M('Model')->find($model);
        $model || $this->error('模型不存在！');

        if(IS_POST){
            $Model  =   M("partner");
            // 获取模型的字段信息
            // $Model  =   $this->checkAttr($Model,$model['id']);
            $Model->create();
            if($Model->save()!==false){
                $this->success('保存成功！', U('index'));
            } else {
                
                $this->error("保存失败", U("index"));
            }
        } else {
            $fields     = get_model_attribute($model['id']);

            //获取数据
            $data       = M(get_table_name($model['id']))->find($id);
            $data || $this->error('数据不存在！');

            $this->assign('model', $model);
            $this->assign('fields', $fields);
            $this->assign('data', $data);
            $this->meta_title = '编辑'.$model['title'];
            $this->display($model['template_edit']?$model['template_edit']:'');
        }
    }


    public function update(){
        $res = D('Model')->update();

        if(!$res){
            $this->error(D('Model')->getError());
        }else{
            $this->success($res['id']?'更新成功':'新增成功', Cookie('__forward__'));
        }
    }
}
?>