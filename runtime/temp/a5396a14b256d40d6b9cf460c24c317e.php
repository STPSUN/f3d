<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:84:"/www/wwwroot/luckywinner.vip/public/../addons/fomo/user/view/default/game/index.html";i:1537585674;s:75:"/www/wwwroot/luckywinner.vip/public/../web/user/view/default/base/list.html";i:1535992995;s:79:"/www/wwwroot/luckywinner.vip/public/../web/user/view/default/public/header.html";i:1535992998;}*/ ?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $SYS_TITLE; ?></title>        
        <link rel="stylesheet" type="text/css" href="__STATIC__/web-icons/css.css" />   
        <link rel="stylesheet" type="text/css" href="__STATIC__/easyui/themes/custom/easyui.css" />  
        <link rel="stylesheet" type="text/css" href="__CSS__/style.css" />           
        <script type="text/javascript" src="__STATIC__/jquery/jquery.min.js"></script>
    </head>
    <body>
        <style type="text/css">   
.li0{background-color:#96c}.li1{background-color:#69f}.li2{background-color:#926dde}.li3{background-color:#57c7d4}.li4{background-color:#62a8ea}.li5{background-color:#926dde}.li6{background-color:#959801}.li7{background-color:#7C51D1}.li8{background-color:#5166D6}.li9{background-color:#47B8C6}.li10{background-color:#3AA99E}.li11{background-color:#A2CAEE}.li12{background-color:#465BD4}.li13{background-color:#5166D6}.li14{background-color:#46BE8A}.li15{background-color:#178D81}.li16{background-color:#79D1C9}.li17{background-color:#3583CA}.li18{background-color:#A2CAEE}
.notise{padding: 0 5px}
.notise a{color:#ff0000}
.notise a:hover{color:#ff0000}
@media(max-width: 1000px){ .notise{display: none}}
</style>
<div id="header">
    <div class="navbar-header">                 
        <span class="mystyle-brand"><i class="icon wb-home"></i></span>
        <a class="navbar-console" id='console'>管理控制台</a>
    </div>
    <div class="nav">      
        <ul id="js_nav_menu" class="navLeft">
            <?php 
                $m = new \web\common\model\sys\UserNavMenuModel();
                $categorys= $m->getCategoryParentMenu(0);                  
                foreach($categorys as $cate1){            
                echo '<li id="act_'.$cate1['id'].'" class="nav-menu"><a class="menu-title" href="javascript:;">'.$cate1['title'].'</a>';
                 ?>
                <div class="sub-nav-container">                                                                        
                    <div class="sub-nav-category">
                        <div class="sub-nav-item">
                            <?php 
                            $i=0;
                            $categorys2= $m->getCategoryParentMenu($cate1['id']);                  
                            foreach($categorys2 as $cate2){                                                     
                            echo '<a class="js_pan li'.$i.' '.$cate2['target'].'" data-width="'.$cate2['dialog_width'].'" data-height="'.$cate2['dialog_height'].'" id="menu_'.$cate2['id'].'" href="'.getUrl($cate2['controller'].'/'.$cate2['action'],'',$cate2['addon']).'">'.$cate2['title'].'</a>';  
                            $i++;
                            }
                             ?>
                        </div>
                    </div>
                </div>
                <?php echo '</li>';} ?>
            </li>
        </ul>
        </ul>
        <ul class="navRight">
            <li class="nav-menu">
                <a class="sub_menu" href="javascript:;">您好，<?php echo $login_user_name; ?></a>
                <div class="mContent">
                    <a href="javascript:;" id="js_edit_pwd">修改登录密码</a>
                </div>
            </li>
            <li class="logout"><a title="退出系统" href="javascript:;" class="sub_menu js_logout">
                    <i class="icon wb-power"></i>&nbsp;退出</a></li>
        </ul>
    </div>
</div>
<script type="text/javascript" src="__STATIC__/jquery/jquery.pjax.js"></script>
<script type="text/javascript">
    var _module_name = null;
    var _controller_name = null;
    var _addon_name = null;
    function getURL(action, param, addon) {
        var m = "<?php echo MODULE_NAME; ?>";
        var c = "<?php echo $_CONTROLLER_NAME; ?>";
        var a = "<?php echo $_ADDON_NAME; ?>";
        if (_module_name != null)
            m = _module_name;
        if (_controller_name != null)
            c = _controller_name;
        var arr = action.split('/');
        var url = "";
        if (arr.length == 3) {
            url = action;
        } else if (arr.length == 2) {
            url = "/" + m + "/" + action;
        } else {
            url = "/" + m + "/" + c + "/" + action;
        }
        if (addon != null)
            a = addon;
        else if (_addon_name != null)
            a = _addon_name;
        if (a != "")
            url += "/addon/" + a;
        if (param != null && param != "") {
            var ref = "";
            if (typeof param === 'string') {
                ref = param;
            } else if (typeof param === 'object') {
                for (var key in param) {
                    if (ref != "")
                        ref += "&";
                    ref += key + "=" + param[key];
                }
            }
            if (ref != "") {
                if (url.indexOf("?") == -1)
                    url += "?";
                else
                    url += "&";
                url += ref;
            }
        }
        return url;
    }

    $(function () {
        $(document).pjax('a.pjax', '#main_container', {timeout: 5000});
        $("#js_nav_menu").on('pjax:click', function (e, obj) {
        });
        $(document).on('pjax:beforeReplace', function (event, data, xhr) {
            _module_name = data.module;
            _controller_name = data.controller;
            _addon_name = data.addon;
            $("#curMenu").val('menu_' + _addon_name + '_' + _controller_name);
        });
        $(document).on('pjax:success', function (event, data, xhr) {
            $(event.relatedTarget).parent().parent().parent().hide();            
        });
        //dialog
        $("#js_nav_menu .dialog").click(function (e, obj) {
            var url = $(this).attr("href");
            var title = $(this).text();
            var width = $(this).data("width");
            var height = $(this).data("height");
            openBarWin(title, width, height, url, function (index) {
                layer.close(index);
            }, ['保存', '取消']);
            e.preventDefault();
            return;
        });
        $('.nav-menu').hover(
                function () {
                    $("#js_nav_menu").find(".sub-nav-container").hide();
                    var left = $(this).offset().left;
                    var window_width = $(window).outerWidth();
                    var container = $(this).find(".sub-nav-container");
                    var container_width = container.outerWidth();
                    if (window_width - left < container_width)
                        container.css("right", 0);
                    container.show();
                    $(this).addClass('active');
                },
                function () {
                     $("#js_nav_menu").find(".sub-nav-container").hide();
                    $(this).removeClass('active');
                });
    });
    $("#console").click(function() {
        location.href = '<?php echo url("/user/index"); ?>';
    });
    $(".js_logout").click(function () {
        confirm("确认要退出登录吗？", function () {
            $.getJSON('<?php echo url("/user/login/logout"); ?>', function () {
                location.href = '<?php echo url("/user/login/index"); ?>';
            });
        });
    });
    $("#js_edit_pwd").click(function () {
        var url = getURL('index/edit_pwd');
        openBarWin('修改登录密码', 400, 300, url, function (index) {
            layer.close(index);
        }, ['保存', '取消']);
    });

</script>
        <input type="hidden" id="curMenu" value="menu_<?php echo $_ADDON_NAME; ?>_<?php echo $_CONTROLLER_NAME; ?>"/><!--当前菜单项-->      
        <div id="main_container">
            
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
        <th data-options="field:'name',width:140,align:'center'">名称</th> 
        <th data-options="field:'coin_name',width:120, align:'center'">币种名称</th>
        <th data-options="field:'hour',width:100, align:'center'">时长(小时)</th>
        <th data-options="field:'status',width:100, align:'center',formatter:formatStatus">游戏状态</th>
        </thead>
        <thead>
            <tr>
                <th data-options="field:'is_set_winner',width:100, align:'center',formatter:formatSetWin">是否指定赢家</th>
                <th data-options="field:'winner_user_name',width:100, align:'center'">赢家用户名</th>
                <th data-options="field:'winner_team_name',width:100, align:'center'">获胜战队</th>
                <th data-options="field:'winner_rate',width:100, align:'center'">胜利者比率</th>
                <th data-options="field:'team_rate',width:100, align:'center'">团队比率</th>
                <th data-options="field:'fund_rate',width:100, align:'center',formatter:formatRate">基金比率</th>
                <th data-options="field:'total_amount',width:120,align:'center',sortable: true">投注总额</th>
                <th data-options="field:'pool_total_amount',width:120,align:'center',sortable: true">奖金池总额</th>
                <th data-options="field:'release_total_amount',width:120,align:'center',sortable: true">释放总额</th>
                <th data-options="field:'drop_total_amount',width:120,align:'center',sortable: true">空投总额</th>
                <th data-options="field:'already_drop_amount',width:120,align:'center',sortable: true">已空投总额</th>
                <th data-options="field:'drop_process',width:120,align:'center',formatter:formatRate">空投进度</th>

                <th data-options="field:'start_time',width:140, align:'center',formatter:formatTimeStamp">开始时间</th>
                <th data-options="field:'end_game_time',width:140, align:'center',formatter:formatTimeStamp">结束时间</th>
                
                <th data-options="field:'update_time',width:140, align:'center'">更新时间</th>
                <th data-options="field:'_oper',width:240,halign:'center',formatter: formatOper">操作</th>
            </tr>
        </thead>
    </table>
</div>


        </div>


        <script type="text/javascript" src="__STATIC__/jquery/jquery.form.ui.js"></script>
        <script type="text/javascript" src="__STATIC__/layer/layer.js"></script>
        <script type="text/javascript" src="__JS__/common.js"></script>        
        <script type="text/javascript" src="__STATIC__/easyui/jquery.easyui.min.js"></script>
        <script type="text/javascript" src="__STATIC__/easyui/locale/easyui-lang-zh_CN.js"></script>        
        <script type="text/javascript">
            var page = "<?php echo $page; ?>";
            var filter = "<?php echo $filter; ?>";
            var main_header_height = 0;
            function getGridHeight() {
                var win_height = $(window).height();
                var header_height = $("#header").outerHeight(true);
                var page_nav_height = $("#js_page_nav").outerHeight(true);
                main_header_height = $("#js_main_header").outerHeight(true);
                if (!main_header_height)
                    main_header_height = 0;
                var active_status = $(".active_status").outerHeight(true);
                if (!active_status)
                    active_status = 0;
                var height = win_height - header_height - page_nav_height - main_header_height - active_status - 10;
                return height;
            }
            $(function () {
                pcInit();
            });
            var form = null;
            function pcInit() {
                form = $(".ui-form").ui().render();
                //回车自动提交
                $('.search').keyup(function (event) {
                    if (event.keyCode === 13) {
                        $("#js_search").click();
                    }
                });
                if (typeof initAfter != 'undefined')
                    initAfter();
            }
            $(window).resize(function () {
                setSideNavHeight(null);
                resizeGridHeight(null);
                if (typeof resize != 'undefined')
                    resize();
            });
            function resizeGridHeight(height) {
                if ($('#grid-table').length > 0) {
                    if (!height)
                        height = getGridHeight();
                    $('#grid-table').datagrid('resize', {
                        height: height
                    });
                }
            }
            function setSideNavHeight(height) {
                var _$js_side_content = $("#js_side_content");
                if (_$js_side_content.length > 0) {
                    if (!height) {
                        height = $(window).height();
                        var header_height = $("#header").outerHeight(true);
                        height -= header_height;
                        var _$js_nav_title = _$js_side_content.find(".js_nav_title");
                        var len = _$js_nav_title.length;
                        if (len > 0) {
                            var nav_title_height = _$js_nav_title.eq(0).outerHeight(true);
                            height = (height - nav_title_height * len) / len;
                        }
                    }
                    _$js_side_content.find(".js_sidebar_nav").height(height);
                }
            }
            $("#main_container").on("click", "#js_side_content li", function () {
                if ($(this).hasClass("active"))
                    return;
                $(this).parent().parent().parent().find("li").removeClass("active");
                $(this).addClass("active");
                if (typeof clickSideNav != 'undefined') {
                    clickSideNav.call(this, $(this).attr("data-id"), $(this).attr("data-data"));
                }
            });
            /*左侧导航栏显示隐藏功能*/
            $("#main_container").on("click", "#js_side_content .subNav", function () {
                /*显示*/
                if ($(this).find("span:first-child").attr('class') == "title-icon icon wb-triangle-right") {
                    $(this).find("span:first-child").removeClass("icon wb-triangle-right");
                    $(this).find("span:first-child").addClass("icon wb-triangle-down");
                }
                /*隐藏*/
                else {
                    $(this).find("span:first-child").removeClass("icon wb-triangle-down");
                    $(this).find("span:first-child").addClass("icon wb-triangle-right");
                }
                // 修改数字控制速度， slideUp(500)控制卷起速度
                $(this).next(".navContent").slideToggle(300).siblings(".navContent").slideUp(300);
            });
        </script>
        
<script type="text/javascript">
    
    function formatOper(value, row, index) {
        var html = '<span class="grid-operation">';
        if(row['status'] == 1){
            html += '<button type="button" onclick="edit_total(' + row['id'] + ')" class="btn btn-xs btn-default edit-btn"><i class="icon wb-edit"></i>修改奖池金额</button>';
        }
        if(row['status'] == 0){
            html += '<button type="button" onclick="start(' + row['id'] + ','+row['hour']+')" class="btn btn-xs btn-default edit-btn"><i class="icon wb-edit"></i>开启</button>';
        }
        html += '<button type="button" onclick="edit(' + row['id'] + ')" class="btn btn-xs btn-default edit-btn"><i class="icon wb-edit"></i>修改</button>';
        html += '<button type="button" onclick="del(' + row['id'] + ')" class="btn btn-xs btn-default del-btn"><i class="icon wb-close"></i>删除</button>';
        html += '</span>';
        return html;
    }
    
//    游戏状态：0=未开始，1=已开始，2=已结束'
    function formatStatus(value,row,index){
        var text = '未开始'
        if(value == '1')
            text = '已开始';
        if(value == '2')
            text= '已结束'
        return text;
    }
    
    function formatTimeStamp(value){
        return formatDateTime(value)
    }
    
    function formatSetWin(value){
        var text = '否';
        if(value == 1){
            text = '是'
        }
        return text;
    }
    
    function formatRate(value,row,index){
        var text = value + '%'
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
    

    function edit(id) {
        var url = getURL('edit', 'id=' + id);
        openBarWin('编辑', 900, 300, url, function () {
            reload();
        }, ['保存', '取消']);
    }
    function edit_total(id) {
        var url = getURL('edit_total', 'id=' + id);
        openBarWin('编辑奖池金额', 350, 150, url, function () {
            reload();
        }, ['保存', '取消']);
    }

    $("#js_addBtn").click(function () {
        if ($(this).hasClass("disabled")) {
            return;
        }
        var url = getURL('edit');
        openBarWin('添加', 900, 300, url, function () {
            reload();
        });
    });

    function start(id,hour) {
        confirm("确认要开启此游戏吗？", function () {
            var url = getURL('start');
            $.getJSON(url, {id: id,hour: hour}, function (json) {
                if (json.success)
                    reload();
                else
                    alert(json.message);
            });
        });
    }
    
    function del(id) {
        confirm("确认要删除此游戏吗？", function () {
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

    </body>
</html>