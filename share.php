<?php 
    require_once './api.inc.php';
    require ROOT."admin/ini.php";
    // 公共函数文件
    require './assets/include/function.php';
?><!-- 作者QQ3213145200-->
<?php
    // 网页head
    title('视频解析接口分享平台 - ','视频解析接口分享平台,','视频解析接口分享平台');
    //网页导航栏
    banner();
?>


<style>
/* 接口测试区域 */
#test {
    margin-top: 30px;
    margin-bottom: 30px;
}
/* 测试接口区域表格 */
.test-table-box {
    height: 310px;
    overflow-y: auto;
}

/* 接口列表的标签 */
.vip-list .am-badge {
    font-weight: 100;
    cursor: pointer;
}

/* 通栏带背景 */
.full-width-bg {
    background: #fff url(http://p16.qhimg.com/bdr/__85/t012b4b7cc338d6a04d.jpg) fixed center center no-repeat;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -ms-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    text-align: center;
    color: #fff;
    padding: 50px 0;
    text-shadow: 0 0 5px #000000;
}

/* 网页头部banner */
.web-head-banner {
    margin-top: -20px;
    margin-bottom: 10px;
}

.web-head-banner>h1 {
    font-weight: normal;
    font-size: 30px;
}
.web-head-banner>.p {
    margin-top: 1.0rem;
    margin-bottom: 10px;
}

/* 网页底部内容 */
.buttom-share-form>h2 {
    font-weight: normal;
    font-size: 28px;
}
.buttom-share-form>span {
    margin-top: 10px;
    display: inline-block;
}

@media screen and (max-width: 1000px) {
    /* 表格内容不换行，允许左右滑动查看完整表格 */
    .vip-list>.am-scrollable-horizontal>.am-table {
        white-space: nowrap; 
    }
}
</style>


<div class="web-head-banner full-width-bg">
    <h1><span class="am-icon-share-alt"></span> 视频解析接口分享平台</h1>
    <p>找接口，分享接口，来这就行了！</p>
    <a class="am-btn am-btn-warning am-round" href="#share" onclick="$('html, body').animate({scrollTop: $('#share').offset().top}, '500');return false;">我有接口要分享</a>
</div>  


<div class="am-container">

<!-- 所有api接口列表 -->
<div class="am-panel am-panel-primary vip-list">
    <div class="am-panel-hd">视屏解析接口大全<span id="api-count"></span></div>
    
    <div class="am-scrollable-horizontal">
    <table class="am-table am-table-hover">
        <thead>
            <tr>
                <th width="300px">解析接口</th>
                <th width="500px">支持的网站</th>
                <th width="230px">备注</th>
                <th width="130px">操作</th>
            </tr>
        </thead>
        <tbody id="api-list">
            <tr><td colspan="4" class="am-text-center">
                <i class="am-icon-cog am-icon-spin"></i> 
                接口列表加载中...
            </td></tr>
            <!-- 接口列表 -->
        </tbody>
    </table>
    </div>
    
    <div class="am-panel-footer">
        说明：
        <span class="am-badge am-badge-success" 
          data-am-popover="{content: '支持该视频源VIP高清解析', trigger: 'hover focus'}">
            视频源
        </span>
        
        <span class="am-badge am-badge-warning" 
          data-am-popover="{content: '支持该视频源VIP普清解析', trigger: 'hover focus'}">
            视频源
        </span>
        
        <span class="am-badge" 
          data-am-popover="{content: '该视频源仅支持非VIP视频', trigger: 'hover focus'}">
            视频源
        </span>
        
        <!--<span class="am-badge am-badge-primary">待定</span>-->
        
        <span class="am-badge am-badge-secondary" 
          data-am-popover="{content: '该解析接口支持 https', trigger: 'hover focus'}">
            https
        </span>
        
        <span class="am-badge am-badge-danger" 
          data-am-popover="{content: '该解析接口含有广告', trigger: 'hover focus'}">
            AD
        </span>
    </div>
</div>      <!-- 接口大全 -->


