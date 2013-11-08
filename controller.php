<?php       

defined('C5_EXECUTE') or die(_("Access Denied."));

class UserSelectorAttributePackage extends Package {

	protected $pkgHandle = 'user_selector_attribute';
	protected $appVersionRequired = '5.5.1';
	protected $pkgVersion = '0.9.1';
	
	public function getPackageDescription() {
		return t("Attribute that allows the selection of users.");
	}
	
	public function getPackageName() {
		return t("User Selector Attribute");
	}
	
	public function install() {
		$pkg = parent::install();
		$pkgh = Package::getByHandle('user_selector_attribute'); 
		//Loader::model('attribute/categories/collection');
		//$col = AttributeKeyCategory::getByHandle('collection');
		$UserSelector = AttributeType::add('user_selector', t('User Selector'), $pkg);
		//$col->associateAttributeKeyType(AttributeType::getByHandle('user_selector'));
	}
}