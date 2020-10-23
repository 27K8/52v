// 接口分享页面专属 js 文件
var mkSiteInfo = { siteUrl: "http://tool.mkblog.cn/movie", debug: false, admin: false };
//孟坤的接口收录
$(function() {
    // 用户分享 Api 提交
    $("#share-user-api").submit(function() {
        $.ajax({
            type: 'POST', 
            url: mkSiteInfo.siteUrl + "/api.php", 
            data: "types=apisubmit&" + $("#share-user-api").serialize(),
            dataType : "jsonp",
            complete: function(XMLHttpRequest, textStatus) {
            },  // complete
            success: function(jsonData){
                switch(jsonData.code) {
                    case 200:   // 提交成功
                        layer.msg(jsonData.msg);    // 展示回馈消息
                        break;
                        
                    default:
                        layer.msg(jsonData.msg, {icon: 5, anim: 6});
                }
                $("#share-user-api")[0].reset();    // 清空表单
                
            },   //success
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                layer.msg("数据提交失败" + XMLHttpRequest.status);
            }   // error
        });// ajax
        
        return false;
    });
    
    // layer.open({
    //     type: 2,
    //     title: '接口测试窗口',
    //     shadeClose: false,
    //     shade: 0,
    //     area: ['380px', '300px'],
    //     resize: true,
    //     maxmin: true, //开启最大化最小化按钮
    //     content: 'http://amazeui.org/css/button' //iframe的url
    // }); 
    
    // 资源按钮点击，预览播放
    $(".btn-check-res").click(function() {
        $("#video-url").val($(this).data("src"));
        
        $("#btn-play").click();
    });
    
    // 记录更新解析接口
    $("#api-edit-form").submit(function () {
        if($("#video-api-url").val() == '') {
            layer.msg("接口地址不能为空");
            return false;
        }
        
        var tmp;
        
        // 获取基础数据
        tmp = {
            name: $("#edit-form-name").val(),   // 接口名字
            url: $("#video-api-url").val(),     // 接口地址
            describe: $("#edit-form-describe").val(),   // 接口备注描述
            ad: !$("#edit-form-ad").is(':checked'),     // 是否有广告
            https: $("#edit-form-https").is(':checked'),    // 是否支持HTTPS
            supports: []
        }
        
        // 获取每个接口的支持情况
        $(".check-api-support").each(function () {
            tmp.supports.push({
                name: $(this).data("name"), 
                ename: $(this).data("ename"), 
                state: parseInt($(this).children().children().filter(':checked').val())
            });
        });
        
        // 转换为json数据
        tmp = JSON.stringify(tmp);
        
        // layer.open({
        //     type: 1,
        //     title: '输出',
        //     closeBtn: 1,
        //     shadeClose: true,
        //     content: '<textarea rows="8" style="width: 300px">' + tmp + '</textarea>'
        // });
        
        $.ajax({
            type: 'POST', 
            url: mkSiteInfo.siteUrl + "/api.php", 
            data: "types=apiupdate&data=" + tmp + "&delete=" + $("#edit-form-delete").is(':checked'),
            dataType : "jsonp",
            complete: function(XMLHttpRequest, textStatus) {
            },  // complete
            success: function(jsonData){
                layer.msg(jsonData.msg);
            },   //success
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                layer.msg("数据提交失败 - " + XMLHttpRequest.status);
            }   // error
        });// ajax
        
        ajaxApiList();
        return false;
    });     // 记录更新接口
    
    // 显示操作演示 GIF
    var playerHtml = '<style type="text/css">* {margin: 0; padding: 0;}html, body {width: 100%; height: 100%;}body{display: table;}.img{text-align: center; vertical-align: middle; display: table-cell;}img{width: 100%; max-width: 200px;}</style>';
    playerHtml += '<div class="img"><img src="https://ws1.sinaimg.cn/large/a15b4afegy1fkee6c479uj207i050jrc.jpg"></div>';
    $("#mk-vip-player").contents().find("body").html(playerHtml);
    
    
    // 测试播放
    $("#btn-play").click(function() {
        refreshVideo();
    });
    
    // 测试按钮
    $(".vip-list").on("click", ".btn-apilist-test", function() {
        var num = parseInt($(this).parent().parent().data("no"));
        if(isNaN(num)) return false;
        
        var apiInfo = mkSiteInfo.allApi[num];
        
        $("#video-api-url").val(apiInfo.url);           // 接口地址
        $("#edit-form-name").val(apiInfo.name);         // 接口名字
        $("#edit-form-describe").val(apiInfo.describe); // 接口描述
        
        if(apiInfo.ad) {    // 广告
            $("#edit-form-ad").prop("checked", false);
        } else {
            $("#edit-form-ad").prop("checked", true);
        }
        
        if(apiInfo.https) {    // https
            $("#edit-form-https").prop("checked", true);
        } else {
            $("#edit-form-https").prop("checked", false);
        }
        
        // 各个接口的支持情况
        $(".check-api-selete").each(function() {    // 归位
            if($(this).val() == '0') $(this).click();
        });
        for(var i=0; i<apiInfo.supports.length; i++) {  // 赋值
            $('input[name="options-' + apiInfo.supports[i].ename + '"][value="' + apiInfo.supports[i].state + '"]').click();
        }
        
        // layer.open({
        //     type: 1,
        //     // skin: 'layui-layer-rim', //加上边框
        //     resize: true,
        //     maxmin: true,
        //     area: ['100%', '100%'], //宽高
        //     content: $("#test")
        // });
        $('html, body').animate({scrollTop: $("#test").offset().top}, '500');
        
    });     // 接口测试按钮
    
    // 测试按钮
    $(".vip-list").on("click", ".btn-apilist-err", function() {
        var num = parseInt($(this).parent().parent().data("no"));
        if(isNaN(num)) return false;
        
        var apiInfo = mkSiteInfo.allApi[num];
        
        layer.open({
            type: 1,
            title: '接口报错',
            closeBtn: 1,
            shadeClose: true,
            content: '<form class="am-form" style="width: 300px; margin: 10px" id="err-report-form">' + 
                    '    <div class="am-form-group">' + 
                    '        <label for="doc-ipt-email-1">接口地址</label>' + 
                    '        <input id="err-report-api" type="url" name="api" placeholder="接口地址" value="'+apiInfo.url+'" required readonly>' + 
                    '    </div>' + 
                    '    <div class="am-form-group">' + 
                    '        <label for="doc-select-1">报错原因</label>' + 
                    '        <select id="err-report-reason" name="reason" required>' + 
                    '            <option value="失效">接口失效</option>' + 
                    '            <option value="支持不符">支持的网站不符</option>' + 
                    '            <option value="其它">其它</option>' + 
                    '        </select>' + 
                    '        <span class="am-form-caret"></span>' + 
                    '    </div>' + 
                    '    <div class="am-form-group">' + 
                    '        <label for="doc-ta-1">详细原因（选填）</label>' + 
                    '        <textarea id="err-report-detail" rows="2" name="detail"></textarea>' + 
                    '    </div>' + 
                    '    <p>*因视屏站算法频繁变更，出现部分接口支持的网站情况与本站测试结果不符为正常情况</p>' + 
                    '    <p><button type="button" class="am-btn am-btn-secondary am-btn-xs" onclick="errReportSubmit()">提交</button></p>' + 
                    '</form>'
        });
        
    });
    
    // ajax 获取所有接口列表
    ajaxApiList();
});

