<link rel="stylesheet" href="assets/common/plugins/umeditor/themes/default/css/umeditor.css">
<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">编辑文章</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">文章标题 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="article[article_title]"
                                           value="<?= $model['article_title'] ?>" placeholder="请输入标题" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">文章分类 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <select name="article[category_id]"
                                            data-am-selected="{searchBox: 1, btnSize: 'sm',
                                             placeholder:'请选择', maxHeight: 400}" id="category">
                                        <option value=""></option>
                                        <?php if (isset($catgory)): foreach ($catgory as $item): ?>
                                            <option value="<?= $item['category_id'] ?>"
                                                <?= $model['category_id'] == $item['category_id'] ? 'selected' : '' ?>>
												<?= $item['name_h1'] ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                    <small class="am-margin-left-xs">
                                        <a href="<?= url('content.article.category/add') ?>">去添加</a>
                                    </small>
                                </div>
                            </div>
							<div class="am-form-group">
								<label class="am-u-sm-2 am-form-label form-require"> 选择用户 </label>
								<div class="am-u-sm-9 am-u-end">
								    <div class="widget-become-goods am-form-file am-margin-top-xs">
								        <button type="button"
								                class="j-selectUser upload-file am-btn am-btn-secondary am-radius">
								            <i class="am-icon-cloud-upload"></i> 选择用户
								        </button>
								        <div class="user-list uploader-list am-cf">
											<?php if(!empty($model['user'])) :?>
											<div class="file-item">
											    <a href="<?= $model['user']['avatarUrl'] ?>" title="点击查看大图" target="_blank">
											        <img src="<?= $model['user']['avatarUrl'] ?>">
											    </a>
											    <input type="hidden" name="arcticle[user_id]" value="<?= $model['user_id'] ?>">
											</div>
											<?php endif;?>
								        </div>
								    </div>
								</div>
							</div>
							<div class="am-form-group">
								<label class="am-u-sm-2 am-form-label form-require"> 关联商品 </label>
								<div class="am-u-sm-9 am-u-end">
								    <div class="widget-become-goods am-form-file am-margin-top-xs">
								        <button type="button"
								                class="j-selectGoods upload-file am-btn am-btn-secondary am-radius">
								            <i class="am-icon-cloud-upload"></i> 选择商品
								        </button>
								        <div class="goods-list uploader-list am-cf">
											<?php if(!empty($goods)) : foreach($goods as $g) :?>
											<div class="file-item">
											    <a href="<?= $g['image'][0]['file_path']?>" title="<?= $g['goods_name']?>" target="_blank">
											        <img src="<?= $g['image'][0]['file_path']?>">
											    </a>
											    <input type="hidden" name="article[goods_id][]" value="<?= $g['goods_id']?>">
												   
											</div>	
											<?php endforeach;endif;?>
								        </div>								        
								    </div>
								</div>
							</div>
                            <div class="am-form-group">
                                <label class="am-u-sm-2 am-form-label form-require"> 列表显示方式 </label>
                                <div class="am-u-sm-10">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="article[show_type]"
                                               value="10"
                                               data-am-ucheck <?= $model['show_type'] == 10 ? 'checked' : '' ?>>
                                        小图模式
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="article[show_type]"
                                               value="20"
                                               data-am-ucheck <?= $model['show_type'] == 20 ? 'checked' : '' ?>>
                                        大图模式
                                    </label>
                                    <div class="help-block am-padding-top-xs">
                                        <small>小图模式建议封面图尺寸：300 * 188，大图模式建议封面图尺寸：750 * 455</small>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">文章封面图 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="am-form-file">
                                        <div class="am-form-file">
                                            <button type="button" id="upload-file" 
                                                    class="upload-file am-btn am-btn-secondary am-radius">
                                                <i class="am-icon-cloud-upload"></i> 选择图片
                                            </button>
                                            <div class="uploader-list am-cf">
                                                <div class="file-item">
                                                    <a href="<?= $model['image']['file_path'] ?>" title="点击查看大图"
                                                       target="_blank">
                                                        <img src="<?= $model['image']['file_path'] ?>">
                                                    </a>
                                                    <input type="hidden" name="article[image_id]"
                                                           value="<?= $model['image_id'] ?>">
                                                    <i class="iconfont icon-shanchu file-item-delete"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group am-padding-top">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">文章内容 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <!-- 加载编辑器的容器 -->
                                    <textarea id="container" name="article[article_content]"
                                              type="text/plain"><?= $model['article_content'] ?></textarea>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label">虚拟阅读量 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" class="tpl-form-input" name="article[virtual_views]"
                                           value="<?= $model['virtual_views'] ?>">
                                    <small>显示的阅读量 = 实际阅读量 + 虚拟阅读量</small>
                                </div>
                            </div>							
							<div class="additional">								
								<?php if(!empty($selfField)): foreach($selfField as $key=>$item):?>
								<div class="am-form-group">
								    <label class="am-u-sm-3 am-u-lg-2 am-form-label"><?= $item['title']?> </label>
								    <div class="am-u-sm-9 am-u-end">
										<?php if($item['type'] == 'image'):?>
								        <div class="am-form-file">
								            <button type="button" data-name="<?= $item['name']?>"
								                    class="upload-file am-btn am-btn-secondary am-radius">
								                <i class="am-icon-cloud-upload"></i> 选择图片
								            </button>
								            <div class="uploader-list am-cf">
								        		<?php if(!empty($item['value'])) :?>
												<div class="file-item">														
								        		    <a href="<?= $item['value'] ?>" title="点击查看大图"
								        		       target="_blank">
								        		        <img src="<?= $item['value'] ?>">
								        		    </a>
								        		    <input type="hidden" name="article[self_field][<?= $item['name']?>][value]" value="<?= $item['value']?>">
								        		    
													<i class="iconfont icon-shanchu file-item-delete"></i>														
								        		</div>
												<?php endif;?>
								        	</div>
											<input type="hidden" name="article[self_field][<?= $item['name']?>][title]" value="<?= $item['title']?>">
											<input type="hidden" name="article[self_field][<?=$item['name']?>][type]" value="<?= $item['type']?>">
								        </div>
										<?php else : ?>
										<input type="<?=$item['type']?>" class="tpl-form-input" name="article[self_field][<?= $item['name']?>][value]"
										           value="<?= $item['value']?>">
										<input type="hidden" name="article[self_field][<?= $item['name']?>][type]" value="<?= $item['type']?>">
										<input type="hidden" name="article[self_field][<?= $item['name']?>][title]" value="<?= $item['title']?>">
										<?php endif;?>
								    </div>
								</div>
								<?php endforeach;endif;?>
							</div>	
							<div class="am-form-group">
							    <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">推荐 </label>
							    <div class="am-u-sm-9 am-u-end">
							        <label class="am-radio-inline">
							            <input type="radio" name="article[commend]" value="1" data-am-ucheck 
										<?= $model['commend'] == 1 ? 'checked' : '' ?>>
							            是
							        </label>
							        <label class="am-radio-inline">
							            <input type="radio" name="article[commend]" value="0" data-am-ucheck 
										<?= $model['commend'] == 0 ? 'checked' : '' ?>>
							            否
							        </label>
							    </div>
							</div>
							<div class="am-form-group">
							    <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">精选 </label>
							    <div class="am-u-sm-9 am-u-end">
							        <label class="am-radio-inline">
							            <input type="radio" name="article[choice]" value="1" data-am-ucheck 
										<?= $model['choice'] == 1 ? 'checked' : '' ?>>
							            是
							        </label>
							        <label class="am-radio-inline">
							            <input type="radio" name="article[choice]" value="0" data-am-ucheck 
										<?= $model['choice'] == 0 ? 'checked' : '' ?>>
							            否
							        </label>
							    </div>
							</div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">文章状态 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="article[article_status]" value="1" data-am-ucheck
                                            <?= $model['article_status'] == 1 ? 'checked' : '' ?>>
                                        显示
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="article[article_status]" value="0" data-am-ucheck
                                            <?= $model['article_status'] == 0 ? 'checked' : '' ?>>
                                        隐藏
                                    </label>
                                </div>
                            </div>
							
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">文章排序 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" class="tpl-form-input" name="article[article_sort]"
                                           value="<?= $model['article_sort'] ?>" required>
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
<!-- 附加字段列表模板 -->
<script id="tpl-field-item" type="text/template">
    {{ each list }}	
    <div class="am-form-group">
		<label class="am-u-sm-3 am-u-lg-2 am-form-label">{{ $value.title }}</label> 
		<div class="am-u-sm-9 am-u-end">
			{{ if $value.type == 'image' }}
			<div class="am-form-file">
				<button type="button" id="upload-file" data-name="{{ $value.name }}"
				        class="upload-file am-btn am-btn-secondary am-radius">
				    <i class="am-icon-cloud-upload"></i> 选择图片
				</button>				
				<div class="uploader-list am-cf"></div>
				<input type="hidden" name="article[self_field][{{ $value.name }}][title]" value="{{ $value.title }}">
				<input type="hidden" name="article[self_field][{{ $value.name }}][type]" value="{{ $value.type }}">
			</div>
			{{ /if }}
			{{ if $value.type == 'text' }}
				<input type="text" class="tpl-form-input" name="article[self_field][{{ $value.name }}][value]"
				       value="" placeholder="请输入{{ $value.title }}">
				<input type="hidden" name="article[self_field][{{ $value.name }}][type]" value="text">
				<input type="hidden" name="article[self_field][{{ $value.name }}][title]" value="{{ $value.title }}">
			{{ /if }}
		</div>
    </div>
    {{ /each }}
