<link rel="stylesheet" href="/plugin/jquery-fd/jquery.iviewer.css" />
<style>
    body{height:400px;}
    .viewer{width: 500px;height: 400px; position: relative;  }
    .wrapper{overflow: hidden;}
</style>
<script type="text/javascript" src="/plugin/module/material.js"></script>
<script type="text/javascript" src="/plugin/jquery-fd/jquery.js" ></script>
<script type="text/javascript" src="/plugin/jquery-fd/jqueryui.js"></script>
<script type="text/javascript" src="/plugin/jquery-fd/jquery.mousewheel.min.js" ></script>
<script type="text/javascript" src="/plugin/jquery-fd/jquery.iviewer.js" ></script>
<script type="text/javascript">
    $(function(){
        var $ = jQuery;
        var fd={}
        var src = "../<?=$src;?>";
        fd.fdimg=function(src){
            var iviewer = {};
            $("#viewer2").iviewer({
                src: src,
                initCallback: function()
                {
                    iviewer = this;
                }
            });
        }
        fd.fdimg(src);
    });
</script>

<!-- wrapper div is needed for opera because it shows scroll bars for reason -->
<div class="wrapper">
    <div id="viewer2" class="viewer iviewer_cursor"></div>
</div>

