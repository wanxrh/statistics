/**
 * Created by duan on 2015-12-17.
 */
$(function(){
    //再次进来的时候
    var $subs = $(".checkbox_td");
    var checked = $subs.length == $subs.filter(":checked").length ? true :false;
    if(checked && $subs.length>0){
        $('.allcheckbox_td').prop("checked",true);
    }else{
        $('.allcheckbox_td').prop("checked",false);
    }

    //批量处理
    $('.table').on('change','.allcheckbox_td',function(){
        $('.checkbox_td').prop("checked",this.checked);
        if(this.checked){
            $('.checkbox_td').closest("span").addClass('checked');
        }else{
            $('.checkbox_td').closest("span").removeClass('checked');
        }
        $('.allcheckbox_td').prop("checked",this.checked);
    })
    //选择
    $('.table').on('click','.checkbox_td',function() {
        var flag = true;
        $(".checkbox_td").each(function() {
            if (!$(this).prop('checked')) {
                flag = false;
            }
        });
        if (!flag) {
            $('.allcheckbox_td').closest("span").removeClass('checked');
            $(".allcheckbox_td").prop('checked', false);
        }else{
            $(".allcheckbox_td").prop('checked', true);
            $('.allcheckbox_td').closest("span").addClass('checked');
        }
    });

    //添加人员
    $('.table-toolbar').on('click','#add-attende',function(){
        addlayer = layer.open({
            type : 1,
            title : '添加人员',
            maxmin: false,
            offset: ['46px', ''],
            closeBtn: 1,
            border : [0],
            fix: false,
            area : ['610px',''],
            btn: ['确定', '取消'],
            yes:function(){
                submit_attendee();
            },
            cancel:function(index){
                layer.close(index);
            },
            content : $('#create_attendee')
        });
    });

    //导入二级用户
    $('.table-toolbar').on('click','#import-user',function(){
        layer.confirm('您确认导入二级用户吗？',
            {
                btn: ['确认','取消']
            },
            function(){
                var load = layer.load('正在导入，请稍后...');
                $.ajax({
                    type: 'POST',
                    url: '/register/import',
                    data: {},
                    dataType:'json',
                    success: function (r) {
                        layer.close(load);
                        if(r.info!="ok"){
                            common_layer(r.data,'');
                            return false;
                        }
                        var url = window.location.href;
                        common_layer(r.data,url);
                    },
                    error: function () {
                        layer.close(load);
                        common_layer('保存失败','');
                    }
                });
            }
        );
    });

    //删除用户
    $('.table').on('click','.delete',function(){
        var guid = $(this).attr('data-id');
        layer.confirm('您确认删除此人员吗？',
            {
                btn: ['确认','取消']
            },
            function(){
                var load = layer.load('正在删除，请稍后...');
                $.ajax({
                    type: 'POST',
                    url: '/register/delete-attendee',
                    data: {guid:guid},
                    dataType:'json',
                    success: function (r) {
                        layer.close(load);
                        if(r.info!="ok"){
                            common_laye(r.data,'');
                            return false;
                        }
                        var url = window.location.href;
                        common_laye(r.data,url);
                    },
                    error: function () {
                        layer.close(load);
                        common_laye('保存失败','');
                    }
                });
            }
        );
    });
    //删除用户 end

    //下一步
    $('.table-toolbar').on('click','#submit-attendee',function(){
        var flag = false;
        $(".checkbox_td").each(function() {
            if ($(this).prop('checked')) {
                flag = true;
            }
        });
        if(!flag){
            common_layer("请至少选择一个参会人员",'');
            return false;
        }

        var load = layer.load('正在提交，请稍后...');
        $.ajax({
            type: 'POST',
            url: '/register/save-info',
            data: $('#info_form').serialize(),
            dataType:'json',
            success: function (r) {
                layer.close(load);
                if(r.info!="ok"){
                    common_layer(r.data,'');
                    return false;
                }
                window.location.href=r.data;
            },
            error: function () {
                layer.close(load);
                common_layer('保存失败','');
            }
        });
    });

    //验证输入
    var reg_mobile = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
    jQuery.validator.addMethod("checkmobile", function(value, element) {
        return this.optional(element) || reg_mobile.test(value);
    }, "请正确输入手机号码");

    $('#create_form').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        rules: {
            name: {
                required: true
            },
            //mobile: {
            //    required: true,
            //    checkmobile:true
            //},
            //email: {
            //    required: true,
            //    email:true
            //},
        },
        messages: {
            name: {
                required: '请输入姓名'
            },
            //mobile: {
            //    required: "请输入手机号码",
            //    checkmobile:"请正确输入手机号码"
            //},
            //email: {
            //    required: "请输入邮箱",
            //    email:"请输入正确的邮箱"
            //},
        },
        invalidHandler: function (event, validator) { //display error alert on form submit
            $('.alert-danger', $('.login-form')).show();
        },
        highlight: function (element) { // hightlight error inputs
            $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
        },
        success: function (label) {
            label.closest('.form-group').removeClass('has-error');
            label.remove();
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element.closest('.col-md-5'));
        },
        submitHandler: function (form) {
            // form.submit();
        }
    });

    //线下支付 start
    var today = GetDateStr(0);
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            endDate: today
        });
    }

    /***
     * 删除附件
     */
    $('#attachment').on('click','.label-danger',function(e){
        $(this).closest('.hidden_value').remove();
        var t = $('#attachment').html();
        t = t.replace(/[\r\n]/g,"").replace(/[ ]/g,"");
        if(t == ''){
            $('#attachment').closest('.form-group').hide();
        }
    });

    $('#offline_form').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        rules: {
            payer: {
                required: true
            },
            pay_date: {
                required: true,
            },
            amount: {
                required: true,
                number:true
            },
        },
        messages: {
            payer: {
                required: '请填写汇款单支付方'
            },
            pay_date: {
                required: "请选择汇款单日期"
            },
            amount: {
                required: "请填写汇款金额",
                number:"请填写正确的汇款金额"
            },
        },
        invalidHandler: function (event, validator) { //display error alert on form submit
            $('.alert-danger', $('.login-form')).show();
        },
        highlight: function (element) { // hightlight error inputs
            $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
        },
        success: function (label) {
            label.closest('.form-group').removeClass('has-error');
            label.remove();
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element.closest('.col-md-4'));
        },
        submitHandler: function (form) {
            // form.submit();
        }
    });

    $('#tab_1_1').on('click','#saveoffline',function(){
        if(!$('#offline_form').validate().form()){
            return false;
        }
        var load = layer.load('正在提交，请稍后...');
        $.ajax({
            type: 'POST',
            url: '/register/save-offline',
            data: $('#offline_form').serialize(),
            dataType:'json',
            success: function (r) {
                layer.close(load);
                if(r.info!="ok"){
                    common_layer(r.data,'');
                    return false;
                }
                common_layer("保存成功", r.data);
            },
            error: function () {
                layer.close(load);
                common_layer('保存失败','');
            }
        });
    });

