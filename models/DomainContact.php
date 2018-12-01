<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "domain_contact".
 *
 * @property int $id
 * @property int $old_id
 * @property string $guid
 * @property int $agent_id
 * @property string $contact_id
 * @property string $old_contact_id
 * @property string $contact_type
 * @property string $company
 * @property string $fname
 * @property string $lname
 * @property string $credentials
 * @property string $credentials_code
 * @property string $password
 * @property string $country
 * @property string $province
 * @property string $city
 * @property string $address
 * @property string $address2
 * @property string $postcode
 * @property string $phone
 * @property string $phone_ext
 * @property string $fax
 * @property string $fax_ext
 * @property string $cellphone
 * @property string $email
 * @property string $organization_type
 * @property string $hide_status
 * @property string $status
 * @property string $use_status 使用状态
 * @property string $visit_status
 * @property string $warning_status
 * @property int $creator
 * @property string $created
 * @property string $modified
 * @property string $default_status
 * @property string $registrant_type
 * @property string $hidden_status
 * @property string $organization_number 证件编码
 * @property string $certificate_copy 证件扫描件
 * @property string $changes_prove 公司变更证明
 */
class DomainContact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'domain_contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['old_id', 'agent_id', 'creator'], 'integer'],
            [['guid', 'contact_type', 'creator', 'created', 'modified'], 'required'],
            [['contact_type', 'credentials', 'organization_type', 'hide_status', 'status', 'use_status', 'visit_status', 'warning_status', 'default_status', 'registrant_type', 'hidden_status', 'changes_prove'], 'string'],
            [['created', 'modified'], 'safe'],
            [['guid', 'contact_id', 'old_contact_id', 'phone'], 'string', 'max' => 64],
            [['company', 'fname', 'password', 'country', 'province', 'city', 'certificate_copy'], 'string', 'max' => 100],
            [['lname', 'credentials_code', 'phone_ext', 'fax', 'fax_ext', 'organization_number'], 'string', 'max' => 50],
            [['address', 'address2'], 'string', 'max' => 200],
            [['postcode', 'cellphone'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 250],
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
            'agent_id' => 'Agent ID',
            'contact_id' => 'Contact ID',
            'old_contact_id' => 'Old Contact ID',
            'contact_type' => 'Contact Type',
            'company' => 'Company',
            'fname' => 'Fname',
            'lname' => 'Lname',
            'credentials' => 'Credentials',
            'credentials_code' => 'Credentials Code',
            'password' => 'Password',
            'country' => 'Country',
            'province' => 'Province',
            'city' => 'City',
            'address' => 'Address',
            'address2' => 'Address2',
            'postcode' => 'Postcode',
            'phone' => 'Phone',
            'phone_ext' => 'Phone Ext',
            'fax' => 'Fax',
            'fax_ext' => 'Fax Ext',
            'cellphone' => 'Cellphone',
            'email' => 'Email',
            'organization_type' => 'Organization Type',
            'hide_status' => 'Hide Status',
            'status' => 'Status',
            'use_status' => 'Use Status',
            'visit_status' => 'Visit Status',
            'warning_status' => 'Warning Status',
            'creator' => 'Creator',
            'created' => 'Created',
            'modified' => 'Modified',
            'default_status' => 'Default Status',
            'registrant_type' => 'Registrant Type',
            'hidden_status' => 'Hidden Status',
            'organization_number' => 'Organization Number',
            'certificate_copy' => 'Certificate Copy',
            'changes_prove' => 'Changes Prove',
        ];
    }
}
