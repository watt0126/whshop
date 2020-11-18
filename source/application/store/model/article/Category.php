<?php

namespace app\store\model\article;

use think\Cache;
use app\store\model\Article as ArticleModel;
use app\common\model\article\Category as CategoryModel;
use app\store\model\article\FieldsCategory as FieldsCategoryModel;
use app\store\model\article\Fields as FieldsModel;
use app\store\model\GoodsArticle as GoodsArticleModel;

/**
 * 文章分类模型
 * Class Category
 * @package app\store\model\article
 */
class Category extends CategoryModel
{
	/**
	 * 获取分类列表
	 * @throws \think\Exception
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function getList()
	{
	    $all = static::getCacheAll();
		//dump($all);exit;
	    return $this->formatTreeData($all);
	}   

    /**
     * 添加新记录
     * @param $data
     * @return false|int
     */
    public function add($data)
    {        
		$this->startTrans();
		try {
		    $data['wxapp_id'] = self::$wxapp_id;
		    $data['level'] = $data['parent_id'] == 0 ? '1' : '2';
		    $this->deleteCache();			
		    $this->allowField(true)->save($data);
		    // 新增商品案例关系
		    (new GoodsArticleModel)->add($data['goods_category_id'],$this['category_id']);
		    $this->commit();
		    return true;
		} catch (\Exception $e) {
		    $this->error = $e->getMessage();
		    $this->rollback();
		    return false;
		}
        //return $this->allowField(true)->save($data);
    }

    /**
     * 编辑记录
     * @param $data
     * @return bool|int
     */
    public function edit($data)
    {
		$this->startTrans();
		try {
			$this->deleteCache();
			$this->allowField(true)->save($data);
			(new GoodsArticleModel)->add($data['goods_category_id'], $this['category_id'],true);
			$this->commit();
		    return true;
		} catch (\Exception $e) {
		    $this->error = $e->getMessage();
		    $this->rollback();
		    return false;
		}
		// return $this->allowField(true)->save($data);
    }
    /**
     * 删除商品分类
     * @param $category_id
     * @return bool|int
     */
    public function remove($category_id)
    {
        // 判断是否存在文章
        $articleCount = ArticleModel::getArticleTotal(['category_id' => $category_id]);
        if ($articleCount > 0) {
            $this->error = '该分类下存在' . $articleCount . '个文章，不允许删除';
            return false;
        }
        $this->deleteCache();
        return $this->delete();
    }	
	
	/**
	 * 获取分类列表
	 * @param $all
	 * @param int $parent_id
	 * @param int $deep
	 * @return array
	 */
	private function formatTreeData(&$all, $parent_id = 0, $deep = 1)
	{
	    static $tempTreeArr = [];
	    foreach ($all as $key => $val) {
	        if ($val['parent_id'] == $parent_id) {
	            // 记录深度
	            $val['deep'] = $deep;
	            // 根据角色深度处理名称前缀
	            $val['name_h1'] = $this->htmlPrefix($deep) . $val['name'];
	            $tempTreeArr[] = $val;
	            $this->formatTreeData($all, $val['category_id'], $deep + 1);
	        }
	    }
	    return $tempTreeArr;
	}
	private function htmlPrefix($deep)
	{
	    // 根据角色深度处理名称前缀
	    $prefix = '';
	    if ($deep > 1) {
	        for ($i = 1; $i <= $deep - 1; $i++) {
	            $prefix .= '&nbsp;&nbsp;&nbsp;├ ';
	        }
	        $prefix .= '&nbsp;';
	    }
	    return $prefix;
	}
    /**
     * 删除缓存
     * @return bool
     */
    private function deleteCache()
    {
        return Cache::rm('article_category_' . self::$wxapp_id);
    }
	
}
