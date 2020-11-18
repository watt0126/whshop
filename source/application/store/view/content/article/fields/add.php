<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div id="app" class="widget am-cf" v-cloak>
                <form id="my-form" class="am-form tpl-form-line-form" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl"><?= isset($model) ? '编辑' : '新增' ?>自定义字段</div>
                            </div>							
							<div class="am-form-group">
							    <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">字段标题 </label>
							    <div class="am-u-sm-9 am-u-end">
							        <input type="text" class="tpl-form-input" name="fields[title]" value="<?= isset($model) ? $model['title'] : '' ?>" placeholder="请输入字段名称" required>
									<small>字段中文名称</small>										
							    </div>								
							</div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">字段名称 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="fields[name]" value="<?= isset($model) ? $model['name'] : '' ?>" placeholder="请输入字段别名" required>
									<small>仅由英文字母、数字和下划线组成，并且仅能字母开头，不能以下划线结尾</small>	
                                </div>								
                            </div>
							
							<div class="am-form-group">
								<label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">字段类型 </label>
								<div class="am-u-sm-9 am-u-end">
									<select name="fields[type]"
									        data-am-selected="{searchBox: 1, btnSize: 'sm', placeholder:'请选择字段类型'}" required>
											 <option value=""></option>											 
											 <option value="text" <?= isset($model) && $model['type'] === 'text' ? 'selected' : '' ?>>单行文本</option>
											 <option value="image" <?= isset($model) && $model['type'] === 'image' ? 'selected' : '' ?>>单个图片</option>
									</select>
								</div>
							</div>
							<div class="am-form-group">
							    <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">所属文章分类 </label>
							    <div class="am-u-sm-9 am-u-end">
									<table class="regional-table am-table am-table-bordered
									 am-table-centered am-margin-bottom-xs">
										<tbody>
										<tr>
											<th width="42%">选择文章分类</th>												
										</tr>
										<tr v-for="(item, formIndex) in forms">
											<td class="am-text-left">
												<p class="selected-content am-margin-bottom-xs">
													<span v-if="item.childs.length == <?= $childCount ?>">全部栏目</span>
													<template v-else v-for="(parents, index) in item.treeData">
														<span>{{ parents.name }}</span>
														<template v-if="!parents.isAllChilds">
															(<span class="am-link-muted">
																<template v-for="(child, index) in parents.child">
																	<span>{{ child.name }}</span>
																	<span v-if="(index + 1) < parents.child.length">、</span>
																</template>
															</span>)
														</template>
													</template>
												</p>
												<p class="operation am-margin-bottom-xs">
													<a class="edit" @click.stop="onEditerForm(formIndex, item)"
													   href="javascript:void(0);">编辑</a>
													<a class="delete" href="javascript:void(0);"
													   @click.stop="onDeleteForm(formIndex)">删除</a>
												</p>
												<input type="hidden" name="fields[category_id]"
													   :value="item.childs" required>
											</td>
										</tr>
										<tr>
											<td colspan="2" class="am-text-left">
												<a class="add-region am-btn am-btn-default am-btn-xs"
												   href="javascript:void(0);" @click.stop="onSelectClassEvent">
													<i class="iconfont icon-dingwei"></i>
													点击添加可选择文章分类
												</a>
											</td>
										</tr>
										</tbody>
									 </table>
							    </div>
							</div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label">排序 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" class="tpl-form-input" name="fields[sort]"
                                           value="100">
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
				
				<!-- 分类选择 -->
				<div ref="choice" class="regional-choice">
				    <div class="place-div">
				        <div>
				            <div class="checkbtn">
				                <label>
				                    <input type="checkbox" @change="onCheckAll(!checkAll)" :checked="checkAll">
				                    全选</label>
				                <a class="clearCheck" href="javascript:void(0);" @click="onCheckAll(false)">清空</a>
				            </div>
				            <div class="place clearfloat">
				                <div class="smallplace clearfloat">
				                    <div v-for="item in columns"
				                         v-if="!isPropertyExist(item.category_id, disable.treeData) || !disable.treeData[item.category_id].isAllChilds"
				                         class="place-tooltips">
				                        <label>
				                            <input type="checkbox" class="parents"
				                                   :value="item.category_id"
				                                   :checked="inArray(item.category_id, checked.parents)"
				                                   @change="onCheckedParents">
				                            <span class="parents_name">{{ item.name }}</span><span
				                                    class="ratio"></span>
				                        </label>
				                        <div class="citys">
				                            <i class="jt"><i></i></i>
				                            <div class="row-div clearfloat">
				                                <p v-for="child in item.child"
				                                   v-if="!inArray(child.category_id, disable.childs)">
				                                    <label>
				                                        <input class="child" type="checkbox"
				                                               :value="child.category_id"
				                                               :checked="inArray(child.category_id, checked.childs)"
				                                               @change="onCheckedChild($event, item.category_id)">
				                                        <span>{{ child.name }}</span>
				                                    </label>
				                                </p>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				            </div>
				        </div>
				    </div>
				</div>
				
            </div>
        </div>
    </div>
</div>
<script src="assets/common/js/vue.min.js?v=<?= $version ?>"></script>
<script src="assets/store/js/select.class.js"></script>
<script>
    $(function () {	
		new selectclass({
		    el: '#app',
		    name: "<?= isset($model) ? $model['name'] : '' ?>",
		    columns: JSON.parse('<?= $categoryData ?>'),
		    childCount: <?= $childCount ?>,
		    formData: JSON.parse('<?= isset($formData) ? $formData : '[]' ?>')
		});
        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();

    });
</script>
