<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:79:"/www/wwwroot/luckywinner.vip/public/../addons/resources/user/view/hook/pic.html";i:1535992937;}*/ ?>
<p class="tips">     
    <span id="_tips"><?php echo $addons_data['tips']; ?></span>
</p>
<div class="img_upload_wrp" id="js_<?php echo $addons_data['name']; ?>_upload_wrp">    
    <?php if(isset($addons_data['picList'])): if(is_array($addons_data['picList']) || $addons_data['picList'] instanceof \think\Collection || $addons_data['picList'] instanceof \think\Paginator): $i = 0; $__LIST__ = $addons_data['picList'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$li): $mod = ($i % 2 );++$i;?>
    <div class="img_upload_box img_upload_preview_box js_edit_pic_wrp">
        <img class="preview_photo" src="<?php echo $li; ?>" />      
        <p class="img_upload_edit_area js_edit_area"><a href="javascript:;"  title="删除" class="icon wb-trash js_delete"></a></p>
    </div>
    <?php endforeach; endif; else: echo "" ;endif; endif; ?>
    <div style="margin-bottom:5px" class="img_upload_box js_img_upload_box">
        <a class="img_upload_box_oper" id="js_<?php echo $addons_data['name']; ?>_pic" href="javascript:;">
            <?php if(($addons_data['type'] == 'add')): ?>            
            <i class="icon wb-plus js_add_gray">上传</i>
            <img class="preview_photo" style="display:none" /> 
            <?php endif; ?>
        </a>        
    </div>    
</div>


<script type="text/javascript">
    var checktype = "<?php echo $addons_data['checktype']; ?>";
    var folder = "<?php echo $addons_data['folder']; ?>";
    var __resources_callback = "<?php echo $addons_data['callback']; ?>";
    $("#js_<?php echo $addons_data['name']; ?>_pic").click(function () {
        if (typeof is_view_page != 'undefined' && is_view_page)
            return;
        var _this = $(this);
        var url = getURL("pic/index", "folder=" + folder + "&checktype=" + checktype, "resources");
        parent._upload_tips = '<?php echo $addons_data['tips']; ?>';
        _openResourcesPic(url, function (paths) {
            var arr = paths.split(",");
            var path = arr[0];
            if (path != "") {
                if (checktype == "" || checktype == "1") {
                    _this.find(".js_add_gray").hide();
                    $("#<?php echo $addons_data['name']; ?>").val(paths);
                    _this.find(".preview_photo").attr("src", arr[0]).show();
                }
                if (__resources_callback && __resources_callback != "")
                    eval(__resources_callback).call(_this, paths);
            }
        });
    });
    function _openResourcesPic(url, callback) {
        parent.layer.open({
            type: 2,
            title: '图片素材',
            btn: ['确定', '取消'],
            area: ['800px', '600px'],
            maxmin: false,
            //skin: 'layui-layer-rim', //加上边框
            content: url,
            yes: function (index) {
                if (callback) {
                    var d = window.parent.frames["layui-layer-iframe" + index];
                    callback(d.ok());
                }
                parent.layer.close(index); //一般设定yes回调，必须进行手工关闭
            }
        });
    }
    function setPicValue(name, val) {
        if (val != "")
            $("#js_" + name + "_pic").html('<img class="preview_photo" src="' + val + '" />');
    }
    function appendPic(name, path) {
        var html = '<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp">';
        html += '<img class="preview_photo" src="' + path + '" /><p class="img_upload_edit_area js_edit_area"><a href="javascript:;" title="删除" class="icon wb-trash js_delete"></a></p></div>';
        $("#js_" + name + "_upload_wrp").find(".js_img_upload_box").before(html);
    }
    function clearPic(name) {
        $("#js_" + name + "_upload_wrp").find(".js_edit_pic_wrp").remove();
    }
</script>