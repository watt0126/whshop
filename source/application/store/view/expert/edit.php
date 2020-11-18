<link rel="stylesheet" href="assets/common/plugins/umeditor/themes/default/css/umeditor.css">
<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">修改专家信息</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">专家标题 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="expert[expert_title]"
                                           value="<?= $model['expert_title']?>" required>
                                </div>
                            </div>                            
							<div class="am-form-group">
							    <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">专家头像 </label>
							    <div class="am-u-sm-9 am-u-end">
							        <div class="am-form-file">
							            <div class="am-form-file">
							                <button type="button" id="upload-file-avatar"
							                        class="upload-file am-btn am-btn-secondary am-radius">
							                    <i class="am-icon-cloud-upload"></i> 选择图片
							                </button>
							                <div class="uploader-list am-cf">
												<div class="file-item">
												    <a href="<?= $model['avatar']['file_path'] ?>" title="点击查看大图"
												       target="_blank">
												        <img src="<?= $model['avatar']['file_path'] ?>">
												    </a>
												    <input type="hidden" name="expert[avatar_id]"
												           value="<?= $model['avatar_id'] ?>">
												    <i class="iconfont icon-shanchu file-item-delete"></i>
												</div>
							                </div>
											<div class="help-block am-padding-top-xs">
											    <small>建议头像尺寸：100 * 100 圆角</small>
											</div>
							            </div>
							        </div>
							    </div>
							</div>
                            <div class="am-form-group">
                                <label class="am-u-sm-2 am-form-label form-require"> 列表显示方式 </label>
                                <div class="am-u-sm-10">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="expert[show_type]"
                                               value="10"
                                               data-am-ucheck <?= $model['show_type'] == 10 ? 'checked' : '' ?>>
                                        小图模式
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="expert[show_type]"
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
												    <input type="hidden" name="expert[image_id]"
												           value="<?= $model['image_id'] ?>">
												    <i class="iconfont icon-shanchu file-item-delete"></i>
												</div>
											</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
													
                            <div class="am-form-group am-padding-top">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">专家简介 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <!-- 加载编辑器的容器 -->
                                    <textarea id="container" name="expert[expert_content]" type="text/plain"><?= $model['expert_content'] ?></textarea>
                                </div>
                            </div>
							<div class="am-form-group">
							    <label class="am-u-sm-3 am-u-lg-2 am-form-label">其他 </label>
							    <div class="am-u-sm-9 am-u-end">
									<textarea class="am-field-valid" name="expert[more]" rows="5" 
									placeholder="请输入专家其他文字描述"><?= $model['more'] ?></textarea>							        
							    </div>
							</div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">标记 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="expert[sign]"
                                           value="<?= $model['sign'] ?>" required>
                                    <small>专家分类，病种首字母大写，多个标记请用逗号‘,’分开</small>
                                </div>
                            </div>	
							
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label">标签 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="expert[tag]"
                                           value="<?= $model['tag'] ?>">
                                    <small>专家标签，多个标签请用逗号‘,’分开</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">文章排序 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" class="tpl-form-input" name="expert[expert_sort]"
                                           value="<?= $model['expert_sort'] ?>" required>
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
<!-- 文件库弹窗 -->
{{include file="layouts/_template/file_library" /}}
<script src="assets/common/plugins/umeditor/umeditor.config.js?v=<?= $version ?>"></script>
<script src="assets/common/plugins/umeditor/umeditor.min.js"></script>
<script>
    $(function () {
		// 选择封面图片
		$('#upload-file-avatar').selectImages({
		    name: 'expert[avatar_id]'
		});
        // 选择封面图片
        $('#upload-file').selectImages({
            name: 'expert[image_id]'
        });
		
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
