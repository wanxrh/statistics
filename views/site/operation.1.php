<?php
/**
 *
 */
$this->title = '域名统计系统';
use app\components\Ext_IdnaConvert;
?>
<link rel="stylesheet" href="/css/apple_num.css" />
<link href="/js/need/layer.css?2.0" type="text/css" rel="styleSheet" id="layermcss">
<script src="/js/jquery-3.3.1.min.js"></script>
<script src="/js/iscroll4.js"></script>
<div id="apply_num" class="containerView condition">
    <div class="containerView-main main_navber">

        <div class="apply_num-main">
            <div class="main-text">今天解析数量（个）</div>
            <div class="main-num"><?php echo $count;?></div>
            <div class="recharge" @click="recharge_btn">日</div>
        </div>
        <div class="wrapperBox wrapperNb">  
            <div id="wrapper" >
                <div class="apply_num-list scrollers">
                    <div class="apply_box">
                        <?php
                        if(!empty($data)){
                        $punycode = new Ext_IdnaConvert();
                        ?>
                        <?php foreach($data as $key=>$value){?>
                            <?php if($key<=2){?>
                                <div class="apply_num-record" @click="recharge_btn">
                                    <div class="record-line">
                                        <div class="col"><?php echo $key+1?></div>
                                        <div class="listTextG line-left">
                                            <div class="listTextG-title main-title"><a href="<?php echo Yii::$app->getUrlManager()->createUrl(['/site/conditions','domain'=>$value['domain_name']])?>"><?php echo $punycode->decode($value['domain_name'])?></a> </div>
                                        </div>
                                        <div class="line-right">
                                            <?php echo $value['num']?>
                                        </div>
                                    </div>
                                </div>
                                <?php }else{?>
                                <div>
                                    <div class="apply_num-record" @click="recharge_btn">
                                        <div class="record-line">
                                            <div class="col"><?php echo $key+1?></div>
                                            <div class="listTextG line-left">
                                                <div class="listTextG-title main-title"><a href="<?php echo Yii::$app->getUrlManager()->createUrl(['/site/conditions','domain'=>$value['domain_name']])?>"><?php echo $punycode->decode($value['domain_name'])?></a> </div>
                                            </div>
                                            <div class="line-right">
                                                <?php echo $value['num']?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                           <?php }?>
                        <?php }?>
                    </div>
                    <div class="loadMore">
                        <div class="record-line">
                            <div class="col">
                                <img src="/images/apply_num/loading.png">
                            </div>
                            <div class="listTextG line-left">
                                <div class="listTextG-title main-title">加载更多</div>
                            </div>
    
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php }?>
        <div class="apply_num-btn">
            <a href="<?php echo Yii::$app->request->getHostInfo();?>" class="btnMain">
                注册数量
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
        var page_num = <?php echo $page_num;?>;
        var myscroll = new iScroll("wrapper", {
            onScrollMove: function () {
                console.log(1212)
                if (this.y < (this.maxScrollY)) {
                    status = 1;
                } 
                if(page == page_num){
                    $('.loadMore-hook .main-title').text('已到底部');
                    $('.loadMore-hook .listTextG').removeClass('line-left');
                    $('.loadMore-hook .col').hide();
                }
            },
            onScrollEnd: function () {
                if (status == 1 && page+1<=page_num) {
                    page++;
                    pullUpAction();
                    status = 0;
                }
            },
            
        });
        
        function pullUpAction() {
            $.ajax({
                url: '?page=' + page,
                type: 'get',
                success: function success(data) {
                    // 请求成功，
                    $('#wrapper .apply_box').append(data);
                    myscroll.refresh();
                },
                error: function () {
                    console.log('error');
                },
            })

        }
        if ($('.scrollers').height() < $('#wrapper').height()) {
            $('.loadMore').hide();
            myscroll.destroy();
        }
        
    })
    var app = new Vue({
        el: '#apply_num',
        data: {},
        created: function created() {
            this.init();
        },

        methods: {
            init: function init() {
            },
            recharge_btn:function recharge_btn(){
                window.location.href="dns_list.html";
            }
        }
    });
</script>
