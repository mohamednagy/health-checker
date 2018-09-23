<?php
namespace Nagy\HealthChecker\Http;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Nagy\HealthChecker\CheckService;

class HealthCheckController extends Controller
{
    /**
     * @var CheckService
     */
    private $checkService;

    public function __construct(CheckService $checkService)
    {
        $this->checkService = $checkService;
    }

    public function index()
    {
        return view('health-check::dashboard');
    }

    public function getCheckers()
    {
        return  array_keys($this->checkService->getCheckers());
    }

    public function run(Request $request, string $name)
    {
        $result = $this->checkService->run($name);

        return $result->toArray();
    }

    public function runAll(Request $request)
    {
        $results = $this->checkService->runAll();

        return $results;

    }

}
