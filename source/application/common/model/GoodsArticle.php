<?php
namespace app\common\model;

class GoodsArticle extends BaseModel
{
	protected $name = 'goods_article';
	protected $autoWriteTimestamp = true;
	protected $updateTime = false;	
	
	protected $hidden = ['id','wxapp_id','create_time'];
	
	
	
}