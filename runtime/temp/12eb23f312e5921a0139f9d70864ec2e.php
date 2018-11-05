<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:87:"/www/wwwroot/luckywinner.vip/public/../addons/fomo/user/view/default/airdrop/index.html";i:1535992907;}*/ ?>


<div class="right-main">
    <div class="page_nav" id="js_page_nav"><span class="page_title"><?php echo $page_nav; ?></span></div>
    <div id="js_main_header" class="ui-form main_header">
        <!--<span class="frm_input_box search append">-->
            <!--<a href="javascript:void(0);" id="js_search" class="frm_input_append">-->
                <!--<i class="icon wb-search" title="搜索"></i>-->
            <!--</a>-->
            <!--<input type="text" id="js_keyword" placeholder="请输入币种名称" value="" class="frm_input" />-->
        <!--</span>-->
        <span class="right">       
            <button type="button" id="js_addBtn" class="btn btn-primary"><i class="icon fa fa-plus"></i> 添加配置</button>
        </span>
    </div>
    <table id="grid-table">
        <thead>
        <tr>
            <th data-options="field:'min',width:160, align:'center'">ETH最小数量</th>
            <th data-options="field:'max',width:160, align:'center'">ETH最大或以上</th>
            <th data-options="field:'rate',width:120, align:'center',formatter:formatRate">空投奖金比率</th>
            <th data-options="field:'update_time',width:140, align:'center'">更新时间</th>
            <th data-options="field:'_oper',width:140,halign:'center',formatter: formatOper">操作</th>
        </tr>
        </thead>
    </table>
</div>



<script type="text/javascript" src="__STATIC__/jquery/jquery.cookie.js"></script>
<script type="text/javascript">
    $("#js_search").click(function () {
        reload();
    });
    function formatRate(value, row, index){
        return value + '%';
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
            pageSize: 20,
        });
        //设置分页控件 
        $('#grid-table').datagrid('getPager').pagination({
            pageSize: 20, //每页显示的记录条数，默认为10 
            pageList: [20, 30, 50]
        });
    });

    function formatImg(value){
        var text = '<img width="100" height="70" src="'+value+'">';
        return text;
    }

    function formatOper(value, row, index) {
        var html = '<span class="grid-operation">';
        html += '<button type="button" onclick="edit(' + row['id'] + ')" class="btn btn-xs btn-default edit-btn"><i class="icon wb-edit"></i>编辑</button>';
        html += '<button type="button" onclick="del(' + row['id'] + ')" class="btn btn-xs btn-default del-btn"><i class="icon wb-close"></i>删除</button>';
        html += '</span>';
        return html;
    }
    
    function reload() {
        var keyword = $("#js_keyword").val();
        $('#grid-table').datagrid('reload', {
            keyword: keyword,
        });
    }
    
    function edit(id) {
        var url = getURL('edit', 'id=' + id);
        openBarWin('编辑', 1000, 400, url, function () {
            reload();
        }, ['确定','取消']);
    }
    
    $("#js_addBtn").click(function () {
        if ($(this).hasClass("disabled")) {
            return;
        }
        var url = getURL('add');
        openBarWin('添加', 420, 220, url, function () {
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

</script>
