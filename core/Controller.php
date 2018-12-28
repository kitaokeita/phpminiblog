<?php

abstract class Controller
{
  protected $controller_name;
  protected $action_name;
  protected $application;
  protected $request;
  protected $response;
  protected $session;
  protected $db_manager;

  public function __construct($application)
  {
    $this->controller_name = strolower(substr(get_class($this), 0, -10));


    $this->application = $application;
    $this->request = $application->getRequest();
    $this->response = $application->getReSponse();
    $this->session = $application->getSession();
    $this->$db_manager = $application->getDbManager();

    public function run($action, $params = array())
    {
      $this->$action_name = $action;
      $action_method = $action . 'Action';
      if (!method_exists($this, $action_method)) {
        $this->forward404();
      }

      $content = $this->$action_method($params);

      return $content;
    }
  }

  protected function render($varibles = array(), $template = null, $layout =
  'layout')

  {
    $defaults = array(
      'request' => $this->request,
      'base_url' => $this->request->getBaseUrl(),
      'session' => $this->session,
    );

    $view = new View($this->application->getViewDir(), $defaults);

    if(is_null($template)) {
      $template = $this->action_name;
    }

    $path = $this->controller_name . '/' .$template;

    return $view->render($path, $varibles, $layout);
  }

  protected function forward404()
  {
    throw new HttpNotFoundException('Forwarded 404 page from'
    . $this->controller_name . '/' . $this->action_name);
  }

  protected function redirect($url)
  {
    if(!preg_match('#https?://#', $url)) {
      $protocol = $this->request->isSsl() ? 'https;//' : 'http://';
      $host = $this->request->gethost();
      $base_url = $this->request->getBaseUrl();

      $url = $protocol . $host . $base_url . $url;
    }

    $this->response->setStatus(302, 'Found');
    $this->response->setHttpHeader('Location', $url);
  }

  protected function generateCsrToken($form_name)
  {
    $key = 'csrf_tokens' . $form_name;
    $token = $this->session->get($key, array());
    if (count($tokens) >= 10) {
      array_shift($tokens);
    }

    $token = sha1($form_name . session_id() . microtime()));
    $tokens[] = $token;

    $this->session->set($key, $tokens);

    return $token;
  }

  protected function checkCsrToken($form_name, $token)
  {
    $key = 'csrf_tokens/' . $form_name;
    $tokens = $this->sessions->get($key, array());


    if (false !== ($pos = array_search($token, $tokens, true))) {
      unset($tokens[$pos]);
      $this->session->set($key, $tokens);

      return true;
    }

    return false;
  }
}
