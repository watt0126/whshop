<?php
namespace app\store\controller\content\article;

use app\store\controller\Controller;

use app\store\model\article\Category as CategoryModel;
use app\store\model\article\Fields as FieldsModel;
use app\store\model\article\FieldsCategory as FieldsCategoryModel;

/**
 * 自定义字段扩展
 * class Fields
 * @package app\store\controller\content
 */
class Fields extends Controller
{
	/**
	 * 自定义字段列表
	 */
	public function index()
	{
		$model = new FieldsModel;
		$list = $model->getList();
		return $this->fetch('index',compact('list'));
	}
	/**
	 * 新增记录
	 * @return bool
	 * @throws \think\exception\DbException
	 */
	public function add()
	{
		$model = new FieldsModel;
		if(!$this->request->isAjax()){
			// $categoryAll = array_values(CategoryModel::getCacheAll());
			// dump($categoryAll);
			// $all = CategoryModel::getApiALL();
			// dump($all);exit;
			// 获取所有栏目
			$categoryData = json_encode(CategoryModel::getCacheTree());
			// 二级栏目总数
			$childCount = CategoryModel::getCacheCounts()['child'];
			//dump($childCount);exit;
			return $this->fetch('add',compact('categoryData','childCount'));
		}
		if($model->add($this->postData('fields'))){
			return $this->renderSuccess('添加成功', url('content.article.fields/index'));
		}
		return $this->renderError($model->getError() ?: '添加失败');
		
	}
	/**
	 * 更新记录
	 * @param array $field_id
	 * @return bool
	 * @throws \think\exception\DbException
	 */
	public function edit($fields_id)
	{
		$model = FieldsModel::detail($fields_id);
		if(!$this->request->isAjax()){
			// 获取所有栏目
			$categoryData = json_encode(CategoryModel::getCacheTree());
			// 二级栏目总数
			$childCount = CategoryModel::getCacheCounts()['child'];
			// 获取所属栏目
			$formData = json_encode($model->getFormList($fields_id));
			return $this->fetch('add',compact('model','categoryData','childCount','formData'));
		}
		if($model->edit($this->postData('fields'))){
			return $this->renderSuccess('更新成功', url('content.article.fields/index'));
		}
		return $this->renderError($model->getError() ?: '更新失败');
	}
	/**
	 * 删除记录
	 * @param {Object} $field_id
	 */
	public function delete($fields_id)
	{
		$model = FieldsModel::detail($fields_id);
		if (!$model->remove()) {
		    return $this->renderError($model->getError() ?: '删除失败');
		}
		return $this->renderSuccess('删除成功');
	}
}