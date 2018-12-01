<?php
/**
 *
 */
$this->title = '域名统计系统';
use app\components\Ext_IdnaConvert;
?>
<link rel="stylesheet" href="/css/apple_num.css" />
<link href="/js/need/layer.css?2.0" type="text/css" rel="styleSheet" id="layermcss">

<div id="apply_num" class="containerView condition">
    <div class="containerView-main main_navber">

        <div class="apply_num-main">
            <div class="main-text">今天解析数量（个）</div>
            <div class="main-num"><?php echo $count;?></div>
            <div class="recharge" @click="recharge_btn">日</div>
        </div>
        <div class="apply_num-list">
            <?php
            if(!empty($data)){
            $punycode = new Ext_IdnaConvert();
            ?>
            <?php foreach($data as $key=>$value){?>
            <div class="apply_num-record" @click="recharge_btn">
                <div class="record-line">
                    <div class="col"><?php echo $key+1?></div>
                    <div class="listTextG line-left">
                        <div class="listTextG-title main-title"><a href="<?php echo Yii::$app->getUrlManager()->createUrl(['/site/conditions','domain'=>$value['domain_name']])?>"><?php echo $punycode->decode($value['domain_name'])?></a> </div>
                    </div>
                    <div class="line-right">
                        <?php echo $value['num']?>                        </div>
                </div>
            </div>
            <?php }?>
            <div class="apply_num-record loadMore">
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
