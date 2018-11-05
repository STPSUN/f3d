<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:84:"/www/wwwroot/luckywinner.vip/public/../addons/fomo/user/view/default/team/index.html";i:1535992912;}*/ ?>


<div class="right-main">
    <div class="page_nav" id="js_page_nav"><span class="page_title"><?php echo $page_nav; ?></span></div>
    <div id="js_main_header" class="ui-form main_header">
        <span class="frm_input_box search append">
            <a href="javascript:void(0);" id="js_search" class="frm_input_append">
                <i class="icon wb-search" title="搜索"></i>
            </a>
            <input type="text" id="js_keyword" placeholder="请输入名称" value="" class="frm_input" />
        </span>
        <button type="button" id="js_addBtn" class="btn btn-primary right"><i class="icon wb-plus"></i> 添加<?php echo $page_nav; ?></button>
    </div>
    <table id="grid-table">
        <thead frozen="true">
        <th data-options="field:'pic',width:250, align:'center',formatter:formatImg">图片</th>
        <th data-options="field:'name',width:100,align:'center'">名称</th> 
        </thead>
        <thead>
            <tr>
                <th data-options="field:'detail',width:200, align:'center'">简介</th>
                <th data-options="field:'status',width:100, align:'center',formatter:formatStatus">是否启用</th>
                <th data-options="field:'pool_rate',width:120, align:'center',formatter:formatRate">投注奖池比率</th>
                <th data-options="field:'p3d_rate',width:120, align:'center',formatter:formatRate">投注p3d分红比率</th>
                <th data-options="field:'f3d_rate',width:120, align:'center',formatter:formatRate">投注f3d分红比率</th>
                <th data-options="field:'to_next_rate',width:120, align:'center',formatter:formatRate">进入下一局比率</th>
                <th data-options="field:'end_f3d_rate',width:120, align:'center',formatter:formatRate">奖金f3d分红比率</th>
                <th data-options="field:'end_p3d_rate',width:120, align:'center',formatter:formatRate">奖金p3d分红比率</th>
                <th data-options="field:'update_time',width:140, align:'center'">更新时间</th>
                <th data-options="field:'_oper',width:250,halign:'center',formatter: formatOper">操作</th>
            </tr>
        </thead>
    </table>
</div>



<script type="text/javascript">
    
    function formatOper(value, row, index) {
        var html = '<span class="grid-operation">';
        html += '<button type="button" onclick="edit(' + row['id'] + ')" class="btn btn-xs btn-default edit-btn"><i class="icon wb-edit"></i>修改</button>';
        html += '<button type="button" onclick="del(' + row['id'] + ')" class="btn btn-xs btn-default del-btn"><i class="icon wb-close"></i>删除</button>';
        html += '</span>';
        return html;
    }
    
    function formatImg(value){
        var text = '<img width="100" height="100" src="'+value+'">';
        return text;
    }
    
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
            pageSize: 20
        });
        //设置分页控件 
        $('#grid-table').datagrid('getPager').pagination({
            pageSize: 20, //每页显示的记录条数，默认为10 
            pageList: [20, 30, 50]
        });
    });
    
    function formatStatus(value,row,index){
        var text = '<span style="color:green">是</span>';
        if(value == '0'){
            text = '<span style="color:red">否</span>';
        }
        return text;
    }
    
    function formatRate(value,row,index){
        var text = value + '%'
        return text;
    }
    
    function edit(id) {
        var url = getURL('edit', 'id=' + id);
        openBarWin('编辑', 830, 500, url, function () {
            reload();
        }, ['保存', '取消']);
    }

    $("#js_addBtn").click(function () {
        if ($(this).hasClass("disabled")) {
            return;
        }
        var url = getURL('edit');
        openBarWin('添加', 830, 500, url, function () {
            reload();
        });
    });

    
    function del(id) {
        confirm("确认要删除此战队吗？", function () {
            var url = getURL('del');
            $.getJSON(url, {id: id}, function (json) {
                if (json.success)
                    reload();
                else
                    alert(json.message);
            });
        });
    }

    $("#js_search").click(function () {
        reload();
    });
    function reload() {
        var keyword = $("#js_keyword").val();
        $('#grid-table').datagrid('reload', {keyword: keyword});
    }
    $("#type").change(function () {
        var keyword = $("#js_keyword").val();
        $('#grid-table').datagrid('reload', {keyword: keyword});
    });
</script>
