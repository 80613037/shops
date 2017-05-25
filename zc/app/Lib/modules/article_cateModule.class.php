<?php
// +----------------------------------------------------------------------
// | easethink 易想团购商城系统
// +----------------------------------------------------------------------
// | Copyright (c) 2011 http://www.easethink.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 云淡风轻(88522820@qq.com)
// +----------------------------------------------------------------------
require APP_ROOT_PATH.'app/Lib/shop_lip.php';
require APP_ROOT_PATH.'app/Lib/page.php';
class article_cateModule extends BaseModule
{
	//文章列表
	public function index()
	{	
		$id=intval($_REQUEST['id']);
		$GLOBALS['tmpl']->assign("page_title","文章列表");
		//改写
        $g_links =get_link_by_id(14);
        $GLOBALS['tmpl']->assign("g_links",$g_links);
		$GLOBALS['tmpl']->caching = true;
		$artilce_cate = load_auto_cache("article_cates"); 
		$type_id=0;
		$cate_name='';

		foreach($artilce_cate as $k=>$v)
		{
 			$artilce_cate[$k]['cate_id']=$v['id'];
 			$artilce_cate[$k]['titles']=$v['title'];
 			if($id>0&&$v['id']==$id){
 				$type_id=intval($v['type_id']);
 				$cate_name=$v['title'];
 			}
 			if($id==$artilce_cate[$k]['cate_id'])
 			{
 				$artilce_cate[$k]['current']=1;
 			}

		}
		$GLOBALS['tmpl']->assign("cate_name",$cate_name);
		$GLOBALS['tmpl']->assign("artilce_cate",$artilce_cate);
		
		
		//分页
		$page_size = DEALUPDATE_PAGE_SIZE;
		$page = intval($_REQUEST['p']);
		if($page==0)
		$page = 1;
		$limit = (($page-1)*$page_size).",".$page_size;
		//条件判断
		$where='1=1 and a.is_delete=0 and a.is_effect=1 ';
		if($id>0){
			$where.=' and c.type_id='.$type_id.'  and a.cate_id='.$id;
		}else{
			$where.=' and c.type_id=0 ';
		}
		$temp_artilce_list = $GLOBALS['db']->getAllCached("SELECT a.*,c.type_id,c.title as cate_name from ".DB_PREFIX."article a LEFT JOIN ".DB_PREFIX."article_cate c on a.cate_id=c.id where $where order by a.update_time desc limit $limit");
		$temp_artilce_count = $GLOBALS['db']->getOne("select COUNT(*) from ".DB_PREFIX."article a,".DB_PREFIX."article_cate c WHERE a.cate_id=c.id and a.is_delete=0 AND a.is_effect=1 and c.type_id=0");
		  
 		$hot_article=array();
		$week_article=array();
		$artilce_item=array();
		foreach($temp_artilce_list as $k=>$v)
		{ 
			//最新智能头条type_id==0普通文章, type_id==1帮助文章，is_hot==1热门，is_week==1本周必读
			if($v['id']>0){
				$artilce_item[$k]['cate_title']=$v['title'];
				$artilce_item[$k]['seo_keyword']=$v['seo_keyword'];
				$artilce_item[$k]['title']=$v['title'];
				$artilce_item[$k]['content']=$v['content'];
				$artilce_item[$k]['update_time']=$v['update_time'];
				
				$artilce_item[$k]['cate_name']=$v['cate_name'];
				$artilce_item[$k]['cate_url']=url('article_cate',array('id'=>$v['cate_id']));
				if($v['rel_url']=="")
 					$artilce_item[$k]['url']=url('article',array('id'=>$v['id']));
				else
					$artilce_item[$k]['url']=$v['rel_url'];
					
			}
			
 		}
 	
 		
 		$page = new Page(intval($temp_artilce_count),$page_size);   //初始化分页对象 		
		$p  =  $page->show();
		$GLOBALS['tmpl']->assign('pages',$p);
		
 		unset($temp_artilce_list);
 		//文章头部导航
  		$nav_top=set_nav_top($GLOBALS['module'],$GLOBALS['action'],$id);
  		$GLOBALS['tmpl']->assign('nav_top',$nav_top);
  		$GLOBALS['tmpl']->assign("id",$id);
		$GLOBALS['tmpl']->assign("artilce_list",$artilce_item);
		$GLOBALS['tmpl']->assign('deal_type','article_type');
		$GLOBALS['tmpl']->display("article_cate.html");
	}
}
?>