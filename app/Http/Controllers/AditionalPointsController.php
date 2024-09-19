<?php
 
namespace App\Http\Controllers;

use App\Domains\AditionalPoints\Application\AditionalPointsService;
use Illuminate\Http\Request;
use ReflectionClass;

class AditionalPointsController extends Controller
{
    private $AditionalPointsService;

    public function __construct(AditionalPointsService $AditionalPointsService)
    {
        $this->AditionalPointsService = $AditionalPointsService;
    }

    public function createAditionalPoints(Request $request){
        return $this->AditionalPointsService->createAditionalPoints($request);
    }

    public function getAllAditionalPoints(int $userId){
        return $this->AditionalPointsService->getAllAditionalPoints($userId);
    }

    public function deleteAditionalPoints(string $id){
        return $this->AditionalPointsService->deleteAditionalPoints($id);
    }

}