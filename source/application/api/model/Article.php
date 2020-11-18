<?php

namespace app\api\model;

use app\common\exception\BaseException;
use app\common\model\Article as ArticleModel;
use app\common\model\article\Category as CategoryModel;

/**
 * 商品评价模型
 * Class Article
 * @package app\api\model
 */
class Article extends ArticleModel
{
    /**
     * 追加字段
     * @var array
     */
    protected $append = [
        'show_views',
        'view_time',		
    ];

    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'is_delete',
        'wxapp_id',
        'create_time',
        'update_time'
    ];

    /**
     * 文章详情：HTML实体转换回普通字符
     * @param $value
     * @return string
     */
    public function getArticleContentAttr($value)
    {
        return htmlspecialchars_decode($value);
    }

    public function getViewTimeAttr($value, $data)
    {
        return date('Y-m-d', $data['create_time']);
    }
	/**
	 * 获取文章列表
	 * @return \think\Paginator
	 * @throws \think\exception\DbException
	 */
	public function getLists($filter,$limit = 1)
	{
		return $this->with(['image', 'category', 'user'])
		    ->where('is_delete', '=', 0)
			->where($filter)
		    ->order(['article_sort' => 'asc', 'create_time' => 'desc'])
		    ->limit($limit)
			->select();
			
	}
	//获取当前文章分类下的关联商品分类
	public static function getArtGoodsCate($category_id){		
		$detail = CategoryModel::detail($category_id);
		$param['category_id'] = $detail['caterule']['goods_category_id'];
		return $param;
	}
    /**
     * 文章详情
     * @param $article_id
     * @return ArticleModel|null
     * @throws BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public static function detail($article_id)
    {
        if (!$model = parent::detail($article_id)) {
            throw new BaseException(['msg' => '文章不存在']);
        }
        // 累积阅读数
        $model->setInc('actual_views', 1);
        return $model;
    }
	

}