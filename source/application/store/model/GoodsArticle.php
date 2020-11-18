<?php
namespace app\store\model;

use app\common\model\GoodsArticle as GoodsArticleModel;

class GoodsArticle extends GoodsArticleModel
{
	/**	
	 * 新增商品文章分类关系记录
	 * @param $goods_category_id
	 * @param $article_category_id
	 * @param $isUpdate
	 * @throws \Exception
	 */
	public function add($goods_category_id,$article_category_id,$isUpdate = false)
	{
		$isUpdate && $this->removeAll(['article_category_id'=>$article_category_id]);
		return $this->save([
			'goods_category_id' => $goods_category_id,
			'article_category_id' => $article_category_id,
			'wxapp_id' => self::$wxapp_id
		]);		
	}
	
	public function removeAll($filter){
		return self::destroy($filter);
	}
}