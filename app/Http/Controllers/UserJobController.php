<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserJob;
use Illuminate\Http\Request;
use Illuminate\Http\Response; // Import Response class
use App\Traits\ApiResponser; // Import ApiResponser trait

class UserJobController extends Controller
{
    // Use ApiResponser trait
    use ApiResponser;

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Add a new user
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        // Validation rules
        $rules = [
            'username' => 'required|max:20',
            'password' => 'required|max:20',
            'gender' => 'required|in:Male,Female',
            'jobid' => 'required|numeric|min:1|not_in:0',
        ];

        // Validate the request data
        $this->validate($request, $rules);

        // Check if the specified job ID exists in the UserJob table
        $userJob = UserJob::findOrFail($request->jobid);

        // Create a new user
        $user = User::create($request->all());

        // Return success response
        return $this->successResponse($user, Response::HTTP_CREATED);
    }

    /**
     * Update an existing user
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validation rules
        $rules = [
            'username' => 'max:20',
            'password' => 'max:20',
            'gender' => 'in:Male,Female',
            'jobid' => 'required|numeric|min:1|not_in:0',
        ];

        // Validate the request data
        $this->validate($request, $rules);

        // Check if the specified job ID exists in the UserJob table
        $userJob = UserJob::findOrFail($request->jobid);

        // Find the user by ID
        $user = User::findOrFail($id);

        // Fill the user with the request data
        $user->fill($request->all());

        // Check if any changes occurred
        if ($user->isClean()) {
            // If no changes happened, return an error response
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Save the updated user
        $user->save();

        // Return success response
        return $this->successResponse($user);
    }
}
