<?php
/**
*
* @package Messageboard
* @copyright (c) 2015 Baie BV
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace messageboard\quickLanguage\event;

/**
* Event listener
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	/**
	* Instead of using "global $user;" in the function, we use dependencies again.
	*/
	public function __construct(\phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user)
	{
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		
		$this->user->add_lang_ext('messageboard/quickLanguage', 'common');
	}
	
	static public function getSubscribedEvents()
	{
		return array(
			'core.page_header_after'				=> 'generate_language_box',
		);
	}
	
	public function generate_language_box($event)
	{
		if($this->user->data['user_id'] == ANONYMOUS)
		{
			$this->template->assign_vars(array(
				'S_QL_HIDDEN_FIELDS'	=> build_hidden_fields($this->request->get_super_global(\phpbb\request\request_interface::GET)),
				'S_QL_LANG_OPTIONS'		=> language_select($this->user->lang_name),
			));
		}
	}
	
}