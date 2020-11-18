<?php
namespace app\store\model\article;

use app\common\model\article\Fields as FieldsModel;
use app\store\model\article\FieldsCategory as FieldsCategoryModel;

/**
 * 自定义字段扩展模型
 * class Fields
 * @package app\store\model\article
 */
class Fields extends FieldsModel
{
	
	/**
	 * 获取自定义字段列表
	 * @return \think\Paginator
	 * @throws \think\exception\DbException
	 */
	public function getList()
	{
	    return $this->with('rule')->order(['create_time' => 'desc'])
	        ->paginate(15, false, [
	            'query' => \request()->request()
	        ]);
	}	
	
	/**
	 * 新增记录
	 * @param $data
	 * @return bool|false|int
	 * @throws \think\exception\DbException
	 */
	public function add($data)
	{
		if (self::checkExist($data['title'])) {
		    $this->error = '字段标题已存在';
		    return false;
		}
		if (self::checkExist($data['name'])) {
		    $this->error = '字段名称已存在';
		    return false;
		}
		if (empty($data['category_id'])) {
		    $this->error = '请选择文章分类';
		    return false;
		}
		$this->startTrans();
		try {
		    // 新增自定义字段记录
		    $data['wxapp_id'] = self::$wxapp_id;
			
		    $this->allowField(true)->save($data);
		    // 新增角色关系记录
		    (new FieldsCategoryModel)->add($this['fields_id'], explode(',',$data['category_id']));
		    $this->commit();
		    return true;
		} catch (\Exception $e) {
		    $this->error = $e->getMessage();
		    $this->rollback();
		    return false;
		}
	}
	/**
	 * 更新记录
	 * @param $data
	 * @return bool|false|int
	 * @throws \think\exception\DbException
	 */
	public function edit($data)
	{
		//dump($data);exit;
		$this->startTrans();
		try {
		    // 更新自定义字段记录
		    $this->allowField(true)->save($data);
		    // 更新角色关系记录
		    (new FieldsCategoryModel)->edit($this['fields_id'], explode(',',$data['category_id']));
		    $this->commit();
		    return true;
		} catch (\Exception $e) {
		    $this->error = $e->getMessage();
		    $this->rollback();
		    return false;
		}
	}
	public function getFields($fieldIds)
	{
		$model = new static;
		$data = $model->where(['fields_id'=>['in',$fieldIds]])->order(['sort' => 'asc', 'create_time' => 'asc'])->select();
		$fields = !empty($data) ? $data->toArray() : [];		
		return $fields;
	}
	
	/**
	 * 获取配送区域及运费设置项
	 * @return array
	 */
	public function getFormList($fields_id)
	{
	    // 所有栏目
	    $categorys = Category::getCacheAll();
		//dump($categorys);
		$categoryIds = FieldsCategory::getCategoryIds($fields_id);
		//dump($categoryIds);exit;
	    $list = [];
		$parent = [];
		foreach ($categoryIds as $categoryId) {
			if (!isset($categorys[$categoryId])) continue;
			!in_array($categorys[$categoryId]['parent_id'], $parent) 
			&& $parent[] = $categorys[$categoryId]['parent_id'];
		}
		$list[]= [
			'parents' => $parent,
			'childs' => $categoryIds,
		];
		
	    return $list;
	}
	/**
	 * 删除记录
	 * @return bool|int
	 */
	public function remove()
	{
		// 删除字段分类关系表记录
		CategoryFieldModel::deleteAll(['fields_id'=>$this['fields_id']]);	
		// 删除字段记录
		return $this->delete();			
	}	
}