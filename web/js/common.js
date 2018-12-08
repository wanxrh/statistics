
var unreadIntval;
var unread_ok = false;
$(function(){
    var notification = $.cookie('notification');
    if (notification > 0) {
        $('#notification_num').text(notification).show();
    }
    _beat_unread_count(5);
    $('.cn_more').click(function(event) {
        var flag = $(this).attr('data-id');
        if (flag=='zhan') {
            $(this).attr('data-id','shou');
            $(this).html('收起&nbsp;<i class="icon-chevron-up"></i>');
            $(this).prev().css('height', 'auto');
        }else if(flag=='shou'){
            $(this).attr('data-id','zhan');
            $(this).html('展开&nbsp;<i class="icon-chevron-down"></i>');
            $(this).prev().css('height', '20px');
        }
    });

    //全选和取消全选
    $('.checkAll').click(function() {
        if (true == this.checked) {
            $(".checkOne").attr('checked', true);
            $('.checkOne').closest('span').addClass('checked');
        }else{
            $(".checkOne").attr('checked', false);
            $('.checkOne').closest('span').removeClass('checked');
        }
    });

});

function _beat_unread_count(time)
{
    //priceIntval = setInterval(function(){
    //    _get_update_notification()
    //}, time*1000);
}

function _get_update_notification()
{
    if (unread_ok == true) return;
    unread_ok = true;
    $.ajax({
        type: 'POST',
        url: '/notification/update',
        data: {},
        dataType:'json',
        success:  function(json){
        		if (json.info != 'ok')
            {
                return false;
            }
            unread_ok = false;
            var data = json.data;
            if (data['num'] > 0) {
            		$('#notification_num').text(data['num']).show();
            }
        }
    });
}
/**长度**/
function getBytesLen(val){
    var len=0;
    for (var i = 0; i < val.length; i++)
    {
        len = len + ((val.charCodeAt(i) >= 0x4e00 && val.charCodeAt(i) <= 0x9fa5) ? 3 : 1);
    }
    return len;
}
/**
 * 通用弹窗
 * @param r
 * @param url
 */
function common_layer(r,url){
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
                location.href= encodeURI(url);
            }
        }

    });
}





//一堆检查字符合法性的JS

function checkFloat(str)
{

  return /^([1-9]\d*|0)(\.\d+)|\d+$/g.test(str);

}

function checkInt(str)

{

  return /^\d+$/g.test(str);

}

function trim(str)

{

  return str.replace(/(^\s*)|(\s*$)/g,"");

}

function Lrim(str)

{

  return str.replace(/(^\s*)/g,"");

}

function Rrim(str)

{

  return str.replace(/(\s*$)/g,"");

}

function checkDate(str)

{

  return /^[1-2]\d{3}-(0[1-9]||1[0-2])-([0-2]\d||3[0-1])$/g.test(str);

}

function checkTime(str)

{

  return /^[1-2]\d{3}-(0[1-9]||1[0-2])-([0-2]\d||3[0-1]) ([0-1][0-9]||2[0-3]):([0-5][0-9]):([0-5][0-9])$/g.test(str);

}

function checkC(str)

{

  return /^[a-zA-Z_]+[a-zA-Z0-9_]*$/g.test(str);

}

function checkPhone(str)

{

  if(!str)return false;

  return /^(([0\+]\d{2,3}-)?(0\d{2,3})-)?(\d{7,8})(-(\d{3,}))?$/.test(str);

}

function checkMobile(str)

{

  if(!str)return false;

  return /^1[3|4|5|8][0-9]\d{4,8}$/.test(str);

}

function checkEmail(str)

{

  if(!str)return false;

  return /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/.test(str);

}


/**
  @Description: 只能输入小数点和数字,需要绑定onKeyup
  @Author:      Dong
  @DateTime:    2015-10-30 13:43:28
 */
function onlyFloat (thisObj) {
  var oldVal = $(thisObj).val();
  var newVal = oldVal.replace(/[^\d.]/g,"");  //清除“数字”和“.”以外的字符
  $(thisObj).val(newVal);
}
