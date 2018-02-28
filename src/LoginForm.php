<?php declare(strict_types=1);

namespace Identity\Login;

use GeneralForm\EventContainer;
use GeneralForm\IEventContainer;
use GeneralForm\IFormContainer;
use GeneralForm\ITemplatePath;
use Nette\Application\UI\Form;
use Nette\Localization\ITranslator;
use Nette\Application\UI\Control;


/**
 * Class LoginForm
 *
 * @author  geniv
 * @package Identity\Login
 */
class LoginForm extends Control implements ITemplatePath
{
    /** @var IFormContainer */
    private $formContainer;
    /** @var IEventContainer */
    private $eventContainer;
    /** @var ITranslator */
    private $translator;
    /** @var string */
    private $templatePath;
    /** @var callback */
    public $onLoggedIn, $onLoggedInException, $onLoggedOut;


    /**
     * LoginForm constructor.
     *
     * @param IFormContainer   $formContainer
     * @param array            $events
     * @param ITranslator|null $translator
     */
    public function __construct(IFormContainer $formContainer, array $events, ITranslator $translator = null)
    {
        parent::__construct();

        $this->formContainer = $formContainer;
        $this->eventContainer = EventContainer::factory($this, $events);
        $this->translator = $translator;

        $this->templatePath = __DIR__ . '/LoginForm.latte'; // set path
    }


    /**
     * Set template path.
     *
     * @param string $path
     */
    public function setTemplatePath(string $path)
    {
        $this->templatePath = $path;
    }


    /**
     * Render.
     */
    public function render()
    {
        $template = $this->getTemplate();

        $template->setTranslator($this->translator);
        $template->setFile($this->templatePath);
        $template->render();
    }


    /**
     * Create component form.
     *
     * @param string $name
     * @return Form
     */
    protected function createComponentForm(string $name): Form
    {
        $form = new Form($this, $name);
        $form->setTranslator($this->translator);
        $this->formContainer->getForm($form);

        $form->onSuccess[] = $this->eventContainer;
        return $form;
    }


    /**
     * Handle out.
     */
    public function handleOut()
    {
        $user = $this->getPresenter()->getUser();
        $user->logout(true);
        if (!$user->isLoggedIn()) {
            $this->onLoggedOut($user);  // logout callback
        }
    }
}
