<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:90:"/www/wwwroot/luckywinner.vip/public/../addons/config/user/view/default/role/role_list.html";i:1535992878;}*/ ?>


<link rel="stylesheet" href="__STATIC__/zTree/css/zTreeStyle/zTreeStyle.css" type="text/css">
<style type="text/css">
    .brand_box div{margin:2px 0;}
    .left_tree_wrap{min-height:300px;}        
    .ztree{overflow:auto}
    .ztree li span.button.switch.level0 {visibility:hidden; width:1px;}
    .ztree li ul.level0 {padding:0; background:none;}
    .ztree li span.button.pIcon01_ico_open, .ztree li span.button.pIcon01_ico_close{margin-right:2px; background: url(__IMG__/1_open.png) no-repeat scroll 0 0 transparent; vertical-align:top; *vertical-align:middle}
    .ztree li span.button.icon01_ico_docu{display:none} 
    .ztree li span.button.pIcon01_ico_docu{display:none}     
    .ztree li span.button.icon01_ico_open, .ztree li span.button.icon01_ico_close{display:none};    
</style>
<div class="right-main">
    <div class="page_nav" id="js_page_nav"><span class="page_title"><?php echo $page_nav; ?></span></div>
    <div id="js_main_header">
        <span class="frm_input_box search append">
            <a href="javascript:void(0);" id="js_search" class="frm_input_append">
                <i class="icon wb-search" title="搜索"></i>
            </a>
            <input type="text" id="js_keyword" placeholder="请输入权限名称" value="" class="frm_input" />
        </span>
        <span class="right">        
            <a href="javascript:;" id="js_addBtn" class="btn btn-primary">添加角色</a>　         
        </span>
    </div>
    
    <table id="grid-table"></table>
</div>


<script type="text/javascript" src="__STATIC__/zTree/js/jquery.ztree.core.js"></script>
<script type="text/javascript" src="__STATIC__/zTree/js/jquery.ztree.excheck.js"></script>
<script type="text/javascript">
    function formatOper(value, row, index) {
        var html = '<span class="grid-operation">';
        html += '<button type="button" onclick="edit(' + row['id'] + ')" class="btn btn-xs btn-default edit-btn"><i class="icon wb-edit"></i>编辑</button>';
        html += '<button type="button" onclick="del(' + row['id'] + ')" class="btn btn-xs btn-default del-btn"><i class="icon wb-close"></i>删除</button>';
        html += '</span>';
        return html;
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
            columns: [[
                    {field: 'name', title: '角色名称', width: 120, halign: 'center', sortable: true},
                    {field: '_oper', title: '操作', width: 120, halign: 'center', align: 'left', formatter: formatOper}
                ]]
        });
    });

    $("#js_addBtn").click(function () {
        var url = getURL('role');
        openBarWin('添加角色信息', 400, 600, url, function () {
            reload();
        });
    });
    function edit(id) {
        var url = getURL('role', 'id=' + id);
        openBarWin('编辑角色信息', 400, 600, url, function () {
            reload();
        },['保存','取消']);
    }
    function del(id) {
        confirm("确定要删除吗？", function () {
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
    }
</script>
