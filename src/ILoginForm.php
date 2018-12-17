<?php declare(strict_types=1);

namespace Identity\Login;

use GeneralForm\ITemplatePath;


/**
 * Interface ILoginForm
 *
 * @author  geniv
 * @package Identity\Login
 */
interface ILoginForm extends ITemplatePath
{

    /**
     * Handle out.
     */
    public function handleOut();
}
