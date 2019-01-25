<?php

namespace App\Http\Controllers\Api\Contact;

use Illuminate\Http\Request;
use App\Models\Contact\Occupation;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Validation\ValidationException;
use App\Services\Contact\Occupation\CreateOccupation;
use App\Services\Contact\Occupation\UpdateOccupation;
use App\Services\Contact\Occupation\DestroyOccupation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\Occupation\Occupation as OccupationResource;

class ApiOccupationController extends ApiController
{
    /**
     * Get the list of occupations.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $occupations = auth()->user()->account->occupations()
                ->orderBy($this->sort, $this->sortDirection)
                ->paginate($this->getLimitPerPage());
        } catch (QueryException $e) {
            return $this->respondInvalidQuery();
        }

        return OccupationResource::collection($occupations);
    }

    /**
     * Get the detail of a given occupation.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $occupationId)
    {
        try {
            $occupation = Occupation::where('account_id', auth()->user()->account_id)
                ->where('id', $occupationId)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        }

        return new OccupationResource($occupation);
    }

    /**
     * Store the occupation.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $occupation = app(CreateOccupation::class)->execute(
                $request->all()
                    +
                    [
                    'account_id' => auth()->user()->account->id,
                ]
            );
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        } catch (ValidationException $e) {
            return $this->respondValidatorFailed($e->validator);
        } catch (QueryException $e) {
            return $this->respondInvalidQuery();
        }

        return new OccupationResource($occupation);
    }

    /**
     * Update an occupation.
     *
     * @param  Request $request
     * @param  int $occupationId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $occupationId)
    {
        try {
            $occupation = app(UpdateOccupation::class)->execute(
                $request->all()
                    +
                    [
                    'account_id' => auth()->user()->account->id,
                    'occupation_id' => $occupationId,
                ]
            );
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        } catch (ValidationException $e) {
            return $this->respondValidatorFailed($e->validator);
        } catch (QueryException $e) {
            return $this->respondInvalidQuery();
        }

        return new OccupationResource($occupation);
    }

    /**
     * Delete an occupation.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $occupationId)
    {
        try {
            app(DestroyOccupation::class)->execute([
                'account_id' => auth()->user()->account->id,
                'occupation_id' => $occupationId,
            ]);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        } catch (ValidationException $e) {
            return $this->respondValidatorFailed($e->validator);
        } catch (QueryException $e) {
            return $this->respondInvalidQuery();
        }

        return $this->respondObjectDeleted((int) $occupationId);
    }
}
