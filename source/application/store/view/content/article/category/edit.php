<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">编辑文章分类</div>
                            </div>
							<div class="am-form-group">
							    <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">上级分类 </label>
							    <div class="am-u-sm-9 am-u-end">
							        <select name="category[parent_id]"
							                data-am-selected="{searchBox: 1, btnSize: 'sm',
							                 placeholder:'请选择', maxHeight: 400}">
							            <option value="0">顶级分类</option>
							            <?php if(isset($categoryList)):foreach($categoryList as $category):?>
							            <option value="<?=$category['category_id']?>"
										<?= $model['parent_id'] == $category['category_id'] ? 'selected' : '' ?>
										<?= $model['category_id'] == $category['category_id'] ? 'disabled' : '' ?>>
										<?=$category['name_h1']?></option>
							            <?php endforeach;endif;?>
							        </select>
							    </div>
							</div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">分类名称 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="category[name]"
                                           value="<?= $model['name'] ?>" required>
                                </div>
                            </div>
							<div class="am-form-group">
							    <label class="am-u-sm-3 am-u-lg-2 am-form-label">关联商品分类 </label>
							    <div class="am-u-sm-9 am-u-end">
							        <select name="category[goods_category_id]"
							                data-am-selected="{searchBox: 1, btnSize: 'sm',
							                 placeholder:'请选择关联商品分类', maxHeight: 400}">
							        		 <option value=""></option>
							        		 <?php if(isset($goodsCategory)):foreach($goodsCategory as $category):?>
							        		 <option value="<?=$category['category_id']?>"
											 <?= $goodsCategoryId = !empty($model['caterule']) ? $model['caterule']['goods_category_id'] : 0 ?>											 										 
											 <?= $goodsCategoryId == $category['category_id'] ? 'selected' : '' ?>><?=$category['name']?></option>
											 <?php endforeach;endif;?>
							        </select>
							    </div>
							</div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">分类排序 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" class="tpl-form-input" name="category[sort]"
                                           value="<?= $model['sort'] ?>" required>
                                    <small>数字越小越靠前</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
                                    <button type="submit" class="j-submit am-btn am-btn-secondary">提交
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {

        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();

    });
</script>
