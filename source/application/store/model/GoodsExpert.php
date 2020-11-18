<?php
namespace app\store\model;

use app\common\model\GoodsExpert as GoodsExpertModel;
/**
 * 商品专家模型
 * Class GoodsExpert
 * @package app\store\model
 */
class GoodsExpert extends GoodsExpertModel
{
	/**
	 * 移除指定商品的所有专家
	 * @param $goods_id
	 * @return int
	 */
	public function removeAll($goods_id)
	{
	    $model = new GoodsExpertModel;
	    $model->where('goods_id','=', $goods_id)->delete();
	    return $this->where('goods_id','=', $goods_id)->delete();
	}
}