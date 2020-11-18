<?php
namespace app\common\model;
use app\common\model\article\Category as CategoryModel;

/**
 * 文章模型
 * Class Article
 * @package app\common\model
 */
class Article extends BaseModel
{
    protected $name = 'article';
    protected $append = ['show_views'];

    /**
     * 关联文章封面图
     * @return \think\model\relation\HasOne
     */
    public function image()
    {
        return $this->hasOne('uploadFile', 'file_id', 'image_id');
    }
	/**
	 * 关联用户
	 * @return \think\model\relation\HasOne
	 */
	public function user()
	{
	    return $this->hasOne('User', 'user_id', 'user_id');
	}
    /**
     * 关联文章分类表
     * @return \think\model\relation\BelongsTo
     */
    public function category()
    {
        $module = self::getCalledModule() ?: 'common';
        return $this->BelongsTo("app\\{$module}\\model\\article\\Category");
    }
	
	
    /**
     * 展示的浏览次数
     * @param $value
     * @param $data
     * @return mixed
     */
    public function getShowViewsAttr($value, $data)
    {
        return $data['virtual_views'] + $data['actual_views'];
    }
	/**
	 * 自定义附加字段转换
	 * @param $value
	 * @param $data
	 */
	public function getMoreAttr($value,$data)
	{
		return ['self_field'=>json_decode($data['more'],true)];
	}
	/**
	 * 获取文章列表
	 * @return \think\Paginator
	 * @throws \think\exception\DbException
	 */
	public function getList($query = [],$limit = 15)
	{
		!empty($query) && $this->setWhere($query);
	    return $this->with(['image', 'category', 'user'])
	        ->where('is_delete', '=', 0)
	        ->order(['article_sort' => 'asc', 'create_time' => 'desc'])
	        ->paginate($limit, false, [
	            'query' => request()->request()
	        ]);
	}
	
	
    /**
     * 文章详情
     * @param $article_id
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($article_id)
    {
        return self::get($article_id, ['image', 'category','user']);
    }
	
	
	/**
	 * 设置检索查询条件
	 * @param $query
	 */
	private function setWhere($query)
	{
	    if (isset($query['search']) && !empty($query['search'])) {
	        $this->where('article_title', 'like', '%' . trim($query['search']) . '%');
	    }
	    if (isset($query['category_id']) && !empty($query['category_id'])) {
	        $query['category_id'] > -1 && $this->where('category_id', 'in', CategoryModel::getSubCategoryId($query['category_id']));
	    }
		// 文章显示隐藏
		if (isset($query['article_status'])) {
			$this->where('article_status', '=', (int)$query['article_status']);
		}		
	    // 用户id
	    if (isset($query['user_id']) && $query['user_id'] > 0) {
	        $this->where('user_id', '=', (int)$query['user_id']);
	    }
		// 文章推荐
		if (isset($query['commend']) && $query['commend'] > -1) {
			$this->where('commend', '=', (int)$query['commend']);
		}
		// 文章精选
		if (isset($query['choice']) && $query['choice'] > -1) {
			$this->where('choice', '=', (int)$query['choice']);
		}
	}

}
