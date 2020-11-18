<?php

namespace app\api\controller;

use app\api\model\Goods as GoodsModel;
use app\api\model\Category as CategoryModel;
use app\api\model\Cart as CartModel;
use app\api\model\Article as ArticleModel;
use app\common\service\qrcode\Goods as GoodsPoster;


/**
 * 商品控制器
 * Class Goods
 * @package app\api\controller
 */
class Goods extends Controller
{
    /**
     * 商品列表
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function lists()
    {
        // 整理请求的参数
        $param = array_merge($this->request->param(), [
            'status' => 10
        ]);
		// 分类数据	
		$category = CategoryModel::getSubCategory($param['category_id']);
        // 获取列表数据
        $model = new GoodsModel;
        $list = $model->getList($param, $this->getUser(false));
        return $this->renderSuccess(compact('list','category'));
    }

    /**
     * 获取商品详情
     * @param $goods_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function detail($goods_id)
    {
        // 用户信息
        $user = $this->getUser(false);
        // 商品详情
        $model = new GoodsModel;
        $goods = $model->getDetails($goods_id, $this->getUser(false));
		//dump($goods->toArray());exit;
        if ($goods === false) {
            return $this->renderError($model->getError() ?: '商品信息不存在');
        }
		
        // 多规格商品sku信息, todo: 已废弃 v1.1.25
        $specData = $goods['spec_type'] == 20 ? $model->getManySpecData($goods['spec_rel'], $goods['sku']) : null;
        
		// 获取当前分类关联的案例分类ids
		$artCategoryIds = [];
		foreach($goods['category']['rule'] as $v){
			$artCategoryIds[] = $v['article_category_id'];
		}
		$filter = ['category_id' => ['in', $artCategoryIds]];
		$depCase = (new ArticleModel)->getLists($filter);		
		$artCategoryParentId = $depCase[0]['category']['parent_id'];
		return $this->renderSuccess([
            // 商品详情
            'detail' => $goods,
			// 相关案例
			'depCase' => $depCase,
            // 购物车商品总数量
            'cart_total_num' => $user ? (new CartModel($user))->getGoodsNum() : 0,
            // 多规格商品sku信息
            'specData' => $specData,
			// 相关案例的上级分类
			'art_parent_id' => $artCategoryParentId,
					
        ]);
    }

    /**
     * 生成商品海报
     * @param $goods_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     * @throws \Exception
     */
    public function poster($goods_id)
    {
        // 商品详情
        $detail = GoodsModel::detail($goods_id);
        $Qrcode = new GoodsPoster($detail, $this->getUser(false));
        return $this->renderSuccess([
            'qrcode' => $Qrcode->getImage(),
        ]);
    }

}
