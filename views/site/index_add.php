<?php
/**
 *
 * @var PsiWhiteSpace $count
 * @var PsiWhiteSpace $data
 */
?>
<?php foreach($data as $key=>$value){?>
<div class="apply_num-record">
    <div class="record-line">
        <div class="col"><?php echo date("H:i",strtotime($value['cre_date']))?></div>
        <a href="<?php echo Yii::$app->getUrlManager()->createUrl(['/site/trademark-list','domain'=>$value['domain_name']])?>">
        <div class="listTextG line-left">
            <div class="listTextG-title main-title"><?php echo $value['domain_name']?> </div>
            <div class="listTextG-text"><?php echo $value['company']?></div>
        </div>
        </a>

    </div>
</div>
<?php }?>
