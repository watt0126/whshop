(function(){
	function selectclass(options){
		var option = $.extend(true, {
            el: '#app',
            name: '',
            columns: {},
            childCount: 0,
            formData: []
        }, options);
        var app = this.createVueApp(option);
        app.initializeForms();
	}
	
	selectclass.prototype = {
		createVueApp: function (option) {
			return new Vue({
				el: option.el,
				data: {
					// 模板名称
					name: option.name,
					// 所有栏目
					columns: option.columns,
					// 全选状态
					checkAll: false,
					// 当前选择的地区id集
					checked: {
						parents: [],
						childs: []
					},
					// 禁止选择的地区id集
					disable: {
						parents: [],
						childs: [],
						treeData: {}
					},
					// 已选择的区域和运费form项
					forms: []
				},
				methods: {
					initializeForms: function () {
						var app = this;
						if (!option.formData.length) return false;
						option.formData.forEach(function (form) {
							// 转换为整数型
							for (var key in  form.child) {
								if (form.child.hasOwnProperty(key)) {
									form.child[key] = parseInt(form.child[key]);
								}
							}
							form['treeData'] = app.getTreeData({
								parents: form.parents,
								childs: form.childs
							});
							app.forms.push(form);
						});
						
					},
					onSelectClassEvent:function(){
						var app = this;
						// 判断是否选择了所有
						var total = 0;
						app.forms.forEach(function (item) {
							total += item.childs.length;
						});
						if (total >= option.childCount) {
							layer.msg('已经选择了所有栏目~');
							return false;
						}
						// 显示选择可选择栏目弹窗
						app.onShowCheckBox({
							complete: function (checked) {
								//console.log(checked);
								// 选择完成后新增form项
								app.forms.push({
									parents: checked.parents,
									childs: checked.childs,
									treeData: app.getTreeData(checked)
								});
							}
						});
					},
					// 全选
					onCheckAll: function (checked) {
						var app = this;
						app.checkAll = checked;
						// 遍历能选择的地区
						for (var key in  app.columns) {
							if (app.columns.hasOwnProperty(key)) {
								var item = app.columns[key];
								if (!app.isPropertyExist(item.category_id, app.disable.treeData)
									|| !app.disable.treeData[item.category_id].isAllChilds) {
									var parentId = parseInt(item.category_id);
									this.checkedParent(parentId, app.checkAll);
								}
							}
						}
					},
					
					// 将选中的区域id集格式化为树状格式
					getTreeData: function (checkedData) {
						//console.log(checkedData);
						var app = this;
						var treeData = {};
						checkedData.parents.forEach(function (parentId) {
							//console.log(parentId);
							var parents = app.columns[parentId], childs = [], childCount = 0;
							//console.log(parents);
							for (var childIndex in parents.child) {
								if (parents.child.hasOwnProperty(childIndex)) {
									var childItem = parents.child[childIndex];
									if (app.inArray(childItem.category_id, checkedData.childs)) {
										childs.push({category_id: childItem.category_id, name: childItem.name});
									}
									childCount++;
								}
							}
							//console.log(childs);
							treeData[parents.category_id] = {
								category_id: parent.category_id,
								name: parents.name,
								child: childs,
								isAllChilds: childs.length === childCount
							};
						});
						//console.log(treeData);
						return treeData;
					},
					// 编辑配送区域
					onEditerForm: function (formIndex, formItem) {
					    var app = this;
					    // 显示选择可配送区域弹窗
					    app.onShowCheckBox({
					        editerFormIndex: formIndex,
					        checkedData: {
					            parents: formItem.parents,
					            childs: formItem.childs
					        },
					        complete: function (data) {
					            // var formItem = app.forms[formIndex];
					            formItem.parents = data.parents;
					            formItem.childs = data.childs;
					            formItem.treeData = app.getTreeData(data);
					        }
					    });
					},
					// 删除配送区域
					onDeleteForm: function (formIndex) {
					    var app = this;
					    layer.confirm('确定要删除吗？'
					        , {title: '友情提示'}
					        , function (index) {
					            app.forms.splice(formIndex, 1);
					            layer.close(index);
					        }
					    );
					},
					// 显示选择可选择栏目弹窗
					onShowCheckBox: function (option) {
						var app = this;
						var options = $.extend(true, {
							editerFormIndex: -1,
							checkedData: null,
							complete: $.noop()
						}, option);
						// 已选中的数据
						app.checked = options.checkedData ? options.checkedData : {
							parents: [],
							childs: []
						};
						// 标记不可选的地区
						//app.onDisableRegion(options.editerFormIndex);
						// 取消全选按钮
						app.checkAll = false;
						// 开启弹窗
						layer.open({
							type: 1,
							shade: false,
							title: '选择可选择栏目',
							btn: ['确定', '取消'],
							area: ['820px', '520px'], //宽高
							content: $(this.$refs['choice']),
							yes: function (index) {
								if (app.checked.childs.length <= 0) {
									layer.msg('请选择栏目~');
									return false;
								}
								options.complete(app.checked);
								layer.close(index);
							}
						});
					},
					// 选择顶级栏目
					onCheckedParents: function (e) {
						var parentId = parseInt(e.target.value);
						this.checkedParent(parentId, e.target.checked);
					},
					// 选择顶级栏目
					checkedParent: function (parentId, checked) {
						var app = this;
						// 更新栏目选择
						var index = app.checked.parents.indexOf(parentId);
						if (!checked) {
							index > -1 && app.checked.parents.splice(index, 1);
						} else {
							index === -1 && app.checked.parents.push(parentId);
						}
						// 更新下级栏目选择
						var childIds = app.columns[parentId].child;
						for (var childIndex in childIds) {
							if (childIds.hasOwnProperty(childIndex)) {
								var childId = parseInt(childIndex);
								var checkedIndex = app.checked.childs.indexOf(childId);
								if (!checked) {
									checkedIndex > -1 && app.checked.childs.splice(checkedIndex, 1)
								} else {
									checkedIndex === -1 && app.checked.childs.push(childId);
								}
							}
						}
					},
					// 选择下级栏目
					onCheckedChild: function (e, parentId) {
						var childId = parseInt(e.target.value);
						//console.log(childId);
						if (!e.target.checked) {
							var index = this.checked.childs.indexOf(childId);
							index > -1 && this.checked.childs.splice(index, 1)
						} else {
							this.checked.childs.push(childId);
						}
						// 更新顶级分类选中状态
						this.onUpdateParentsChecked(parseInt(parentId));
					},
					// 更新顶级分类选中状态
					onUpdateParentsChecked: function (parentId) {
						var parentIndex = this.checked.parents.indexOf(parentId);
						//console.log(parentIndex);
						var isExist = parentIndex > -1;
						if (!this.onHasChildChecked(parentId)) {
							isExist && this.checked.parents.splice(parentIndex, 1);
						} else {
							!isExist && this.checked.parents.push(parentId);
						}
					},
					// 是否存在下级分类被选中
					onHasChildChecked: function (parentId) {
						var app = this;
						var childIds = this.columns[parentId].child;						
						for (var childId in childIds) {
							if (childIds.hasOwnProperty(childId)
								&& app.inArray(parseInt(childId), app.checked.childs))
								return true;
						}
						return false;
					},
					
					// 数组中是否存在指定的值
					inArray: function (val, array) {
						return array.indexOf(val) > -1;
					},
					
					// 对象的属性是否存在
					isPropertyExist: function (key, obj) {
						return obj.hasOwnProperty(key);
					},
					
					// 数组合并
					arrayMerge: function (arr1, arr2) {
						return arr1.concat(arr2);
					}
				}
			});
		}
	};
	window.selectclass = selectclass;
	
})(window);