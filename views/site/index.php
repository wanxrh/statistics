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
    th{text-align: center}
    .container{width: 80%}
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
                        <th>前三和值</th>
                        <th>杀060723252627和值</th>
                        <!--<th>形态</th>-->
                        <th>两码合尾1234</th>
                        <th>0001111222路</th>


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
                                <?php $hezhi=$kj_number[0]+$kj_number[1]+$kj_number[2];$hewei=['06','07','23','25','26','27']?>
                                <td><?php echo $hezhi?></td>
                            <?php if(\app\models\Service::shunza([$kj_number[0],$kj_number[1],$kj_number[2]])){$shunzi[] = 0;}else{$shunzi[] = 1;}?>
                            <?php if(!in_array($hezhi,$hewei)){
                                $arr[] = 1;
                                ?>
                                <td><i class="icon-ok ">√</i></td>
                            <?php }else{
                                $arr[] = 0;
                                ?>
                                <td><i class="icon-ok ">x</i></td>
                            <?php }?>

                                <!--<td>--><?php //echo \app\models\Service::xingtai([$kj_number[0],$kj_number[1],$kj_number[2]])?><!--</td>-->
                                <td><?php echo \app\models\Service::liangmahe([$kj_number[0],$kj_number[1],$kj_number[2]])?></td>
                                <?php if(\app\models\Service::x012($kj_number[0].' '.$kj_number[1].' '.$kj_number[2])){
                                    $arr_012[] = 1;
                                    ?>
                                    <td><i class="icon-ok ">√</i></td>
                                <?php }else{
                                    $arr_012[] = 0;
                                    ?>
                                    <td><i class="icon-ok ">x</i></td>
                                <?php }?>
                            </tr>
                        <?php } ?>
                    <?php } else {
                        ?>
                        <tr>

                            <td align="center" colspan="12" class="no_record" style="display: table-cell">无记录</td>
                        </tr>
                    <?php } ?>
                    <?php $lian = \app\models\Service::hello($arr);?>
                    <lable class="red">和值条件-》</lable>
                    <lable class="red">连错：</lable><?php echo isset($lian[0])?$lian[0]:'0';?>期
                    <lable class="red">连对：</lable><?php echo $lian[1];?>期
                    <?php $count = array_count_values($arr);
                    $odds = round( ($count[1]/count($arr)) * 100 , 2) . "％";
                    ?>
                    <lable class="red">错：</lable><?php echo isset($count[0])?$count[0]:'0';?>期
                    <lable class="red">胜率：</lable><?php echo $odds;?>
                    <br>
                    <?php $lian2 = \app\models\Service::hello($shunzi);?>
                    <lable class="red">三连条件-》</lable>
                    <lable class="red">连错：</lable><?php echo isset($lian2[0])?$lian2[0]:'0';?>期
                    <lable class="red">连对：</lable><?php echo $lian2[1];?>期
                    <?php $count2 = array_count_values($shunzi);
                    $odds2 = round( ($count2[1]/count($shunzi)) * 100 , 2) . "％";
                    ?>
                    <lable class="red">错：</lable><?php echo isset($count2[0])?$count2[0]:'0';?>期
                    <lable class="red">胜率：</lable><?php echo $odds2;?>

                    <br>
                    <?php $lian012 = \app\models\Service::hello($arr_012);?>
                    <lable class="red">012条件-》</lable>
                    <lable class="red">连错：</lable><?php echo isset($lian012[0])?$lian012[0]:'0';?>期
                    <lable class="red">连对：</lable><?php echo $lian012[1];?>期
                    <?php $count012 = array_count_values($arr_012);
                    $odds012 = round( ($count012[1]/count($arr_012)) * 100 , 2) . "％";
                    ?>
                    <lable class="red">错：</lable><?php echo isset($count012[0])?$count012[0]:'0';?>期
                    <lable class="red">胜率：</lable><?php echo $odds012;?>
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