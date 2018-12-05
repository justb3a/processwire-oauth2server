<?php namespace ProcessWire;

require(/*NoCompile*/__DIR__ . '/vendor/autoload.php');

use \OAuth2\Storage\Pdo as Storage;

/**
 * Class PdoStorage
 */
class PdoStorage extends Storage {

  /**
   * construct
   */
  public function __construct() {
    $this->db = wire('database');

    $this->config = array(
      'client_table' => 'oauth_clients',
      'access_token_table' => 'oauth_access_tokens',
      'refresh_token_table' => 'oauth_refresh_tokens',
      'code_table' => 'oauth_authorization_codes',
      'scope_table'  => 'oauth_scopes'
    );
  }

  /**
    * @param string $usernameOrId
    * @return array|bool
    */
  public function getUser($usernameOrId) {
    $user = wire('users')->get("name=$usernameOrId");

    return ($user instanceof NullPage || $user->status == Page::statusHidden) ? false : $user;
  }

  /**
   * plaintext passwords are bad!  Override this for your application
   *
   * @param string $username
   * @param string $password
   * @param string $firstName
   * @param string $lastName
   * @return bool
   */
  public function setUser($username, $password, $firstName = null, $lastName = null) {
    // only for testing purposes
    return array();
  }

  /**
   * plaintext passwords are bad!  Override this for your application
   *
   * @param array $user
   * @param string $password
   * @return bool
   */
  protected function checkPassword($user, $password) {
    return wire('session')->authenticate($user, $password);
  }

  /**
   * @param string $username
   * @return array|bool
   */
  public function getUserDetails($username) {
    $user = $this->getUser($username);

    return array(
      'user_id' => $user->id,
      'username' => $user->name,
      'email' => $user->email
    );
  }

}
