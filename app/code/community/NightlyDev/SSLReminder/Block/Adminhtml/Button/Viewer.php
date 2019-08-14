<?php
class NightlyDev_SSLReminder_Block_Adminhtml_Button_Viewer
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
        $this->setTemplate('sslreminder/adminhtml/button/viewer.phtml');
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
    			'id'        => 'nightlydevsslreminder_get_info',
    			'label'     => $this->helper('adminhtml')->__('View the SSL Certificate details from '.Mage::getStoreConfig('web/secure/base_url')),
    			'onclick'   => 'javascript:get_sslinfo(); return false;'
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
    public function getInfoUrl()
    {
        return Mage::getSingleton('adminhtml/url')->getUrl('*/nightlydevsslreminder/sslviewer');
    }
}
