// 验证管理员密码
function adminCodeCK(adminCode,isIN=false) {
    // 将对象转换成JSON字符串
    var postStr = JSON.stringify({
        "command":  adminCode
    })
    // 推送
    $.post("adminlogin.php", postStr, function(data) {
        if(isIN&&data == "True"){
            GetPageInfo();
            Get_data(1);
        }else
        {
            if (data == "True") {
                location.href='admin.html?ac='+adminCode;
            } else {
                alert("错误的密码");
                location.href='admin.html?ac=0';
            }
        }
        
    });
}


//summary
//用于获得页面基础信息，例如总页数
function GetPageInfo() {
    //定义
    $.get("datainfo.php?page=0", function(data, status) {
        var data = JSON.parse(data);
        var v = $(".switchPage-button").clone(); //复制按钮
        for (var i = 2; i <= data.allPages; i++) {
            v.html(i);
            v.appendTo(".page-container");
            v = v.clone();
        }
    });
}
//summary
//文章标题
function GetPassageTitleById(id) {
    $.get("msg.php?id=" + id, function(data, status) {
        var data = JSON.parse(data);
        $("#source-title").html(data[0].title);
    });
}

function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r !== null) return unescape(r[2]);
    return null;
}

//summary
//用于获得文章信息
//ind 当前页数
function Get_data(ind) {
    $(".spinner").show(); //显示等待
    //使用get目录在test.php获得ind页的文章
    $.get("datainfo.php?page=" + ind, function(data, status) {
        try {
            var data = JSON.parse(data);

            data.sort((x, y) => { //按id顺序
                return x.id - y.id;
            });

            $("#model-comment").show(); //隐藏模板
            $("#model-message").show();
            //将文章添加到DOM
            for (var i = 0; i < data.length; i++) {
                var item = data[i];
                if (item.sourceId === 0) {
                    var v = $("#model-message").clone(); //复制模板
                    v.id = "msg_" + item.id;
                    v.attr("id", v.id); //修改id
                    v.find(".message-title").html(item.title); //标题
                    // v.find(".Comment-button").attr("id", v.id);//
                    v.find(".message-text").html(item.text); //正文
                    v.find(".like-num").html(item.like); //赞
                    v.find(".dislike-num").html(item.dislike); //踩
                    v.prependTo(".message-container"); //倒序插入到根容器
                } else {
                    var v = $("#model-comment").clone(); //复制模板
                    v.id = "msg_" + item.id;
                    v.attr("id", v.id);
                    v.find(".message-title").html(item.title); //标题
                    v.find(".message-text").html(item.text); //正文
                    //  v.find(".Comment-button").attr("id", v.id);//
                    v.find(".like-num").html(item.like); //赞
                    v.find(".dislike-num").html(item.dislike); //踩
                    v.prependTo($("#msg_" + item.sourceId).find(".comment-container")[0]); //倒序插入到评论区
                    v.show();
                }
            }
            $("#model-message").hide(); //隐藏模板
            $("#model-comment").hide(); //隐藏模板
            // $(".message-container").load("model.html .message")
        } catch (e) {

        }

        $(".spinner").hide(); //隐藏等待
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
    $(".spinner").show(); //显示等待
}

// 标准推送流程
// command ["msg", "like", "dislike"]
function post(command, f_id,adminCode=0) {
    // 生成时间
    var myTime = + new Date();

    // 生成推送数据
    data = {
        "time": myTime,
        "sourceId": f_id,
        "adminCode":adminCode
    }
    if (command == "msg") {
        data.title = $(".title").text();
        data.text = $(".text").text();

        // 判断输入是否合法
        if (data.title == "Title" || data.text == "Lorem ipsum dolor sit amet, consectetur adipisici elit,.") {
            alert("不合法的输入");
            return;
        }
    }

    // 将对象转换成JSON字符串
    var postStr = JSON.stringify({
        "command": command,
        "data": data
    })

    // 推送
    $.post("postNew.php", postStr, function(data) {
        if (data == "200 Ok") {
            //如果是手机发帖自动支付宝红包
            if (!IsPC()) {
                window.open("//qr.alipay.com/c1x03755egvovifw2ztz8aa");
            }
            window.history.back();
        } else {
            alert(data);
        }
    });
}

//summary
//用于点赞
// f_id 文章的父id 为主文章即为0
function like(f_id) {
    post("like", f_id.replace("msg_",""));
}

//summary
//用于点踩
// f_id 文章的父id 为主文章即为0
function dislike(f_id) {
    post("dislike", f_id.replace("msg_",""));
}

//summary
//用于删除
// id 文章的id
function delPost(id,adminCode) {
    post("del", id.replace("msg_",""),adminCode);
}
//summary
//用于发送新的文章
// f_id 文章的父id 为主文章即为0
function postMsgTo(f_id) {
    post("msg", f_id);
}

///
///监测手机还是电脑
///
function IsPC() {
    var userAgentInfo = navigator.userAgent;
    var Agents = ["Android", "iPhone",
        "SymbianOS", "Windows Phone",
        "iPad", "iPod"
    ];
    var flag = true;
    for (var v = 0; v < Agents.length; v++) {
        if (userAgentInfo.indexOf(Agents[v]) > 0) {
            flag = false;
            break;
        }
    }
    return flag;
}
