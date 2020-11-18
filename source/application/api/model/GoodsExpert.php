<?php
namespace app\api\model;

use app\common\model\GoodsExpert as GoodsExpertModel;
/**
 * 商品专家模型
 * Class GoodsExpert
 * @package app\api\model
 */
class GoodsExpert extends GoodsExpertModel
{
	/**
	 * 隐藏字段
	 * @var array
	 */
	protected $hidden = [
	    'wxapp_id',
	    'create_time',
	];
}