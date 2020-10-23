<!--
<?php
    require "../admin/ini.php";
    require "../admin/config.php";
?>微宝影视系统 QQ3213145200  http://400rj.com
-->
<?php
    // 公共函数文件
	require_once '../api.inc.php';
    require '../assets/include/function.php';
    // 网页head
	$type=$_GET['type'];
	if(empty($type))$type='m';
	switch($type) {
        case 'm':
            $leixing="dianying";
            $title="电影";			
        break;
                        
        case 'tv':
            $leixing="dianshi";
            $title="电视剧";	
        break;
                        
        case 'ct':
            $leixing="dongman";
            $title="动漫";	
        break;
						
		case 'va':
            $leixing="zongyi";
            $title="综艺";	
        break;	

        default:
           exit("........不要乱输入");		
    }
	
	
    title($title.' - ',$title.',',$title);
    //网页导航栏
    banner();
	require 'get.php';
?>


<style>
/* 顶部的筛选框 */
.panel-filter {
    padding: 1.25rem 0 0 0;
}

.panel-filter .am-u-md-3 {
    padding-bottom: 1.25rem;
}

.panel-filter .am-btn,.panel-filter input {
    font-size: 14px!important;
    height: 32px!important;
}

#movie-year-select {
    background-color: #fff;
    cursor: pointer;
}

.am-pagination-prev, .am-pagination-next, #selectPage {
    background-color: #fff;
    padding: 5px 10px;
    font-size: 14px;
    line-height: 23px;
    width: auto;
    height: auto;
    color: #444;
    cursor: pointer;
}
#selectPage {
    padding-right: 0;
    -webkit-appearance: menulist;
    -moz-appearance: menulist;
}
.am-pagination-select .am-disabled {
    background-color: #F9F9F9;
    cursor: not-allowed;
}
/* 滑过不要弹起了…… */
.movie-item:hover .movie-description {
    bottom: -51px;
}
</style>

<div class="am-container">

	<?php if(!empty($gonggao))echo $gonggao;?>
	
    <form class="am-form" id="filter-form">
    
    <div class="am-panel am-panel-default" style="margin-bottom: 10px">
    <div class="am-panel-bd panel-filter">
    
    <div class="am-g">
    
	<input name="type" value="<?=$type?>" style="display:none;">
    <div class="am-u-md-3">
    
        <select placeholder="类型" name="cat" data-am-selected="{btnWidth: '100%', maxHeight: 225}" 
         class="filter-change-listen" id="movie-cat">
            <option selected value=""></option>
			<option value="all">全部</option><?php
			//$yuanma=$info;
			$yuanma=getwy("https://www.360kan.com/$leixing/list");
			preg_match_all('#<a class="js-tongjip" href="(.*?)cat=(.*?)" target="_self">(.*?)</a>#',getSubstr($yuanma, '<dt class="type">类型:</dt>', '</dd>'),$leixing); 			
			
			foreach ($leixing[3] as $n=>$lei){
				echo '
			<option value="'.$leixing[2][$n].'">'.$lei.'</option>';
			} ?>
			
        </select>
    
    </div>  <!-- md-3 -->
    
    <div class="am-u-md-3">
       
        <select placeholder="地区" name="area" data-am-selected="{btnWidth: '100%', maxHeight: 225}" 
         class="filter-change-listen" id="movie-area">
            <option selected value=""></option>
            <option value="all">全部</option><?php
			preg_match_all('#<a class="js-tongjip" href="(.*?)area=(.*?)" target="_self">(.*?)</a>#',getSubstr($yuanma, '<dt class="type">地区:</dt>', '</dd>'),$leixing); 
			foreach ($leixing[3] as $n=>$lei){
				echo '
			<option value="'.$leixing[2][$n].'">'.$lei.'</option>';
			} ?>
			
        </select>
    
    </div>  <!-- md-3 -->
    
    <div class="am-u-md-3">
        
        <div class="am-input-group">
            <input type="text" class="am-form-field" id="movie-year-select" 
             data-am-datepicker="{format: 'yyyy ', viewMode: 'years', minViewMode: 'years'}" value="<?php echo $year;?>" 
             placeholder="年份" data-am-datepicker readonly>
            
            <input type="text" name="year" class="am-hide filter-change-listen" id="movie-year" value="<?php echo $year;?>" readonly hidden="hidden">
            
            <span class="am-input-group-btn">
                <button class="am-btn am-btn-default" type="button" id="movie-year-clear" title="清除年份设置">
                    ×
                    <!--<i class="am-icon-remove"></i>-->
                </button>
            </span>
        </div>
        
    </div>  <!-- md-3 -->
    
    <div class="am-u-md-3">
    
        <div class="am-input-group">
            <input type="text" class="am-form-field" name="act" placeholder="主演" id="movie-act">
            <span class="am-input-group-btn">
                <button class="am-btn am-btn-default" type="submit">
                    <i class="am-icon-angle-right"></i>
                </button>
            </span>
        </div>
    
    </div>  <!-- md-3 -->
    
    </div>  <!-- 网格 -->
    
    </div>  <!-- 面板 -->
    </div>  <!-- 面板 -->
    
    <input type="text" name="pageno" id="movie-pageno" class="am-hide">
    
    </form>

    <ul class="am-avg-sm-3 am-avg-md-4 am-avg-lg-6 am-thumbnails movie-lists">

