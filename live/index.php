<!--
<?php
    require "../admin/ini.php";
    require "../admin/config.php";
?>
-->
<?php
    // 公共函数文件
	require_once '../api.inc.php';
    require '../assets/include/function.php';
    // 网页head
    title('电视直播 - ','电视直播,','电视直播');
    //网页导航栏
    banner();
?>


<style>
.btn-play-source {
    margin: 0 5px 5px 0;
}
</style>

<div class="am-container">

<?php if(!empty($gonggao))echo $gonggao;?>

<div class="am-alert am-alert-warning am-show-sm-only" data-am-alert>
    <button type="button" class="am-close">&times;</button>
    <p>电视直播功能仅支持电脑使用</p>
</div>

<div class="am-panel am-panel-default">
    <div class="am-panel-hd">电视直播</div>
    
    <div class="am-panel-bd player-box">
        <iframe id="ty-vip-player" src="" allowtransparency="true" scrolling="No" width="100%" height="100%"></iframe>
    </div>
    
</div>

<div class="am-panel am-panel-default">
    <div class="am-panel-hd">播放源</div>
    <div class="am-panel-bd">
        <button type="button" class="am-btn am-btn-sm btn-play-source" 
            data-url="http://live.64ma.com/tv/live.html">
            64码
        </button>
        
        <button type="button" class="am-btn am-btn-sm btn-play-source" 
            data-url="http://www.cietv.com/images/img/100">
            易视
        </button>
        
        <!-- http://www.wydy8.com/TV/ -->
        <button type="button" class="am-btn am-btn-sm btn-play-source" 
            data-url="http://tv.bingdou.net/live.html">
            冰豆
        </button>
        
        <!--http://bubuys.com/dy/1.swf-->
        <button type="button" class="am-btn am-btn-sm btn-play-source" 
            data-url="http://www.icantv.cn/live.html">
            爱看TV
        </button>
        
        <button type="button" class="am-btn am-btn-sm btn-play-source" 
            data-url="/live/live.php">
            微站直播
        </button>
		
        <!--<button type="button" class="am-btn am-btn-sm btn-play-source" -->
        <!--    data-url="http://a.allproof.net/tv/cmpn.swf">-->
        <!--    ITV-->
        <!--</button>-->
        
        <!--<button type="button" class="am-btn am-btn-sm btn-play-source" -->
        <!--    data-url="http://a.allproof.net/pptv/pptv.htm">-->
        <!--    PPTV-->
        <!--</button>-->
        
        <!--<button type="button" class="am-btn am-btn-sm btn-play-source" -->
        <!--    data-url="http://a.allproof.net/cntv/live.asp">-->
        <!--    CNTV-->
        <!--</button>-->
        
        <br>* 如遇播放失败请尝试切换播放源
    </div>
</div>

<script>
var store;
var liveUrl = $(".btn-play-source:eq(0)").data("url");

$(function() {
    store = $.AMUI.store;
    
    // 获取存储在本地的个性设置
    if (store.enabled) {
        liveUrl = store.get('liveUrl')? store.get('liveUrl'): liveUrl;
    }
    
    $("#ty-vip-player").attr("src", liveUrl);
    
    // 找到并高亮所用在线播放地址
    $(".btn-play-source").each(function () {
        if($(this).data("url") == liveUrl) {
            $(this).addClass("am-btn-secondary");
            return false;
        }
    });
    
    // $(".btn-play-source:eq(0)").addClass("am-btn-secondary");
    
    $(".btn-play-source").click(function(){
        $(".btn-play-source").removeClass("am-btn-secondary");
        $(this).addClass("am-btn-secondary");
        $("#ty-vip-player").attr("src", $(this).data("url"));
        layer.msg("已切换到 " + $(this).html() + " 电视直播");
        
        store.set('liveUrl', $(this).data("url"));
    });
});

</script>

</div>  <!-- 容器 -->

<?php
    //网页页尾
    footer();
?>