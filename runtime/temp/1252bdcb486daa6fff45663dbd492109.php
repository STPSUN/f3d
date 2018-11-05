<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:84:"/www/wwwroot/luckywinner.vip/public/../addons/otc/user/view/default/order/index.html";i:1539585526;}*/ ?>


 
<div class="right-main">
    <div class="page_nav" id="js_page_nav"><span class="page_title"><?php echo $page_nav; ?></span></div>
    <ul class="tab_navs" id="js_tab_navs">
        <li class="<?php if($status == -1): ?>current<?php endif; ?>"><a class="pjax" href="<?php echo getUrl('index','status=-1'); ?>">撤单</a></li>            
        <li class="<?php if($status == 0): ?>current<?php endif; ?>"><a class="pjax" href="<?php echo getUrl('index','status=0'); ?>">未成交</a></li>  
        <li class="<?php if($status == 2): ?>current<?php endif; ?>"><a class="pjax" href="<?php echo getUrl('index','status=2'); ?>">已匹配</a></li>
        <li class="<?php if($status == 3): ?>current<?php endif; ?>"><a class="pjax" href="<?php echo getUrl('index','status=3'); ?>">待确认</a></li>
        <li class="<?php if($status == 4): ?>current<?php endif; ?>"><a class="pjax" href="<?php echo getUrl('index','status=4'); ?>">已完成</a></li>
        
    </ul>
    <div id="js_main_header" class="ui-form main_header">
        <span class="frm_input_box search append">
            <a href="javascript:void(0);" id="js_search" class="frm_input_append">
                <i class="icon wb-search" title="搜索"></i>
            </a>
            <input type="text" id="js_keyword" placeholder="请输入用户邮箱名称" value="" class="frm_input" />
        </span>
    </div>
    <table id="grid-table">
        <thead frozen="true">
        <th data-options="field:'username',width:120,align:'center'">委托用户</th>
        <th data-options="field:'buy_username',width:100, align:'center'">下单用户</th>
        <th data-options="field:'candy_name',width:100, align:'center'">币种</th>
        <th data-options="field:'num',width:120,align:'center'">数量</th>    
        </thead>
        <thead>
            <tr>
                <th data-options="field:'price',width:120, align:'center',sortable: true">单价</th>
                <th data-options="field:'pay_amount',width:120, align:'center',sortable: true">成交额</th>
                <th data-options="field:'update_time',width:150, align:'center',sortable: true">更新时间</th>
                <th data-options="field:'remark',width:200, align:'center',sortable: true">备注</th>
                <th data-options="field:'status',width:140,align:'center', formatter:formatStatus">订单状态</th>
                
                <th data-options="field:'_oper',width:220,halign:'center',formatter: formatOper">操作</th>
            </tr>
        </thead>
    </table>
</div>



<script type="text/javascript">
    var status = '<?php echo $status; ?>'
    $("#js_search").click(function () {
        reload();
    });
    $(function () {
        $('#grid-table').datagrid({
            url: getURL('loadList','status='+status),
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

    function confirm_order(id){
        confirm("确定要确认完成订单吗？", function () {
            var url = getURL('confirm');
            showLoading('处理转账中...');
            $.post(url, {id:id}, function (json) {
                hideLoading();
                if (json.success)
                    reload();
                else{
                     msg(json.message);
                }
            });
        });
    }
    
    function cancel_order(id,status){
        confirm("确定要取消选中的订单吗?", function () {
            var url = getURL('cancel');
            $.post(url, {id:id,status: status}, function (json) {
                if (json.success)
                    reload();
                else{
                   msg(json.message);
                }

            });
        });
    }

    function cancel_unset(id){
        confirm("确定要取消选中的订单吗?", function () {
            var url = getURL('unsetCancel');
            $.post(url, {id:id}, function (json) {
                if (json.success)
                    reload();
                else{
                    msg(json.message);
                }

            });
        });
    }
    
    function formatOper(value, row, index) {
        var html = '<span class="grid-operation">';
        html += '<button type="button" onclick="detail(' + row['id'] + ')" class="btn btn-xs btn-default edit-btn"><i class="icon wb-eye"></i>查看详情</button>';
        if(row['status'] == 3){
            html += '<button type="button" onclick="confirm_order(' + row['id'] + ')" class="btn btn-xs btn-default edit-btn"><i class="icon wb-edit"></i>确认完成</button>';
            html += '<button type="button" onclick="cancel_order(' + row['id'] + ',3)" class="btn btn-xs btn-default edit-btn"><i class="icon wb-edit"></i>取消订单</button>';
        }
        if(row['status'] == 2)
        {
            html += '<button type="button" onclick="cancel_order(' + row['id'] + ',2)" class="btn btn-xs btn-default edit-btn"><i class="icon wb-edit"></i>取消订单</button>';
        }
        if(row['status'] == 0)
        {
            html += '<button type="button" onclick="cancel_unset(' + row['id'] + ',0)" class="btn btn-xs btn-default edit-btn"><i class="icon wb-edit"></i>取消订单</button>';
        }
        html += '</span>';
        return html;
    }
    
    function detail(id){
        var url = getURL('detail', 'id=' + id);
        openBarWin('查看详情', 800, 600, url, function () {
            reload();
        }, []);
    }
    
    function formatStatus(value,row,index){
        var text = '撤单';
        if(value == 0)
            text = '未成交'
        else if(value == 2)
            text = '已匹配'
        else if(value == 3)
            text = '待确认'
        else if(value == 4)
            text = '已完成'

        return text;
    }
    
    function reload() {
        var keyword = $("#js_keyword").val();
        $('#grid-table').datagrid('reload', {
            keyword: keyword,
        });
    }

</script>
