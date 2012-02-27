<?php
namespace Onside;

/**
 * Wrapper for Amazon Email Service (AES)
 */
class Email
{
    private $template;

    public function __construct(\Onside\Model\Email $template)
    {
	$this->template = $template;
    }

    /**
     * @param array $data Data to be used for substitution
     */
    public function sendEmail(array $data = array())
    {
	// subject
	$this->template->subject = $this->replaceWithValues($this->template->subject, $data);

	// plain text part
	$this->template->text = $this->replaceWithValues($this->template->text, $data);

	// html part
	$this->template->html = $this->replaceWithValues($this->template->html, $data);

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/plain; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: please.reply@onside.me' . "\r\n";
	if (!empty($this->template->cc))
		$headers .= 'Cc: ' . $this->template->cc . "\r\n";
	if (!empty($this->template->bcc))
		$headers .= 'Bcc: ' . $this->template->bcc . "\r\n";

	mail($this->template->to, $this->template->subject, $this->template->text, $headers, '-fwebsite@onside.me');
    }

    private function replaceWithValues($field, array $data = array())
    {
	preg_match_all('/\|([a-z_]+)\|/', $field, $matches);
	for ($i = 0; $i < count($matches[1]); $i++) {
	    $replace = (isset($data[$matches[1][$i]])) ? $data[$matches[1][$i]] : '';
	    $field = preg_replace('/\|' . $matches[1][$i] . '\|/', $replace, $field);
	}

	return $field;
    }
}
