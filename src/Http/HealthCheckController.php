<?php
namespace Nagy\HealthChecker\Http;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Nagy\HealthChecker\CheckRunner;

class HealthCheckController extends Controller
{
    /**
     * @var CheckRunner
     */
    private $checkRunner;

    public function __construct(CheckRunner $checkRunner)
    {
        $this->checkRunner = $checkRunner;
    }

    public function index()
    {
        return view('health-checker::dashboard');
    }

    public function getCheckers()
    {
        return  array_keys($this->checkRunner->getCheckers());
    }

    public function run(Request $request, string $name)
    {
        $result = $this->checkRunner->run($name);

        return $result->toArray();
    }

    public function runAll(Request $request)
    {
        $results = $this->checkRunner->runAll();

        return $results;

    }

}
