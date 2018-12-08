/**
 * Created by duan on 2015-12-22.
 */
jQuery(document).ready(function () {

    var today = GetDateStr(0);
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            autoclose: true,
            rtl: Metronic.isRTL(),
            format: "yyyy-mm-dd",
            endDate: today
        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }
    function GetDateStr(AddDayCount) {
        var dd = new Date();
        dd.setDate(dd.getDate() + AddDayCount);//获取AddDayCount天后的日期
        var y = dd.getFullYear();
        var m = dd.getMonth() + 1;//获取当前月份的日期
        var d = dd.getDate();
        return y + "-" + m + "-" + d;
    }
    /****寄送发票***/
    $('#send-invocie').on('click',function(){
        addlayer = layer.open({
            type : 1,
            title : '寄送发票',
            maxmin: false,
            offset: ['46px', ''],
            closeBtn: 1,
            border : [0],
            fix: false,
            area : ['760px',''],
            btn: ['确定', '取消'],
            yes:function(){
                send_invoice();
            },
            cancel:function(index){
                layer.close(index);
            },
            content : $('#send-modal')
        });
    });

    $('#myform').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        rules: {
            express_company: {
                required: true
            },
            express_number: {
                required: true
            },
            //invoice_number:{
            //    required: true
            //}
        },

        messages: {
            express_company: {
                required: '请选择快递公司'
            },
            express_number: {
                required: '请填写快递单号'
            },
            //invoice_number:{
            //    required: '请填写发票号码'
            //}
        },
        invalidHandler: function (event, validator) { //display error alert on form submit
            $('.alert-danger', $('.login-form')).show();
        },
        highlight: function (element) { // hightlight error inputs
            $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
            var eclass = $(element).attr('class');
            if(eclass=='hidden_value'){
                $(element).siblings('.input-group-btn').find('.uneditable-input').css({border: "1px solid #b94a48"});
            }
        },
        success: function (label) {
            label.closest('.form-group').removeClass('has-error');
            label.siblings('.col-md-5').find('.uneditable-input').css({border: "1px solid #e5e5e5"});
            label.remove();
        },
        errorPlacement: function (error, element) {
            if(element.closest('.col-md-5').next('.help-inline').html()!=undefined){
                error.insertAfter(element.closest('.col-md-5').next('.help-inline'));
            }else{
                error.insertAfter(element.closest('.col-md-5'));
            }
        },
        submitHandler: function (form) {
            // form.submit();
        }
    });

    /****寄送发票****/
    function send_invoice()
    {
        if($('#myform').validate().form()){
            var load = layer.load('正在提交，请稍后...');
            $.ajax({
                type: 'POST',
                url: '/invoice/express-send',
                data: $('#myform').serialize(),
                dataType:'json',
                success: function (r) {
                    layer.close(load);
                    saveflag = false;
                    if('err'==r.info){
                        common_layer(r.data,'');
                    }else{
                        var url = '/order/index';
                        common_layer(r.data,url);
                    }
                },
                error: function () {
                    layer.close(load);
                    common_layer('保存失败','');
                }
            });
        }
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
});
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
/**
 * 收起发票信息
 * @param obj
 */
function show(obj){
    if ($(obj).hasClass('glyphicon-chevron-up')){
        $(obj).removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
    }else{
        $(obj).removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
    }
    $('.info').slideToggle(100);
}