<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:92:"/www/wwwroot/luckywinner.vip/public/../addons/fomo/user/view/default/reward_bonus/index.html";i:1536809041;}*/ ?>


<div class="right-main">
    <div class="page_nav" id="js_page_nav"><span class="page_title"><?php echo $page_nav; ?></span></div>
    <ul class="tab_navs" id="js_tab_navs">
        <li class="<?php if($status == 0): ?>current<?php endif; ?>"><a class="pjax" href="<?php echo getUrl('index','status=0'); ?>">未释放</a></li>
        <li class="<?php if($status == 1): ?>current<?php endif; ?>"><a class="pjax" href="<?php echo getUrl('index','status=1'); ?>">已释放</a></li>
    </ul>
    <div id="js_main_header" class="ui-form main_header">
        <span>
            <select name="coin_id" id="coin_id" class="form-control" style="width:130px">
                <option value="0">选择币种</option>
                <?php if(is_array($coins) || $coins instanceof \think\Collection || $coins instanceof \think\Paginator): $i = 0; $__LIST__ = $coins;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$game): $mod = ($i % 2 );++$i;?>
                <option value="<?php echo $game['id']; ?>"><?php echo $game['coin_name']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </span>
        <span>
            <select name="type" id="type" class="form-control" style="width:130px">
                <option value="-1">选择分红类型</option>
                <option value="0">p3d分红</option>
                <option value="1">f3d分红</option>
            </select>
        </span>
        <span>
            <select name="type" id="scene" class="form-control" style="width:130px">
                <option value="-1">选择分红场景</option>
                <option value="0">p3d购买</option>
                <option value="1">f3d购买</option>
                <option value="2">f3d开奖</option>
            </select>
        </span>


        <span class="frm_input_box search append">
            <a href="javascript:void(0);" id="js_search" class="frm_input_append">
                <i class="icon wb-search" title="搜索"></i>
            </a>
            <input type="text" id="js_keyword" placeholder="请输入名称" value="" class="frm_input"/>
        </span>
    </div>
    <table id="grid-table">
        <thead frozen="true">
        <th data-options="field:'username',width:100,align:'center'">用户名称</th>
        </thead>
        <thead>
        <tr>
            <th data-options="field:'game_name',width:120, align:'center'">所属游戏</th>
            <th data-options="field:'coin_name',width:120, align:'center'">分红币种</th>
            <th data-options="field:'status',width:100, align:'center',formatter:formatStatus">游戏状态</th>
            
            <th data-options="field:'amount',width:160, align:'center'">分红值</th>
            <th data-options="field:'type',width:140, align:'center',formatter:formatType">分红类型</th>
            <th data-options="field:'scene',width:140, align:'center',formatter:formatScene">分红场景</th>
            <th data-options="field:'update_time',width:160, align:'center'">更新时间</th>
            <th data-options="field:'_oper',width:100,halign:'center',formatter: formatOper">操作</th>
        </tr>
        </thead>
    </table>
</div>



<script type="text/javascript">
    var type = "<?php echo $type; ?>";
    var status = "<?php echo $status; ?>";

    function formatOper(value, row, index) {
        if(row.status == '0'){
            var html = '<span class="grid-operation">';
            html += '<button type="button" onclick="del(' + row['id'] + ')" class="btn btn-xs btn-default edit-btn"><i class="icon wb-edit"></i>释放</button>';
            html += '</span>';
            return html;
        }
    }
    function formatStatus(value,row,index){
        var text = '未处理';
        if(value == '1')
            text = '<span style="color:green">已处理</span>';
        return text;
    }
    function formatType(value,row,index){
        var text = 'p3d分红';
        if(row.type == '1')
            text = '<span style="color:green">f3d分红</span>';
        return text;
    }
    function formatScene(value,row,index){
        var text = 'p3d购买';
        if(row.scene == '1')
            text = '<span style="color:green">f3d购买</span>';
        if(row.scene == '2')
            text = '<span style="color:green">f3d开奖</span>';
        return text;
    }

    $(function () {
        $('#grid-table').datagrid({
            url: getURL('loadList', "type=" + type + "&status=" + status),
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
            onLoadSuccess:function(data) {
                $('#grid-table').datagrid('reloadFooter', [
                    {
                        coin_name: '统计',
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

    $("#js_search").click(function () {
        reload();
    });

    function del(id) {
        confirm("确认手动释放该分红？", function () {
            var url = "http://<?php echo $_SERVER['SERVER_NAME']; ?>/index/crontab/excute/addon/fomo";
            $.getJSON(url, {id: id}, function (json) {
                if (json.success)
                    reload();
                else
                    alert(json.message);
            });
        });
    }
    function reload() {
        var keyword = $("#js_keyword").val();
        var type = $("#type").val();
        var scene = $("#scene").val();
        var coin_id = $("#coin_id").val();
        $('#grid-table').datagrid('reload', {keyword: keyword, type: type, coin_id: coin_id, scene:scene});
    }

    $("#coin_id").change(function () {
        reload()
    });

    $("#type").change(function () {
        reload()
    });

</script>