</script>
<!-- 附加图片文件列表模板 -->
<script id="tpl-filemore-item" type="text/template">
    {{ each list }}
    <div class="file-item">
        <a href="{{ $value.file_path }}" title="点击查看大图" target="_blank">
            <img src="{{ $value.file_path }}">
        </a>
		<input type="hidden" name="{{ name }}[value]" value="{{ $value.file_path }}">
		<input type="hidden" name="{{ name }}[type]" value="image">
        <i class="iconfont icon-shanchu file-item-delete"></i>
    </div>
    {{ /each }}
</script>
<!-- 图片文件列表模板 -->
<script id="tpl-file-item" type="text/template">
    {{ each list }}
    <div class="file-item">
        <a href="{{ $value.file_path }}" title="点击查看大图" target="_blank">
            <img src="{{ $value.file_path }}">
        </a>
		<input type="hidden" name="{{ name }}" value="{{ $value.file_id }}">
        <i class="iconfont icon-shanchu file-item-delete"></i>
    </div>
    {{ /each }}
</script>
<!-- 图片文件列表模板 -->
<script id="tpl-user-item" type="text/template">
    {{ each $data }}
    <div class="file-item">
        <a href="{{ $value.avatarUrl }}" title="{{ $value.nickName }} (ID:{{ $value.user_id }})" target="_blank">
            <img src="{{ $value.avatarUrl }}">
        </a>
        <input type="hidden" name="article[user_id]" value="{{ $value.user_id }}">
    </div>
    {{ /each }}
