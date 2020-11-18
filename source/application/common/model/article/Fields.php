<?php
namespace app\common\model\article;

use app\common\model\BaseModel;

/**
 * 文章扩展字段模型
 * Class Category
 * @package app\common\model
 */
class Fields extends BaseModel
{
	protected $name = 'fields';
	
	/**
	 * 关联文章分类表
	 * @return \think\model\relation\BelongsToMany
	 */
	public function category()
	{
	    return $this->belongsToMany('Category');
	}
	/**
	 * 关联文章分类字段关系表
	 * @return \think\model\relation\HasMany
	 */
	public function rule()
	{
		return $this->hasMany('FieldsCategory','fields_id');
	}	
	
	public function getIsRequiredAttr($value){
		$status = [0 => '否', 1=> '是'];
		return ['text' => $status[$value], 'value' => $value];
	}
	/**
	 * 验证字段是否重复
	 * @param $userName
	 * @return bool
	 */
	public static function checkExist($title)
	{
	    return !!static::useGlobalScope(false)
	        ->where('title|name', '=', $title)
	        ->value('fields_id');
	}
	public static function detail($fields_id)
	{
		return self::get($fields_id, ['rule']);
	}
}