<?php

namespace App\Repositories;

use App\Models\Applicant;

class ApplicantRepository extends BaseRepository
{
    public function __construct(Applicant $applicant)
    {
        parent::__construct($applicant);
    }

    public function allWithOwner()
    {
        return Applicant::where("owner", "!=", null)->get();
    }
}