// ajax 获取所有接口列表
function ajaxApiList() {
    $.ajax({
        type: 'POST', 
        url: mkSiteInfo.siteUrl + "/api.php", 
        data: "types=getapilist",
        dataType : "jsonp",
        complete: function(XMLHttpRequest, textStatus) {
        },  // complete
        success: function(jsonData){
            if(jsonData.code != 200) {
                layer.msg("接口数据获取失败 - " + jsonData.code);
            } else {
                mkSiteInfo.allApi = jsonData.msg;
                refreshApiList(); // 刷新接口列表
            }
        },   //success
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            layer.msg("接口数据获取失败 " + XMLHttpRequest.status);
        }   // error
    });// ajax
}

// 刷新接口列表
function refreshApiList() {
    var allApi = mkSiteInfo.allApi;
    var tmpHtml = '', tmpName;
    
    $("#api-count").html(' （本站共收录 ' + allApi.length + ' 个解析接口）');
    
    for(var i=0; i<allApi.length; i++) {
        tmpHtml += '<tr data-no="'+ i +'">' + 
        '        <td><a href="' + allApi[i].url + '" target="_blank">' + allApi[i].url + '</a></td>' + 
        '        <td>';
        
        for(var j=0; j<allApi[i].supports.length; j++) {
            tmpName = allApi[i].supports[j].name;   // 接口名字
            switch(allApi[i].supports[j].state) {
                case 1:     // 支持高清 VIP
                    tmpHtml+='<span class="am-badge am-badge-success" title="本接口支持 ' + tmpName + ' 高清VIP视频解析">' + tmpName + '</span> ';
                break;
                
                case 2:     // 支持低清 VIP
                    tmpHtml+='<span class="am-badge am-badge-warning" title="本接口支持 ' + tmpName + ' 普清VIP视频解析">' + tmpName + '</span> ';
                break;
                
                case 3:     // 只支持普通视屏
                    tmpHtml+='<span class="am-badge" title="本接口支持 ' + tmpName + ' 非VIP视频解析">' + tmpName + '</span> ';
                break;
            }
        }
        
        tmpHtml += '</td><td>';
        
        if(allApi[i].https) {     // 支持 https
            tmpHtml += '<span class="am-badge am-badge-secondary" title="本接口支持 https">https</span> ';
        }
        
        if(allApi[i].ad) {     // 广告
            tmpHtml += '<span class="am-badge am-badge-danger" title="本接口可能含有广告">AD</span> ';
        }
        
        tmpHtml +='        </td>' + 
        '        <td>' + 
        '            <button class="am-btn am-btn-primary am-btn-xs btn-apilist-test">测试</button>' + 
        '            <button class="am-btn am-btn-primary am-btn-xs btn-apilist-err">报错</button>' + 
        '        </td>' + 
        '    </tr>';
        console.log();
    }
    $("#api-list").html(tmpHtml);
}

