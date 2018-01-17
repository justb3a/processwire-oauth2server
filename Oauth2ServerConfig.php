<?php namespace ProcessWire;

/**
 * Class Oauth2ServerConfig
 */
class Oauth2ServerConfig extends ModuleConfig {

  /**
   * array Default config values
   */
  public function getDefaults() {
    return array(
      // 'clientId' => '',
      // 'clientSecret' => '',
      // 'redirectPage' => '',
      // 'state' => '',
      'allowedGrantTypes' => array(),
      'expirationTime' => '86400',
    );
  }

  /**
   * array Default config values
   */
  public function getOptions() {
    return array(
      'user_credentials' => $this->_('User Credentials'),
      'client_credentials' => $this->_('Client Credentials'),
      'refresh_token' => $this->_('Refresh Token'),
      'authorization_code' => $this->_('Authorization Code')
    );
  }

  /**
   * Retrieves the list of config input fields
   * Implementation of the ConfigurableModule interface
   *
   * @return InputfieldWrapper
   */
  public function getInputfields() {
    $inputfields = parent::getInputfields();

    // // field app ID
    // $field = $this->modules->get('InputfieldText');
    // $field->name = 'clientId';
    // $field->label = __('Client ID');
    // $field->columnWidth = 50;
    // // $field->required = 1;
    // $inputfields->add($field);

    // // field app secret
    // $field = $this->modules->get('InputfieldText');
    // $field->name = 'clientSecret';
    // $field->label = __('Client Secret');
    // $field->columnWidth = 50;
    // // $field->required = 1;
    // $inputfields->add($field);

    // // field redirectPage
    // $field = $this->modules->get('InputfieldPageListSelect');
    // $field->name = 'redirectPage';
    // $field->label = __('Redirect to a specific page after getting authorization token.');
    // $field->columnWidth = 50;
    // // $field->required = 1;
    // $inputfields->add($field);

    // field state
    // $field = $this->modules->get('InputfieldText');
    // $field->name = 'state';
    // $field->label = __('State');
    // $field->columnWidth = 50;
    // $field->required = 1;
    // $inputfields->add($field);

    // expirationTime
    $field = $this->modules->get('InputfieldInteger');
    $field->name = 'expirationTime';
    $field->label = __('Access Token Expiration Time');
    $field->description = __('If the access token is expired, we\'ll need to send the user through the authorization process again.');
    $field->notes = __('- in seconds -');
    $field->required = 1;
    $field->columnWidth = 50;
    $inputfields->add($field);

    $field = $this->modules->get('InputfieldAsmSelect');
    $field->attr('name', 'allowedGrantTypes');
    $field->label = $this->_('Which grant types should be added.');
    $field->description = __('If nothing is selected, all grant types are allowed.');
    $field->addOptions($this->getOptions());
    $inputfields->add($field);

    return $inputfields;
  }

}
