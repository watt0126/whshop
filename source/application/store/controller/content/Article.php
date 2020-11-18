<?php

namespace app\store\controller\content;

use app\store\controller\Controller;
use app\store\model\Article as ArticleModel;
use app\store\model\article\Category as CategoryModel;
use app\store\model\User as UserModel;
use app\store\model\Goods as GoodsModel;
use app\store\model\article\Fields as FieldsModel;
//use app\api\model\Article as ApiArticleModel;

/**
 * 文章管理控制器
 * Class article
 * @package app\store\controller\content
 */
class Article extends Controller
{
    /**
     * 文章列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new ArticleModel;
        $list = $model->getList($this->request->param());
		// 文章分类
		$category = (new CategoryModel)->getList();
		//dump($category);exit;
		// 用户列表
		$user = (new UserModel)->getList();
		
        return $this->fetch('index', compact('list','category','user'));
    }

    /**
     * 添加文章
     * @return array|mixed
     */
    public function add()
    {
        $model = new ArticleModel;
        if (!$this->request->isAjax()) {
            // 文章分类
            $catgory = (new CategoryModel)->getList();
            return $this->fetch('add', compact('catgory'));
        }
        // 新增记录
        if ($model->add($this->postData('article'))) {
            return $this->renderSuccess('添加成功', url('content.article/index'));
        }
        return $this->renderError($model->getError() ?: '添加失败');
    }

    /**
     * 更新文章
     * @param $article_id
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function edit($article_id)
    {
        // 文章详情
        $model = (new ArticleModel)->detail($article_id);
		// $goodslist = (new GoodsModel)->getListByIds(explode(',',$model['goods_id']),$status = 10);
		// dump($goodslist->toArray());exit;
		// 文章里已存在的附加字段
		$articleFields = !empty($model['more']['self_field']) ? $model['more']['self_field'] : [];
		// 文章分类下的附加字段
		$categoryFields = $this->getCategoryFieldHtml($model['category_id']);
		//文章的所有附加字段
		$selfField = [];
		foreach($categoryFields as $key=>$value){
			foreach($articleFields as $k=>$v){				
				if($value['name'] == $k){
					$selfField[$key]['fields_id'] = $value['fields_id'];
					$selfField[$key]['name'] = $value['name'];
					$selfField[$key]['type'] = $v['type'];
					$selfField[$key]['title'] = $v['title'];					
					$selfField[$key]['value'] = !empty($v['value']) ? $v['value'] : '';
				}
				if(array_key_exists($value['name'],$articleFields) === false) {
					$selfField[$key]['fields_id'] = $value['fields_id'];
					$selfField[$key]['name'] = $value['name'];
					$selfField[$key]['type'] = $value['type'];
					$selfField[$key]['title'] = $value['title'];					
					$selfField[$key]['value'] = '';
				}
				
			}
		}
		//dump($selfField);exit;
		if(!empty($model['goods_id'])){
			$goodsIds = explode(',', $model['goods_id']);
			$goods = (new GoodsModel)->getListByIds($goodsIds);
		}		
		//dump($goods->toArray());exit;
        if (!$this->request->isAjax()) {
            // 文章分类
            $catgory = (new CategoryModel)->getList();
			
            return $this->fetch('edit', compact('model', 'catgory', 'selfField', 'goods'));
        }
        // 更新记录
        if ($model->edit($this->postData('article'))) {
            return $this->renderSuccess('更新成功', url('content.article/index'));
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }

    /**
     * 删除文章
     * @param $article_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete($article_id)
    {
        // 文章详情
        $model = ArticleModel::detail($article_id);
        if (!$model->setDelete()) {
            return $this->renderError($model->getError() ?: '删除失败');
        }
        return $this->renderSuccess('删除成功');
    }
	/**
	 * ajax加载附加字段方法
	 * @param $category_id
	 */
	public function getCategoryFieldHtml($category_id)
	{
		$data = (new CategoryModel)->detail($category_id);
		$fieldIds = [];
		foreach($data['rule'] as $v){
			$fieldIds[] = $v['fields_id'];
		}
		return (new FieldsModel)->getFields($fieldIds);
	}

}