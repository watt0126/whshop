<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">添加文章分类</div>
                            </div>
							<div class="am-form-group">
							    <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">上级分类 </label>
							    <div class="am-u-sm-9 am-u-end">
							        <select name="category[parent_id]"
							                data-am-selected="{searchBox: 1, btnSize: 'sm',
							                 placeholder:'请选择', maxHeight: 400}">
											 <option value="0">顶级分类</option>
											 <?php if(isset($categoryList)):foreach($categoryList as $category):?>
											 <option value="<?=$category['category_id']?>"><?=$category['name_h1']?></option>
											 <?php endforeach;endif;?>
									</select>
							    </div>
							</div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">分类名称 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="category[name]"
                                           value="" required>
                                </div>
                            </div>
							<div class="am-form-group">
							    <label class="am-u-sm-3 am-u-lg-2 am-form-label">关联商品分类 </label>
							    <div class="am-u-sm-9 am-u-end">
							        <select name="category[goods_category_id]"
							                data-am-selected="{searchBox: 1, btnSize: 'sm',
							                 placeholder:'请选择', maxHeight: 400}">
							        		 <option value=""></option>
							        		 <?php if(isset($goodsCategory)):foreach($goodsCategory as $category):?>
							        		 <option value="<?=$category['category_id']?>"><?=$category['name']?></option>
							        		 <?php endforeach;endif;?>
							        </select>
							    </div>
							</div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">分类排序 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" class="tpl-form-input" name="category[sort]"
                                           value="100" required>
                                    <small>数字越小越靠前</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
                                    <button type="submit" class="j-submit am-btn am-btn-secondary">提交</button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script id="tpl-category-field" type="text/template">
    <div class="am-padding-xs am-padding-top">
        <form class="am-form tpl-form-line-form" method="post" action="">
            <div class="am-tab-panel am-padding-0 am-active">
				<div class="am-form-group">
					<label class="am-u-sm-3 am-form-label form-require">类型</label>
					<div class="am-u-sm-7 am-u-end">
						<select name="category[field][type]">
							<option value="-1">请选择字段类型</option>
							<option value="1">text</option>
							<option value="2">image</option>
							<option value="3">textarea</option>
						</select>
					</div>
				</div>
                <div class="am-form-group">
                    <label class="am-u-sm-3 am-form-label form-require">名称</label>
                    <div class="am-u-sm-7 am-u-end">
						<input class="tpl-form-input" type="text" value="" name="category[field][title]" placeholder="输入字段名" required="">
                    </div>
                </div>
				
            </div>
        </form>
    </div>
</script>
<script>
    $(function () {
		// 选择用户
		$('.j-addField').on('click', function () {
		    var data = $(this).data();
		    $.showModal({
		        title: '新增扩展字段', 
				area: '460px', 
				content: template('tpl-category-field', data), 
				uCheck: true, 
				success: function ($content) {
					
		        }
		        , yes: function ($content) {
		            $content.find('form').myAjaxSubmit({
		                url: '<?= url('user/grade') ?>',
		                data: {user_id: data.id}
		            });
		            return true;
		        }
		    });
		});
		
        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();

    });
</script>
