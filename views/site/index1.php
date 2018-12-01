<?php
$this->title = '域名统计系统';
?>
<link rel="stylesheet" href="/css/apple_num.css" />
<link href="/js/need/layer.css?2.0" type="text/css" rel="styleSheet" id="layermcss">
<script src="/js/jquery-3.3.1.min.js"></script>
<script src="/js/iscroll4.js"></script>
<!-- <script src="/js/iscrollUtils.js"></script> -->
<div id="apply_num" class="containerView">
    <div class="containerView-main main_navber">

        <div class="apply_num-main">
            <div class="main-text">今天注册数量（个）</div>
            <div class="main-num">
                <?php echo $count;?>
            </div>
            <div class="recharge">日</div>
        </div>
        <div class="wrapperBox">
            <div id="wrapper">
                <div class="apply_num-list scroller">
                    <div class="apply_box">
                        <?php foreach($data as $key=>$value){?>
                        <div class="apply_num-record">
                            <div class="record-line">
                                <div class="col">
                                    <?php echo date("H:i",strtotime($value['cre_date']))?>
                                </div>
                                <div class="listTextG line-left">
                                    <div class="listTextG-title main-title"><a href="<?php echo Yii::$app->getUrlManager()->createUrl(['/site/trademark-list','domain'=>$value['domain_name']])?>">
                                            <?php echo $value['domain_name']?></a> </div>
                                    <div class="listTextG-text">
                                        <?php echo $value['company']?>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <?php }?>
                    </div>
                    <div class="apply_num-record loadMore">
                        <div class="record-line">
                            <div class="col">
                                <img src="/images/apply_num/loading.png">
                            </div>
                            <div class="listTextG line-left">
                                <div class="listTextG-title main-title ">加载更多...</div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="apply_num-btn">
            <a href="/site/operation" class="btnMain">
                运营情况
            </a>
        </div>
    </div>

</div>
<script src="/js/common.js"></script>
<script type="text/javascript">
    'use strict';
    $(window).ready(function () {
        var page = 1;
        var status = 0;
        var myscroll = new iScroll("wrapper", {
            onScrollMove: function () {
                console.log(1212)
                if (this.y < (this.maxScrollY)) {
                    status = 1;
                } else {
                    $('.loadMore .main-title').text('加载更多...')
                }
            },
            onScrollEnd: function () {
                if (status == 1) {
                    page++;
                    pullUpAction();
                    status = 0;
                }
            },
            onRefresh: function () {
                $('.loadMore .main-title').text('加载更多...');
            }
        });

        function pullUpAction() {
            $.ajax({
                url: '?page=' + page,
                type: 'get',
                success: function success(data) {
                    $('#wrapper .apply_box').append(data);
                    myscroll.refresh();
                },
                error: function () {
                    console.log('error');
                },
            })
        }
        if ($('.scroller').height() < $('#wrapper').height()) {
            $('.loadMore').hide();
            myscroll.destroy();
        }
    })

    function bodyScroll(event) {
        event.preventDefault();
    }
    var app = new Vue({
        el: '#apply_num',
        data: {
            scrollShade3: null,

        },
        created: function created() {
            this.init();
            // this.invoice_Scroll();
            // this.invScroll();
        },

        methods: {
            init: function init() {},
            // invoice_Scroll: function invoice_Scroll() {
            //     var _this = this;
            //     setTimeout(function () {
            //         _this.scrollShade3 = new IScroll('#wrapper', {
            //             mouseWheel: true,
            //             click: true,
            //             scrollbars: true
            //         });
            //         _this.scrollShade3.on("scroll", function () {
            //             console.log(123123)
            //             console.log(_this.y, _this.maxScrollY)
            //             if (_this.y < (_this.maxScrollY)) {
            //                 $('.loadMore .main-title').text('释放加载...');
            //             } else {
            //                 $('.loadMore .main-title').text('上拉加载...')
            //             };
            //         })
            //         _this.scrollShade3.on("scrollEnd", function () {
            //             $('.loadMore .main-title').text('正在加载中')

            //             _this.pullUpAction();
            //         });
            //         _this.scrollShade3.on("refresh", function () {
            //             $('.loadMore .main-title').text('上拉加载...')

            //         });

            //     }, 100);
            // },
            // invScroll: function invScroll() {
            //     var _this = this;
            //     this.$nextTick(function () {
            //         setTimeout(function () {
            //             _this.scrollShade3.refresh();
            //         }, 200);
            //     });
            // },
            // pullUpAction: function pullUpAction() {
            //     var _this = this;
            //     setTimeout(function () {
            //         /*$.ajax({
            //         url:'/json/ay.json',
            //         type:'get',
            //         dataType:'json',
            //         success:function(data){
            //         for (var i = 0; i < 5; i++) { 
            //             $('.scroller ul').append(data); } myscroll.refresh(); 
            //         }, error:function(){
            //             console.log('error'); }, 
            //         })*/
            //         for (var i = 0; i < 5; i++) {
            //             $('#wrapper .scroller').append("<li>一只将死之猿!</li>");
            //         }
            //         // myscroll.refresh();
            //         _this.invScroll();
            //         document.removeEventListener('touchmove', bodyScroll, false);

            //     }, 1000)
            // }
        }
    });
</script>