<?php
/**
 *
 */
$domain_register_state=[

    'Reserved by Registry'=>'域名已被注册局预留',
    'The domain you request is prohibited'=>'域名已被注册局预留',
    'Name Collision Reservation From ICANN'=>'ICANN规则限制注册'
];
$this->title = '域名统计系统';
?>
<link rel="stylesheet" type="text/css" href="/css/trademark_info.css">
<div id="contract-info" class="containerView" style="background: none;">
    <div class="navber navberNB">
        <div class="navber-left" @click="goBack">
            <img src="/images/goback.png">
        </div>
        <div class="navber-center">注册明细</div>
        <div class="navber-right"></div>
    </div>
    <div class="containerView-main main_navber">

        <form action="/contracts/add-cons-pinfo" id="applyCont" method="post">
            <div class="contract-info-main">
                <div class="invoice-details">

                    <?php if(isset($domaininfo) &&isset($domaininfo[2]['last'])){ ?>
                    <ul>
                        <?php foreach($domaininfo as $key=>$value){?>
                        <?php if(isset($value['chs']) && $value['chs'] == '创建日期'){?>
                        <div class="titleG input">
                            <div class="titleG-left">创建日期</div>
                            <div class="titleG-right">
                                <!-- <input type="text" placeholder="请输入创建日期"/> -->
                                <p>2014-10-04T12:46:40Z</p>
                            </div>
                        </div>
                        <?php }?>
                        <?php }?>
                        <?php foreach($domaininfo as $key=>$value){?>
                        <?php if(isset($value['chs']) && $value['chs'] == '到期日期'){?>
                        <div class="titleG input">
                            <div class="titleG-left">到期日期</div>
                            <div class="titleG-right">
                                <p><?php echo $value['value']?></p>

                            </div>
                        </div>
                        <?php }?>
                        <?php }?>
                        <?php foreach($domaininfo as $key=>$value){?>
                        <?php if(isset($value['chs']) && $value['chs'] == '所属注册服务商'){?>
                        <div class="titleG input">
                            <div class="titleG-left">所属注册服务商</div>
                            <div class="titleG-right">
                                <!-- <input type="text" placeholder="请输入创建日期"/> -->
                                <p><?php echo $value['value']?></p>

                            </div>
                        </div>
                        <?php }?>
                        <?php }?>
                        <?php foreach($domaininfo as $key=>$value){?>
                        <?php if(isset($value['chs']) && $value['chs'] == '域名注册组织单位名称'){?>
                        <div class="titleG input">
                            <div class="titleG-left">注册组织单位名称</div>
                            <div class="titleG-right">
                                <!-- <input type="text" placeholder="请输入创建日期"/> -->
                                <p><?php echo $value['value']?></p>

                            </div>
                        </div>
                        <?php }?>
                        <?php }?>
                        <?php /*foreach($domaininfo as $key=>$value){*/?><!--
                        <?php /*if(isset($value['chs']) && $value['chs'] == '域名注册人邮箱'){*/?>
                        <div class="titleG input">
                            <div class="titleG-left">注册人邮箱</div>
                            <div class="titleG-right">
                                <p><?php /*echo $value['value']*/?></p>

                            </div>
                        </div>
                        <?php /*}*/?>
                        --><?php /*}*/?>

                    </ul>
                    <?php }else{?>
                        <div class="titleG input">
                            <div class="">
                                <p>获取信息失败</p>
                            </div>
                        </div>
                    <?php }?>
                </div>
            </div>
        </form>
    </div>

</div>
<script src="/js/common.js"></script>
<script type="text/javascript">


    var app = new Vue({
        el: '#contract-info',
        data: {
//
        },
        created: function created() {

        },
        methods: {
            init: function init() {

            },
            goBack: function goBack() {
                location.href = "/site/conditions?domain=<?php echo $domain?>";

            }

        },

    })
</script>