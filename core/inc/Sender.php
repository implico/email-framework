<?php

/**
 * Implico Email Framework
 * 
 * @package Sender - Used to send emails via PHPMailer
 * @author Bartosz Sak <info@implico.pl>
 * 
*/

namespace Implico\Email;


class Sender
{
  protected $mailer;
  protected $config;
  protected $smarty;
  
  //parameters
  protected $script, $toAddress, $fromName, $fromAddress, $subject, $attachments, $useMinified, $interval, $stopOnError;
  
  public function __construct($config, $script, $toAddress, $toAddressFilename, $fromName, $fromAddress, $subject, $attachments, $useMinified, $interval, $stopOnError)
  {
    $this->mailer = new \PHPMailer();
    $this->config = $config;
    
    $this->setSmarty();
    
    $this->data = array();
    $this->script = $script ? $script : 'index';
    
    if (!$toAddress) {
      $toAddress = $this->smarty->getConfigVars('senderDefaultToAddress');
    }
    if (!is_array($toAddress)){
      $toAddress = explode(',', $toAddress);
    }
    
    if ($toAddressFilename && file_exists($toAddressFilename)) {
      $toAddress = array_merge(explode(PHP_EOL, file_get_contents($toAddressFilename)), $toAddress);
    }
    
    $this->toAddress = array_unique(array_map(function($val) {
      return trim(str_replace(' ', '', $val));
    }, $toAddress));
    
    if (!$fromName) {
      $fromName = $this->smarty->getConfigVars('senderFromName');
    }
    $this->fromName = $fromName;
    
    if (!$fromAddress){
      $fromAddress = $this->smarty->getConfigVars('senderFromAddress');
    }
    
    $this->fromAddress = $fromAddress;
    
    if (!$subject) {
      $subject = $this->smarty->getConfigVars('senderSubject');
    }
    $this->subject = $subject;

    if (!$attachments) {
      $attachments = array();
    }
    else if (!is_array($attachments)) {
      $attachments = array($attachments);
    }
    $this->attachments = $attachments;
    
    if ($useMinified === null) {
      $useMinified = $this->smarty->getConfigVars('senderUseMinified');
    }
    
    $this->useMinified = $useMinified;
    
    $this->interval = $interval;
    
    $this->stopOnError = $stopOnError;
  }
  
  protected function setSmarty()
  {
    $smarty = new \Smarty();
    $smarty->setCompileDir(IE_SMARTY_COMPILE_DIR);
    
    $smarty->configLoad(IE_CORE_DIR.'config.conf');
    
    //load optional master config file
    $customConf = IE_CUSTOM_DIR.'config.conf';
    if (file_exists($customConf)) {
      $smarty->configLoad($customConf);
    }

    
    //load project config file
    $configFile = $this->config['configsDir'] . 'config.conf';
    if (file_exists($configFile)) {
      $smarty->configLoad($configFile);
    }
    
    //load script config file
    $configFileScript = $this->config['configsScriptsDir'] . $this->script . '.conf';
    if (file_exists($configFileScript)) {
      $smarty->configLoad($configFileScript);
    }
    
    $this->smarty = $smarty;
  }
  
  protected function configureMailer($content)
  {
    $mail = $this->mailer;
    
    $host = $this->smarty->getConfigVars('senderHost');
    if ($host) {
      $mail->IsSMTP();
      $mail->SMTPAuth = true;
      
      $mail->Host = $host;
      
      $mail->Username = $this->smarty->getConfigVars('senderUser');
      $mail->Password = $this->smarty->getConfigVars('senderPassword');
      
      $secure = $this->smarty->getConfigVars('senderSecure');
      if ($secure)
        $mail->SMTPSecure = $secure;
    }
    else {
      $mail->IsMail();
    }

    //remove verification
    $mail->SMTPOptions = array(
      'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
      )
    );    
    
    $port = $this->smarty->getConfigVars('senderPort');
    if ($port) {
      $mail->Port = $port;
    }
    
    //$mail->SMTPDebug = 1;
    
    $mail->CharSet = $this->smarty->getConfigVars('encoding');

    $mail->From = $this->fromAddress;
    $mail->FromName = $this->fromName;
    
    $mail->IsHTML(true);
      
    //make cids
    $cids = array();
    $i = 1;
    preg_match_all('/\<img.*?src="(.*?)".*?\/?\>/', $content, $imgs);
    foreach ($imgs[1] as $img)
    {
      $fname = $this->config['outputsDir'].(substr($img, 0, 1) == '/' ? substr($img, 1) : $img);
      $pi = pathinfo($img);
      $name = $pi['basename'];
      $cid = 'cid-'.($i++);
      $cids[$fname] = array('fname' => $fname, 'cid' => $cid, 'name' => $name, 'replace' => $img);
    }
    
    foreach ($cids as $c)
    {
      $mail->AddEmbeddedImage($c['fname'], $c['cid'], $c['name']);
      $content = str_replace('src="'.$c['replace'].'"', 'src="cid:'.$c['cid'].'"', $content);
    }

    foreach ($this->attachments as $attachment) {
      $mail->addAttachment($this->config['outputsDir'] . $attachment);
    }
    
    
    $mail->Subject = $this->subject;
    
    $mail->Body = $content;
    
    // if ($randomUrl = $this->smarty->getConfigVars('senderGenerateRandomUnsubscribe'))
    //  $mail->addCustomHeader('List-Unsubscribe: <' . $randomUrl . substr(md5(mt_rand(10000, mt_getrandmax())), 0, 12) . '>');
  }
  
  
  public function run($callbackInit = null, $callback = null)
  {
    $ret = array('error' => false, 'count' => 0, 'message' => '', 'sent' => array(), 'left' => array());

    $file = $this->config['outputsDir'] . $this->script . ($this->useMinified ? '.min' : '') . '.html';
    if ($content = @file_get_contents($file)) {
      
      $this->configureMailer($content);
      
      if ($callbackInit) {
        $callbackInit($this->mailer);
      }
      //file_put_contents($this->config['senderDir'] . 'text.html', $content);
      
      foreach ($this->toAddress as $toAddress) {
        
        $toAddress = trim($toAddress);
        
        if (filter_var($toAddress, FILTER_VALIDATE_EMAIL)) {
          $this->mailer->ClearAddresses();
          $this->mailer->AddAddress($toAddress);
          $message = '';
          
          $ret['count']++;
          if (!$this->mailer->send()) {
            $message = $ret['count'] . ': An error occurred for email: ' . $toAddress.'. Message from PHP Mailer: ' . $this->mailer->ErrorInfo;
            if ($this->stopOnError) {
              $ret['error'] = true;
              $ret['message'] = $message;
              $ret['left'] = array_diff($this->toAddress, $ret['sent']);
              return $ret;
            }
          }
          
          $ret['sent'][] = $toAddress;
          if ($callback)
            $callback($toAddress, $ret['count'], $message);
          
          if ($this->interval)
            usleep($this->interval * 1000);
        }
      }
    }
    
    return $ret;
  }
}
