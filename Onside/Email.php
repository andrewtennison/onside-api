<?php
namespace Onside;

/**
 * Wrapper for Amazon Email Service (AES)
 */
class Email
{
    private $email;
    
    public function __construct($data = array())
    {
	$this->email = $data;
    }
    
    /**
     * @param array $data Data to be used for substitution
     */
    public function sendEmail($data = array())
    {
	// subject
	$this->email['subject'] = $this->replaceWithValues($this->email['subject'], $data);
	
	// plain text part
	$this->email['text'] = $this->replaceWithValues($this->email['text'], $data);
	
	// html part
	$this->email['html'] = $this->replaceWithValues($this->email['html'], $data);
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: website@onside.me' . "\r\n";
	if (!empty($this->email['cc']))
		$headers .= 'Cc: ' . $this->email['cc'] . "\r\n";
	if (!empty($this->email['bcc']))
		$headers .= 'Bcc: ' . $this->email['cc'] . "\r\n";
	
	mail($this->email['to'], $this->email['subject'], $this->email['html'], $headers, '-f');
    }
    
    private function replaceWithValues($field, $data = array())
    {
	preg_match_all('/(|([a-z_]+)|)/', $field, $matches);
	for ($i = 0; $i < count($matches[1]); $i++) {
	    $replace = (isset($data[$matches[2][$i]])) ? $data[$matches[2][$i]] : '';
	    $field = preg_replace('/' . $data[$matches[1][$i]] . '/', $data[$matches[2][$i]], $field);
	}
	
	return $field;
    }
}
