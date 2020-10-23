<!--
<?php
    require "admin/ini.php";
    require "admin/config.php";
?>
-->
<?php
    // 公共函数文件
	require_once './api.inc.php';
    require './assets/include/function.php';
    // 网页head	
    title('关于','关于600米分享','关于600米分享');
    //网页导航栏
    banner();
?>

<div class="am-container">

<div class="am-alert am-alert-success" data-am-alert>
    <button type="button" class="am-close">&times;</button>
    <p>
        免责声明：本站不进行任何资源存储，只提供影视播放服务。
        所有的影视数据均来自全网各大资源站！
        所有的影视播放均采用 iframe 引用的外站资源。<br>
        如有侵犯您的权益，请联系版权投诉邮箱 sysh8888#126.com我们将在第一时间进行处理！
    </p>
</div>


<?php if(!empty($gonggao))echo $gonggao;?>

<div class="am-panel-group" id="accordion">

    <div class="am-panel am-panel-default">
        <div class="am-panel-hd">
        <h4 class="am-panel-title" data-am-collapse="{parent: '#accordion', target: '#do-not-say-1'}">
            点击查看网站更新日志！
        </h4>
        </div>
        <div id="do-not-say-1" class="am-panel-collapse am-collapse">
        <div class="am-panel-bd">
            <ul>
                <li>
                    <h3>2018/05/06</h3>
                    <ul>
                        <li>重写为商业版系统/可运营卖VIP会员赚钱！</li>
                    </ul>
                </li>
                <li>
                    <h3>2018/03/06</h3>
                    <ul>
                        <li>重新布局简约风格</li>
                    </ul>
                </li>
                <li>
                    <h3>2018/03/05</h3>
                    <ul>
                        <li>地址： <a href="http://m.600m.net/index.php/">http://m.600m.net/index.php</a></li>
                    </ul>
                <li>
                    <h3>2017/07/20</h3>
                    <ul>
                        <li>网站上线！请大家记住我们的永久域名： <a href="http://www.600m.net/">http://www.600m.net/</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        </div>
    </div>
  
    <div class="am-panel am-panel-default">
        <div class="am-panel-hd">
        <h4 class="am-panel-title" data-am-collapse="{parent: '#accordion', target: '#do-not-say-2'}">
            点击拥有自己的视频网站！
        </h4>
        </div>
        <div id="do-not-say-2" class="am-panel-collapse am-collapse">
        <div class="am-panel-bd">
            <h2>基础版【¥588元/年】</h2>
            功能：单独看电影功能，没有美女直播、游戏直播、福利视频等等…
            <code>（手机端+PC电脑端+安卓APP）</code>            
            <h2>专业版【¥888元/年】</h2>
            全部功能：影视功能、游戏直播、美女直播、福利视频等…
            <code>（手机端+PC电脑端+安卓APP）</code>
            <h2>运营版【¥1888元/年】</h2>
            全部功能：影视功能、游戏直播、美女直播、福利视频等…
            <code>（手机端+PC电脑端+安卓APP+苹果APP）</code>  
            <h3>以上所有套餐都包含服务器1年+顶级.com域名一年 </h3>
            <h2>1.这个视频网站有什么用？</h2>
           <p>
            这个网站集合全网十几家视频网站所有影视，不管收费还是免费的全部都能看。
           </p>
            这是一个所有人看到就会马上收藏的网站。而我们可以利用这一点积累人脉。
            <h2>2.这个网站怎么赚钱？</h2>
          <p>
            设置看电影收费，卖会员赚钱！
          <p>
购买你网站的会员等于同时购买了优酷、爱奇艺、乐视、腾讯、搜狐、土豆、新浪、暴风、电影网等全网十几家视频网站的VIP会员。
            <p>
你有了这样的网站，以后别人购买会员肯定只会在你这里购买了。
              </p>
          
            <h2>3.这个网站能赚多少钱？</h2>
            <b><1>充值影视会员赚钱</b>
              <p>
假如你定价1年VIP会员¥58元
                <p>
58元即可享受1年全网几十家视频网站全部服务。
                  <p>
并且这么超值的价格，所有人都会心动。
                    <p>
1天有一个人都买一个月你就可以赚1740元。
                      <p>
 <b><2>批发会员卡赚钱</b>
                 <p>
在网站自身获得会员充值收益的同时，
                   <p>你还可以做线上或线下更低价去批发卖会员卡。
                     <p>
让更多的人成为你的网站业务员，帮助你卖你影视会员，
                       <p>
批发价格例如1年18元，100个会员卡起批发，
                         <p>
那么有一个人帮你卖会员，你一次最少可以赚1800元。
                          <p>
               <b><3>卖网站赚钱、招代理赚钱</b>
                  <p>
这样的网站每个人都想要，
                        <p>
全网有7亿网民，几乎全部网民都是不会自己建网站的。
                           <p>
全网影视系统刚刚上线，任意套餐都有自己独立的影视网站，
                              <p>
试想这么大的一块市场，如今完全空白，
                                 <p>
卖这个网站赚钱可想而知？轻松月入几万不是问题！

          
        </div>
        </div>
    </div>

<?php $title = "abouttymovies";require 'assets/include/pinglun.php'; ?>

</div>  <!-- 容器 -->  

<?php
    //网页页尾
    footer();
?>