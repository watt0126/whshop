<?php
namespace app\store\model;

use app\common\model\Expert as ExpertModel;

class Expert extends ExpertModel
{
	/**
	 * 获取专家列表
	 * @return \think\Paginator
	 * @throws \think\exception\DbException
	 */
	public function getList($expertTitle='')
	{
		// 检索：专家名字
		!empty($expertTitle) && $this->where('expert_title', 'like', "%$expertTitle%");
	    return $this->with(['image'])
	        ->where('is_delete', '=', 0)
	        ->order(['expert_sort' => 'asc', 'create_time' => 'desc'])
	        ->paginate(15, false, [
	            'query' => request()->request()
	        ]);
	
	}
	/**
	 * 获取回收站列表
	 * @return \think\Paginator
	 * @throws \think\exception\DbException
	 */
	// public function getRecycleList()
	// {
	// 	return $this->with(['image'])
	// 	    ->where('is_delete', '=', 1)
	// 	    ->order(['expert_sort' => 'asc', 'create_time' => 'desc'])
	// 	    ->paginate(15, false, [
	// 	        'query' => request()->request()
	// 	    ]);
	// }
	/**
	 * 添加专家信息
	 * @param $data
	 * @return false|int
	 */
	public function add($data)
	{
		if (empty($data['image_id'])) {
		    $this->error = '请上传封面图';
		    return false;
		}
		if (empty($data['expert_content'])) {
		    $this->error = '请输入专家简介';
		    return false;
		}
		$this->startTrans();
		try{
			$data['wxapp_id'] = self::$wxapp_id;
			$this->allowField(true)->save($data);
			$this->commit();
			return true;
		}catch (\Exception $e) {
		    $this->error = $e->getMessage();
		    $this->rollback();
		    return false;
		}
	}
	/**
	 * 编辑专家信息
	 * @param $data
	 */
	public function edit($data)
	{
		if (empty($data['image_id'])) {
		    $this->error = '请上传封面图';
		    return false;
		}
		if (empty($data['expert_content'])) {
		    $this->error = '请输入专家简介';
		    return false;
		}
		$this->startTrans();
		try {
		    // 更新文章记录
		    $this->allowField(true)->save($data);
		    $this->commit();
		    return true;
		} catch (\Exception $e) {
		    $this->error = $e->getMessage();
		    $this->rollback();
		    return false;
		}
	}
	/**
	 * 软删除
	 * @return false|int
	 */
	public function setDelete()
	{
	    return $this->save(['is_delete' => 1]);
	}
	
	public function remove()
	{
		return $this->delete();
	}
}