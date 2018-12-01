<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "domain_register".
 *
 * @property int $id
 * @property int $old_id
 * @property string $guid
 * @property int $trademark_id
 * @property string $domain_name
 * @property string $domain_password
 * @property int $period
 * @property string $price
 * @property string $realsum
 * @property string $url
 * @property string $new_url 新存解析网址
 * @property string $is_parsing 是否解析
 * @property string $registrant_name
 * @property string $registrant_type
 * @property int $contact_paper_type
 * @property string $contact_paper_number
 * @property string $admin_id
 * @property string $contact_id
 * @property string $teach_id
 * @property string $renew_id
 * @property string $responsible_id
 * @property string $cre_date
 * @property string $exp_date
 * @property string $old_exp_date
 * @property string $exp_date_status
 * @property string $exp_date_dtime
 * @property string $notice_id
 * @property string $accepted_date
 * @property string $not_after_date
 * @property string $status
 * @property string $fail_reason
 * @property int $registrar_id
 * @property int $agent_id
 * @property string $type
 * @property string $register_type
 * @property string $free_give_type
 * @property string $give_org_domain_name
 * @property string $give_time
 * @property string $source_type
 * @property string $audit_status
 * @property string $refund_status
 * @property string $first_audit
 * @property string $last_refresh_time
 * @property string $epp_id
 * @property string $old_epp_id
 * @property int $order_id
 * @property string $lang_type
 * @property string $need_feedback
 * @property string $org_domain_name
 * @property int $upload_count
 * @property string $issue_id
 * @property string $visit_issue_id
 * @property string $is_cross_district
 * @property string $cross_district_area
 * @property string $cross_district_describe
 * @property string $cross_district_file
 * @property string $allow_status
 * @property string $allow_file
 * @property int $operator_id
 * @property string $created
 * @property string $modified
 * @property int $current_level
 * @property int $month_level
 * @property string $amount_payable
 * @property string $from_type
 * @property string $come_from
 * @property string $is_signed 是否5.1前签订协议
 * @property string $qualified_status
 * @property string $is_qualified
 * @property string $is_pre_register
 * @property string $email_status
 * @property string $upload_to_knet_modified
 * @property string $audit_remark_id
 * @property string $audit_time
 * @property int $audit_user_id
 * @property string $audit_issue_id
 * @property string $upload_to_knet_time
 * @property string $domain_register_type
 * @property int $domain_relation 用于变体，关联两个域名
 * @property string $hourcheck
 * @property string $trademark_category
 * @property int $naming_type 1代表普通商标名，2代表服务项目名+商标名域名，3代表指定地+商标名域名,4代表指定地+服务项目名域名
 * @property int $giving_period 赠送年限
 * @property int $giving_period_choose 选择赠送年限
 * @property string $giving_domain_places 免费赠送域名名额
 * @property string $giving_domain 免费赠送三个域名
 * @property string $is_giving_three 是否属于买一送三
 * @property int $is_giving_success 是否赠送成功1:注册2:赠送成功
 * @property int $remaining_years 剩余可续费年限
 * @property int $parent_domain_id 主词id
 * @property string $protect_view_status
 * @property int $protect_refresh_id
 * @property string $approval_status
 * @property string $approval_issue_id
 * @property int $approval_user_id
 * @property string $trademark_logo
 * @property string $pay_ststus
 */
