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
        $("#product3,#product4").html("<option value=''>请选择</option>");
        var id = $(this).val();
        $("#product2").load('/business/product?id='+id+'&level_id=2');
    });
    //当第二个产品变化是执行下面的方法
    $("#product2").on("change",function(){
        $("#product3,#product4").html("<option value=''>请选择</option>");
        var id = $(this).val();
        $("#product3").load('/business/product?id='+id+'&level_id=3');
    });
    //当第三个产品变化是执行下面的方法
    $("#product3").on("change",function(){
        $("#product4").html("<option value=''>请选择</option>");
        var id = $(this).val();
        $("#product4").load('/business/product?id='+id+'&level_id=4');
    });

    sumPrice();
});

function cancelBtn(){
    $("#productShow").hide();
}

/**
 * 图形和组合商标只能选择一个
 * 选择图形，商标中文的值为图形且只读，英文或其他同时变成只读，并把二者之前的内容清空
 * 选择组合商标，商标中文和英文或其他可写，并把二者之前的内容清空
 * @param obj
 */
function getgraph(obj){
    if(obj.closest('span').className!=='checked'){
        if($(obj).val()=="图形"){
            $("#chinese_shangbiao").val("图形");
            $("#chinese_shangbiao").attr("readonly","readonly");
            $("#english_other").attr("readonly","readonly");
            $("#product_combine").attr("disabled","disabled");
        }
        if($(obj).val()=="组合商标"){
            $("#product_graph").attr("disabled","disabled");
        }
    }else{
        $("#product_combine").removeAttr("disabled");
        $("#product_graph").removeAttr("disabled");
        $("#chinese_shangbiao").val("");
        $("#english_other").val("");
        $("#chinese_shangbiao").removeAttr("readonly");
        $("#english_other").removeAttr("readonly");
    }
}

//是否是二维码，如果是显示二维码名称
function isErweima(obj){
    if(obj.closest('span').className!=='checked'){
        $("#erewima_name").show();
    }else{
        $("#erewima_name").hide();
    }
}

//移除产品，虚拟删除
function delProduct(obj){
    obj.closest('tr').remove();
    sumPrice();
}

//添加产品，显示form表单
function addProduct(){
    $('#saveData').attr('disabled',true);
    $("#productShow").show();
}

