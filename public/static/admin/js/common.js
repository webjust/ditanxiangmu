// 删除
function btn_del(url) {
    layer.confirm("确定删除吗？", function (index) {
        window.location.href = url;
    })
}

// 更新排序操作
$("#button_listorder").click(function () {
    var data = $("#list_order_form").serializeArray();
    postData = {};
    $(data).each(function (i) {
        postData[this.name] = this.value;
    })
    var url = SCOPE.listorder_url;

    // 将获取的数据post给服务器
    $.post(url, postData, function (result) {
        if (result.status == 1) {
            layer.msg(result.info);
            window.location.href = SCOPE.jump_url;
            return false;
        } else {
            layer.msg(result.info);
            window.location.href = SCOPE.jump_url;
            return false;
        }
    }, "JSON")

});

// 修改状态
$("#list_order_form .btn_on_off").click(function () {
    var id = $(this).attr('attr-id');
    var status = $(this).attr('attr-status');
    var url = SCOPE.set_status_url;

    data = {};
    data['id'] = id;
    data['status'] = status;

    layer.open({
        type: 0,
        title: "是否提交?",
        btn: ['yes', 'no'],
        icon: 3,
        closeBtn: 2,
        content: "是否确定修改状态",
        scrollbar: true,
        yes: function () {
            // 执行相关跳转
            todelete(url, data);
        },
    });
});

// 跳转
function todelete(url, data) {
    $.post(url, data, function (s) {
        if (s.status == 1) {
            return dialog.success(s.info, '');
        } else {
            return dialog.error(s.info);
        }
    }, "JSON");
}