<?php declare(strict_types=1);

namespace Identity\Login\Bridges\Nette;

use GeneralForm\GeneralForm;
use Identity\Login\FormContainer;
use Identity\Login\LoginForm;
use Nette\DI\CompilerExtension;


/**
 * Class Extension
 *
 * @author  geniv
 * @package Identity\Login\Bridges\Nette
 */
class Extension extends CompilerExtension
{
    /** @var array default values */
    private $defaults = [
        'autowired'     => true,
        'formContainer' => FormContainer::class,
    ];


    /**
     * Load configuration.
     */
    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();
        $config = $this->validateConfig($this->defaults);

        $formContainer = GeneralForm::getDefinitionFormContainer($this);

        // define form
        $builder->addDefinition($this->prefix('form'))
            ->setFactory(LoginForm::class, [$formContainer])
            ->setAutowired($config['autowired']);
    }
}