//保存产品信息到下面的table中
var pro_num = 0;
function saveProduct(){
    var bln = true;

    $("#productInfo .must_cls").each(function(index,element){
        if($.trim($(this).val()) == ''){
            layer.alert($(this).attr('alert'));
            $(this).focus();
            bln = false;
            return false;
        }
    })

    if(!bln)return false;
    /**
     * 申请项目列名
     * 以下是添加项目到一个隐藏的html中，在提交后真实的保存到数据库中
     */
    var product4 = $("#product4").find("option:selected");
    var product_content = product4.text();//产品内容
    var productName =$("#product2").find("option:selected").text();//产品名称
    var product_id = $("#product_id").val();//产品product表中的id
    var modelcode = $("#modelcode").val();//modelcode

    var account_email = $("#productInfo #account_email").length>0?$("#productInfo #account_email").val():'';//账号
    var qrName = $("#productInfo #qrName").length>0?$("#productInfo #qrName").val():'';//二维码名称


    if($("#product2").find("option:selected").text()=="注册类"){
        //注册类
        productName = $("#product3").find("option:selected").text();
    }

    if(product4.attr('modelcode')=="EMAIL"){
        //邮箱类
        product_content = product4.text()+'—'+qrName;
    }

    if(product4.attr('modelcode')=="IP_TWOCODE_D"){
        //品牌二维码
        productName = $("#product2").find("option:selected").text();
        product_content = product4.text()+'—'+qrName;
    }

    //DOMAIN.php
    var user_num = $("#productInfo #user_sum").length>0?$("#productInfo #user_sum").val():'';
    var params = $("#productInfo #params").length>0?$("#productInfo #params").val():'';
    var year_limit = $("#productInfo #year_limit").length>0?$("#productInfo #year_limit").val():'';

    //IP_TWOCODE_D.php
    var only_design = $("#productInfo input[name=only_design]:checked").length>0?$("#productInfo input[name=only_design]:checked").val():'';
    var main_name = $("#productInfo #main_name").length>0?$("#productInfo #main_name").val():'';
    var qredirect = $("#productInfo #qredirect").length>0?$("#productInfo #qredirect").val():'';
    var platform_no = $("#productInfo #platform_no").length>0?$("#productInfo #platform_no").val():'';
    var series_number = $("#productInfo #series_number").length>0?$("#productInfo #series_number").val():'';
    var design_request = $("#productInfo #design_request").length>0?$("#productInfo #design_request").val():'';

    //IP_TWOCODE_F.php
    var amount = $("#productInfo #cost_amount").length>0?$("#productInfo #cost_amount").val():'';

    //LAW_IM.php
    if(product4.attr('modelcode')=="LAW_IM" || product4.attr('modelcode')=="LAW") {
        product_content = $("#productInfo #product_content").length>0?$("#productInfo #product_content").val():'';
    }
    var monitor_domain = $("#productInfo #monitor_domain").length>0?$("#productInfo #monitor_domain").val():'';

    //CC.php
    var registerType = $("#productInfo #registerType").length>0?$("#productInfo #registerType").val():'';
    var cost_keyword = $("#productInfo #cost_keyword").length>0?$("#productInfo #cost_keyword").val():'';

    var product_remark = $("#product_remark").val();//备注
    var category_id = $("#product4").val();//产品类型第四个的id
    var feiyong = $("#feiyong").val();
    var serveMode = $("#serveMode").length>0?$("#serveMode").val():'';

    //TMCH.php
    var register_main_keyword = $("#productInfo #register_main_keyword").length>0?$("#productInfo #register_main_keyword").val():'';
    var register_keyword = $("#productInfo #register_keyword").length>0?$("#productInfo #register_keyword").val():'';
    var domain_web = $("#productInfo #domain_web").length>0?$("#productInfo #domain_web").val():'';
    var shangbiao_name = $("#productInfo #shangbiao_name").length>0?$("#productInfo #shangbiao_name").val():'';
    var shangbiao_type = $("#productInfo #shangbiao_type").length>0?$("#productInfo #shangbiao_type").val():'';
    var register_number = $("#productInfo #register_number").length>0?$("#productInfo #register_number").val():'';
    var shangbiao_holder = $("#productInfo #shangbiao_holder").length>0?$("#productInfo #shangbiao_holder").val():'';
    var shangbiao_place = $("#productInfo #shangbiao_place").length>0?$("#productInfo #shangbiao_place").val():'';
    var deadline = $("#productInfo #deadline").length>0?$("#productInfo #deadline").val():'';

    if(product4.attr('modelcode')=="TMCH"){
        product_content = product4.text()+'—'+shangbiao_name;
    }

    var html_input = '';
    html_input += '<input type="hidden" name="Item['+pro_num+'][productName]" value="'+productName+'" />';
    html_input += '<input type="hidden" name="Item['+pro_num+'][serveMode]" value="'+serveMode+'" />';
    html_input += '<input type="hidden" name="Item['+pro_num+'][product_content]" value="'+product_content+'" />';
    html_input += '<input type="hidden" name="Item['+pro_num+'][product_remark]" value="'+product_remark+'" />';
    html_input += '<input type="hidden" name="Item['+pro_num+'][feiyong]" value="'+feiyong+'" class="feiyong"/>';
    html_input += '<input type="hidden" name="Item['+pro_num+'][category_id]" value="'+category_id+'" />';
    html_input += '<input type="hidden" name="Item['+pro_num+'][product_id]" value="'+product_id+'" />';
    html_input += '<input type="hidden" name="Item['+pro_num+'][modelcode]" value="'+modelcode+'" />';

    var html = '<tr id="product_list_'+pro_num+'">';
    html += '<td>'+productName+'</td>';
    html += '<td>'+serveMode+'</td>';
    html += '<td>'+product_content+'</td>';
    html += '<td>'+year_limit+'/'+amount+'</td>';
    html += '<td>'+feiyong+'</td>';
    html += '<td>'+product_remark+'</td>';
    html += '<td><a class="delete" href="javascript:;" onclick="delProduct(this)" >删除</a>'+html_input+'</td>';
    html += '</tr>';

    if($('#product_list_'+pro_num).length > 0){
        $('#product_list_'+pro_num).after(html);
        $('#product_list_'+pro_num).remove();
    }else{
        $("#productList").append(html);
    }

    pro_num += 1;
    sumPrice();
    $("#productShow").hide();
    return true;
}

function chooseVcompany(VcomType)
{
    if(!VcomType)VcomType = 'A';
    var v = '';
    $('#comName option').each(function(index, element) {
        if($(this).attr('VcomType') == VcomType)
        {
            v = $(this).val();
            $('#comName').val(v);
            changeVcompany();
            return false;
        }
    });
    return false;
}
function sumPrice()
{
    var total = 0;
    $('.feiyong').each(function(index, element) {
        var ms = $(this).val();
        if(ms == '' || isNaN(ms))ms = 0;
        ms = parseFloat(ms);
        total += ms;
    });
    $('#total_money').val(total);
    var daxie = new Array();
    daxie[0] = '零';
    daxie[1] = '壹';
    daxie[2] = '贰';
    daxie[3] = '叁';
    daxie[4] = '肆';
    daxie[5] = '伍';
    daxie[6] = '陆';
    daxie[7] = '柒';
    daxie[8] = '捌';
    daxie[9] = '玖';

    var arr = (total+"").split('.');
    total = arr[0];
    var len = total.length;
    for(i=len;i>0;i--)
    {
        var num = total.substr(0,1);
        total = total.substr(1);
        $('#price'+i).val(daxie[num]);
    }
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
        if($("#tradetype3").val()==''){
            layer.alert("请选择行业类别");return false;
        }
    }
    if($("#productList tr").length<=1){
        layer.alert("请添加产品");return false;
    }

}


//根据产品类型展示不同的产品信息
function getProductTypeSelect(level,classCode){
    var obj = $('#product'+level);
    var id = $(obj).val();

    //产品类型的最后一级
    if(level == 4){
        var modelcode = $(obj).find("option:selected").attr('modelcode');
        if(!modelcode){
            $('#productInfo').html('');
        }else{
            var url = '/business/product-template?id='+id+'&modelcode='+modelcode+'&ref='+Math.random();
            $('#productInfo').html('<img src="/img/ajax-loading.gif"/>').load(url);
        }
    }else {
        $('#productInfo').html('');
    }
}


/**
 * --------end
 */
