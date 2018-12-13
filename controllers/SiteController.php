<?php

namespace app\controllers;

use app\models\AnalysisLog;
use app\models\Service;
use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\data\Pagination;
use app\components\Ext_IdnaConvert;
use app\components\EPP\EPP;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * 域名注册情况
     *
     * @return string
     */
    public function actionIndex()
    {
        $period = Yii::$app->request->get('period','50');
        $querylist = new Query();
        $querylist->select('*')->from('xy_data');
        $querylist->orderBy('number desc');
        $count = $querylist->count();
        $pages = new Pagination(['defaultPageSize' => $period, 'totalCount' => $count,'pageSizeLimit'=>$period]);
        $querylist->offset($pages->offset)->limit($pages->limit);
        $data = $querylist->all();
        return $this->render("index",[
            'data'=>$data,
            'pages'=>$pages,
            'period'=>$period,
        ]);

    }

    /**
     * 域名续费情况
     * @return string
     * @author lvlinlin <lvlinlin@tdnnic.org>
     */
    public function actionRenew()
    {
        $page = htmlspecialchars(trim(Yii::$app->request->get('page',1)));

        $date = yii::$app->request->get('date','今天');
        switch($date){
            case '今天':
                $start_date = date("Y-m-d",time());
                $end_date = date("Y-m-d",time());
                break;
            case '本周':
                $start_date = date('Y-m-d', strtotime("this week Monday", time()));
                $end_date = date('Y-m-d',strtotime(date('Y-m-d', strtotime("this week Sunday", time()))) + 24 * 3600 - 1);
                break;
            case '本月':
                $start_date = date('Y-m-d',mktime(0, 0, 0, date('m'), 1, date('Y')));
                $end_date = date('Y-m-d',mktime(23, 59, 59, date('m'), date('t'), date('Y')));
                break;
            case '半年':
                $start_date = date("Y-m-d H:i:s", strtotime("-6 month"));
                $end_date = date("Y-m-d",time());
                break;
            case '一年':
                $start_date = date("Y-m-d H:i:s", strtotime("-1 year"));
                $end_date = date("Y-m-d",time());
                break;
            default:
                $start_date = date("Y-m-d",time());
                $end_date = date("Y-m-d",time());
                break;
        }
        $querylist = new Query();
        $querylist->select('t.id,t.domain_name,t.created,c.company')
            ->from('renew_record t')
            ->leftJoin("domain_register d","t.domain_register_id=d.id")
            ->leftJoin("domain_contact c","d.contact_id=c.id")
            ->where(['!=', 't.audit_status', '审核拒绝'])
            ->andWhere(['and', ['>=','t.created', $start_date.' 00:00:00'],['<=','t.created',$end_date.' 23:59:59']]);
        $querylist->orderBy('t.id desc');
        $count = $querylist->count();
        $pages = new Pagination(['defaultPageSize' => 5, 'totalCount' => $count]);
        $querylist->offset($pages->offset)->limit($pages->limit);
        $data = $querylist->all();
        if($page>1){
            return $this->renderPartial('renew_add',[
                'count'=>$count,
                'data'=>$data,
                'date'=>$date,
            ]);
        }else{
            //页码
            $page_num = ceil($count/5);
            return $this->render('renew',[
                'count'=>$count,
                'data'=>$data,
                'page_num'=>$page_num,
                'date'=>$date,
            ]);
        }

    }
    /**
     * 运营情况
     * @author lvlinlin <lvlinlin@tdnnic.org>
     */
    public function actionOperation(){
        $page = htmlspecialchars(trim(Yii::$app->request->get('page',1)));
        $query = new Query();
        $db = Yii::$app->db_analysis;
        $date = yii::$app->request->get('date','今天');
        switch($date){
            case '今天':
                $start_date = date("Y-m-d",time());
                $end_date = date("Y-m-d",time());
                break;
            case '本周':
                $start_date = date('Y-m-d', strtotime("this week Monday", time()));
                $end_date = date('Y-m-d',strtotime(date('Y-m-d', strtotime("this week Sunday", time()))) + 24 * 3600 - 1);
                break;
            case '本月':
                $start_date = date('Y-m-d',mktime(0, 0, 0, date('m'), 1, date('Y')));
                $end_date = date('Y-m-d',mktime(23, 59, 59, date('m'), date('t'), date('Y')));
                break;
            case '半年':
                $start_date = date("Y-m-d", strtotime("-6 month"));
                $end_date = date("Y-m-d",time());
                break;
            case '一年':
                $start_date = date("Y-m-d", strtotime("-1 year"));
                $end_date = date("Y-m-d",time());
                break;
            default:
                $start_date = date("Y-m-d",time());
                $end_date = date("Y-m-d",time());
                break;
        }
        $search_domain= htmlspecialchars(trim(yii::$app->request->get('search_domain', '')));
        //$query->batch = "";
        $query->select('`id`,`domain_name`,count(`id`) as num')->where("is_crawler=0")->from(AnalysisLog::tableName());

        if (!empty($search_domain)) {
            $query->andWhere("domain_name like '%{$search_domain}%'");
        }

        if (!empty($start_date)) {
            $query->andWhere("created_at >= '{$start_date} 00:00:00'");
        }
        if (!empty($end_date)) {
            $query->andWhere("created_at <= '{$end_date} 23:59:59'");
        }
        $sum_info =Yii::$app->db_analysis->createCommand("SELECT * FROM `sum_tmp`")->queryone();
        switch($date){
            case '本月':
                if($page==1) {
                    $count = $sum_info['month_sum'];
                }
                $query->groupBy("domain_name");
                $query->orderBy("count(`id`) desc");

                $count2= $sum_info['month_page_sum'];
                break;
            case '半年':
                if($page==1) {
                    $count = $sum_info['half_year_sum'];
                }
                $query->groupBy("domain_name");
                $query->orderBy("count(`id`) desc");

                $count2= $sum_info['half_year_page_sum'];
                break;
            case '一年':
                if($page==1) {
                    $count = $sum_info['year_sum'];
                }
                $query->groupBy("domain_name");
                $query->orderBy("count(`id`) desc");

                $count2= $sum_info['year_page_sum'];
                break;
            default:
                if($page==1) {
                    $count = $query->count('id', $db);
                }
                $query->groupBy("domain_name");
                $query->orderBy("count(`id`) desc");

                $count2= $query->count('id',$db);
                break;
        }
        //if($page==1) {
        //    $count = $query->count('id', $db);
        //}
        //$query->groupBy("domain_name");
        ////$query->orderBy("count(`id`) desc");
        //
        //$count2= $query->count('id',$db);

        //print_r($count);exit;
        $pages = new Pagination(['defaultPageSize'=>20,'totalCount'=>$count2]);
        $query->offset($pages->offset)->limit($pages->limit);
        $visits = $query->all($db);
        //对数组进行排序
        //$visits = Service::array_sort($visits,'num','desc');
        if($page>1){
            return $this->renderPartial("operation_add",[
                'data'=>$visits,
                'page'=>$page
            ]);
        }else{//页码
            $page_num = ceil($count2/20);
            return $this->render("operation",[
                'count'=>$count,
                'data'=>$visits,
                'page_num'=>$page_num,
                'date'=>$date
            ]);
        }

    }

    /**
     * 商标注册列表
     * @author lvlinlin <lvlinlin@tdnnic.org>
     */
    public function actionTrademarkList(){
        $query = new Query();
        $db = Yii::$app->db_analysis;
        $domain = htmlspecialchars(trim(yii::$app->request->get('domain', '')));
        $start_date = yii::$app->request->get('start_date', date("Y-m-d",time()));
        $end_date = yii::$app->request->get('end_date', date("Y-m-d",time()));
        //$query->batch = "";
        $query->select('`domain_name`,created_at')->where("is_crawler=0")->from(AnalysisLog::tableName());

        if (!empty($domain)) {
            $punycode = new Ext_IdnaConvert($domain);
            $domain = $punycode->encode($domain);
            $query->andWhere("domain_name='{$domain}'");
        }

        if (!empty($start_date)) {
            $query->andWhere("created_at >= '{$start_date} 00:00:00'");
        }
        if (!empty($end_date)) {
            $query->andWhere("created_at <= '{$end_date} 23:59:59'");
        }

        $query->orderBy("id desc");

        $count = $query->count('*',$db);
        $pages = new Pagination(['defaultPageSize'=>20,'totalCount'=>$count]);
        $query->offset($pages->offset)->limit($pages->limit);
        $visits = $query->all($db);
        //注册人名称
        $querylist = new Query();
        $querylist->select('t.id,t.domain_name,c.company')
            ->from('domain_register t')
            ->leftJoin("domain_contact c","t.contact_id=c.id")
            ->where(['!=', 'audit_status', '命名审核拒绝'])
            ->andWhere(['!=','t.status','创建失败'])
            ->andWhere(['domain_name'=>$domain]);
        $domaininfo = $querylist->one();

        return $this->render("trademark-list",[
            'data'=>$visits,
            'company'=>$domaininfo['company']
        ]);
    }
    public function actionTrademarkDetail(){
        $domain = htmlspecialchars(trim(Yii::$app->request->get("domain",'')));

        $epp = new EPP();
        $returndata = $epp->whois($domain);
        $domaininfo = [];
        if(!empty($returndata) && $returndata['code']==1){
            $domaininfo = nl2br($returndata['message']);
            if(strstr($domaininfo,'Name is reserved by Registry')){
                $infos = explode('Primary IDN: ',$domaininfo);
                $infos = explode('<br />',$infos[1]);
                $infos = $infos[0];
                $returndata = $epp->whois($infos);
                $domaininfo = nl2br($returndata['message']);
            }
        }else{
            echo "<script language=\"javascript\">alert('查询失败,请稍后重试');history.go(-1)</script>";
        }
        if(isset($domaininfo) && !empty($domaininfo)){
            $domaininfo = $this->get_whois_info($domaininfo);
        }
        //print_r($domaininfo);exit;
        return $this->render("trademark-detail",[
            'domaininfo'=>$domaininfo,
            'domain'=>$domain
        ]);
    }

    /**
     * 解析明细
     * @return string
     * @author lvlinlin <lvlinlin@tdnnic.org>
     */
    public function actionConditions(){
        $domain = htmlspecialchars(trim(Yii::$app->request->get("domain",'')));
        if(strpos($domain,'.商标')==false && strpos($domain,'.xn--czr694b')==false){
            $newdomain = $domain.'.商标';
        }else{
            $newdomain = $domain;
        }
        $punycode = new Ext_IdnaConvert();
        $newdomain = $punycode->encode($newdomain);
        $query = new Query();
        //$db = Yii::$app->db_analysis;
        //获取最近6个月的访问记录
        $data = Yii::$app->db_analysis->createCommand("SELECT count(id) as total,date_format(created_at, '%m') as `month` FROM analysis_log WHERE domain_name='{$newdomain}' AND date_sub(curdate(), INTERVAL 150 DAY) <= date(`created_at`) GROUP BY date_format(created_at, '%Y-%m') ORDER BY created_at desc")->queryAll();
        $count = count($data);
        if($count<=5){//不够6个月的数据 补充空数组
            $month = date("m",time());
            for($i=0;$i<=5;$i++){
                $countmonth[] = sprintf("%02d",$month-$i);;
            }
            //print_r($countmonth);exit;
            $res = [];
            foreach($countmonth as $key=>$item){
                $bool = true;
                foreach($data as $item2){
                    if($item2['month'] ==$item){
                        $bool = false;
                        $temp['total'] = $item2['total'];
                        $temp['month'] = $item2['month'];
                        $res[]=$temp;
                        continue;
                    }

                }
                if($bool) {
                    $res[] = array('total' => '0', 'month' => $item);
                }

            }


        }else{
            $res = $data;
        }
        $count_parsing = 0;
        foreach($data as $key=>$val){
            $count_parsing += $val['total'];
        }
        if($count_parsing == 0) $count_parsing = 1;
        return $this->render("conditions",[
            'domain'=>$punycode->decode($newdomain)=='商标'?'':$punycode->decode($newdomain),
            'data'=>$res,
            'count_parsing'=>$count_parsing
        ]);
    }


    /**
     * 处理whois信息
     * @param $content
     * @return array
     */
    private function get_whois_info($content){
        $content = str_replace("Internationalized Domain Name","Domain Name",$content);
        $data = explode('<br />',$content);
        if(!strstr($data[0],"The queried object does not exist")){
            array_shift($data);
        }
        $array = [
            "Domain Name" => "域名",
            "Registry Domain ID" => "域名ID",
            "Creation Date" => "创建日期",
            "Registry Expiry Date" => "到期日期",
            "Registrar" => "所属注册服务商",
            "Registrar IANA ID" => "所属注册服务商IANA ID",
            "Registrant Organization" => "域名注册组织单位名称",
            "Registrant Email" => "域名注册人邮箱",
        ];
        $values = [];
        if(!empty($data)){
            foreach($data as $key=>$value){

                $value = trim($value);

                if(empty($value)) continue;

                //if(($key==13||$key==14) && strpos($value,"Registrant Name")==0){
                if(($key==13||$key==14) && strpos($value,"Registrant Name") ===0){
                    continue;
                }

                $arrs = explode(": ",$value);
                $arrs[0] = trim($arrs[0],":");
                if(isset($arrs[0]) && isset($array[$arrs[0]])){
                    $valuename = isset($arrs[1])?$arrs[1]:'';
                    $values[] = $this->replace_content($valuename,$arrs[0],$array[$arrs[0]]);
                }else{
                    $values[]['last'] = $value;
                }
            }
        }
        return $values;
    }
    /**
     * 替换无成所需格式
     * @param $value
     * @param $keyword
     * @param $chs_name
     * @return array
     */
    private function replace_content($value,$keyword,$chs_name){
        $values = [];
        $eng_status = [
            'ok',
            'pendingUpdate',
            'pendingCreate',
            'serverHold',
            'clientDeleteProhibited',
            'clientRenewProhibited',
            'clientTransferProhibited',
            'serverUpdateProhibited'
        ];
        $chs_status = [
            '已注册(ok)',
            '更新中(pendingUpdate)',
            '审核中(pendingCreate)',
            '已注册不予解析(serverHold)',
            '禁止客户端删除(clientDeleteProhibited)',
            '禁止客户端续签(clientRenewProhibited)',
            '禁止客户端迁移(clientTransferProhibited)',
            '禁止服务器更新(serverUpdateProhibited)'
        ];

        $values['chs'] = $chs_name;
        $values['value'] = str_replace([$keyword,' <<<'],["",""],$value);
        $values['eng'] = str_replace("<<<","",$keyword);
        if(empty($chs_name)){
            $values['chs'] =  $values['eng'];
            $values['eng'] = '';
        }

        if('Domain Status'==$keyword){
            $arr = explode("https",trim($value));
            if(isset($arr[0])){
                $str = trim(str_replace("https","",$arr[0]));
                $value = str_replace($eng_status,$chs_status,$str);
                $value = isset($arr[1]) ? $value."&nbsp;https".$arr[1] : $value;
            }else{
                $value = str_replace($eng_status,$chs_status,$value);
            }
            $values['value'] = $value;
        }

        return $values;
    }
}
