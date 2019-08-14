<?php
class NightlyDev_SSLReminder_Block_Adminhtml_Button_Fingerprint
    extends Mage_Adminhtml_Block_System_Config_Form_Field
{
		protected $entity;
    /*
     * Set template
     */
    protected function _construct()
    {
        parent::_construct();
        Mage::getDesign()->setTheme('template', 'nightlydev');
        $this->setTemplate('sslreminder/adminhtml/button/fingerprint.phtml');
    }
    
    /**
     * Generate synchronize button html
     *
     * @return string
     */
    public function getButtonHtml()
    {
    	$button = $this->getLayout()->createBlock('adminhtml/widget_button')
    	->setData(array(
    			'id'        => 'nightlydevsslreminder_get_fingerprint',
    			'label'     => $this->helper('adminhtml')->__('Get the SHA1 Fingerprint'),
    			'onclick'   => 'javascript:get_fingerprint(); return false;'
    	));
    
    	return $button->toHtml();
    }
    
    /**
     * Remove scope label
     *
     * @param  Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * Return element html
     *
     * @param  Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        return $this->_toHtml();
    }

    /**
     * Return ajax url for synchronize button
     *
     * @return string
     */
    public function getFingerprintUrl()
    {
        return Mage::getSingleton('adminhtml/url')->getUrl('*/nightlydevsslreminder/fingerprint');
    }
}
