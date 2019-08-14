<?php
class NightlyDev_SSLReminder_Model_Adminhtml_System_Config_Source_Time
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'now',       'label'=>Mage::helper('adminhtml')->__('When the SSL certificate is expired')),
            array('value' => '+1 day',    'label'=>Mage::helper('adminhtml')->__('1 day before the SSL certificate is expired')),
            array('value' => '+3 days',   'label'=>Mage::helper('adminhtml')->__('3 days before the SSL certificate is expired')),
            array('value' => '+1 week',   'label'=>Mage::helper('adminhtml')->__('1 week before the SSL certificate is expired')),
            array('value' => '+2 weeks',  'label'=>Mage::helper('adminhtml')->__('2 weeks before the SSL certificate is expired')),
            array('value' => '+1 month',  'label'=>Mage::helper('adminhtml')->__('1 month before the SSL certificate is expired')),
            array('value' => '+2 months', 'label'=>Mage::helper('adminhtml')->__('2 months before the SSL certificate is expired')),
            array('value' => '+3 months', 'label'=>Mage::helper('adminhtml')->__('3 months before the SSL certificate is expired'))
        );
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            'now'       => Mage::helper('adminhtml')->__('When the SSL Certificate is expired'),
            '+1 day'    => Mage::helper('adminhtml')->__('1 day before the SSL Certificate is expired'),
            '+3 days'   => Mage::helper('adminhtml')->__('3 days before the SSL Certificate is expired'),
            '+1 week'   => Mage::helper('adminhtml')->__('1 week before the SSL Certificate is expired'),
            '+2 weeks'  => Mage::helper('adminhtml')->__('2 weeks before the SSL Certificate is expired'),
            '+1 month'  => Mage::helper('adminhtml')->__('1 month before the SSL Certificate is expired'),
            '+2 months' => Mage::helper('adminhtml')->__('2 months before the SSL Certificate is expired'),
            '+3 months' => Mage::helper('adminhtml')->__('3 months before the SSL Certificate is expired')
        );
    }

}