<?php
    require 'list2.php';
?>
	
   </ul>
    
    <ul data-am-widget="pagination" class="am-pagination am-pagination-select">
        <li class="am-pagination-prev" id="prevPage">
            上一页
        </li>
        
        <li class="am-pagination-select">
            <select id="selectPage"></select>
        </li>
        
        <li class="am-pagination-next" id="nextPage">
            下一页
        </li>
    
    </ul>
    

</div>  <!-- 容器 -->

<script type="text/javascript">
var pageInfo = {
    act: "<?php echo $act;?>",
    cat: "<?php echo $cat;?>",
    area: "<?php echo $area;?>",
    curPage: <?php echo $pageno;?>,     // 当前页码
    maxPage: <?php echo $maxpage;?>    // 最大的页码
}


$(function() {
    $("#movie-cat").val(pageInfo.cat);
    $("#movie-area").val(pageInfo.area);
    $("#movie-act").val(pageInfo.act);
    
    
    // 循环添加页码
    for(var i=1; i<=pageInfo.maxPage; i++) {
        $("#selectPage").append('<option value="'+i+'">第 '+i+' 页</option>');
    }
    $("#selectPage").val(pageInfo.curPage);
    
    // 页码选择器改变自动跳转
    $("#selectPage").change(function(){
        goPage($('#selectPage').val());
    });
    
    // 上下翻页功能
    if(pageInfo.curPage <= 1) {
        $("#prevPage").addClass("am-disabled");
    }
    if(pageInfo.curPage >= pageInfo.maxPage) {
        $("#nextPage").addClass("am-disabled");
    }
    $("#prevPage").click(function() {
        if(pageInfo.curPage > 1) goPage((parseInt(pageInfo.curPage)-1));
    });
    $("#nextPage").click(function() {
        if(pageInfo.curPage < pageInfo.maxPage) goPage((parseInt(pageInfo.curPage)+1));
    });
    
    // 跳转至指定页码
    function goPage(newPage) {
        $("#movie-pageno").val(newPage);
        $("#filter-form").submit();
    }
    
    // 删除年份
    $("#movie-year-clear").click(function() {
        $("#movie-year").val('');
        $("#filter-form").submit();
    });
    
    // 监听筛选表单变化
    $(".filter-change-listen").change(function() {
        $("#filter-form").submit();
    });
    
    
    
    var nowTemp = new Date();
    var nowYear = new Date(nowTemp.getFullYear() + 1, 0, 1, 0, 0, 0, 0).valueOf();
    var $myStart2 = $('#movie-year-select');
    
    
    var checkin = $myStart2.datepicker({
        // linkField: 'movie-year',
        // linkFormat: 'yyyy ',
        onRender: function(date, viewMode) {
            // 默认 days 视图，与当前日期比较
            var viewDate = nowYear;
            
            switch (viewMode) {
                // years 视图，与当前年份比较
                case 2:
                    viewDate = nowYear;
                break;
            }
            
            return date.valueOf() > viewDate - 1 ? 'am-disabled' : '';
        }
    }).on('changeDate.datepicker.amui', function(ev) {
        checkin.close();
        $("#movie-year").val(ev.date.getYear() + 1900);
        $("#filter-form").submit();
    }).data('amui.datepicker');
    
});
</script>	
<?php
    //网页页尾
    footer();
?>