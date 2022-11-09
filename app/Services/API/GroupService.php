<?php
namespace App\Services\API;

use App\Http\Resources\groupResource;
use App\Repositories\API\GroupRepository;

class GroupService{

    protected $postRepository;
    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }


}

