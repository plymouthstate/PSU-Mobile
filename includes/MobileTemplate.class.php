<?php

/*
 * Custom Mobile extensions to the Smarty templating engine
 * @author   Trevor Suarez <tnsuarez@plymouth.edu> *
 *
 */

/*
 * A templating class providing Smarty calls and some custom functionality
 */
class MobileTemplate extends PSUSmarty {
	/** 
      * __construct      *
      * Initial object setup.
      *
      * @param string|boolean $uid_or_auto indicates how cache and template directories should be set. uid specifies a unique id to build names, true generates paths automatically. leave blank or false to specify these paths yourself.
      */
	function __construct($params = null, $uid_or_auto = true) {
		// Call the super/parent classes constructor
		parent::__construct($uid_or_auto);

		if($GLOBALS['TEMPLATES']) $this->template_dir = $GLOBALS['TEMPLATES'];

		// register any custom functions
		$this->register_block('box', array($this, 'psu_box'));
          $this->register_block('jqm_header', array($this, 'jqmobile_header'));
          $this->register_block('jqm_content', array($this, 'jqmobile_content'));
          $this->register_block('jqm_footer', array($this, 'jqmobile_footer'));
		$this->register_function('nav', array($this, 'nav'));
	}

	// Creates a content box
	function psu_box($params, $content, &$smarty, &$repeat) {
		$params['content'] = $content;

		if($params['style']) $params['style'] .= '-box';

		$this->assign('box', $params);
		return $this->fetch('/web/pscpages/webapp/style/templates/box.tpl');
	} // end psu_box
	
	// Creates a navigation list
	function nav($params, &$smarty) {
		$smarty->assign('params', $params);

		$nav = $smarty->fetch('/web/pscpages/webapp/style/templates/nav.tpl');

		return $nav;
	} // end nav

	// Creates a jQuery Mobile header
	function jqmobile_header($params, $content, &$smarty, &$repeat) {
		$params['content'] = $content;

		$this->assign('jqm_header', $params);
		
		return $this->fetch('jqmobile-templates/jqmobile-header.tpl');
	} // end jqmobile-header

	// Creates a jQuery Mobile content
	function jqmobile_content($params, $content, &$smarty, &$repeat) {
		$params['content'] = $content;

		$this->assign('jqm_content', $params);
		
		return $this->fetch('jqmobile-templates/jqmobile-content.tpl');
	} // end jqmobile-content

	// Creates a jQuery Mobile footer
	function jqmobile_footer($params, $content, &$smarty, &$repeat) {
		$params['content'] = $content;

		$this->assign('jqm_footer', $params);
		
		return $this->fetch('jqmobile-templates/jqmobile-footer.tpl');
	} // end jqmobile-footer
}
