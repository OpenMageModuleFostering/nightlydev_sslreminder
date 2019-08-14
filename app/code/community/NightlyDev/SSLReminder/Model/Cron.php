<?php
class NightlyDev_SSLReminder_Model_Cron
{
  public function run() {
    $_reminder = $_validator = FALSE;
    $reminder = Mage::getStoreConfig(NightlyDev_SSLReminder_Helper_Data::XML_PATH_REMINDER_ENABLED);
    $validator = Mage::getStoreConfig(NightlyDev_SSLReminder_Helper_Data::XML_PATH_VALIDATOR_ENABLED);
    try {
      if ($reminder or $validator) {
        $host = preg_replace('/^.*\:\/\/([^\/]*).*$/', '$1', Mage::getStoreConfig('web/secure/base_url'));
        $g = stream_context_create(array("ssl" => array("capture_peer_cert" => true)));
        $r = stream_socket_client('ssl://'.$host.':443', $errno, $errstr, 3, STREAM_CLIENT_CONNECT, $g);
        if ($errno) throw new Exception('SSL Certificate not found.');
        $cont = stream_context_get_params($r);
        if (!isset($cont["options"]["ssl"]["peer_certificate"])) throw new Exception('SSL Certificate not found.');
        $cert = $cont["options"]["ssl"]["peer_certificate"];
        $_data = openssl_x509_parse($cert);
        if ($reminder) {
          $strtotime = Mage::getStoreConfig(NightlyDev_SSLReminder_Helper_Data::XML_PATH_REMINDER_TIME);
          $_reminder = $_data['validTo_time_t']>strtotime($strtotime);
          $day = floor(($_data['validTo_time_t'] - time()) / 86400);
          $days = (abs($day)==1?NULL:'s');
          $days = $day.' day'.$days;
        }
        if ($validator) {
          $fingerprint = Mage::getStoreConfig(NightlyDev_SSLReminder_Helper_Data::XML_PATH_VALIDATOR_FINGERPRINT);
          $_fingerprint = $output = null;
          $export = openssl_x509_export($cert, $output);
          if($export !== false) {
            $_output = str_replace('-----BEGIN CERTIFICATE-----', '', $output);
            $_output = str_replace('-----END CERTIFICATE-----', '', $_output);
            $_output = base64_decode($_output);
            $_fingerprint = sha1($_output);
          }
          $_validator = ($fingerprint==$_fingerprint);
        }
        openssl_x509_free($cert);
      }
    } catch (Exception $e) {
      Mage::logException($e);
      Mage::printException($e);
    }
    
    if ($reminder and !$_reminder) {
      $message = Mage::getStoreConfig(NightlyDev_SSLReminder_Helper_Data::XML_PATH_REMINDER_MESSAGE);
      $recip = Mage::getStoreConfig(NightlyDev_SSLReminder_Helper_Data::XML_PATH_REMINDER_RECIP);
      $sender = Mage::getStoreConfig(NightlyDev_SSLReminder_Helper_Data::XML_PATH_REMINDER_SENDER);
      if ($sender and $recip) {
        foreach(explode(',',$recip) as $mail) {
          Mage::getModel('core/email')
            ->setToName(trim($mail))
            ->setToEmail(trim($mail))
            ->setSubject('SSL Certificate Reminder: '.$days.' to expire.')
            ->setBody($message)
            ->setFromEmail($sender)
            ->setFromName($sender)
            ->setType('text')
            ->send();
        }
      }
    }
    if ($validator and !$_validator) {
      $message = "The validation of your SSL Certificate falied because the current fingerprint doesnt match to the expected fingerprint.";
      $recip = Mage::getStoreConfig(NightlyDev_SSLReminder_Helper_Data::XML_PATH_VALIDATOR_RECIP);
      $sender = Mage::getStoreConfig(NightlyDev_SSLReminder_Helper_Data::XML_PATH_VALIDATOR_SENDER);
      if ($sender and $recip) {
        foreach(explode(',',$recip) as $mail) {
          Mage::getModel('core/email')
            ->setToName(trim($mail))
            ->setToEmail(trim($mail))
            ->setSubject('SSL Certificate Validator Error')
            ->setBody($message)
            ->setFromEmail($sender)
            ->setFromName($sender)
            ->setType('text')
            ->send();
        }
      }
    }
  }
}