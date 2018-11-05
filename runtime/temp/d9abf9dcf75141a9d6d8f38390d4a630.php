<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:88:"/www/wwwroot/luckywinner.vip/public/../addons/fomo/user/view/default/key_rule/index.html";i:1536720950;}*/ ?>


<div class="right-main">
    <div class="page_nav" id="js_page_nav"><span class="page_title"><?php echo $page_nav; ?></span></div>
    <div id="js_main_header" class="ui-form main_header">
        <span class="right">       
            <button type="button" id="js_addBtn" class="btn btn-primary"><i class="icon fa fa-plus"></i> 添加配置</button>
        </span>
    </div>
    <table id="grid-table">
        <thead>
        <tr>
            <th data-options="field:'init_amount',width:160, align:'center'">初始价格</th>
            <th data-options="field:'multi',width:160, align:'center'">递增价格</th>
            <th data-options="field:'time_multi',width:120, align:'center'">增加时间(秒)</th>
            <th data-options="field:'limit',width:120, align:'center'">用户限购金额</th>
            <th data-options="field:'unfreeze',width:120, align:'center'">解除限制额度</th>
            <th data-options="field:'invite_rate',width:140, align:'center'">推荐奖励(%)</th>
            <th data-options="field:'update_time',width:140, align:'center'">更新时间</th>
            <th data-options="field:'_oper',width:140,halign:'center',formatter: formatOper">操作</th>
        </tr>
        </thead>
    </table>
</div>



<script type="text/javascript">
    $(function () {
        $('#grid-table').datagrid({
            url: getURL('loadList'),
            method: "GET",
            height: getGridHeight(),
            rownumbers: true,
            singleSelect: true,
            remoteSort: false,
            multiSort: true,
            emptyMsg: '<span>无相关数据</span>',
            pagination: true,
            pageSize: 20,
        });
        //设置分页控件 
        $('#grid-table').datagrid('getPager').pagination({
            pageSize: 20, //每页显示的记录条数，默认为10 
            pageList: [20, 30, 50]
        });
    });

    function formatOper(value, row, index) {
        var html = '<span class="grid-operation">';
        html += '<button type="button" onclick="edit(' + row['id'] + ')" class="btn btn-xs btn-default edit-btn"><i class="icon wb-edit"></i>编辑</button>';
        html += '<button type="button" onclick="del(' + row['id'] + ')" class="btn btn-xs btn-default del-btn"><i class="icon wb-close"></i>删除</button>';
        html += '</span>';
        return html;
    }
    
    function edit(id) {
        var url = getURL('edit', 'id=' + id);
        openBarWin('编辑', 800, 300, url, function () {
            reload();
        }, ['确定','取消']);
    }
    
    $("#js_addBtn").click(function () {
        var url = getURL('edit');
        openBarWin('添加', 800, 300, url, function () {
            reload();
        },['保存','取消']);
    });

    function del(id) {
        confirm("确认要删除吗？", function () {
            var url = getURL('del');
            $.getJSON(url, {id: id}, function (json) {
                if (json.success)
                    reload();
                else
                    alert(json.message);
            });
        });
    }

    function reload() {
        $('#grid-table').datagrid('reload');
    }
</script>
