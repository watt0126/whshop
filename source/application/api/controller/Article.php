<?php
namespace app\api\controller;

use app\api\model\Article as ArticleModel;
use app\api\model\article\Category as CategoryModel;
use app\common\model\Goods as GoodsModel;

/**
 * 文章控制器
 * Class Article
 * @package app\api\controller
 */
class Article extends Controller
{
    /**
     * 文章首页
     * @return array
     */
    public function index()
    {
        // 文章分类列表
        $categoryList = array_values(CategoryModel::getCacheAll());
        return $this->renderSuccess(compact('categoryList'));
    }	
	
    /**
     * 文章列表
     * @param int $category_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function lists()
    {		
        $model = new ArticleModel;
        $list = $model->getList($this->request->param());
		
        return $this->renderSuccess(compact('list'));
    }
	/**
	 * 用户案例列表为你推荐商品
	 * @return array
	 * @throws \think\exception\DbException
	 */
	public function usergoodslists()
	{
		$model = new ArticleModel;
		$list = $model->getGoodsList($goodIds);		
		return $this->renderSuccess(compact('list'));
	}
    /**
     * 文章详情
     * @param $article_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function detail($article_id)
    {
        $detail = ArticleModel::detail($article_id);
		$comlists = (new GoodsModel)->getListByIds(explode(',',$detail['goods_id']),$status = 10);
			
		$goodscateid = ArticleModel::getArtGoodsCate($detail['category_id']);
		$dependlists = (new GoodsModel)->getList($goodscateid);
        return $this->renderSuccess(compact('detail', 'comlists','dependlists'));
    }

}
