<?php declare(strict_types=1);

namespace Identity\Login\Bridges\Nette;

use GeneralForm\GeneralForm;
use Identity\Authenticator\Drivers\CombineDriver;
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
        'driver'        => null,
        'formContainer' => FormContainer::class,
        'events'        => [],
    ];


    /**
     * Load configuration.
     */
    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();
        $config = $this->validateConfig($this->defaults);

        $formContainer = GeneralForm::getDefinitionFormContainer($this);
        $events = GeneralForm::getDefinitionEventContainer($this);

        // define form
        $builder->addDefinition($this->prefix('form'))
            ->setFactory(LoginForm::class, [$formContainer, $events])
            ->setAutowired($config['autowired']);

        // special way for combine driver
        if ($config['driver']->getEntity() == CombineDriver::class) {
            foreach ($config['driver']->arguments[0] as $index => $argument) {
                $builder->addDefinition($this->prefix('driver.' . $index))
                    ->setFactory($argument)
                    ->setAutowired('self');
            }
        }

        $builder->addDefinition($this->prefix('driver'))
            ->setFactory($config['driver'])
            ->setAutowired($config['autowired']);
    }
}
