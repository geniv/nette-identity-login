<?php declare(strict_types=1);

namespace Identity\Login;


use GeneralForm\IFormContainer;
use Nette\Application\UI\Form;
use Nette\SmartObject;


/**
 * Class FormContainer
 *
 * @author  geniv
 * @package Identity\Login
 */
class FormContainer implements IFormContainer
{
    use SmartObject;


    /**
     * Get form.
     *
     * @param Form $form
     */
    public function getForm(Form $form)
    {
        $form->addText('username', 'login-form-username')
            ->setRequired('login-form-username-required');

        $form->addPassword('password', 'login-form-password')
            ->setRequired('login-form-password-required');

        $form->addSubmit('send', 'login-form-send');
    }
}
