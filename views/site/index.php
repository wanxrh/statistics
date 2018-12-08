<?php

?>
<style>
    .red{
        color: red;
    }
    .table th a{ color:#000;text-decoration:none;}
    .table td a{text-decoration:none;}
    .input-small {width: 250px !important;}
    .number_name{ display: block;height:15px;text-align: center;}
    .code { display: block;}
    .span{width: 50px; display: block;float: left;text-align: center}
    .color{ color: #b3b3b3;text-align: center;}
    td{text-align: center}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption cap-head">
                    <i class="icon icon-cog"></i>
                    <a>开奖走势&nbsp;&nbsp;<i class="icon-angle-right"></a></i>
                </div>
                <div class="tools">
                    <a href="javascript:location.reload();"><i class="icon-refresh"></i>刷新</a>&nbsp;&nbsp;
                </div>
            </div>
            <div class="portlet-body form">
                <form class="form-inline" role="form" method="get" action="">
                    <div class="form-body">
                        <div class="form-group">
                            <select  name="period" class="form-control input-small">
                                <option value="">--选择期数--</option>
                                <option value="20" <?php if($period==20):?> selected <?php endif;?>>20</option>
                                <option value="50" <?php if($period==50):?> selected <?php endif;?>>50</option>
                                <option value="100"<?php if($period==100):?> selected <?php endif;?>>100</option>
                                <option value="200"<?php if($period==200):?> selected <?php endif;?>>200</option>
                                <option value="500"<?php if($period==500):?> selected <?php endif;?>>500</option>
                                <option value="1000"<?php if($period==1000):?> selected <?php endif;?>>1000</option>
                                <option value="2000"<?php if($period==2000):?> selected <?php endif;?>>2000</option>
                            </select>
                        </div>
                        <button class="btn blue" type="submit"><i class="icon-search"></i> 查询</button>

                    </div>
                </form>
                <!--<form class="form-inline" role="form" method="get" target="_blank" action="<?php /*echo Yii::$app->urlManager->createUrl('gdList/results');*/?>">
                    <div class="form-body">
                        <div class="form-group">
                            <input type="text" class="form-control" name="number">
                        </div>


                        <button class="btn blue" type="submit"><i class="icon-search"></i> 查询</button>

                    </div>
                </form>-->
            </div>

            <div class="portlet-body">
                <table class="table table-striped table-hover table-bordered table-advance">
                    <thead id="table-head">
                    <tr>
                        <th width="10%" height="5%">期号
                        </th>
                        <th width="15%">开奖时间
                        </th>

                        <th colspan="10">开奖号码
                        </th>
                        <th>
                            是否中奖
                        </th>


                    </tr>
                    </thead>
                    <tbody>
                    <?php if($data) {
                        $count = count($data);
                        $arr = [];
                        ?>
                        <?php foreach($data as $key=>$list) { ?>
                            <tr>
                                <td><?php echo $list['number'];?></td>
                                <td><?php echo $list['time'];?></td>
                                <?php $kj_number = explode(',',$list['data']); ?>
                                <?php foreach($kj_number as $kk=>$val){?>
                                    <?php if(\app\models\Service::Kill_number([$val])){?>
                                    <td width="5%" style="background-color: red;color: #000000"><?php echo $val?></td>
                                    <?php }else{?>
                                        <td width="5%"><?php echo $val?></td>
                                    <?php }?>
                                <?php };?>
                            <?php if(\app\models\Service::Kill_number($kj_number)){?>
                                <td><i class="icon-ok ">√</i></td>
                            <?php }else{?>
                                <td>×</td>
                            <?php }?>
                            </tr>
                        <?php } ?>
                    <?php } else {
                        ?>
                        <tr>

                            <td align="center" colspan="12" class="no_record" style="display: table-cell">无记录</td>
                        </tr>
                    <?php } ?>

                    </tbody>
                </table>
                <div class="pull-right">
                    <?php
                    echo \yii\widgets\LinkPager::widget([
                        'pagination' => $pages,
                        'firstPageLabel'=>'首页',
                        'lastPageLabel'=>'末页'
                    ])
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function () {
        var today = GetDateStr(0);
        if (jQuery().datepicker) {
            $('.date-picker').datepicker({
                autoclose: true,
                isRTL: App.isRTL(),
                format: "yyyy-mm-dd",
                endDate: today
            });
            $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
        }
    });
    function GetDateStr(AddDayCount) {
        var dd = new Date();
        dd.setDate(dd.getDate() + AddDayCount);//获取AddDayCount天后的日期
        var y = dd.getFullYear();
        var m = dd.getMonth() + 1;//获取当前月份的日期
        var d = dd.getDate();
        return y + "-" + m + "-" + d;
    }
</script>



<script type="text/javascript" language="javascript">


</script>