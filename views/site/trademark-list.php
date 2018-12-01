<?php
/**
 *
 */
$this->title = '域名统计系统';
use app\components\Ext_IdnaConvert;
?>
<link rel="stylesheet" type="text/css" href="/css/trademark_list.css">
<div id="contract-dsb" class="containerView">
    <div class="navber navberNB">
        <div class="navber-left" @click="goBack">
            <img src="/images/goback.png">
        </div>
        <div class="navber-center">注册商标列表</div>
        <div class="navber-right"></div>
    </div>
    <div class="containerView-main main_navber">

        <div class="contract-dsb-main">
            <ul class="contract-dsb-table">
                <?php if(!empty($data)){
                    $punycode = new Ext_IdnaConvert();
                    ?>
                    <?php foreach($data as $key=>$val){?>
                    <div class="titleG" @click="nextStep">
                        <div class="cont-time">
                            <p class="times"><?php echo date("H:i",strtotime($val['created_at']))?></p>
                        </div>
                        <div class="con_comRight">
                            <div class="contract-company">
                                <p class="main-title">
                                    <?php echo $punycode->decode($val['domain_name'])?>
                                </p>
                                <p class="company-name "><?php echo $company?></p>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                <?php }else{?>
                    <div class="titleG input">
                        暂无数据！
                    </div>
                <?php }?>

            </ul>
        </div>
    </div>
</div>
<script src="/js/common.js"></script>
<script type="text/javascript">
    'use strict';

    var app = new Vue({
        el: '#contract-dsb',
        data: {

        },
        created: function created() {
            this.init()
        },

        methods: {
            init: function init() {
                // console.log(localStorage.index)
            },
            nextStep: function nextStep() {
               if(localStorage.index == ''){
                    location.href = "/site/index";
                } else {
                    location.href = localStorage.index;
                }
            },
            goBack: function goBack() {
                if(localStorage.index == ''){
                    location.href = "/site/index";
                } else {
                    // console.log(localStorage.index)
                    location.href = localStorage.index;
                }

            }
        }
    });
</script>