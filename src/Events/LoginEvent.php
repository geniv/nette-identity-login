<?php declare(strict_types=1);

namespace Identity\Login\Events;

use GeneralForm\IEvent;
use GeneralForm\IEventContainer;
use Nette\Security\AuthenticationException;


/**
 * Class LoginEvent
 *
 * @author  geniv
 * @package Identity\Login\Events
 */
class LoginEvent implements IEvent
{

    /**
     * Update.
     *
     * @param IEventContainer $eventContainer
     * @param array           $values
     */
    public function update(IEventContainer $eventContainer, array $values)
    {
        try {
            $user = $eventContainer->getComponent()->getPresenter()->getUser();

            $user->login($values['username'], $values['password']);
            $eventContainer->getComponent()->onLoggedIn($user); // success callback

        } catch (AuthenticationException $e) {
            $eventContainer->getComponent()->onLoggedInException($e); // exception callback
        }
    }
}
