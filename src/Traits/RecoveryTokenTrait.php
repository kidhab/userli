<?php

namespace App\Traits;

/**
 * @author doobry <doobry@systemli.org>
 */
trait RecoveryTokenTrait
{
    /**
     * @var string|null
     */
    private $recoveryToken;

    /**
     * @return string|null
     */
    public function getRecoveryToken(): ?string
    {
        return $this->recoveryToken;
    }

    /**
     * @param string $recoveryToken
     */
    public function setRecoveryToken($recoveryToken)
    {
        $this->recoveryToken = $recoveryToken;
    }
}
