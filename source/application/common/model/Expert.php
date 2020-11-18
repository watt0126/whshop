<?php
namespace app\common\model;

class Expert extends BaseModel
{
	protected $name = 'expert';
	
	/**
	 * 关联专家封面图
	 * @return \think\model\relation\HasOne
	 */
	public function image()
	{
	    return $this->hasOne('uploadFile', 'file_id', 'image_id');
	}
	
	/**
	 * 关联专家头像图
	 * @return \think\model\relation\HasOne
	 */
	public function avatar()
	{
	    return $this->hasOne('uploadFile', 'file_id', 'avatar_id');
	}
	
	/**
	 * 文章详情
	 * @param $expert_id
	 * @return null|static
	 * @throws \think\exception\DbException
	 */
	public static function detail($expert_id)
	{
	    return self::get($expert_id, ['avatar','image']);
	}
}