<?php
/**
 *
 */
$this->title = '域名统计系统';
?>
<link rel="stylesheet" type="text/css" href="/css/dns_list.css">
<div id="contract-admin" class="containerView">
    <!-- <navber-com title="下载和保存合同" gobackurl="/contracts/index"></navber-com> -->
    <form role="form" method="get" id="saveform" href="/site/conditions">
    <div class="navber navberNB">
        <div class="navber-left" @click="goBack">
            <img src="/images/goback.png">
        </div>

            <div class="navber-center searchT">
                <input type="text" placeholder="请输入" name="domain" class="searchInput" value="<?php echo $domain?>">
                <div class="searchBtn">
                    <img src="/images/search.png" alt="" class="searchImg">
                    <p class="searchTxt">搜索</p>
                </div>
            </div>


        <!-- <div class="navber-right"></div> -->
    </div>
    </form>
    <div class="containerView-main main_navber">
        <div class="contract-admin-main">
            <div class="domain-inform">
                <p class="nearly">近半年的解析明细</p>
                <p class="domain-i"><a href="<?php echo Yii::$app->getUrlManager()->createUrl(['/site/trademark-detail','domain'=>$domain])?>">域名信息</a> </p>
            </div>
            <div class="detail-box">
                <?php foreach($data as $key=>$value){?>
                <div class="mouth-detail">
                    <div class="detail">
                        <p><?php echo $value['month']?>月：</p>
                        <p class="detail-num"><?php echo $value['total']?></p>
                    </div>
                    <div class="grayBar">
                        <div class="orangeBar" style="width: <?php echo ($value['total']/intval($count_parsing))*100?>%"></div>
                    </div>
                </div>
                <?php }?>

            </div>
        </div>
    </div>
    <!-- <menu-com :active="3" :num="0"></menu-com> -->

</div>
<script src="/js/common.js"></script>
<script type="text/javascript">
    'use strict';
    var _csrf = "<?php echo Yii::$app->request->csrfToken; ?>";
    var app = new Vue({
        el: '#contract-admin',
        data: {},
        created: function created() {
            this.init()
        },
        methods: {
            init: function init() {
                // console.log(localStorage.operation)
            },
            goBack: function goBack() {
                
                if(localStorage.operation == ''){
                    location.href = "/site/operation";
                } else {
                    location.href = localStorage.operation;
                }
            }
        }
    });
    $(".searchTxt").click(function(){
        $("#saveform").submit();
    });
</script>