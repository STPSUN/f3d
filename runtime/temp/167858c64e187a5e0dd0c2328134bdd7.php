<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:84:"/www/wwwroot/luckywinner.vip/public/../addons/eth/user/view/default/trade/index.html";i:1535992887;}*/ ?>


 
<div class="right-main">
    <div class="page_nav" id="js_page_nav"><span class="page_title"><?php echo $page_nav; ?></span></div>
    <ul class="tab_navs" id="js_tab_navs">
        <li class="<?php if($status == 0): ?>current<?php endif; ?>"><a class="pjax" href="<?php echo getUrl('index','status=0'); ?>">未审核</a></li>            
        <li class="<?php if($status == 1): ?>current<?php endif; ?>"><a class="pjax" href="<?php echo getUrl('index','status=1'); ?>">已完成</a></li>
        <li class="<?php if($status == 2): ?>current<?php endif; ?>"><a class="pjax" href="<?php echo getUrl('index','status=2'); ?>">提交转出成功</a></li>
        <li class="<?php if($status == -1): ?>current<?php endif; ?>"><a class="pjax" href="<?php echo getUrl('index','status=-1'); ?>">未通过</a></li>
        <li class="<?php if($status == -2): ?>current<?php endif; ?>"><a class="pjax" href="<?php echo getUrl('index','status=-2'); ?>">转出异常</a></li>
    </ul>
    <div id="js_main_header" class="ui-form main_header">
        <?php if($status == 1): ?>
        <span>
            <select name="type" id="type" class="form-control" style="width:120px">
                <option value="">全部</option>
                <option value="0">转出</option>
                <option value="1">转入</option>
            </select>
        </span>
        <?php endif; ?>
        <span class="frm_input_box search append">
            <a href="javascript:void(0);" id="js_search" class="frm_input_append">
                <i class="icon wb-search" title="搜索"></i>
            </a>
            <input type="text" id="js_keyword" placeholder="请输入用户邮箱名称" value="" class="frm_input" />
        </span>
    </div>
    <table id="grid-table">
        <thead frozen="true">
        <th data-options="field:'username',width:100,align:'center'">用户名称</th> 
        <th data-options="field:'phone',width:100,align:'center'">手机号</th> 
        <th data-options="field:'amount',width:120,align:'center'">数量</th>
        <th data-options="field:'coin_name',width:100, align:'center'">币种</th>
        </thead>
        <thead>
            <tr>
                <th data-options="field:'type',width:100, align:'center', formatter:formatType">类型</th>
                <th data-options="field:'to_address',width:300, align:'center',sortable: true">目标钱包地址</th>
                <th data-options="field:'txhash',width:300, align:'center',sortable: true">交易哈希值</th>
                <th data-options="field:'update_time',width:150, align:'center',sortable: true">更新时间</th>
                <th data-options="field:'remark',width:200, align:'center',sortable: true">备注</th>
                <th data-options="field:'status',width:140,align:'center', formatter:formatStatus">订单状态</th>
                <th data-options="field:'_oper',width:140,halign:'center',formatter: formatOper">操作</th>
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
            showFooter:true,
            pageSize: 20,
            onLoadSuccess: function(data){
                $('#grid-table').datagrid('reloadFooter', [
                    {
                        phone: '统计',
                        amount: data.count_total
                    }
                ]);
            }
        });
        //设置分页控件 
        $('#grid-table').datagrid('getPager').pagination({
            pageSize: 20, //每页显示的记录条数，默认为10 
            pageList: [20, 30, 50]
        });
    });

    function appr(id){
        confirm("确定要审核所选订单吗？", function () {
            var url = getURL('appr');
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
    
    function cancelAppr(id){
        confirm("确定要驳回选中的订单吗?", function () {
            var url = getURL('cancel_appr');
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
        if(row['status'] == 0){
            html += '<button type="button" onclick="appr(' + row['id'] + ')" class="btn btn-xs btn-default edit-btn"><i class="icon wb-edit"></i>通过</button>';
            html += '<button type="button" onclick="cancelAppr(' + row['id'] + ')" class="btn btn-xs btn-default edit-btn"><i class="icon wb-edit"></i>不通过</button>';
        }
//        html += '<button type="button" onclick="del(' + row['id'] + ')" class="btn btn-xs btn-default del-btn"><i class="icon wb-close"></i>删除</button>';
        html += '</span>';
        return html;
    }
    
    function formatStatus(value,row,index){
        var tx_arr=['未审核','已完成','未通过','处理中','转出成功','异常'];

        return tx_arr[value];
    }
    
    function formatType(value,row,index){
        if(row['id']){
            var text ='<span style="color:red">转出</span>'
            if(value == 1){
                text = '<span style="color:green">转入</span>'
            }
            return text
        }
    }
    
    $("#type").change(function(){
        reload();
    })
    
    function reload() {
        var keyword = $("#js_keyword").val();
        var type = $("#type").val();
        $('#grid-table').datagrid('reload', {
            keyword: keyword,
            type:type
        });
    }

</script>
