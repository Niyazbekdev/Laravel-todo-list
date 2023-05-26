<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Services\Task\DeleteTask;
use App\Services\Task\GetAllTask;
use App\Services\Task\IsDone;
use App\Services\Task\StoreTask;
use App\Services\Task\UpdateTask;
use Illuminate\Http\Request;
use App\Traits\JsonRespondController;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    use JsonRespondController;
    
    public function index(Request $request){
        try{
            $task = app(GetAllTask::class)->execute($request->all());
            return new TaskCollection($task);
        }catch (ValidationException $exception) {
            return $this->respondValidatorFailed($exception->validator);
        }
    }

    public function store(Request $request){
        try{
            $task = app(StoreTask::class)->execute($request->all());
            return $this->respondSuccess();
        }catch(ValidationException $exception){
            return $this->respondValidatorFailed($exception->validator);
        }
    }

    public function edit(Request $request, string $id){
        try{
            app(IsDone::class)->execute([
                'id' => $id,
                'is_done' => $request->is_done,
            ]);
            return $this->respondSuccess();
        }catch (ValidationException $exception){
            return $this->respondValidatorFailed($exception->validator);
        }catch (ModelNotFoundException){
            return $this->respondNotFound();
        }catch (Exception $exception){
            $this->setHTTPStatusCode($exception->getCode());
            return $this->respondWithError($exception->getMessage());
        }
    }

    public function update(Request $request, string $id){
        try{
            app(UpdateTask::class)->execute([
                'id' => $id,
                'title' => $request->title,
                'description' => $request->description,
            ]);
            return $this->respondSuccess();
        }catch (ValidationException $exception){
            return $this->respondValidatorFailed($exception->validator);
        }catch (ModelNotFoundException){
            return $this->respondNotFound();
        }catch (Exception $exception){
            $this->setHTTPStatusCode($exception->getCode());
            return $this->respondWithError($exception->getMessage());
        }   
    }

    public function destroy(Request $request, string $id){
        try{
            app(DeleteTask::class)->execute([
                'id' => $id,
            ]);
            return $this->respondSuccess();
        }catch (ValidationException $exception){
            return $this->respondValidatorFailed($exception->validator);
        }catch (ModelNotFoundException){
            return $this->respondNotFound();
        }catch (Exception $exception){
            $this->setHTTPStatusCode($exception->getCode());
            return $this->respondWithError($exception->getMessage());
        }
    }
}
