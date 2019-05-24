Identity login
==============

Installation
------------

```sh
$ composer require geniv/nette-identity-login
```
or
```json
"geniv/nette-identity-login": "^1.1"
```

require:
```json
"php": ">=7.0",
"nette/application": ">=2.4",
"nette/di": ">=2.4",
"nette/security": ">=2.4",
"nette/utils": ">=2.4",
"geniv/nette-general-form": ">=1.0"
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
protected function createComponentIdentityLogin(ILoginForm $loginForm): ILoginForm
{
    //$loginForm->setTemplatePath(__DIR__ . '/templates/LoginForm.latte');
    $loginForm->onLoggedIn[] = function (User $user) {
        $this->flashMessage('Login!', 'info');
    };
    $loginForm->onAfterLoggedIn[] = function (User $user) {
        $this->redirect('this');
    };
    $loginForm->onLoggedInException[] = function (AuthenticationException $e) {
        $this->flashMessage('Login exception! ' . $e->getMessage(), 'danger');
    };
    $loginForm->onLoggedOut[] = function (User $user) {
        $this->flashMessage('Logout!', 'info');
    };
    $loginForm->onAfterLoggedOut[] = function (User $user) {
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
