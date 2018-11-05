<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:87:"/www/wwwroot/luckywinner.vip/public/../addons/config/user/view/default/coins/index.html";i:1535992874;}*/ ?>


<div class="right-main ui-form">
    <div class="page_nav" id="js_page_nav"><span class="page_title"><?php echo $page_nav; ?></span></div>       
    <div id="js_main_header" class="main_header">
        <div>
            <span class="frm_input_box search append">
                <a href="javascript:void(0);" id="js_search" class="frm_input_append">
                    <i class="icon wb-search" title="搜索"></i>
                </a>
                <input type="text" id="js_keyword" placeholder="请输入名称" value="" class="frm_input" />
            </span>
            <span class="right">       
                <button type="button" id="js_addBtn" class="btn btn-primary"><i class="icon wb-plus"></i> 添加<?php echo $page_nav; ?></button>
            </span>
        </div>
    </div>    
    <table id="grid-table"></table>    
</div>


<script type="text/javascript">

    function formatOper(value, row, index) {
        var html = '<span class="grid-operation">';
        html += '<button type="button" onclick="edit(' + row['id'] + ', 0)" class="btn btn-xs btn-default view-btn"><i class="icon wb-edit"></i>编辑</button>';
        html += '<button type="button" onclick="del(' + row['id'] + ')" class="btn btn-xs btn-default del-btn"><i class="icon wb-close"></i>删除</button>';
        html += '</span>';
        return html;
    }
    $(function () {
        $('#grid-table').datagrid({
            url: getURL('loadList'),
            method: "GET",
            height: getGridHeight(),
            singleSelect: false,
            remoteSort: false,
            rownumbers: true,
            multiSort: true,
            emptyMsg: '<span>无相关数据</span>',
            pagination: true,
            pageSize: 20,
            columns: [[
                    {field: 'coin_name', title: '币种名称', width: 90, align: 'center', sortable: true},
                    {field: 'is_token', title: '是否代币', width: 90, align: 'center',formatter:formatType},
                    {field: 'update_time', title: '更新时间', width: 140, align: 'center'},
                    {field: 'without_rate', title: '提现手续费', width: 140, align: 'center',formatter:formatRate},
                    {field: 'without_min', title: '最低提现额度', width: 140, align: 'center'},
                    
                    {field: '_oper', title: '操作', width: 160, align: 'center', sortable: true, formatter: formatOper}
                ]]
        });

        //设置分页控件 
        var p = $('#grid-table').datagrid('getPager');
        $(p).pagination({
            pageSize: 20, //每页显示的记录条数，默认为10 
            pageList: [20, 30, 50]
        });

    });
    
    function formatRate(val,row,index){
        var text = val + '%'
        return text;
    }
    
    function formatType(value, row, index){
        var text = '是';
        if(value == 0){
            text = '否';
        }
        return text;
    }

    $("#col_main").resize(function () {
        $('#grid-table').datagrid('resize', {
            height: getGridHeight()
        });
    });

    $("#js_addBtn").click(function () {
        var url = getURL('edit');
        openBarWin('添加币种', 800, 370, url, function () {
            reload();
        });
    });

    function edit(id, act) {
        var url = getURL('edit', 'id=' + id + '&act=' + act);
        openBarWin('编辑币种', 800, 370, url, function () {
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

    $("#js_search").click(function () {
        reload();
    });

    function reload() {
        var keyword = $("#js_keyword").val();
        $('#grid-table').datagrid('reload', {
            keyword: keyword
        });
    }

</script>
