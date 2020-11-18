<?php
namespace app\common\model\article;

use app\common\model\BaseModel;
//use think\model\Pivot;

/**
 * 文章分类自定义字段模型
 * Class CategoryField
 * @package app\common\model\article
 */
class FieldsCategory extends BaseModel
{
	protected $name = 'fields_category';	
	protected $autoWriteTimestamp = true;
	protected $updateTime = false;	
	
}