</script>
<!-- 商品列表模版 -->
<script id="tpl-goods-list-item" type="text/template"> 
   {{ each $data }}
   <div class="file-item">
       <a href="{{ $value.image }}" title="{{ $value.goods_name }}" target="_blank">
           <img src="{{ $value.image }}">
       </a>
       <input type="hidden" name="article[goods_id][]" value="{{ $value.goods_id }}">
	   
   </div>
   {{ /each }}
</script>
<!-- 文件库弹窗 -->
{{include file="layouts/_template/file_library" /}}
<script src="assets/store/js/select.data.js?v=<?= $version ?>"></script>
<script src="assets/common/plugins/umeditor/umeditor.config.js?v=<?= $version ?>"></script>
<script src="assets/common/plugins/umeditor/umeditor.min.js"></script>
<script>
    $(function () {
		$('#category').on('change',function(){
			//alert(1111);
			$.ajax({
				async: false, 
				type: 'post',
				url: "<?=url('content.article/getCategoryFieldHtml') ?>",
				data: {'category_id':$(this).val()},
				dataType:'json',
				success:function(data){					
					var $html = $(template('tpl-field-item', {list: data}));
					$('.additional').empty().append($html);
					//动态绑定selectImages事件选择附加图片
					$(".additional .am-form-file").each((index,item)=>{
						var buttonObj=$(item).find("button");
						var dataname = buttonObj.data('name');
						buttonObj.selectImages({
							name: 'article[self_field]['+dataname+']',
							custom: true
						})
					})
				}
			});
		});
		// 选择用户
		$('.j-selectUser').click(function () {
		    var $userList = $('.user-list');
		    $.selectData({
		        title: '选择用户',
		        uri: 'user/lists',
		        dataIndex: 'user_id',
		        done: function (data) {
		            var user = [data[0]];
		            $userList.html(template('tpl-user-item', user));
		        }
		    });
		});
		// 选择关联商品
		var $goodsList = $('.goods-list');
		$('.j-selectGoods').selectData({
		    title: '选择商品',
		    uri: 'goods/lists',
		    dataIndex: 'goods_id',
		    done: function (data) {				
		        var $html = $(template('tpl-goods-list-item', data));
		        $goodsList.html($html);
		    }
		});
        // 选择图片
        $('#upload-file').selectImages({
            name: 'article[image_id]'
        });
		$(".additional .am-form-file").each((index,item)=>{
			var buttonObj=$(item).find("button");
			var dataname = buttonObj.data('name');
			buttonObj.selectImages({
				name: 'article[self_field]['+dataname+']',
				custom: true
			})
		})
        // 富文本编辑器
        UM.getEditor('container', {
            initialFrameWidth: 852 + 15,
            initialFrameHeight: 600
        });

        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();

    });
</script>
