<?php
class NightlyDev_SSLReminder_Helper_Data extends Mage_Core_Helper_Abstract
{
  const XML_PATH_REMINDER_ENABLED = 'system/nightlydevsslreminder/enabled';
  const XML_PATH_REMINDER_TIME    = 'system/nightlydevsslreminder/time';
  const XML_PATH_REMINDER_MESSAGE = 'system/nightlydevsslreminder/message';
  const XML_PATH_REMINDER_RECIP   = 'system/nightlydevsslreminder/email';
  const XML_PATH_REMINDER_SENDER  = 'system/nightlydevsslreminder/email_identity';
  
  const XML_PATH_VALIDATOR_ENABLED     = 'system/nightlydevsslvalidator/enabled';
  const XML_PATH_VALIDATOR_FINGERPRINT = 'system/nightlydevsslvalidator/fingerprint';
  const XML_PATH_VALIDATOR_RECIP       = 'system/nightlydevsslvalidator/email';
  const XML_PATH_VALIDATOR_SENDER      = 'system/nightlydevsslvalidator/email_identity';
}
