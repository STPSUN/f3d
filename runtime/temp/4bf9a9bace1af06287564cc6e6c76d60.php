<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:90:"/www/wwwroot/luckywinner.vip/public/../addons/config/user/view/default/exchange/index.html";i:1535992875;}*/ ?>


<div class="right-main">
    <div class="page_nav" id="js_page_nav"><span class="page_title"><?php echo $page_nav; ?></span></div>
    <div id="js_main_header" class="ui-form main_header">
        <span class="frm_input_box search append">
            <a href="javascript:void(0);" id="js_search" class="frm_input_append">
                <i class="icon wb-search" title="搜索"></i>
            </a>
            <input type="text" id="js_keyword" placeholder="请输入货币名称" value="" class="frm_input" />
        </span>
        <span class="right">       
            <button type="button" id="js_addBtn" class="btn btn-primary"><i class="icon wb-reload"></i> 更新<?php echo $page_nav; ?></button>
        </span>
    </div>
    
    <table id="grid-table">
        <thead frozen="true">
        <th data-options="field:'name',width:140,align:'center',sortable: true">货币名称</th>    
        </thead>
        <thead>
            <tr>
                <th data-options="field:'rate',width:140,align:'center',sortable: true">人民币比率</th>
                <th data-options="field:'amount',width:140,align:'center',sortable: true">交易单位</th>
                <th data-options="field:'buying_rate',width:100,align:'center',sortable: true">现汇买入价</th>  
                <th data-options="field:'cash_buying_rate',width:120,align:'center',sortable: true">现钞买入价</th>  
                <th data-options="field:'cash_sale_rate',width:140,align:'center',sortable: true">现钞卖出价</th>  
                <th data-options="field:'converted_price',width:140,align:'center',sortable: true">中行折算价</th>  
                <th data-options="field:'update_time',width:140,align:'center',sortable: true">更新时间</th>  
                <!--<th data-options="field:'_oper',halign:'center',formatter: formatOper">操作</th>-->
            </tr>
        </thead>
    </table>
</div>



<script type="text/javascript">

    function formatOper(value, row, index) {
        var html = '<span class="grid-operation">';
        html += '<button type="button" onclick="edit(' + row['id'] + ')" class="btn btn-xs btn-default edit-btn"><i class="icon wb-edit"></i>编辑</button>';
        if(row['is_admin'] == 0)
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
            pagination: true,
            pageSize: 20
        });
        //设置分页控件 
        $('#grid-table').datagrid('getPager').pagination({
            pageSize: 20, //每页显示的记录条数，默认为10 
            pageList: [20, 30, 50]
        });
    });

    $("#js_addBtn").click(function () {
        var url = getURL('update');
        $.getJSON(url, {}, function (json) {
            if (json.success)
                reload();
            else
                alert(json.message);
        });
    })

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
