'use strict';

// 全局ajax
function defaultAjax(csrf) {
    $.ajaxSetup({
        data: {
            _csrf: csrf
        }
    });
}

function _photoSwipe() {
}
// _photoSwipe();

function init() {
    var winW = document.documentElement.clientWidth;
    var maxW = 768;
    if (winW <= maxW) {
        document.documentElement.style.fontSize = winW / 7.5 + 'px';
    } else {
        document.documentElement.style.fontSize = maxW / 7.5 + 'px';
    }
}
init();
window.addEventListener('resize', init);

// $('head link').each(function () {
//     var has_v = $(this).attr('href').split("?").length < 2;
//     var _v = '1.0.1';
//     var _url = $(this).attr("href") + '?' + _v;
//     if (has_v) {
//         $(this).attr("href",_url);
//     }
// })

$(function () {
    // var ap = navigator.userAgent.toLowerCase();
    // if (/iphone|ipad|ipod/.test(ap)) {
            $('input:text,input[type="number"],input[type="tel"],textarea,select').bind('focus', function () {
                $(".menu").css({display: "none"});
            });
            
            $('input:text,input[type="number"],input[type="tel"],textarea,select').bind('blur', function () {
                $(".menu").css({display: "flex"});
            });
        // }
})

// 验证方式
// 例子：validate.isPhone('13488888888', '手机格式错误')
var validate = {
    isPhone: function isPhone(val, text) {
        // 手机号码验证
        var _phone = /^(?:13\d|15\d|18\d|17\d)\d{5}(\d{3}|\*{3})$/;
        if (!_phone.test(val)) {
            console.log('isPhone');
            layer.open({
                content: text,
                skin: 'msg',
                time: 3
            });
            return false;
        }
        return true;
    },
    isTel: function isTel(val, text) {
        // 座机号验证
        var _tel = /^((0\d{2,3})-)?(\d{7,8})(-(\d{3,}))?$/;
        if (!_tel.test(val)) {
            console.log('isTel');
            layer.open({
                content: text,
                skin: 'msg',
                time: 3
            });
            return false;
        }
        return true;
    },
    isEmail: function isEmail(val, text) {
        // 邮件验证
        var _reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
        if (!_reg.test(val)) {
            console.log('isEmail');
            layer.open({
                content: text,
                skin: 'msg',
                time: 3
            });
            return false;
        }
        return true;
    },
    isPostcode: function isPostcode(val, text) {
        // 邮政编码验证
        var _postcode = /^[0-9]{6}$/;
        if (!_postcode.test(val)) {
            console.log('isPostcode');
            layer.open({
                content: text,
                skin: 'msg',
                time: 3
            });
            return false;
        }
        return true;
    },
    isIdCard: function isIdCard(val, text) {
        // 身份证验证
        var _idcard = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
        if (!_idcard.test(val)) {
            console.log('isIdCard');
            layer.open({
                content: text,
                skin: 'msg',
                time: 3
            });
            return false;
        }
        return true;
    }
};

function setSelect() {
    // 例：
    // <select class="select-hook"></select>
    if (navigator.userAgent.match(/mobile/i)) {
        $(".select-hook").each(function () {
            var el = $('<span class="selectVal-hook"></span>').text($(this).find('option:selected').text());
            if ($(this).siblings('.selectVal-hook').length > 0) {
                $(this).siblings('.selectVal-hook').text($(this).find('option:selected').text());
            } else {
                $(this).after(el);
            }
        });
        $(".select-hook").on("change", function () {
            $(this).siblings('.selectVal-hook').text($(this).find('option:selected').text());
        });
    } else {
        $(".select-hook").addClass("ispc");
    }
}

function setCheckbox() {
    $(".checkbox-hook").each(function () {
        if ($(this).find(":checked").length) {
            $(this).addClass("active");
        }
    });
    $(".checkbox-hook").on("change", function () {
        if ($(this).find(":checked").length) {
            $(this).addClass("active");
        } else {
            $(this).removeClass("active");
        }
    });
}

function isVal() {
    // 例：
    // <div class="line-hook">
    //      <div class="line-left-hook"></div>
    //      <input class="line-right-hook">
    // </div>
    var returnVal;
    $(".line-hook .line-right-hook").each(function () {
        if (!!$(this).val() == '') {
            console.log('isVal', $(this).hasClass("select-hook"));
            if ($(this).hasClass("select-hook")) {
                console.log("has");
            }
            var titleText = $(this).parents('.line-hook').find('.line-left-hook').text();
            var test = $(this).parents('.line-hook');
            returnVal = false;
            layer.open({
                content: $.trim(titleText) + '不能为空',
                skin: 'msg',
                time: 3
            });
            return false;
        } else {
            returnVal = true;
        }
    });
    return returnVal;
}

