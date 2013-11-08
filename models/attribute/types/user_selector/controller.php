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
		$form_selector = Loader::helper('form/user_selector');
		$htmlId = uniqid('ccm-user-selector');
		
		$html = '';
		
		$html .= '<div id="'.$htmlId.'">';
		$html .= $form_selector->selectUser($htmlId, $value);
		$html .= '<input type="hidden" name="'.$this->field('value').'" value="'.$value.'" />';
		$html .= '</div>';
		
		$html .= "
			<script>
			 $(function(){
				 var wrap = $('#".$htmlId."'),
				 	selectBtn = wrap.find('a[dialog-title]'),
				 	deselectBtn = $('<a href=\"javascript:;\">".t('Deselect User')."</a>').hide().insertAfter(selectBtn),
				 	helperField = wrap.find('input[name=\"".$htmlId."\"]'),
				 	actualField = wrap.find('input[name=\"".$this->field('value')."\"]');
				 
				 var toggleSelectBtns = function(){
					 if(helperField.val() && helperField.val() != '0'){
						selectBtn.hide();
						deselectBtn.show(); 
					 }else{
						selectBtn.show();
						deselectBtn.hide(); 
					 }
				 };
				 toggleSelectBtns();
				 
				 deselectBtn.click(function(){
					selectBtn.show();
					deselectBtn.hide()
					wrap.find('.ccm-summary-selected-item-label').html('');
					helperField.val('');
				 });
				 
				 //It is not very cool that we have to do this, but the hidden field doesn't naturally fire a change event
				 
				 setInterval(function(){
				 	actualField.val(helperField.val());
					toggleSelectBtns();
				 }, 500);
			 });
			</script>
		";
		
		print $html;
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