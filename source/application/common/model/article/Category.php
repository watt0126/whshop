<?php

namespace app\common\model\article;

use think\Cache;
use app\common\library\helper;
use app\common\model\BaseModel;

/**
 * 文章分类模型
 * Class Category
 * @package app\common\model
 */
class Category extends BaseModel
{
    protected $name = 'article_category';
	
	/**
	 * 关联分类扩展字段表
	 * @return \think\model\relation\HasMany
	 */
	public function rule()
	{
	    return $this->hasMany('FieldsCategory','category_id');
	}
	/**
	 * 关联商品文章分类关系表
	 * @return \think\model\relation\HasMany
	 */
	public function caterule()
	{
		$module = self::getCalledModule() ?: 'common';
		return $this->hasOne("app\\{$module}\\model\\GoodsArticle",'article_category_id','category_id');
	}
	/**
	 * 获取所有分类
	 * @return mixed
	 */
	public static function getCacheAll()
	{
	    return self::getCacheData()['all'];
	}
	/**
	 * 获取所有分类(树状结构)
	 * @return mixed
	 */
	public static function getCacheTree()
	{
	    return self::getCacheData()['tree'];
	}
	/**
	 * 获取所有分类的总数
	 * @return mixed
	 */
	public static function getCacheCounts()
	{
	    return static::getCacheData()['counts'];
	}
	
	/**
	 * 获取缓存中的数据(存入静态变量)
	 * @param null $item
	 * @return array|mixed
	 */
	private static function getCacheData($item = null)
	{
	    static $cacheData = [];
	    if (empty($cacheData)) {
	        $static = new static;
	        $cacheData = $static->getALL();
	    }
	    if (is_null($item)) {
	        return $cacheData;
	    }
	    return $cacheData[$item];
	}
	
    /**
     * 所有分类
     * @return mixed
     */
    public static function getALL()
    {
        $model = new static;
        if (!Cache::get('article_category_' . $model::$wxapp_id)) {
			$allList = $tempList = self::getAllList();
			//dump($allList);exit;
			$complete = [
				'all' => $allList,
				'tree' => self::getTreeList($allList),
				'counts' => self::getCount($allList),
			];	
			
            Cache::tag('cache')->set('article_category_' . $model::$wxapp_id, $complete);
        }
        return Cache::get('article_category_' . $model::$wxapp_id);
    }
	
	private static function getTreeList($allList)
	{
		$treeList = [];
		foreach ($allList as $pKey => $parent) {
		    if ($parent['level'] == 1) {    // 顶级栏目
		        $treeList[$parent['category_id']] = $parent;
		        unset($allList[$pKey]);
		        foreach ($allList as $cKey => $child) {
		            if ($child['level'] == 2 && $child['parent_id'] == $parent['category_id']) {    // 二级栏目
		                $treeList[$parent['category_id']]['child'][$child['category_id']] = $child;
		                unset($allList[$cKey]);			                
		            }
		        }
		    }
		}
		return $treeList;
	}
	
	private static function getCount($allList)
	{
	    $counts = [
	        'total' => count($allList),
	        'parent' => 0,
	        'child' => 0,
	    ];
	    $level = [1 => 'parent', 2 => 'child'];
	    foreach ($allList as $item) {
	        $counts[$level[$item['level']]]++;
	    }
	    return $counts;
	}
	/**
	 * 从数据库中获取所有地区
	 * @return array
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	private static function getAllList()
	{
		$model = new static;
	    $list = $model->order(['sort' => 'asc', 'create_time' => 'asc'])->select()->toArray();
	    return helper::arrayColumn2Key($list, 'category_id');
	}
	/**
	 * 获取指定分类下的所有子分类id
	 * @param $parent_id
	 * @param array $all
	 * @return array
	 */
	public static function getSubCategoryId($parent_id, $all = [])
	{
	    $arrIds = [$parent_id];
	    empty($all) && $all = self::getALL()['all'];
	    foreach ($all as $key => $item) {
	        if ($item['parent_id'] == $parent_id) {
	            unset($all[$key]);
	            $subIds = self::getSubCategoryId($item['category_id'], $all);
	            !empty($subIds) && $arrIds = array_merge($arrIds, $subIds);
	        }
	    }
	    return $arrIds;
	}
	
	public static function detail($category_id)
	{
		return self::get($category_id, ['caterule','rule']);
	}
}
