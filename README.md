Identity login
==============

Installation
------------

```sh
$ composer require geniv/nette-identity-login
```
or
```json
"geniv/nette-identity-login": ">=1.0.0"
```

require:
```json
"php": ">=7.0.0",
"nette/nette": ">=2.4.0",
"geniv/nette-general-form": ">=1.0.0"
```

Include in application
----------------------

neon configure:
```neon
# identity login
identityLogin:
#   autowired: true
#   formContainer: Identity\Login\FormContainer
```

neon configure extension:
```neon
extensions:
    identityLogin: Identity\Login\Bridges\Nette\Extension
```

presenters:
```php
protected function createComponentIdentityLogin(LoginForm $loginForm): LoginForm
{
    //$loginForm->setTemplatePath(__DIR__ . '/templates/LoginForm.latte');
    $loginForm->onLoggedIn[] = function (User $user) {
        $this->flashMessage('Login!', 'info');
        $this->redirect('this');
    };
    $loginForm->onLoggedInException[] = function (AuthenticationException $e) {
        $this->flashMessage('Login exception! ' . $e->getMessage(), 'danger');
    };
    $loginForm->onLoggedOut[] = function (User $user) {
        $this->flashMessage('Logout!', 'info');
        $this->redirect('this');
    };
    return $loginForm;
}
```

usage:
```latte
    {if !$user->isLoggedIn()}
        {control identityLogin}
    {else}
        <a n:href="identityLogin:Out!">Logout</a>
    {/if}
```
