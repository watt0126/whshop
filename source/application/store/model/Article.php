<?php

namespace app\store\model;

use app\common\model\Article as ArticleModel;
use app\common\model\article\Category as CategoryModel;
use app\store\model\article\FieldsValue as FieldsValueModel;

/**
 * 文章模型
 * Class Article
 * @package app\store\model
 */
class Article extends ArticleModel
{	
    /**
     * 新增记录
     * @param $data
     * @return false|int
     */
    public function add($data)
    {
		if (empty($data['category_id'])) {
		    $this->error = '请选择文章分类';
		    return false;
		}
		if (empty($data['user_id'])) {
		    $this->error = '请选择关联用户';
		    return false;
		}
		if (empty($data['goods_id'])) {
		    $this->error = '请选择关联商品';
		    return false;
		}
        if (empty($data['image_id'])) {
            $this->error = '请上传封面图';
            return false;
        }
        if (empty($data['article_content'])) {
            $this->error = '请输入文章内容';
            return false;
        }
		
		$this->startTrans();
		try{
			$data['wxapp_id'] = self::$wxapp_id;
			if(!empty($data['goods_id'])){
				$data['goods_id'] = implode(',',$data['goods_id']);
			}
			if(!empty($data['self_field'])){
				$data['more'] = json_encode($data['self_field'],true);
			}			
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
     * 更新记录
     * @param $data
     * @return bool|int
     */
    public function edit($data)
    {
		//dump($data);exit;
        if (empty($data['category_id'])) {
            $this->error = '请选择文章分类';
            return false;
        }        
        
        if (empty($data['image_id'])) {
            $this->error = '请上传封面图';
            return false;
        }
        if (empty($data['article_content'])) {
            $this->error = '请输入文章内容';
            return false;
        }
		$this->startTrans();
		try {
		    // 更新文章记录
			if(!empty($data['goods_id'])){
				$data['goods_id'] = implode(',',$data['goods_id']);
			}
			if(!empty($data['self_field'])){
				$data['more'] = json_encode($data['self_field'],true);
			}
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

    /**
     * 获取文章总数量
     * @param array $where
     * @return int|string
     */
    public static function getArticleTotal($where = [])
    {
        $model = new static;
        !empty($where) && $model->where($where);
        return $model->where('is_delete', '=', 0)->count();
    }
	
	

}