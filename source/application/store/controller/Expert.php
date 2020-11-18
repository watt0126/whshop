<?php
namespace app\store\controller;

use app\store\model\Expert as ExpertModel;

class Expert extends Controller
{
	
	public function index()
	{
		$model = new ExpertModel;
		$list = $model->getList();
		return $this->fetch('index', compact('list'));
	}
	/**
	 * 添加专家信息
	 */
	public function add()
	{
		$model = new ExpertModel;
		if (!$this->request->isAjax()) {
			return $this->fetch('add');
		}
		// 新增记录
		if ($model->add($this->postData('expert'))) {
		    return $this->renderSuccess('添加成功', url('expert/index'));
		}
		return $this->renderError($model->getError() ?: '添加失败');
		
	}
	/**
	 * 编辑专家信息
	 * @param $expert_id
	 */
	public function edit($expert_id)
	{
		// 专家详情
		$model = (new ExpertModel)->detail($expert_id);
		if (!$this->request->isAjax()) {
			return $this->fetch('edit',compact('model'));
		}
		// 更新记录
		if ($model->edit($this->postData('expert'))) {
		    return $this->renderSuccess('更新成功', url('expert/index'));
		}
		return $this->renderError($model->getError() ?: '更新失败');
	}
	/**
	 * 获取回收站列表
	 */
	// public function recycle()
	// {
	// 	$model = new ExpertModel;
	// 	$list = $model->getRecycleList();
	// 	return $this->fetch('index', compact('list'));
	// }
	/**
	 * 删除文章
	 * @param $expert_id
	 * @return array
	 * @throws \think\exception\DbException
	 */
	public function delete($expert_id)
	{
	    // 文章详情
	    $model = ExpertModel::detail($expert_id);
	    if (!$model->remove()) {
	        return $this->renderError($model->getError() ?: '删除失败');
	    }
	    return $this->renderSuccess('删除成功');
	}
}