// 全局菜单组件
Vue.component("menu-com", {
    template: '<div class="menu">\n            <a :class="{active:active == 0}" href="/site/index" class="menu-item menu-home">\n                <i class="item-icon">\n                </i>\n                <span class="item-text">\u9996\u9875</span>\n            </a>\n            <a :class="{active:active == 1}" href="/service/index" class="menu-item menu-service">\n                <i class="item-icon">\n                </i>\n                <span class="item-text">\u5BA2\u670D</span>\n            </a>\n            <a :class="{active:active == 2}" href="/cart/index" class="menu-item menu-shop">\n                <i class="item-icon">\n                </i>\n                <i class="numb" v-show="fill">{{fill}}</i>\n                <span class="item-text">\u6CE8\u518C\u5217\u8868</span>\n            </a>\n            <a :class="{active:active == 3}" href="/user/index" class="menu-item menu-user">\n                <i class="item-icon">\n                </i>\n                <i class="numb_my" v-show="numb_my"></i>\n               <span class="item-text">\u6211\u7684</span>\n            </a>\n        </div>',
    data: function data() {
        return {
            fill: 0,
            numb_my:false,
            service_num:0
        
        };
    },
    props: {
        active: Number, //传值0~3，对应的active
        num: null
    },
    created: function created() {
        var _this = this;
        $.ajax({
            type: 'GET',
            url: '/cart/get-count',
            success: function(data){
                var data = JSON.parse(data);
                console.log(data);
                if (data.code !== 1) {
                    _this.fill = 0;
                    _this.numb_my = false;
                    _this.service_num = 0;
                    
                } else{
                    _this.fill = parseInt(data.count);
                    _this.service_num = parseInt(data.service_count);
                    if(data.my_count<1){
                        console.log(data.my_count)
                        _this.numb_my = false;
                    }else{
                        _this.numb_my = true;
                    }
                }
            },
            error:function(err){
                _this.fill = 0;
                _this.service_num = 0;
            }
        });
        
    },
   
    methods: {
        // 加入注册列表购物车+1
        numAdd:function numAdd() {
            var _this=this;
            _this.fill++
        }
    }
});

// 全局搜索组件
Vue.component("search-com", {
    template: '<div class="searchHead">\n            <div class="head-main">\n                <i class="webIcon-search">\n                    <img src="/images/index/icon_search.png" alt="">\n                </i>\n                <div class="main-content">\n                    <input class="searchText" type="text" name="" v-model="searchText" placeholder="\u641C\u7D22\u6216\u8F93\u5165\u7F51\u7AD9\u540D\u79F0">\n                </div>\n                <i class="webIcon-refresh">\n                    <img src="/images/index/icon_refresh.png" alt="">\n                </i>\n            </div>\n        </div>',
    data: function data() {
        return {
            searchText: ''
        };
    }
});

// 全局标题组件
Vue.component("navber-com", {
    template: '<div class="navber">\n            <div class="navber-left" @click="goBack">\n                <img src="/images/icon_back.png">\n            </div>\n            <div class="navber-center">{{title}}</div>\n            <div class="navber-right">\n            </div>\n        </div>',
    props: {
        title: '', // 标题内容
        gobackurl: '' // 返回的连接
    },
    methods: {
        goBack: function goBack() {
            if (this.gobackurl) {
                window.location.href = this.gobackurl;
            } else {
                history.go(-1);
            }
        }
    }
});

// 全局图片查看组件
/*Vue.component("photo-swipe", {
    template: `<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="pswp__bg"></div>
        <div class="pswp__scroll-wrap">
            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>
            <div class="pswp__ui pswp__ui--hidden">
                <div class="pswp__top-bar">
                    <div class="pswp__counter"></div>
                    <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                    <button class="pswp__button pswp__button--share" title="Share"></button>
                    <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                    <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                    <div class="pswp__preloader">
                        <div class="pswp__preloader__icn">
                          <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div> 
                </div>
                <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                </button>
                <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                </button>
                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>
            </div>
        </div>
    </div>`,
    methods: {}
});*/