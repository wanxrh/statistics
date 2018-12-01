<?php
$this->title = '域名统计系统';
?>
<link rel="stylesheet" href="/css/apple_num.css" />
<link href="/js/need/layer.css?2.0" type="text/css" rel="styleSheet" id="layermcss">
<script src="/js/jquery-3.3.1.min.js"></script>
<script src="/js/iscroll4.js"></script>
<script src="/js/iscrollUtils.js"></script>
<div id="apply_num" class="containerView">
    <div class="containerView-main main_navber">

        <div class="apply_num-main">
            <div class="main-text"><span class="dateText-hook">今天</span>续费数量（个）</div>
            <div class="main-num">
                <?php echo $count;?>
            </div>
            <label class="recharge recharge-hook" for="setData">
                <select id="setData" name="date">
                    <option value="今天" <?php echo !empty($date)&&$date=='今天'?'selected="selected"':''?>>日</option>
                    <option value="本周"<?php echo !empty($date)&&$date=='本周'?'selected="selected"':''?>>周</option>
                    <option value="本月"<?php echo !empty($date)&&$date=='本月'?'selected="selected"':''?>>月</option>
                    <option value="半年"<?php echo !empty($date)&&$date=='半年'?'selected="selected"':''?>>半年</option>
                    <option value="一年"<?php echo !empty($date)&&$date=='一年'?'selected="selected"':''?>>一年</option>
                </select>
            </label>
        </div>
        <div class="wrapperBox">
            <div id="wrapper" style="overflow:hidden;">
                <div class="apply_num-list scroller">
                    <div class="apply_box">
                        <?php foreach($data as $key=>$value){?>
                            <div class="apply_num-record">
                                <div class="record-line">
                                    <div class="col">
                                        <?php echo date("H:i",strtotime($value['created']))?>
                                    </div>
                                    <a href="<?php echo Yii::$app->getUrlManager()->createUrl(['/site/trademark-list','domain'=>$value['domain_name']])?>" @click="router">
                                        <div class="listTextG line-left">
                                            <div class="listTextG-title main-title">
                                                <?php echo $value['domain_name']?> </div>
                                            <div class="listTextG-text">
                                                <?php echo $value['company']?>
                                            </div>
                                        </div>
                                    </a>

                                </div>
                            </div>
                        <?php }?>
                    </div>
                    <div class="apply_num-record loadMore loadMore-hook">
                        <div class="record-line">
                            <div class="col">
                                <img src="/images/apply_num/loading.png">
                            </div>
                            <div class="listTextG line-left">
                                <div class="listTextG-title main-title">上拉加载</div>
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
        var page_num = <?php echo $page_num?>;
        // var page_num = 5;
        var scrollStatu = 0;

        isPage();
        setDate();

        // 日期选择
        function setDate() {
            var recharge = $('.recharge-hook select');
            if(recharge.val() == '半年' || recharge.val() == '一年'){
                recharge.addClass('paddingR')
            }else {
                recharge.removeClass('paddingR')
            }
            $('.dateText-hook').text(recharge.val());

            recharge.on('change', function () {
                $('.dateText-hook').text(recharge.val());

                window.location.href = "/site/renew/?date=" + recharge.val();
                if(recharge.val() == '半年' || recharge.val() == '一年'){
                    recharge.addClass('paddingR')
                }else {
                    recharge.removeClass('paddingR')
                }
            })
        }
        document.addEventListener('touchmove', bodyScroll, isPassive() ? {
            capture: false,
            passive: false
        } : false);

        if (page_num) {
            var myscroll = new iScroll("wrapper", {
                onScrollMove: function () {
                    if($('.loadMore-hook .main-title').text() != '加载中'){
                        if (this.y < (this.maxScrollY) && page != page_num) {
                            status = 1;
                            $('.apply_num-main').addClass('ani');
                            $('.wrapperBox').addClass('wrapperAni');
                            $('.loadMore-hook .main-title').text('释放加载');

                        } else if(page != page_num){
                            $('.loadMore-hook .main-title').text('上拉加载');
                        }
                    }
                },
                onScrollEnd: function () {
                    if (status == 1 && page+1<=page_num) {
                        if(scrollStatu == 0){
                            page++;
                            pullUpAction();
                        }
                        $('.loadMore-hook .main-title').text('加载中');
                        scrollStatu = 1;
                        status = 0;
                    } else if(status == 1 && page_num == 1){
                        myscroll.refresh();
                    }
                },
                onRefresh:function(){
                    if(page != page_num){
                        $('.loadMore-hook .main-title').text('上拉加载');
                    }
                }
            });
        }
        function isPage() {
            if(page == page_num){
                $('.loadMore-hook .main-title').text('已到底部');
                $('.loadMore-hook .listTextG').removeClass('line-left');
                $('.loadMore-hook .col').hide();
            }
        };
        function pullUpAction() {
            $.ajax({
                url: '/site/renew/?page=' + page+'&date=<?php echo $date?>',
                type: 'get',
                success: function success(data) {
                    scrollStatu = 0;
                    $('#wrapper .apply_box').append(data);
                    isPage();
                    myscroll.refresh();
                },
                error: function () {
                    $('.loadMore-hook .main-title').text('上拉加载');
                },
            })
        }
        if ($('.scroller').height() < $('#wrapper').height()) {
            $('.loadMore').hide();
            page_num ? myscroll.destroy() : '';
        }
        function bodyScroll(event) {
            event.preventDefault();
        }
    })


    var app = new Vue({
        el: '#apply_num',
        data: {
            scrollShade3: null,

        },
        created: function created() {
            this.init();
        },

        methods: {
            init: function init() {},
            router: function router() {
                localStorage.index = window.location.href;
            }
        }
    });
</script>