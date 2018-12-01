<?php
/**
 *
 * @var PsiWhiteSpace $count
 * @var PsiWhiteSpace $data
 */
use app\components\Ext_IdnaConvert;
$punycode = new Ext_IdnaConvert();
$kk = ($page-1)*20;
?>
<?php foreach($data as $key=>$value){?>
    <a href="<?php echo Yii::$app->getUrlManager()->createUrl(['/site/conditions','domain'=>$value['domain_name']])?>">
    <div class="apply_num-record" @click="recharge_btn">
        <div class="record-line">
            <div class="col"><?php echo $key+1+$kk?></div>
            <div class="listTextG line-left">
                <div class="listTextG-title main-title"><?php echo $punycode->decode($value['domain_name'])?> </div>
            </div>
            <div class="line-right">
                <?php echo $value['num']?>
            </div>
        </div>
    </div>
    </a>
<?php }?>