<!-- 接口测试工具 -->
<div class="am-g" id="test">
    <div class="am-u-lg-7">
        <div class="am-panel am-panel-default">
            <div class="am-panel-hd">接口测试工具</div>
            
            <div class="am-panel-bd player-box">
                <iframe id="ty-vip-player" src="" allowtransparency="true" scrolling="No" width="100%" height="100%"></iframe>
            </div>
        </div>
    </div>  <!-- am-u-sm-7 -->
    
    <div class="am-u-lg-5">
        <div class="am-panel am-panel-secondary">
            <div class="am-panel-hd">
                接口测试工具控制台 
            </div>
            <div class="am-panel-bd">
                
                <form class="am-form am-form-horizontal" id="api-edit-form">
                
                <div class="am-form-group am-form-icon">
                    <i class="am-icon-film"></i>
                    <input type="url" id="video-url" class="am-form-field" placeholder="测试视屏地址">
                </div>
                
                <div class="am-form-group am-form-icon">
                    <i class="am-icon-link"></i>
                    <input name="url" type="url" id="video-api-url" class="am-form-field" placeholder="测试接口地址">
                </div>
                
                <div class="am-form-group am-form-icon">
                    <i class="am-icon-th-large"></i>
                    <input id="edit-form-name" name="name" type="text" class="am-form-field" placeholder="接口名字" value="">
                </div>
                
                <div class="am-form-group am-form-icon">
                    <i class="am-icon-tags"></i>
                    <input id="edit-form-describe" name="describe" type="text" class="am-form-field" placeholder="备注信息" value="">
                </div>
                
                <div>
                    <label class="am-checkbox-inline">
                        <input id="edit-form-ad" name="ad" type="checkbox" value="0"> 无广告
                    </label>
                    <label class="am-checkbox-inline">
                        <input id="edit-form-https" name="https" type="checkbox" value="1"> https
                    </label>
                    <button type="button" class="am-btn am-btn-success am-btn-xs" id="btn-play">测试播放</button>
                                    </div>
                
                </form>
                
            </div>  <!-- am-panel-bd -->
            
            <div class="test-table-box">
            
            <table class="am-table ">
                <thead>
                    <tr><th>视屏平台</th><th>视屏资源</th><th>支持情况</th></tr>
                </thead>
                <tbody>
                    
                    <tr>
                        <td class="am-text-middle"><a href="http://www.iqiyi.com/" target="_blank">爱奇艺</a></td>
                        <td>
                            <button data-src="http://www.iqiyi.com/v_19rr7qhgp0.html" class="am-btn am-btn-warning am-btn-xs btn-check-res">VIP</button>
                            <button data-src="http://www.iqiyi.com/v_19rr9tqe9s.html" class="am-btn am-btn-success am-btn-xs btn-check-res">普</button>
                        </td>
                        <td>
                            <div class="am-btn-group check-api-support" data-name="爱奇艺" data-ename="iqiyi" data-am-button>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-iqiyi" value="1"> VIP高清
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-iqiyi" value="2"> VIP普清
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-iqiyi" value="3"> 非VIP
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs am-active">
                                    <input class="check-api-selete" type="radio" name="options-iqiyi" value="0" checked> 不支持
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="am-text-middle"><a href="https://v.qq.com/" target="_blank">腾讯视屏</a></td>
                        <td>
                            <button data-src="https://v.qq.com/x/cover/3j6v0bpyyudipae.html" class="am-btn am-btn-warning am-btn-xs btn-check-res">VIP</button>
                            <button data-src="https://v.qq.com/x/cover/2xxul4n2j8y0rxi.html" class="am-btn am-btn-success am-btn-xs btn-check-res">普</button>
                        </td>
                        <td>
                            <div class="am-btn-group check-api-support" data-name="腾讯视屏" data-ename="qq" data-am-button>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-qq" value="1"> VIP高清
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-qq" value="2"> VIP普清
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-qq" value="3"> 非VIP
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs am-active">
                                    <input class="check-api-selete" type="radio" name="options-qq" value="0" checked> 不支持
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="am-text-middle"><a href="http://www.youku.com/" target="_blank">优酷土豆</a></td>
                        <td>
                            <button data-src="http://v.youku.com/v_show/id_XODAzOTY2NDUy.html" class="am-btn am-btn-warning am-btn-xs btn-check-res">VIP</button>
                            <button data-src="http://v.youku.com/v_show/id_XMjg2NTM2ODU5Mg==.html" class="am-btn am-btn-success am-btn-xs btn-check-res">普</button>
                        </td>
                        <td>
                            <div class="am-btn-group check-api-support" data-name="优酷土豆" data-ename="youku" data-am-button>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-youku" value="1"> VIP高清
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-youku" value="2"> VIP普清
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-youku" value="3"> 非VIP
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs am-active">
                                    <input class="check-api-selete" type="radio" name="options-youku" value="0" checked> 不支持
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="am-text-middle"><a href="http://www.le.com/" target="_blank">乐视</a></td>
                        <td>
                            <button data-src="http://www.le.com/ptv/vplay/2030782.html" class="am-btn am-btn-warning am-btn-xs btn-check-res">VIP</button>
                            <button data-src="http://www.le.com/ptv/vplay/29118674.html" class="am-btn am-btn-success am-btn-xs btn-check-res">普</button>
                        </td>
                        <td>
                            <div class="am-btn-group check-api-support" data-name="乐视" data-ename="letv" data-am-button>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-letv" value="1"> VIP高清
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-letv" value="2"> VIP普清
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-letv" value="3"> 非VIP
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs am-active">
                                    <input class="check-api-selete" type="radio" name="options-letv" value="0" checked> 不支持
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="am-text-middle"><a href="http://www.mgtv.com/" target="_blank">芒果TV</a></td>
                        <td>
                            <button data-src="https://www.mgtv.com/b/296772/3911699.html" class="am-btn am-btn-warning am-btn-xs btn-check-res">VIP</button>
                            <button data-src="http://www.mgtv.com/b/314894/4000292.html" class="am-btn am-btn-success am-btn-xs btn-check-res">普</button>
                        </td>
                        <td>
                            <div class="am-btn-group check-api-support" data-name="芒果TV" data-ename="mgtv" data-am-button>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-mgtv" value="1"> VIP高清
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-mgtv" value="2"> VIP普清
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-mgtv" value="3"> 非VIP
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs am-active">
                                    <input class="check-api-selete" type="radio" name="options-mgtv" value="0" checked> 不支持
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="am-text-middle"><a href="http://www.pptv.com/" target="_blank">PPTV聚力</a></td>
                        <td>
                            <button data-src="http://v.pptv.com/show/3zAJhu5UxAJl40s.html" class="am-btn am-btn-warning am-btn-xs btn-check-res">VIP</button>
                            <button data-src="http://v.pptv.com/show/aDcQjvZczApt61M.html" class="am-btn am-btn-success am-btn-xs btn-check-res">普</button>
                        </td>
                        <td>
                            <div class="am-btn-group check-api-support" data-name="PPTV聚力" data-ename="pptv" data-am-button>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-pptv" value="1"> VIP高清
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-pptv" value="2"> VIP普清
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-pptv" value="3"> 非VIP
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs am-active">
                                    <input class="check-api-selete" type="radio" name="options-pptv" value="0" checked> 不支持
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="am-text-middle"><a href="http://www.fun.tv/" target="_blank">风行网</a></td>
                        <td>
                            <button data-src="http://www.fun.tv/vplay/g-316267/" class="am-btn am-btn-warning am-btn-xs btn-check-res">VIP</button>
                            <button data-src="http://www.fun.tv/vplay/g-313897/" class="am-btn am-btn-success am-btn-xs btn-check-res">普</button>
                        </td>
                        <td>
                            <div class="am-btn-group check-api-support" data-name="风行网" data-ename="funtv" data-am-button>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-funtv" value="1"> VIP高清
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-funtv" value="2"> VIP普清
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-funtv" value="3"> 非VIP
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs am-active">
                                    <input class="check-api-selete" type="radio" name="options-funtv" value="0" checked> 不支持
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="am-text-middle"><a href="http://www.1905.com/" target="_blank">m1905</a></td>
                        <td>
                            <button data-src="http://vip.1905.com/play/1158376.shtml" class="am-btn am-btn-warning am-btn-xs btn-check-res">VIP</button>
                            <button data-src="http://www.1905.com/vod/play/862185.shtml" class="am-btn am-btn-success am-btn-xs btn-check-res">普</button>
                        </td>
                        <td>
                            <div class="am-btn-group check-api-support" data-name="m1905" data-ename="m1905" data-am-button>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-m1905" value="1"> VIP高清
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-m1905" value="2"> VIP普清
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-m1905" value="3"> 非VIP
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs am-active">
                                    <input class="check-api-selete" type="radio" name="options-m1905" value="0" checked> 不支持
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="am-text-middle"><a href="http://www.baofeng.com/" target="_blank">暴风影音</a></td>
                        <td>
                            <button data-src="http://www.baofeng.com/play/312/play-825812.html" class="am-btn am-btn-warning am-btn-xs btn-check-res">VIP</button>
                            <button data-src="http://www.baofeng.com/play/414/play-821914.html" class="am-btn am-btn-success am-btn-xs btn-check-res">普</button>
                        </td>
                        <td>
                            <div class="am-btn-group check-api-support" data-name="暴风影音" data-ename="baofeng" data-am-button>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-baofeng" value="1"> VIP高清
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-baofeng" value="2"> VIP普清
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-baofeng" value="3"> 非VIP
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs am-active">
                                    <input class="check-api-selete" type="radio" name="options-baofeng" value="0" checked> 不支持
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="am-text-middle"><a href="http://www.kankan.com/" target="_blank">天天看看</a></td>
                        <td>
                            <button data-src="http://vip.kankan.com/vod/75075.html" class="am-btn am-btn-warning am-btn-xs btn-check-res">VIP</button>
                            <button data-src="http://vod.kankan.com/v/67/67180.shtml" class="am-btn am-btn-success am-btn-xs btn-check-res">普</button>
                        </td>
                        <td>
                            <div class="am-btn-group check-api-support" data-name="天天看看" data-ename="kankan" data-am-button>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-kankan" value="1"> VIP高清
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-kankan" value="2"> VIP普清
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-kankan" value="3"> 非VIP
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs am-active">
                                    <input class="check-api-selete" type="radio" name="options-kankan" value="0" checked> 不支持
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="am-text-middle"><a href="http://tv.sohu.com/" target="_blank">搜狐视频</a></td>
                        <td>
                            <button data-src="https://film.sohu.com/album/1008706.html" class="am-btn am-btn-warning am-btn-xs btn-check-res">VIP</button>
                            <button data-src="http://tv.sohu.com/20090213/n262230436.shtml" class="am-btn am-btn-success am-btn-xs btn-check-res">普</button>
                        </td>
                        <td>
                            <div class="am-btn-group check-api-support" data-name="搜狐视频" data-ename="sohu" data-am-button>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-sohu" value="1"> VIP高清
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-sohu" value="2"> VIP普清
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-sohu" value="3"> 非VIP
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs am-active">
                                    <input class="check-api-selete" type="radio" name="options-sohu" value="0" checked> 不支持
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="am-text-middle"><a href="https://www.wasu.cn/" target="_blank">华数TV</a></td>
                        <td>
                            <button data-src="https://www.wasu.cn/Play/show/id/1016801" class="am-btn am-btn-warning am-btn-xs btn-check-res">VIP</button>
                            <button data-src="https://www.wasu.cn/Play/show/id/9255986" class="am-btn am-btn-success am-btn-xs btn-check-res">普</button>
                        </td>
                        <td>
                            <div class="am-btn-group check-api-support" data-name="华数TV" data-ename="wasu" data-am-button>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-wasu" value="1"> VIP高清
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-wasu" value="2"> VIP普清
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs">
                                    <input class="check-api-selete" type="radio" name="options-wasu" value="3"> 非VIP
                                </label>
                                <label class="am-btn am-btn-default am-btn-xs am-active">
                                    <input class="check-api-selete" type="radio" name="options-wasu" value="0" checked> 不支持
                                </label>
                            </div>
                        </td>
                    </tr>                <tbody>
            </table>
            
            </div>      <!-- .test-table-box -->
        </div>
    </div>  <!-- am-u-sm-7 -->
</div>  <!-- 网格（接口测试结束） -->

</div>  <!-- 容器 -->

<!-- 接口分享栏 -->
<div class="full-width-bg" id="share">
    <div class="am-g">
    <div class="am-u-lg-6 am-u-lg-offset-3 buttom-share-form">
        <h2>分享视频解析接口</h2>
        <form class="am-form" id="share-user-api">
            <div class="am-input-group am-input-group-primary">
                <input name="api" type="url" class="am-form-field" placeholder="请输入欲分享的接口地址" required>
                <span class="am-input-group-btn">
                    <button class="am-btn am-btn-primary" type="submit">分享</button>
                </span>
            </div>
        </form>
        <span>（如果您有比较好的视频解析接口，可以在这里分享给大家）<br>*即日起不再收录无技术含量的 iframe 二次解析接口</span>
    </div>
    </div>
</div>
<!-- 接口分享栏 -->

    <!-- 接口分享页面专属 JS  -->
    <script src="http://d.nyqty.com/tyys/default/js/share.js?v1.2"></script>

<?php
    //网页页尾
    footer();
?>