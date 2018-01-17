# ProcessWire Oauth2Server

Integration of Brent Shaffer's [oauth2-server-php](https://github.com/bshaffer/oauth2-server-php) into ProcessWire 3.

**Work in progrss! Do not use in production!**

## Installation

1. Install the module, it'll create some tables.
2. Add the client directly to the database (table **oauth_clients**) *@maybe: set later via module settings?* 
3. Add necessary templates, set **Content-Type** to `application/json` and disable automatic prepend and append file (tab *Files*):
    - token
    - authorize
    - validate
4. Create a page for each template.

### Template content

*@maybe: create templates and pages during installation progress*

**authorize.php**

```
echo $modules->get('Oauth2Server')->getAuthorizationCode();
```

**token.php**

```
$modules->get('Oauth2Server')->getAccessToken();
```

**validate.php**

```
echo $modules->get('Oauth2Server')->validateAccessToken();
```


## Examples

*@see:* [Cookbook](http://bshaffer.github.io/oauth2-server-php-docs/cookbook/)

**Assumptions:**

- base-url: `http://pw.local`
- client_id: `testclient`
- client_secret: `testpass`
- state: `xyz`

### get authorization code

**GET**

```
curl 'http://pw.local/authorize/?response_type=code&client_id=testclient&state=xyz'
```

### get access token using authorization code

**POST**

```
curl -u testclient:testpass http://pw.local/token/ -d 'grant_type=authorization_code&code={insert-code}'
```

### use refresh token

**POST**

```
curl -u testclient:testpass http://pw.local/token/ -d 'grant_type=refresh_token&refresh_token={inser-refresh_token}'
```

## @TODO:

- use refresh token
- remove invalid tokens (refresh and access)
- use grant_type user_credentials
- user login: get authorization_code, get access_token, send login credentials, update access_token add user_id
- user logout: delete access and refresh token

