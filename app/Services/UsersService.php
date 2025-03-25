<?php

namespace App\Services;

use App\Repositories\UsersRepository;

/**
 * Class UsersService.
 */
class UsersService
{
    private $usersRepos;

    public function __construct(UsersRepository $usersRepos)
    {
        $this->usersRepos = $usersRepos;
    }

    public function getUsersBySectionId($sectionId)
    {
        $users = $this->usersRepos->getUsersBySectionId($sectionId);
        
        return $users;
    }
}
