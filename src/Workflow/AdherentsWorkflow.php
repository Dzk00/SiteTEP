<?php

declare(strict_types=1);

namespace App\Workflow;

use App\Entity\Adherents;
use Symfony\Component\Workflow\WorkflowInterface;

final class AdherentsWorkflow
{
    public const TRANSITION_VALIDATE = 'validate';

    private WorkflowInterface $adherentsStateMachine;

    public function __construct(WorkflowInterface $adherentsStateMachine)
    {
        $this->adherentsStateMachine = $adherentsStateMachine;
    }

    public function canValidate(Adherents $adherents): bool
    {
        return $this->adherentsStateMachine->can($adherents, self::TRANSITION_VALIDATE);
    }

    public function validate(Adherents $adherents): void
    {
        if (!$this->adherentsStateMachine->can($adherents, self::TRANSITION_VALIDATE)) {
            throw new \LogicException("Can't apply the 'validate' transition on user n°{$adherents->getId()}°, current state: '{$adherents->getState()}'.");
        }

        $this->adherentsStateMachine->apply($adherents, self::TRANSITION_VALIDATE);
    }
}