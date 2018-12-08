/**
 * Created by Administrator on 2015/11/7.
 */

/**
 * 添加产品 -------------start
 */

$(function(){
    $(".glyphicon-remove").click(function(){
        $("#productShow").hide();
    });

    //当第一个产品变化是执行下面的方法
    $("#product1").on("change",function(){
        $("#product3,#product4").html("<option value='-1'>请选择</option>");
        var id = $(this).val();
        $("#product2").load('/product/prochk?id='+id+'&level_id=2');
    });
    //当第二个产品变化是执行下面的方法
    $("#product2").on("change",function(){
        $("#product3,#product4").html("<option value='-1'>请选择</option>");
        var id = $(this).val();
        $("#product3").load('/product/prochk?id='+id+'&level_id=3');
    });
    //当第三个产品变化是执行下面的方法
    $("#product3").on("change",function(){
        $("#product4").html("<option value='-1'>请选择</option>");
        var id = $(this).val();
        $("#product4").load('/product/prochk?id='+id+'&level_id=4');

    });

        $("#product4").on("change",function(){
            var id        = $(this).val();
            var typecode  = $(this).find("option:selected").attr('typecode');
            var modelcode = $(this).find("option:selected").attr('modelcode');

            $("#finance_category_id").val(id);
            $("#product_code").val(typecode);
            $("#template").val(modelcode);

            });

});



//添加产品，显示form表单
function addProduct(){
    $('#saveData').attr('disabled',true);
    $("#productShow").show();
}



function checkForm(){
    if($("#username").val()==''){
        layer.alert("请填写委托方");return false;
    }
    if($("#phone").val()==''){
        layer.alert("请填写联系电话");return false;
    }
    if($("#address").val()==''){
        layer.alert("请填写地址");return false;
    }
    if($("#contact_person").val()==''){
        layer.alert("请填写联系人");return false;
    }
    //行业类别为其他或者个人的，后面的选择分类可以为空
    if($("#tradetype1").val()!='1377' && $("#tradetype1").val()!='1378'){
        if($("#tradetype3").val()=='-1'){
            layer.alert("请选择行业类别");return false;
        }
    }
    if($("#productList tr").length<=1){
        layer.alert("请添加产品");return false;
    }

}
function checkFrm(obj)
{
    $('#submit_btn').attr('disabled',true);
    var corp_name = $('#corp_name').val();
    var telephone = $('#telephone').val();
    var corpAddrv = $('#corpAddr').val();
    var contact = $('#contact').val();
    var email = $('#email').val();
    var tradetype_name = '';
    if($('#tradetype1').length > 0 && $('#tradetype1 option:selected').val() != '')tradetype_name = $('#tradetype1 option:selected').text();
    if($('#tradetype2').length > 0 && $('#tradetype2 option:selected').val() != '')tradetype_name += '--'+$('#tradetype2 option:selected').text();
    if($('#tradetype3').length > 0 && $('#tradetype3 option:selected').val() != '')tradetype_name += '--'+$('#tradetype3 option:selected').text();
    $('#tradetype_name').val(tradetype_name);

    if(corp_name == '')
    {
        alert('请填写客户名称');
        $('#corp_name').focus();
        $('#submit_btn').attr('disabled',false);
        return false;
    }
    if(telephone == '')
    {
        alert('请填写联系电话');
        $('#telephone').focus();
        $('#submit_btn').attr('disabled',false);
        return false;
    }
    if(corpAddr == '')
    {
        alert('请填写地址');
        $('#corpAddr').focus();
        $('#submit_btn').attr('disabled',false);
        return false;
    }
    if(contact == '')
    {
        alert('请填写联系人');
        $('#contact').focus();
        $('#submit_btn').attr('disabled',false);
        return false;
    }

    //注销录入合同时企业邮箱的必填项，但是在编辑合同时企业邮箱为必填项  20150923 by weijunying
    if($("#vid").val()!='' && !checkEmail(email))
    {
        alert('企业邮箱格式不正确');
        $('#email').focus();
        $('#submit_btn').attr('disabled',false);
        return false;
    }
    if(tradetype_name == '')
    {
        alert('请选择行业类型');
        $('#tradetype1').focus();
        $('#submit_btn').attr('disabled',false);
        return false;
    }
    return true;
}

function getProductTypeSelect(level,classCode){

    var obj = $('#product'+level);
    var id = $(obj).val();
}


