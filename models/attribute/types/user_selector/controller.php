<?php  
defined('C5_EXECUTE') or die("Access Denied.");

class UserSelectorAttributeTypeController extends AttributeTypeController  {

	protected $searchIndexFieldDefinition = 'I 11 DEFAULT 0 NULL';

	public function getValue() {
		$db = Loader::db();
		$value = $db->GetOne("select value from atUserSelector where avID = ?", array($this->getAttributeValueID()));
		return $value;	
	}
	
	public function searchForm($list) {
		$userID = $this->request('value');
		$list->filterByAttribute($this->attributeKey->getAttributeKeyHandle(), $userID, '=');
		return $list;
	}
	
	public function search() {
		$form_selector = Loader::helper('form/user_selector');
		print $form_selector->selectUser($this->field('value'), $this->request('value'), false);
	}
	
	public function form() {
		if (is_object($this->attributeValue)) {
			$value = $this->getAttributeValue()->getValue();
		}
		
		$this->set('value', $value);
		
	}
	
	public function validateForm($p) {
		return $p['value'] != 0;
	}

	public function saveValue($value) {
		$db = Loader::db();
		$db->Replace('atUserSelector', array('avID' => $this->getAttributeValueID(), 'value' => $value), 'avID', true);
	}
	
	public function deleteKey() {
		$db = Loader::db();
		$arr = $this->attributeKey->getAttributeValueIDList();
		foreach($arr as $id) {
			$db->Execute('delete from atUserSelector where avID = ?', array($id));
		}
	}
	
	public function saveForm($data) {
		$db = Loader::db();
		$this->saveValue($data['value']);
	}
	
	public function deleteValue() {
		$db = Loader::db();
		$db->Execute('delete from atUserSelector where avID = ?', array($this->getAttributeValueID()));
	}
	
}