<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="renderer" content="webkit"/>
    <link rel="stylesheet" href="assets/common/css/amazeui.min.css"/>
    <link rel="stylesheet" href="assets/store/css/app.css?v=<?= $version ?>"/>
    <script src="assets/common/js/jquery.min.js"></script>
    <title>专家列表</title>
</head>
<body class="select-data">
<!-- 工具栏 -->
<div class="page_toolbar am-margin-bottom-xs am-cf">
    <form class="toolbar-form" action="">
        <input type="hidden" name="s" value="/<?= $request->pathinfo() ?>">
        <div class="am-u-sm-12">
            <div class="am fr">
                <div class="am-form-group am-fl">
                    <div class="am-input-group am-input-group-sm tpl-form-border-form">
                        <input type="text" class="am-form-field" name="expertTitle"
                               placeholder="请输入专家名字"
                               value="<?= $request->get('expertTitle') ?>">
                        <div class="am-input-group-btn">
                            <button class="am-btn am-btn-default am-icon-search"
                                    type="submit"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="am-scrollable-horizontal am-u-sm-12">
    <table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap">
        <thead>
        <tr>
            <th>
                <label class="am-checkbox">
                    <input data-am-ucheck data-check="all" type="checkbox">
                </label>
            </th>
			<th>专家ID</th>			
			<th>专家头像</th>
			<th>专家姓名</th>
            <th>专家封面图</th>            
            <th>专家标记</th>
            <th>添加时间</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!$list->isEmpty()): foreach ($list as $item): ?>
            <tr>
                <td class="am-text-middle">
                    <label class="am-checkbox">
                        <input data-am-ucheck data-check="item" data-params='<?= json_encode([
                            'expert_id' => (string)$item['expert_id'],
                            'expertTitle' => $item['expert_title'],
                            'avatarUrl' => $item['avatar']['file_path'],
                        ], JSON_UNESCAPED_SLASHES) ?>' type="checkbox">
                    </label>
                </td>
				<td class="am-text-middle"><?= $item['expert_id'] ?></td>				
				<td class="am-text-middle">
				    <a href="<?= $item['avatar']['file_path'] ?>" title="点击查看大图" target="_blank">
				        <img src="<?= $item['avatar']['file_path'] ?>" width="72" height="72" alt="">
				    </a>
				</td>
				<td class="am-text-middle"><?= $item['expert_title'] ?></td>
                <td class="am-text-middle">
                    <a href="<?= $item['image']['file_path'] ?>" title="点击查看大图" target="_blank">
                        <img src="<?= $item['image']['file_path'] ?>" width="72" height="72" alt="">
                    </a>
                </td>
                
                <td class="am-text-middle"><?= $item['sign'] ?></td>
                <td class="am-text-middle"><?= $item['create_time'] ?></td>
            </tr>
        <?php endforeach; else: ?>
            <tr>
                <td colspan="8" class="am-text-center">暂无记录</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<div class="am-u-lg-12 am-cf">
    <div class="am-fr"><?= $list->render() ?> </div>
    <div class="am-fr pagination-total am-margin-right">
        <div class="am-vertical-align-middle">总记录：<?= $list->total() ?></div>
    </div>
</div>

<script src="assets/common/js/amazeui.min.js"></script>
<script>
    /**
     * 获取已选择的数据
     * @returns {Array}
     */
    function getSelectedData() {
        var data = [];
        $('input[data-check=item]:checked').each(function () {
            data.push($(this).data('params'));
        });
        return data;
    }

    $(function () {

        // 全选框元素
        var $checkAll = $('input[data-check=all]')
            , $checkItem = $('input[data-check=item]')
            , itemCount = $checkItem.length;

        // 复选框: 全选和反选
        $checkAll.change(function () {
            $checkItem.prop('checked', this.checked);
        });

        // 复选框: 子元素
        $checkItem.change(function () {
            if (!this.checked) {
                $checkAll.prop('checked', false);
            } else {
                var checkedItemNum = $checkItem.filter(':checked').length;
                checkedItemNum === itemCount && $checkAll.prop('checked', true);
            }
        });

    });
</script>
</body>
</html>