/***这是会员费用续费时提交方法***/
    $('#tab_1_3').on('click','#saveoffline',function(){
        if(!$('#offline_form').validate().form()){
            return false;
        }
        var load = layer.load('正在提交，请稍后...');
        $.ajax({
            type: 'POST',
            url: '/renew/save-offline',
            data: $('#offline_form').serialize(),
            dataType:'json',
            success: function (r) {
                layer.close(load);
                if(r.info!="ok"){
                    common_layer(r.data,'');
                    return false;
                }
                common_layer("保存成功", r.data);
            },
            error: function () {
                layer.close(load);
                common_layer('保存失败','');
            }
        });
    });






});

/*****保存人员信息*****/
function submit_attendee(){

    if($('#create_form').validate().form()){
        var load = layer.load('正在提交，请稍后...');
        $.ajax({
            type: 'POST',
            url: '/order/save-attendee',
            data: $('#create_form').serialize(),
            dataType:'json',
            success: function (r) {
                layer.close(load);
                if(r.info!="ok"){
                    common_laye(r.data,'');
                    return false;
                }
                layer.close(addlayer);
                var url = window.location.href;
                common_laye(r.data,url);
            },
            error: function () {
                layer.close(load);
                common_laye('保存失败','');
            }
        });
    }
}
/**
 * 通用弹窗
 * @param r
 * @param url
 * 这个主要用回会议报名添加，删除人员
 */
function common_laye(r,url){
    var layerc = layer.open({
        title:['信息提示'],
        area: '400px',
        border: [1, 0.3, '#ccc'],
        shade: [0.5, '#000'],
        content:r,
        btn:['确定'],
        yes: function(){
            if(url=='' || url==undefined){
                layer.close(layerc);
            }else{
                location.href= url;
            }
        }

    });
}
//上传附件
function ajaxFileUpload(obj) {
    var fileName = $(obj).attr('id');
    var uploadInfo = $(obj).parent();
    var fileInput = $("#"+fileName)[0];
    if (fileInput.files && fileInput.files[0]) {
        var size = fileInput.files[0].fileSize;
        if(size>1024*1024*2 || size<6*1024){
            common_layer('文件大小不能超过20M','');
            return false;
        }
    }
    var load = layer.load('正在上传');
    $.ajaxFileUpload
    (
        {
            url: '/upload/upload-file',
            secureuri: false,
            fileElementId: fileName,
            dataType: 'json',
            data: {
                'file_name': fileName
            },
            success: function (data, status) {
                layer.close(load);
                if (typeof(data.error) != 'undefined' && data.error != '') {
                    common_layer(data.error,'');
                } else {
                    var str = '<div class="hidden_value"><input type="hidden" name="attachment[]" value="' + data.guid + '" >' +
                        '<span class="help-inline" style="padding-top:0px;"><a href="/upload/showuploadfile?id=' + data.guid + '" target="_blank">' + data.name + '</a></span>'+
                        '<span class="label label-sm label-danger"><a href="javascript:;" style="color:#fff;">删除</a></span></div>';
                    $('#attachment').append(str);
                    $('#attachment').closest('.form-group').show();
                }
            },
            error: function (data, status, e) {
                layer.close(load);
                common_layer('上传失败，请稍后重试','');
            }
        }
    );
    return false;
}
function GetDateStr(AddDayCount) {
    var dd = new Date();
    dd.setDate(dd.getDate() + AddDayCount);//获取AddDayCount天后的日期
    var y = dd.getFullYear();
    var m = dd.getMonth() + 1;//获取当前月份的日期
    var d = dd.getDate();
    return y + "-" + m + "-" + d;
}