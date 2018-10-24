//summary
//用于获得页面基础信息，例如总页数
//
function GetPageInfo() {
    //定义
    $.get("test.php?page=0", function (data, status) {
        var data = JSON.parse(data);
        var v = $(".switchPage-button").clone();//复制按钮
        for (var i = 2; i <= data.allPages; i++) {
            v.html(i);
            v.appendTo(".page-container");
            v = v.clone();
        }
    });
}

//summary
//文章标题
//
function GetPassageTitleById(id) {
    $.get("test.php?id=" + id, function (data, status) {
        var data = JSON.parse(data);
        $("#source-title").html(id + data.title);
    });
}
function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r !== null) return unescape(r[2]); return null;
}

//summary
//用于获得文章信息
//ind 当前页数
function Get_data(ind) {
    $(".spinner").show();//显示等待
    //使用get目录在test.php获得ind页的文章
    $.get("test.php?page=" + ind, function (data, status) {
        try {
            var data = JSON.parse(data);

            $("#model-comment").show();//隐藏模板
            $("#model-message").show();
            //将文章添加到DOM
            for (var i = 0; i < data.count; i++) {
                if (data.sourceId[i] === 0) {
                    var v = $("#model-message").clone();//复制模板
                    v.id = "msg_" + data.id[i];
                    v.attr("id", v.id);//修改id
                    v.find(".message-title").html(data.title[i]);//标题
                    // v.find(".Comment-button").attr("id", v.id);//
                    v.find(".message-text").html(data.text[i]);//正文
                    v.find(".like-num").html(data.like[i]);//赞
                    v.find(".dislike-num").html(data.dislike[i]);//踩
                    v.appendTo(".message-container");
                }
                else {
                    var v = $("#model-comment").clone();//复制模板
                    v.id = "msg_" + data.id[i];
                    v.attr("id", v.id);
                    v.find(".message-title").html(data.title[i]);//标题
                    v.find(".message-text").html(data.text[i]);//正文
                    //  v.find(".Comment-button").attr("id", v.id);//
                    v.find(".like-num").html(data.like[i]);//赞
                    v.find(".dislike-num").html(data.dislike[i]);//踩
                    v.appendTo($("#msg_" + data.sourceId[i]).find(".comment-container")[0]);
                    v.show();
                }

            }
            $("#model-message").hide();//隐藏模板
            $("#model-comment").hide();//隐藏模板
            // $(".message-container").load("model.html .message")
        } catch (e) {

        }

        $(".spinner").hide();//隐藏等待
    });
}

//summary
//用于清理DOM文章
//
function Clean() {
    var v0 = $(".spinner").clone();
    var v = $("#model-message").clone();
    var v2 = $("#model-comment").clone();
    $("#message-container").empty();
    v0.appendTo("#message-container");
    v.appendTo("#message-container");
    v2.appendTo("#message-container");
    $(".spinner").show();//显示等待
}

//summary
//用于点赞
//
function like(f_id) {
    var myDate = new Date();
    var mytime = myDate.getTime();
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/userPost", true);//
    xhr.setRequestHeader("Content-type", "application/json");
    xhr.setRequestHeader("kbn-version", "5.3.0");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                window.history.back();
            }
        }
    };

    xhr.send(
        JSON.stringify({
            "command": "like",
            "data": {
                "sourceId": f_id,
                "time": mytime
            }
        })
    );

}

//summary
//用于点踩
//
function dislike(f_id) {
    var myDate = new Date();
    var mytime = myDate.getTime();

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/userPost", true);//
    xhr.setRequestHeader("Content-type", "application/json");
    xhr.setRequestHeader("kbn-version", "5.3.0");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {

            }
        }
    };

    xhr.send(
        JSON.stringify({
            "command": "dislike",
            "data": {
                "sourceId": f_id,
                "time": mytime
            }
        })
    );

}

//summary
//用于发送新的文章
//f_id 文章的父id 为主文章即为0
function Post_new(f_id) {
    //获得发帖数据
    var myDate = new Date();
    var mytime = myDate.getTime();

    var us = { title: $(".title").text(), text: $(".text").text(), source_id: f_id, time: mytime };
    //准备
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/userPost", true);//
    xhr.setRequestHeader("Content-type", "application/json");
    xhr.setRequestHeader("kbn-version", "5.3.0");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                window.history.back();
            }
        }
    };

    //发送信息
    xhr.send(
        JSON.stringify({
            "command": "post",
            "data": {
                "title": us.title,
                "text": us.text,
                "sourceId": us.source_id,
                "time": us.time
            }
        })
    );

    if (!IsPC()) {
        window.open("//qr.alipay.com/c1x03755egvovifw2ztz8aa");//如果是手机发帖自动支付宝红包
    }

}

///
///监测手机还是电脑
///
function IsPC() {
    var userAgentInfo = navigator.userAgent;
    var Agents = ["Android", "iPhone",
        "SymbianOS", "Windows Phone",
        "iPad", "iPod"];
    var flag = true;
    for (var v = 0; v < Agents.length; v++) {
        if (userAgentInfo.indexOf(Agents[v]) > 0) {
            flag = false;
            break;
        }
    }
    return flag;
}