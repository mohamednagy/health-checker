<?php
namespace Nagy\HealthChecker;


use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Helper\Table;

class HealthCheckCommand extends Command
{
    /** @var string  */
    protected $signature = 'health:check {name?} {--s|silent}';

    /** @var string  */
    protected $description = 'Run the health check and get the result printed on the console';

    /** @var CheckRunner  */
    private $checkRunner;

    public function __construct(CheckRunner $checkRunner)
    {
        parent::__construct();

        $this->checkRunner = $checkRunner;
    }

    public function handle()
    {
        $isSilent = $this->option('silent');
        $name = $this->argument('name');
        if ($name) {
            $results = collect($this->checkRunner->run($name));
        } else{
            $results = $this->checkRunner->runAll();
        }

        if ($isSilent != true) {
            $this->displayResult($results);
        }
    }

    private function displayResult(Collection $results)
    {
        $columns = ['name', 'type', 'message'];
        $rows = $results->map( function (Result $result) {
            return collect($result->toArray())
                ->only(['checkerName', 'type', 'message'])
                ->toArray();
        });

        $styledRows = $rows->map( function (array $result) {
            $type = $result['type'];
            $bg = 'green';
            if ($type == Result::ERROR_STATUS) {
                $bg = 'red';
            } elseif ($type == Result::WARNING_STATUS) {
                $bg = 'yellow';
            }
            foreach ($result as &$item) {
                $item = '<bg='.$bg.';>'. $item.'</>';
            }

            return $result;
        });

        $this->table($columns, $styledRows);
    }

}
