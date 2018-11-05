<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:86:"/www/wwwroot/luckywinner.vip/public/../addons/config/user/view/default/help/index.html";i:1535992876;}*/ ?>


<div class="right-main">
    <div class="page_nav" id="js_page_nav"><span class="page_title"><?php echo $page_nav; ?></span></div>
    <div id="js_main_header" class="ui-form main_header">
        <span class="frm_input_box search append">
            <a href="javascript:void(0);" id="js_search" class="frm_input_append">
                <i class="icon wb-search" title="搜索"></i>
            </a>
            <input type="text" id="js_keyword" placeholder="请输入标题" value="" class="frm_input" />
        </span>
        <span class="right">       
            <button type="button" id="js_addBtn" class="btn btn-primary"><i class="icon wb-plus"></i> 添加<?php echo $page_nav; ?></button>
        </span>
    </div>
    
    <table id="grid-table">
        <thead frozen="true">
        <th data-options="field:'title',width:200,align:'center',sortable: true">标题</th>    
        </thead>
        <thead>
            <tr>
                <th data-options="field:'content',width:350,align:'center',formatter:formatterHTML">内容</th>
                <th data-options="field:'type',width:350,align:'center',formatter:formatterType">类型</th>
                <th data-options="field:'_oper',halign:'center',formatter: formatOper">操作</th>
            </tr>
        </thead>
    </table>
</div>



<script type="text/javascript">

    function formatOper(value, row, index) {
        var html = '<span class="grid-operation">';
        html += '<button type="button" onclick="edit(' + row['id'] + ')" class="btn btn-xs btn-default edit-btn"><i class="icon wb-edit"></i>编辑</button>';
        html += '<button type="button" onclick="del(' + row['id'] + ')" class="btn btn-xs btn-default del-btn"><i class="icon wb-close"></i>删除</button>';
        html += '</span>';
        return html;
    }
    
    function formatterHTML(value,row,index){
        if (value != '' && value != null && typeof(value) != 'undefined') {
            return value.replace(/<[^<>]+?>/g,'');//删除所有HTML标签
        } else {
            return '';
        }
    }
    function formatterType(value,row,index){
        switch (value){
            case 1:
                return "商学院";break;
            case 2:
                return "游戏规则";break;
            case 3:
                return "常见问题";break;
        }

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

    function edit(id) {
        var url = getURL('edit', 'id=' + id);
        openBarWin('编辑', 1000, 600, url, function () {
            reload();
        }, ['保存', '取消']);
    }

    function del(id) {
        confirm("确认要删除此数据吗？", function () {
            var url = getURL('del');
            $.getJSON(url, {id: id}, function (json) {
                if (json.success)
                    reload();
                else
                    alert(json.message);
            });
        });
    }

    $("#js_addBtn").click(function () {
        if ($(this).hasClass("disabled")) {
            return;
        }
        var url = getURL('edit');
        openBarWin('添加', 1000, 600, url, function () {
            reload();
        });
    });
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
