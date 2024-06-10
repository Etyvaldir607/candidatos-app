<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicantRequest;
use App\Http\Requests\UpdateApplicantRequest;
use App\Http\Resources\ApplicantResource;
use App\Models\Applicant;
use App\Models\User;
use App\Repositories\ApplicantRepository;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Models\Role;

class ApplicantsController extends Controller
{

    private $applicantRepositories;

    public function __construct(ApplicantRepository $applicantRepositories)
    {
        $this->applicantRepositories = $applicantRepositories;
        $this->middleware('manager', ['except' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (!auth()->user()->cannot('owner applicant')) {
                return response()->apiResponse(
                    ApplicantResource::collection(
                        $this->applicantRepositories->allWithOwner()
                    )->all()
                );
            } else {
                return response()->apiResponse(
                    ApplicantResource::collection(
                        $this->applicantRepositories->all()
                    )->all()
                );
            }
        } catch (\Exception $e) {
            $status_code = is_integer($e->getCode()) ? $e->getCode() : 500;
            return response()->apiException($e->getMessage(), $status_code);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreApplicantRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApplicantRequest $request)
    {
        try {
            $applicant = new Applicant($request->validated());
            $this->applicantRepositories->save($applicant);
            return response()->apiResponse(
                ApplicantResource::make($applicant)
            , 201);
        } catch (\Exception $e) {
            $status_code = is_integer($e->getCode()) ? $e->getCode() : 500;
            return response()->apiException($e->getMessage(), $status_code);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        try {
            return response()->apiResponse(
                ApplicantResource::make(
                    $this->applicantRepositories->get($id)
                )
            );
        } catch (\Exception $e) {
            $status_code = is_integer($e->getCode()) ? $e->getCode() : 500;
            return response()->apiException($e->getMessage(), $status_code);
        }
    }
}
