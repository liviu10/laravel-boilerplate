<?php

namespace App\BusinessLogic\Interfaces;

interface UserInterface
{
    /**
     * Fetch current authenticated user.
     * @return \Illuminate\Http\Response
     */
    // TODO: Improve this when finishing with the login system
    // public function handleCurrentAuthUser();

    public function handleStatisticalIndicators(): array;
}
