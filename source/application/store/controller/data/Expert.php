<?php
namespace app\store\controller\data;

use app\store\controller\Controller;
use app\store\model\Expert as ExpertModel;

class Expert extends Controller
{
	/* @var \app\store\model\Expert $model */
	private $model;
	
	/**
	 * 构造方法
	 * @throws \app\common\exception\BaseException
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function _initialize()
	{
	    parent::_initialize();
	    $this->model = new ExpertModel;
	    $this->view->engine->layout(false);
	}
	
	/**
	 * 专家列表
	 * @return mixed
	 * @param string $nickName 昵称
	 * @param int $gender 性别
	 * @param int $grade 会员等级
	 * @throws \think\exception\DbException
	 */
	public function lists($expertTitle = '')
	{
	    // 专家列表
	    $list = $this->model->getList($expertTitle);
	    return $this->fetch('list', compact('list'));
	}
}