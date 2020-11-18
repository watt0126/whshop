<?php
namespace app\common\model;

/**
 * 商品专家模型
 * Class GoodsImage
 * @package app\common\model
 */
class GoodsExpert extends BaseModel
{
	protected $name = 'goods_expert';
	protected $updateTime = false;
	
	/**
	 * 关联专家表
	 * @return \think\model\relation\BelongsTo
	 */
	public function expert()
	{
	    return $this->belongsTo('Expert', 'expert_id', 'expert_id');
	}
}