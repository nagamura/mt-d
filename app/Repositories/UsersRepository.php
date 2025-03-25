<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Users;
//use Your Model

/**
 * Class UsersRepository.
 */
class UsersRepository extends BaseRepository
{
    private $usersModel;
    
    public function __construct(Users $usersModel)
    {
        $this->usersModel = $usersModel;
    }
    
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Users::class;
    }

    public function getUsersBySectionId($sectionId)
    {
        $users = $this->usersModel::where('department_sections_id', $sectionId)->get();
        return $users;
    }
}
