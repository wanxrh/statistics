/**
 * Created by Administrator on 2014-12-17.
 */
$(function(){

    $(".autoFillContactCheckbox").click(function(event) {
        var check = $(this).prop("checked");
        if (check) {
            $("#registrant_cname").val(NAME);
            $("#province_cname").val(PROVINCE);
            $("#city_cname").val(CITY);
            $("#mobile").val(CELLPHONE);
            $("#email").val(EMAIL);
        }
    });

	//附件删除
    $('.fileupload').on('click','.red',function(e){
        $(this).siblings('.hidden_value').val('');
        $(this).siblings('.btn-file').find('.fileupload-new').show();
        $(this).siblings('.btn-file').find('.fileupload-exists').hide();
        $(this).siblings('.input-group-btn').find('.icon-file').addClass('fileupload-exists');
        $(this).siblings('.input-group-btn').find('.fileupload-preview').html('');
        $(this).hide();
    });

    /***根据所有者类型选择上传附件****/
    $('#myform').on('change','.registrant_type',function(e){
        var value = $(this).val();
        var organization_type = $('#organization_type').val();

        if(value=='个人'){
            $('.many').find('.help-inline').hide();
            $('#organization_type').find('.qiye').remove();
            $('.organization_number').empty().html('营业执照编号<span class="required">*</span>');
            $('.business_license_file').empty().html('营业执照复印件<span class="required">*</span>');
            $('.organization_type').empty().html('组织证件类型<span class="required">*</span>');
            //$('.many').hide();
            $('.ID_card_copy_file').empty().html('域名所有者身份证复印件<span class="required">*</span>');
        }else{
            var select = 'selected="selected"';
            $('#organization_type').append('<option  value="组织机构代码证" class="qiye" '+select+'>组织机构代码证</option>');
            $('.many').find('.help-inline').show();
            $('.organization_number').empty().html('组织机构代码证编号<span class="required">*</span>');
            $('.business_license_file').empty().html('组织机构代码证复印件<span class="required">*</span>');
            $('.organization_type').empty().html('组织证件类型<span class="required">*</span>');
            //$('.many').hide();
            $('.ID_card_copy_file').empty().html('域名承办人身份证复印件<span class="required">*</span>');
        }
    });
    /***根据根据商标注册类型选择域名注册年限****/
    $('#myform').on('change','.trademark_registration_type',function(e){
        var value = $(this).val();
        if(value=='商标注册证书'){
            var html =  render_years(10);
            $('#selected_year').empty().html(html);
            $('.trademark_rights').empty().html('商标注册证书复印件<span class="required">*</span>');
            $('.start_date').empty().html('商标注册证书颁发日期<span class="required">*</span>');
        }else{
            var html =  render_years(2);
            $('#selected_year').empty().html(html);

            $('.trademark_rights').empty().html('商标受理通知书复印件<span class="required">*</span>');
            $('.start_date').empty().html('商标受理通知书颁发日期<span class="required">*</span>');
        }
    });

    /***根据根据组织证件类型选标题****/
    $('#myform').on('change','#organization_type',function(e){
        var value = $(this).val();
        if(value=='组织机构代码证'){
            $('.organization_number').empty().html('组织机构代码证编号<span class="required">*</span>');
            $('.business_license_file').empty().html('组织机构代码证复印件<span class="required">*</span>');
            $('.organization_number').closest('.control-label').siblings('.help-inline').show();
            $('#organization_type').closest('.col-md-6').siblings('.help-inline').show();
            $('.organization_number').closest('.form-group').removeClass('has-error');
            $('.organization_number').closest('.control-label').siblings('.help-block').remove();
        }else{
            $('.organization_number').empty().html('营业执照编号<span class="required">*</span>');
            $('.organization_number').closest('.control-label').siblings('.help-inline').hide();
            $('#organization_type').closest('.col-md-6').siblings('.help-inline').hide();
            $('.organization_number').closest('.form-group').removeClass('has-error');
            $('.organization_number').closest('.control-label').siblings('.help-block').remove();
            $('.business_license_file').empty().html('营业执照复印件<span class="required">*</span>');
        }
    });
    $('#myform').on('change', '#selected_year', function (e) {
        getInfo();
    });

    //渲染颁发国
    renderRegionSelect();

    //附件删除
    $('.fileupload').on('click','.red',function(e){
        $(this).siblings('.hidden_value').val('');
        $(this).siblings('.btn-file').find('.fileupload-new').show();
        $(this).siblings('.btn-file').find('.fileupload-exists').hide();
        $(this).siblings('.input-group-btn').find('.icon-file').addClass('fileupload-exists');
        $(this).siblings('.input-group-btn').find('.fileupload-preview').html('');
        $(this).siblings('.fileupload-exists').remove();
        $(this).hide();
    });

    //组织机构代码证编号
    jQuery.validator.addMethod("checkorglength", function(value, element) {
        var type = $('#organization_type').val();
        var flag = $('#bussiness').attr('checked');
        if(type=='组织机构代码证' && flag){
            if(value.replace(/(^\s*)|(\s*$)/g, "")==''){
                return false;
            }
            return /^[0-9]{9,10}$/.test(value);
        }else{
            return true;
        }
    }, "长度为9-10位");
    //营业执照编号
    jQuery.validator.addMethod("checkbussinesslength", function(value, element) {
        var type = $('#organization_type').val();
        if(type=='营业执照'){
            if(value.replace(/(^\s*)|(\s*$)/g, "")==''){
                return false;
            }
            return /^[0-9]{15}$/.test(value) || /^[0-9]{13}$/.test(value);
        }else{
           return true;
        }
    }, "长度为13-15位");

    //营业执照
    jQuery.validator.addMethod("checkbussiness", function(value, element) {
        var type = $('#organization_type').val();
        var flag = $('#bussiness').attr('checked');
        if(type=='营业执照'  && flag){
            if(value.replace(/(^\s*)|(\s*$)/g, "")==''){
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    }, "请上传营业执照复印件");

    //组织机构代码证
    jQuery.validator.addMethod("checkorgcopy", function(value, element) {
        var type = $('#organization_type').val();
        var flag = $('#bussiness').attr('checked');
        if(type=='组织机构代码证'  && flag){
            if(value.replace(/(^\s*)|(\s*$)/g, "")==''){
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    }, "请上传组织机构代码证复印件");

    /***身份证号***/
    jQuery.validator.addMethod("checkcontactnumber", function(value, element) {
        var type = $('#contact_paper_type').val();
        if("身份证"==type){
            return isCardID(value);
        }else{
            return getBytesLen(value)>=32 ? false:true;
        }
    }, "请正确输入身份证号");

    /***域名所有者***/
    jQuery.validator.addMethod("checkregistrantname", function(value, element) {
        return this.optional(element) || /^[-a-zA-Z0-9\s&,#_\'\:\：\"\.\u4E00-\u9FA5\(\)\uFF08\uFF09\u300A\u300B\u00b7\ue863]{1,}$/.test(value);
    }, "请输入域名所有者名称");

    /***地址信息***/
    jQuery.validator.addMethod("checkaddress", function(value, element) {
        return this.optional(element) || /^[-0-9a-zA-Z\u4e00-\u9fa5\(\)\s,#\._\'\"&\/]+$/.test(value);
    }, "请输入通信地址（中文）");
    /***邮编***/
    jQuery.validator.addMethod("checkpostalcode", function(value, element) {
        return this.optional(element) || /^[0-9]\d{5}$/.test(value);
    }, "邮编为六位数字");

    /***提交表单****/
    $('#myform').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "",
        rules: {
            name: {
                required: true
            },
            province_cname: {
                required: true
            },
            city_cname: {
                required: true
            },
            registrant_name: {
                required: true
            },
            credentials_number: {
                required: true
            },
            parse_url:{
                url:true
            },
            organization_number: {
                required: true
            },
            telephone: {
                required: true,
                remote:{
                    url:'/domain-register/check-telephone',
                    type:'post',
                    data:{
                        'telephone':function(){
                            return $('#telephone').val();
                        },
                        'type':'tel'

                    }
                }
            },
            mobile: {
                required: true,
                remote:{
                    url:'/domain-register/check-telephone',
                    type:'post',
                    data:{
                        'telephone':function(){
                            return $('#mobile').val();
                        },
                        'type':'mobile'

                    }
                }
            },
            business_license:{
                checkbussiness:true,
                checkorgcopy:true
            },
            trademark_certificate_copy:{
                required : true
            },
            id_card_copy:{
                required : true
            },
            email: {
                required: true,
                email: true
            },
            zip: {
                required: true,
                checkpostalcode: true
            },
            fax:{
                remote:{
                    url:'/domain-register/check-telephone',
                    type:'post',
                    data:{
                        'telephone':function(){
                            return $('#telephone').val();
                        },
                        'type':'tel'

                    }
                }
            },
            address: {
                required: true,
                checkaddress: true
            }
        },
        messages: {
            name: {
                required: "请输入域名所有者名称"
            },
            province_cname: {
                required: "请输入所在省份"
            },
            city_cname: {
                required: "请输入所在城市"
            },
            registrant_name: {
                required: "请输入公司单位名称"
            },
            credentials_number: {
                required: "请输入证件号码"
            },
            parse_url:{
                url:"请输入正确的网址"
            },
            organization_number: {
                required: "请输入营业执照编号或组织机构代码证编号"
            },
            telephone: {
                required: "请输入联系电话",
                remote:'请输入正确的联系电话。格式如：+86.01012345678'
            },
            mobile: {
                required: "请输入手机号",
                remote:'请输入正确的手机号码。格式如：+86.13188888888'
            },
            fax:{
                remote:'请输入正确的传真号码。格式如：+86.01012345678'
            },
            email: {
                required: '请输入email',
                email: '请正确输入电子邮箱'
            },
            zip: {
                required: '请输入邮编',
                checkpostalcode: '邮编为六位数字'
            },
            business_license:{
                checkbussiness:'请上传营业执照复印件',
                checkorgcopy:'请上传组织机构代码证复印件'
            },
            trademark_certificate_copy:{
                required : '请上传商标证书或商标受理通知书复印件'
            },
            id_card_copy:{
                required : '请上传域名承办人身份证复印件'
            },
            address: {
                required: '请输入详细地址',
                checkaddress: '请输入通信地址（中文）'
            }
        },

        highlight: function (element) { // hightlight error inputs
            $(element)
                .closest('.form-group').addClass('has-error'); // set error class to the control group
        },

        success: function (label) {
            label.closest('.form-group').removeClass('has-error');
            label.remove();
        },

        errorPlacement: function (error, element) {
            error.insertAfter(element.closest('.input-icon'));
        }
    });
    var saveflag = false;
    if (saveflag == false) {
        $('#registBtn').click(function () {
            if ($('#myform').validate().form()) {
                var checked = $('#agree_rule').prop('checked');
                if(!checked){
                    common_layer('只有阅读并接受协议才能购买产品');
                    return false;
                }
                saveflag = true;
                var load = layer.load('正在提交，请稍后...');
                $.ajax({
                    type: 'POST',
                    url: '/domain-register/save-trademark',
                    data: $('#myform').serialize(),
                    dataType: 'json',
                    success: function (r) {
                        layer.close(load);
                        if ('err' == r.info) {
                            saveflag = false;
                            if(r.data=='login'){
                                _checkLogin();
                                return false;
                            }else{
                                common_layer(r.data);
                            }
                        } else {
                            var url=encodeURI(r.data);
                            location.href=url;
                        }
                    },
                    error: function () {
                        layer.close(load);
                        saveflag = false;
                        common_layer('提交失败', '');
                    }
                });
            }
        });
    } else {
        alert("数据已提交");
    }
});
//上传附件
function ajaxFileUpload(obj) {

    var fileName = $(obj).attr('id');
    var uploadInfo = $(obj).parent();
    var file = $(obj).val();
    var fileType = file.substring(file.lastIndexOf(".")+1);
    fileType = fileType.toLowerCase();
    var allows = ['png','jpg','jpeg','bmp'];
    if($.inArray(fileType,allows)==-1){
        common_layer('上传文件格式不允许','');
        return;
    }
    var fileInput = $("#"+fileName)[0];
    if (fileInput.files && fileInput.files[0]) {
       var size = fileInput.files[0].fileSize;
        if(size>1024*1024*2 || size<6*1024){
            common_layer('File size is required between 5K-2M.','');
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
                'file_name': fileName,
                'type':'bmp,jpeg,jpg,png',
                'minsize':5
            },
            success: function (data, status) {
                layer.close(load);
                if (typeof(data.error) != 'undefined' && data.error != '') {
                    common_layer(data.error,'');
                } else {
                    /***给隐藏域赋值***/
                    uploadInfo.siblings('.hidden_value').val(data.guid);
                    //删除之前错误提示
                    uploadInfo.siblings('.input-group-btn').find('.uneditable-input').css({border: "1px solid #e5e5e5"});
                    uploadInfo.closest('.form-group').removeClass('has-error');
                    uploadInfo.closest('.form-group').find('.help-block').hide();
                    uploadInfo.closest('.form-group').find('.business_license_help').hide();
                    /***输入框显示文件名***/
                    uploadInfo.siblings('.input-group-btn').find('.icon-file').removeClass('fileupload-exists');
                    uploadInfo.siblings('.input-group-btn').find('.fileupload-preview').html(data.name);
                    /****remove change 替换***/
                    uploadInfo.find('.fileupload-new').hide();
                    uploadInfo.find('.fileupload-exists').show();
                    var html = '&nbsp;<a class="btn btn-primary fileupload-exists show_pic" target="_blank" href="/upload/showuploadfile?id='+data.guid+'" style="display: inline;">' +
                        '<i class="glyphicon glyphicon-zoom-in"></i>查看</a>';
                    uploadInfo.siblings('.show_pic').remove();
                    uploadInfo.parent().append(html);
                    uploadInfo.siblings('.fileupload-exists').show();

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

function getInfo(){
    var keyword = $('#keyword').val();
    var period = $('#selected_year').val();
    if(''==$.trim(keyword)){
        common_layer('参数错误');
        return false;
    }
    $.ajax({
        type: 'POST',
        url: '/domain-register/get-price',
        dataType:'json',
        data:{'keyword':keyword,'period':period},
        success: function(json) {
            if(json.info=='ok'){
                $('#year').empty().html(json.data.period);
                $('#money').empty().html(json.data.price);
                $('#audit_price').empty().html(json.data.audit_price);
                $('#total').empty().html(json.data.total_price);
            }else{
                common_layer(json.data);
            }
        },
        error:function(){
            common_layer('系统繁忙，请稍后重试','');
        }
    });
}
//根据不同商标注册类型显示不同年限
function render_years(num){
    var html = '';
    for(var i=1;i<=num;i++) {
        html += '<option value="' + i + '">' + i + '年</option>';
    }
    return html;
}

