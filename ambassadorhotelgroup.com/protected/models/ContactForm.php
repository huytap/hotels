<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ContactForm extends CFormModel
{
	public $first_name;
	public $last_name;
	public $subject;
	public $email;
	public $body;
	public $phone;
	public $verifyCode;
	public $logo;
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('first_name, last_name, subject, email, body, phone', 'required', 'message' => Yii::t('lang', 'please_enter').' {attribute}'),
			// email has to be a valid email address
			array('email', 'email'),
			array('phone','safe'),
			// verifyCode needs to be entered correctly
			//array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}

	public function attributeLabels(){
		return array(
			'verifyCode'=>Yii::t('lang', 'verify_code'),
			'first_name'=> Yii::t('lang', 'first_name'),
			'last_name'=> Yii::t('lang', 'last_name'),
			'email'=>Yii::t('lang', 'email'), 
			'body'=>Yii::t('lang', 'body'),
			'phone'=>Yii::t('lang', 'phone'),
			'subject' => Yii::t('lang', 'subject')
		);
	}
}