<?php

/**
 * This performs an automatic login with the configured credentials.
 *
 * @license GNU GPLv3+
 */
class singleuserautologin extends rcube_plugin
{
  public $task = 'login';

  function init()
  {
    $this->load_config();

    $this->add_hook('startup', array($this, 'startup'));
    $this->add_hook('authenticate', array($this, 'authenticate'));
  }

  function startup($args)
  {
    // change action to login
    if (empty($_SESSION['user_id']) && !empty($_GET['_autologin']))
      $args['action'] = 'login';

    return $args;
  }

  function authenticate($args)
  {
    if (!empty($_GET['_autologin'])) {
      $args['user'] = $this->get_config('username');
      $args['pass'] = $this->get_config('password');
      $args['cookiecheck'] = false;
      $args['valid'] = true;
    }

    return $args;
  }

  protected function get_config($key)
  {
    $rcmail = rcube::get_instance();

    return $rcmail->config->get(sprintf('singleuserautologin_%s', $key));
  }
}
