<?php defined('C5_EXECUTE') or die(_("Access Denied."));

$form_selector = Loader::helper('form/user_selector');
$htmlId = uniqid('ccm-user-selector');
?>

<div id="<?php echo $htmlId ?>">
	<?php echo $form_selector->selectUser($htmlId, $value); //have to pass a jQuery selector-friendly field name in ?>
        
	<input type="hidden" name="<?php echo $this->controller->field('value') ?>" value="<?php echo $value ?>" />
</div>
		
<script>
 $(function(){
	 var wrap = $('#<?php echo $htmlId ?>'),
		selectBtn = wrap.find('a[dialog-title]'),
		deselectBtn = $('<a href="javascript:;"><?php echo t('Deselect User') ?></a>').hide().insertAfter(selectBtn),
		helperField = wrap.find('input[name="<?php echo $htmlId ?>"]'),
		actualField = wrap.find('input[name="<?php echo $this->controller->field('value') ?>"]');
	 
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
		