// 刷新视屏播放
function refreshVideo() {
    var videoUrl = $("#video-url").val();
    
    if(videoUrl == "") {
        layer.msg("测试视频链接不能为空");
    }
    
    $("#mk-vip-player").attr("src", $("#video-api-url").val() + videoUrl);
}

// 接口报错提交
function errReportSubmit() {
    $.ajax({
        type: 'POST', 
        url: mkSiteInfo.siteUrl + "/api.php", 
        data: "types=apierr&" + $("#err-report-form").serialize(),
        dataType : "jsonp",
        complete: function(XMLHttpRequest, textStatus) {
        },  // complete
        success: function(jsonData){
            layer.close(layer.index);
            layer.msg(jsonData.msg);    // 展示回馈消息
        },   //success
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            layer.msg("数据提交失败" + XMLHttpRequest.status);
        }   // error
    });// ajax
    
    return false;
}

// ajax 获取所有错误接口列表
function ajaxErrApiList() {
    $.ajax({
        type: 'POST', 
        url: mkSiteInfo.siteUrl + "/api.php", 
        data: "types=geterrapilist",
        dataType : "jsonp",
        complete: function(XMLHttpRequest, textStatus) {
        },  // complete
        success: function(jsonData){
            if(jsonData.code != 200) {
                layer.msg("出错接口数据获取失败 - " + jsonData.code);
            } else {
                mkSiteInfo.allApi = jsonData.msg;
            }
        },   //success
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            layer.msg("接口数据获取失败 " + XMLHttpRequest.status);
        }   // error
    });// ajax
}
