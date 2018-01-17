# ProcessWire Oauth2Server

Integration of Brent Shaffer's [oauth2-server-php](https://github.com/bshaffer/oauth2-server-php) into ProcessWire 3.

**Work in progress! Do not use in production!**

## Installation

1. Install the module, it'll create some tables.
2. Add the client directly to the database (table **oauth_clients**) *@maybe: set later via module settings?* 
3. Add necessary templates
    - settings:
        - set **Content-Type** to `application/json` 
        - disable automatic prepend and append file (tab *Files*)
    - templates:
        - token
        - authorize
        - validate
4. Create a page for each template.

### Template content

*@maybe: create templates and pages during installation progress*

**authorize.php**

```php
echo $modules->get('Oauth2Server')->getAuthorizationCode();
```

**token.php**

```php
$modules->get('Oauth2Server')->getAccessToken();
```

**validate.php**

```php
echo $modules->get('Oauth2Server')->validateAccessToken();
```


## Examples

*@see:* [Cookbook](http://bshaffer.github.io/oauth2-server-php-docs/cookbook/)

**Assumptions:**

| key           | value             |
|---------------|-------------------|
| base-url      | `http://pw.local` |
| client_id     | `testclient`      |
| client_secret | `testpass`        |
| state         | `xyz`             |

### get authorization code

**GET**

```json
curl 'http://pw.local/authorize/?response_type=code&client_id=testclient&state=xyz'

{"success":true,"message":"SUCCESS! Authorization Code: bf867975b366d0ce1ec25287fba70930c00427c1"}
```

### get access token using authorization code

**POST**

```json
curl -u testclient:testpass http://pw.local/token/ -d 'grant_type=authorization_code&code={insert-code}'

{"access_token":"975610c3807953fd4702218a8746fde0538a54ce","expires_in":3600,"token_type":"Bearer","scope":null,"refresh_token":"55b39b07c2f67368293425dd8bacbc4c29e3c5bb"}
```

### use refresh token

**POST**

```json
curl -u testclient:testpass http://pw.local/token/ -d 'grant_type=refresh_token&refresh_token={inser-refresh_token}'

{"access_token":"0ad2fd0746b49baee40364298b4f55edfd113efa","expires_in":3600,"token_type":"Bearer","scope":null,"refresh_token":"0c462a784e9bcce436bace2e706960f8f30e8024"}
```

## @TODO:

- use refresh token
- remove invalid tokens (refresh and access)
- use grant_type user_credentials
- user login: get authorization_code, get access_token, send login credentials, update access_token add user_id
- user logout: delete access and refresh token

