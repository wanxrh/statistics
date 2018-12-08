$(function(){
	var memberAddbtn = true;
	$('#myform input').keypress(function (e) {
        if (e.which == 13) {
        		if (!memberAddbtn){
        			layer.msg('正在处理，请稍等...');
        			return;
        		}
            form_submit();
        }
    })
    $('#saveform').click(function(){
    		if (!memberAddbtn){
    			layer.msg('正在处理，请稍等...');
    			return;
    		}
        form_submit();
    });

    // 删除附件
    $('#attachment').on('click','.label-danger',function(e){
        $(this).closest('.hidden_value').remove();
        var t = $('#attachment').html();
        t = t.replace(/[\r\n]/g,"").replace(/[ ]/g,"");
        if(t == ''){
            $('#attachment').closest('.form-group').hide();
        }
    });
})
function form_submit(){
	memberAddbtn = false;
    var company_name = $("#company_name").val();
    if (company_name=='') {
    		common_layer('请输入企业名称');
    		$("#company_name").focus();
    		memberAddbtn = true;
    		return;
    }

    var user_level = $("#user_level").val();
    if (user_level=='') {
    		common_layer('请选择会员类别');
    		$("#user_level").focus();
    		memberAddbtn = true;
    		return;
    }

    var company_category = $("#company_category").val();
    if (company_category=='') {
    		common_layer('请选择企业性质');
    		$("#company_category").focus();
    		memberAddbtn = true;
    		return;
    }

    var s_county = $("#s_county").val();
    if (s_county=='市、县级市') {
    		common_layer('请选择地区信息');
    		$("#s_county").focus();
    		memberAddbtn = true;
    		return;
    }

    var address = $("#address").val();
    if (address=='') {
    		common_layer('请输入街道地址');
    		$("#address").focus();
    		memberAddbtn = true;
    		return;
    }

    var legal_person = $("#legal_person").val();
    if (legal_person=='') {
    		common_layer('请输入法定代表人');
    		$("#legal_person").focus();
    		memberAddbtn = true;
    		return;
    }

    var company_founding_date = $("#company_founding_date").val();
    if (company_founding_date=='') {
    		common_layer('请输入成立时间');
    		$("#company_founding_date").focus();
    		memberAddbtn = true;
    		return;
    }

    var postcode = $("#postcode").val();
    if (postcode=='') {
    		common_layer('请输入邮政编码');
    		$("#postcode").focus();
    		memberAddbtn = true;
    		return;
    }

    var director_name = $("#director_name").val();
    if (director_name=='') {
    		common_layer('请输入部门负责人');
    		$("#director_name").focus();
    		memberAddbtn = true;
    		return;
    }

    var director_phone = $("#director_phone").val();
    if (director_phone=='') {
    		common_layer('请输入负责人联系电话');
    		$("#director_phone").focus();
    		memberAddbtn = true;
    		return;
    }

    var director_email = $("#director_email").val();
    if (director_email=='') {
    		common_layer('请输入负责人电子邮箱');
    		$("#director_email").focus();
    		memberAddbtn = true;
    		return;
    }

    var contact_name = $("#contact_name").val();
    if (contact_name=='') {
    		common_layer('请输入联系人');
    		$("#contact_name").focus();
    		memberAddbtn = true;
    		return;
    }

    var contact_phone = $("#contact_phone").val();
    if (contact_phone=='') {
    		common_layer('请输入联系人电话');
    		$("#contact_phone").focus();
    		memberAddbtn = true;
    		return;
    }

    var contact_email = $("#contact_email").val();
    if (contact_email=='') {
    		common_layer('请输入联系人电子邮箱');
    		$("#contact_email").focus();
    		memberAddbtn = true;
    		return;
    }

    var contact_cellphone = $("#contact_cellphone").val();
    if (contact_cellphone=='') {
    		common_layer('请输入联系人手机');
    		$("#contact_cellphone").focus();
    		memberAddbtn = true;
    		return;
    }

    /*var fax = $("#fax").val();
    if (fax=='') {
    		common_layer('请输入传真');
    		$("#fax").focus();
    		memberAddbtn = true;
    		return;
    }

    var employees_number = $("#employees_number").val();
    if (employees_number=='') {
    		common_layer('请输入员工人数');
    		$("#employees_number").focus();
    		memberAddbtn = true;
    		return;
    }
    var contact_qq = $("#contact_qq").val();
    if (contact_qq=='') {
    		common_layer('请输入联系人QQ');
    		$("#contact_qq").focus();
    		memberAddbtn = true;
    		return;
    }

    var website = $("#website").val();
    if (website=='') {
    		common_layer('请输入官网网址');
    		$("#website").focus();
    		memberAddbtn = true;
    		return;
    }

    var wechat = $("#wechat").val();
    if (wechat=='') {
    		common_layer('请输入企业微信');
    		$("#wechat").focus();
    		memberAddbtn = true;
    		return;
    }

    var weibo = $("#weibo").val();
    if (weibo=='') {
    		common_layer('请输入企业微博');
    		$("#weibo").focus();
    		memberAddbtn = true;
    		return;
    }*/

    var application_membership = $("#application_membership").val();
    if (application_membership=='') {
    		common_layer('请输入入会申请');
    		$("#application_membership").focus();
    		memberAddbtn = true;
    		return;
    }

    var company_describe = $("#company_describe").val();
    if (company_describe=='') {
    		common_layer('请输入企业简介');
    		$("#company_describe").focus();
    		memberAddbtn = true;
    		return;
    }

    /*var domain_name1 = $("#domain_name1").val();
    if (domain_name1=='') {
    		common_layer('请输入注册商标');
    		$("#domain_name1").focus();
    		memberAddbtn = true;
    		return;
    }

    var domain_number1 = $("#domain_number1").val();
    if (domain_number1=='') {
    		common_layer('请输入商标注册号');
    		$("#domain_number1").focus();
    		memberAddbtn = true;
    		return;
    }

    var domain_registration_date1 = $("#domain_registration_date1").val();
    if (domain_registration_date1=='') {
    		common_layer('请输入商标注册日期');
    		$("#domain_registration_date1").focus();
    		memberAddbtn = true;
    		return;
    }

    var domain_category1 = $("#domain_category1").val();
    if (domain_category1=='') {
    		common_layer('请输入商标注册类别');
    		$("#domain_category1").focus();
    		memberAddbtn = true;
    		return;
    }

    var domain_register1 = $("#domain_register1").val();
    if (domain_register1=='') {
    		common_layer('请输入商标注册人名义');
    		$("#domain_register1").focus();
    		memberAddbtn = true;
    		return;
    }*/
    // var load = layer.load('正在提交，请稍后...');
    $.ajax({
        type: 'POST',
        url: '/member/mcreate',
        data: $('#myform').serialize(),
        dataType:'json',
        success: function (r) {
        		memberAddbtn = true;
        		// layer.close(load);
            if('err'==r.info){
                common_layer(r.data,'');
            }else{
                common_layer(r.data,'/member/mlist');
                //window.location.href="/member/mlist"
            }
        },
        error: function () {
        		memberAddbtn = true;
        		// layer.close(load);
            common_layer('添加失败','');
        }
    });
}

//上传附件
function ajaxFileUpload(obj) {
    var fileName = $(obj).attr('id');
    var uploadInfo = $(obj).parent();
    var file = $(obj).val();
    var fileType = file.substring(file.lastIndexOf(".")+1);
    fileType = fileType.toLowerCase();
    var allows = ['png','jpg','jpeg','bmp','zip','doc','docx','pdf','xls','xlsx','rar'];
    if($.inArray(fileType,allows)==-1){
        common_layer('上传文件格式不允许','');
        return;
    }
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
                'file_name': fileName,
                'type':'bmp,jpeg,jpg,png,pdf,zip,rar,doc,docx,xls,xlsx',
                'minsize':5
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