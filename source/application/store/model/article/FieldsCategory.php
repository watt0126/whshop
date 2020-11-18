<?php
namespace app\store\model\article;

use app\common\model\article\FieldsCategory as FieldsCategoryModel;
use app\common\model\BaseModel;

/**
 * 文章分类自定义字段模型
 * Class CategoryField
 * @package app\common\model\article
 */
class FieldsCategory extends FieldsCategoryModel
{
	/**
	 * 新增关系记录
	 * @param {Object} $field_id
	 * @param {Object} $categroyIds
	 */
	public function add($fields_id, $categroyIds)
	{
		$data = [];
		foreach ($categroyIds as $category_id) {
		    $data[] = [
		        'fields_id' => $fields_id,
		        'category_id' => $category_id,
		        'wxapp_id' => BaseModel::$wxapp_id,
		    ];
		}
		return $this->saveAll($data);
	}
	/**
	 * 更新关系记录
	 * @param $store_user_id
	 * @param array $newRole 新的角色集
	 * @return array|false
	 * @throws \Exception
	 */
	public function edit($fields_id, $newCategroy)
	{
		// 已分配的分类集合
		$assignCategroyIds = self::getCategoryIds($fields_id);
		/**
		 * 找出删除的分类
		 * 假如已有的分类集合是A，界面传递过得分类集合是B
		 * 分类集合A当中的某个分类不在分类集合B当中，就应该删除
		 * 使用 array_diff() 计算补集
		 */
		if ($deleteCategroyIds = array_diff($assignCategroyIds, $newCategroy)) {
		    self::deleteAll(['fields_id' => $fields_id, 'category_id' => ['in', $deleteCategroyIds]]);
		}
		/**
		 * 找出添加的分类
		 * 假如已有的分类集合是A，界面传递过得分类集合是B
		 * 分类集合B当中的某个分类不在分类集合A当中，就应该添加
		 * 使用 array_diff() 计算补集
		 */
		$newCategroyIds = array_diff($newCategroy, $assignCategroyIds);
		$data = [];
		foreach ($newCategroyIds as $category_id) {
		    $data[] = [
		        'fields_id' => $fields_id,
		        'category_id' => $category_id,
		        'wxapp_id' => BaseModel::$wxapp_id,
		    ];
		}
		return $this->saveAll($data);
	}
	/**
	 * 获取指定自定义字段的所有分类id
	 * @param $field_id
	 * @return array
	 */
	public static function getCategoryIds($fields_id)
	{
	    return (new self)->where(compact('fields_id'))->column('category_id');
	}
	/**
	 * 获取指定文章分类下的自定义字段集
	 * @param {Object} $category_id
	 * @return array
	 */
	public static function getFieldIds($category_id){
		
		return (new self)->where(compact('category_id'))->column('fields_id');
	}
	/**
	 * 获取总数
	 */
	public static function getCategoryTotal($where = [])
	{
		$model = new static;
		return $model->where($where)->count();
	}
	/**
	 * 删除记录
	 * @param $where
	 * @return int
	 */
	public static function deleteAll($where)
	{
	    return self::destroy($where);
	}
}