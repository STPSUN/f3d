<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:80:"/www/wwwroot/luckywinner.vip/public/../addons/editor/user/view/hook/content.html";i:1535992884;}*/ ?>
<input type="hidden" name="parse" value="0">
<script type="text/javascript" charset="utf-8" src="__STATIC__/global/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="__STATIC__/global/ueditor/ueditor.all.js"></script>
<script type="text/javascript" charset="utf-8" src="__STATIC__/global/ueditor/lang/zh-cn/zh-cn.js"></script>

<script type="text/javascript"> 
    var height = "<?php echo $data['height']; ?>";
    var width = '';
    if(height == "")
            height = 350;
    if(width == "")
            width = 980;
    var bars = [<?php echo $data['toolbars']; ?>];
    if (bars.length == 0)
            bars = [
                ['fullscreen', 'source', 'undo', 'redo', 'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'lineheight'],
                ['paragraph', 'fontfamily', 'fontsize', 'indent', 'justifyleft', 'justifycenter', 'justifyright', 'link', 'unlink', 'insertimage', 'emotion', 'attachment', 'template', 'map']
            ];
    <?php if(empty($data['id']) || (($data['id'] instanceof \think\Collection || $data['id'] instanceof \think\Paginator ) && $data['id']->isEmpty())): ?>
        $("textarea[name='<?php echo $data['name']; ?>']").attr("data-editor", "<?php echo $data['name']; ?>_Editor");
        var <?php echo $data['name']; ?>_Editor = UE.getEditor('<?php echo $data['name']; ?>', {
            serverUrl: getURL("editor/uedit",'','editor'),
            toolbars: bars,
            wordCount: false,
            autoHeightEnabled: false,
            autoFloatEnabled: true,
            initialFrameWidth: width,
            initialFrameHeight: height
        });
    <?php endif; ?>

    function onLoadSuccess(data){
        $("textarea[name='<?php echo $data['name']; ?>']").attr("data-editor", "<?php echo $data['name']; ?>_Editor");
        var <?php echo $data['name']; ?>_Editor = UE.getEditor('<?php echo $data['name']; ?>', {
            serverUrl: getURL("editor/uedit",'','editor'),
            toolbars: bars,
            wordCount: false,
            autoHeightEnabled: false,
            autoFloatEnabled: true,
            initialFrameWidth: width,
            initialFrameHeight: height
        });
    }

</script>