class DomainRegister extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'domain_register';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['old_id', 'trademark_id', 'period', 'contact_paper_type', 'registrar_id', 'agent_id', 'order_id', 'upload_count', 'operator_id', 'current_level', 'month_level', 'audit_user_id', 'domain_relation', 'naming_type', 'giving_period', 'giving_period_choose', 'remaining_years', 'parent_domain_id', 'protect_refresh_id', 'approval_user_id'], 'integer'],
            [['guid', 'trademark_id', 'domain_name', 'agent_id', 'operator_id', 'created', 'modified'], 'required'],
            [['price', 'realsum', 'amount_payable'], 'number'],
            [['is_parsing', 'registrant_type', 'exp_date_status', 'status', 'fail_reason', 'type', 'register_type', 'free_give_type', 'source_type', 'audit_status', 'refund_status', 'first_audit', 'lang_type', 'need_feedback', 'is_cross_district', 'cross_district_describe', 'allow_status', 'come_from', 'is_signed', 'qualified_status', 'is_qualified', 'is_pre_register', 'email_status', 'domain_register_type', 'hourcheck', 'is_giving_three', 'protect_view_status', 'approval_status', 'pay_ststus'], 'string'],
            [['cre_date', 'exp_date', 'old_exp_date', 'exp_date_dtime', 'give_time', 'last_refresh_time', 'created', 'modified', 'upload_to_knet_modified', 'audit_time', 'upload_to_knet_time'], 'safe'],
            [['guid', 'contact_paper_number'], 'string', 'max' => 64],
            [['domain_name', 'domain_password', 'registrant_name', 'accepted_date', 'not_after_date', 'issue_id', 'visit_issue_id', 'cross_district_area', 'cross_district_file', 'allow_file', 'from_type', 'audit_remark_id', 'audit_issue_id', 'approval_issue_id', 'trademark_logo'], 'string', 'max' => 100],
            [['url', 'new_url', 'notice_id'], 'string', 'max' => 200],
            [['admin_id', 'contact_id', 'teach_id', 'renew_id', 'responsible_id'], 'string', 'max' => 20],
            [['give_org_domain_name', 'org_domain_name'], 'string', 'max' => 300],
            [['epp_id', 'old_epp_id'], 'string', 'max' => 50],
            [['trademark_category', 'giving_domain_places', 'giving_domain'], 'string', 'max' => 255],
            [['is_giving_success'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'old_id' => 'Old ID',
            'guid' => 'Guid',
            'trademark_id' => 'Trademark ID',
            'domain_name' => 'Domain Name',
            'domain_password' => 'Domain Password',
            'period' => 'Period',
            'price' => 'Price',
            'realsum' => 'Realsum',
            'url' => 'Url',
            'new_url' => 'New Url',
            'is_parsing' => 'Is Parsing',
            'registrant_name' => 'Registrant Name',
            'registrant_type' => 'Registrant Type',
            'contact_paper_type' => 'Contact Paper Type',
            'contact_paper_number' => 'Contact Paper Number',
            'admin_id' => 'Admin ID',
            'contact_id' => 'Contact ID',
            'teach_id' => 'Teach ID',
            'renew_id' => 'Renew ID',
            'responsible_id' => 'Responsible ID',
            'cre_date' => 'Cre Date',
            'exp_date' => 'Exp Date',
            'old_exp_date' => 'Old Exp Date',
            'exp_date_status' => 'Exp Date Status',
            'exp_date_dtime' => 'Exp Date Dtime',
            'notice_id' => 'Notice ID',
            'accepted_date' => 'Accepted Date',
            'not_after_date' => 'Not After Date',
            'status' => 'Status',
            'fail_reason' => 'Fail Reason',
            'registrar_id' => 'Registrar ID',
            'agent_id' => 'Agent ID',
            'type' => 'Type',
            'register_type' => 'Register Type',
            'free_give_type' => 'Free Give Type',
            'give_org_domain_name' => 'Give Org Domain Name',
            'give_time' => 'Give Time',
            'source_type' => 'Source Type',
            'audit_status' => 'Audit Status',
            'refund_status' => 'Refund Status',
            'first_audit' => 'First Audit',
            'last_refresh_time' => 'Last Refresh Time',
            'epp_id' => 'Epp ID',
            'old_epp_id' => 'Old Epp ID',
            'order_id' => 'Order ID',
            'lang_type' => 'Lang Type',
            'need_feedback' => 'Need Feedback',
            'org_domain_name' => 'Org Domain Name',
            'upload_count' => 'Upload Count',
            'issue_id' => 'Issue ID',
            'visit_issue_id' => 'Visit Issue ID',
            'is_cross_district' => 'Is Cross District',
            'cross_district_area' => 'Cross District Area',
            'cross_district_describe' => 'Cross District Describe',
            'cross_district_file' => 'Cross District File',
            'allow_status' => 'Allow Status',
            'allow_file' => 'Allow File',
            'operator_id' => 'Operator ID',
            'created' => 'Created',
            'modified' => 'Modified',
            'current_level' => 'Current Level',
            'month_level' => 'Month Level',
            'amount_payable' => 'Amount Payable',
            'from_type' => 'From Type',
            'come_from' => 'Come From',
            'is_signed' => 'Is Signed',
            'qualified_status' => 'Qualified Status',
            'is_qualified' => 'Is Qualified',
            'is_pre_register' => 'Is Pre Register',
            'email_status' => 'Email Status',
            'upload_to_knet_modified' => 'Upload To Knet Modified',
            'audit_remark_id' => 'Audit Remark ID',
            'audit_time' => 'Audit Time',
            'audit_user_id' => 'Audit User ID',
            'audit_issue_id' => 'Audit Issue ID',
            'upload_to_knet_time' => 'Upload To Knet Time',
            'domain_register_type' => 'Domain Register Type',
            'domain_relation' => 'Domain Relation',
            'hourcheck' => 'Hourcheck',
            'trademark_category' => 'Trademark Category',
            'naming_type' => 'Naming Type',
            'giving_period' => 'Giving Period',
            'giving_period_choose' => 'Giving Period Choose',
            'giving_domain_places' => 'Giving Domain Places',
            'giving_domain' => 'Giving Domain',
            'is_giving_three' => 'Is Giving Three',
            'is_giving_success' => 'Is Giving Success',
            'remaining_years' => 'Remaining Years',
            'parent_domain_id' => 'Parent Domain ID',
            'protect_view_status' => 'Protect View Status',
            'protect_refresh_id' => 'Protect Refresh ID',
            'approval_status' => 'Approval Status',
            'approval_issue_id' => 'Approval Issue ID',
            'approval_user_id' => 'Approval User ID',
            'trademark_logo' => 'Trademark Logo',
            'pay_ststus' => 'Pay Ststus',
        ];
    }
}
