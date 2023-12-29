<?php

namespace App\BusinessLogic\Services;

use App\BusinessLogic\Interfaces\ReportInterface;
use App\Utilities\ApiResponse;
use App\Utilities\ApiCheckPermission;
use App\Utilities\ApiResourcePermission;
use App\Utilities\Actions;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

use App\Models\AcceptedDomain;

class ReportService implements ReportInterface
{
    protected $apiResponse;
    protected $checkPermission;
    protected $resourcePermissions;

    /**
     * Create a new instance of the service class.
     * This constructor initializes the service with the necessary dependencies.
     */
    public function __construct()
    {
        $this->apiResponse = new ApiResponse();
        $this->checkPermission = new ApiCheckPermission();
        $this->resourcePermissions = new ApiResourcePermission();
    }

    /**
     * Handle the GET request to retrieve reports.
     * @param array $options An array of options for reports retrieval.
     * @return Response|ResponseFactory The HTTP response or response factory.
     */
    public function handleGetReport(array $options): Response|ResponseFactory
    {
        if ($this->checkPermission->handleApiCheckPermission()) {
            $modelClassName = 'App\Models\\' . $options['resource'];
            $modelInstance = new $modelClassName();
            dd('aici', $modelInstance->getTableName());

            // TODO: use

            $apiDisplayAllRecords = $this->apiResponse->generateApiResponse(
                $instanceQuery,
                Actions::get
            );

            return $apiDisplayAllRecords;
        } else {
            return $this->apiResponse->generateApiResponse(null, Actions::forbidden);
        }
    }
}
