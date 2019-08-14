<?php
class NightlyDev_SSLReminder_NightlydevsslreminderController extends Mage_Adminhtml_Controller_Action
{
  public function sslviewerAction() {
    if (!$this->getRequest()->isAjax()) {
        $this->_forward('noRoute');
        return;
    }
    $return = NULL;
    $host = 'http://support.nightlydev.org/ssl-check?host='
      .preg_replace('/^.*\:\/\/([^\/]*).*$/', '$1', 
        Mage::getStoreConfig('web/secure/base_url')
      );
    if (ini_get('allow_url_fopen'))
      $return = file_get_contents($host);
    else if (function_exists('curl_init')) {
      $ch = curl_init();
      curl_setopt ($ch, CURLOPT_URL, $host);
      curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
      $return = curl_exec($ch);
      curl_close($ch);
    } else $return = "Error while fetching the SSL Certificate.";
    $this->getResponse()->setBody($return);
   
  }
  public function fingerprintAction()
  {
    if (!$this->getRequest()->isAjax()) {
        $this->_forward('noRoute');
        return;
    }
    $error = $return = FALSE;
    try {
      $host = preg_replace('/^.*\:\/\/([^\/]*).*$/', '$1', Mage::getStoreConfig('web/secure/base_url'));
      $g = stream_context_create(array("ssl" => array("capture_peer_cert" => true)));
      $r = stream_socket_client('ssl://'.$host.':443', $errno, $errstr, 3, STREAM_CLIENT_CONNECT, $g);
      if ($errno) throw new Exception();
      $cont = stream_context_get_params($r);
      if (!isset($cont["options"]["ssl"]["peer_certificate"])) throw new Exception();
      $cert = $cont["options"]["ssl"]["peer_certificate"];
      $return = $output = null;
      $export = openssl_x509_export($cert, $output);
      openssl_x509_free($cert);
      if($export !== false) {
        $_output = str_replace('-----BEGIN CERTIFICATE-----', '', $output);
        $_output = str_replace('-----END CERTIFICATE-----', '', $_output);
        $_output = base64_decode($_output);
        $return = sha1($_output);
      }
    } catch (Exception $e) {
      $error = TRUE;
      #Mage::getSingleton('adminhtml/session')->addError(
      #  Mage::helper('nightlydevsslreminder')->__('Failed while fetching the SHA1 Fingerprint of your SSL Certificate.')
      #);
    }
    if (!$error and $return)
      Mage::getModel('core/config')->saveConfig('system/nightlydevsslvalidator/fingerprint', $return);
    $this->getResponse()->setBody($return);
  }
}