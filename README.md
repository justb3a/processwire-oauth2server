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

### – get authorization code

**GET**

```zsh
curl 'http://pw.local/authorize/?response_type=code&client_id=testclient&state=xyz'

{"success":true,"message":"SUCCESS! Authorization Code: bf867975b366d0ce1ec25287fba70930c00427c1"}
```

### – get access token using authorization code

**POST**

```zsh
curl -u testclient:testpass http://pw.local/token/ -d 'grant_type=authorization_code&code={insert-code}'

{"access_token":"975610c3807953fd4702218a8746fde0538a54ce","expires_in":3600,"token_type":"Bearer","scope":null,"refresh_token":"55b39b07c2f67368293425dd8bacbc4c29e3c5bb"}
```

### – get access token using client credentials

**POST**

```zsh
curl -u testclient:testpass http://pw.local/token/ -d 'grant_type=client_credentials'

{"access_token":"42bf0bf090a8b367ff8ec7f58698810477aebca3","expires_in":3600,"token_type":"Bearer","scope":null}
```

### – get access token using user credentials 

**POST**

```zsh
curl -u testclient:testpass http://pw.local/token/ -d 'grant_type=password&username={username}&password={password}'

{"access_token":"2f6a8b49f6f1ebd7f04c3f0a5150b4c0194bb940","expires_in":3600,"token_type":"Bearer","scope":null,"refresh_token":"441c78a1468f7b33fcd9f1ae9e823ad075ca64ed"}
```

If your client is public, you can omit the `client_secret` value in the request.
(by default, this is true when no secret is associated with the client in storage)

```zsh
curl http://pw.local/token/ -d 'grant_type=password&client_id=testclient2&username={username}&password={password}'

{"access_token":"70d54567fce4f87de3c64f189e00bf5db76480b8","expires_in":3600,"token_type":"Bearer","scope":null,"refresh_token":"4151fed2080cb6a38e28f74080ae31a776608fb8"}
```

### – use refresh token

**POST**

```zsh
curl -u testclient:testpass http://pw.local/token/ -d 'grant_type=refresh_token&refresh_token={inser-refresh_token}'

{"access_token":"0ad2fd0746b49baee40364298b4f55edfd113efa","expires_in":3600,"token_type":"Bearer","scope":null,"refresh_token":"0c462a784e9bcce436bace2e706960f8f30e8024"}
```

### – validate access token

**POST**

```zsh
curl http://pw.local/validate/ -d 'access_token={your-token}'

{"success":true,"message":"You accessed my APIs!"}
{"error":"invalid_token","error_description":"The access token provided has expired"}
{"error":"invalid_token","error_description":"The access token provided is invalid"}

```

## @TODO:

- remove invalid tokens (authorization_code, refresh and access)
- user login
- user logout: delete access and refresh token
- access token lifetime
- scope handling

