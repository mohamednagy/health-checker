<?php
namespace Nagy\HealthChecker;


use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;

class HealthCheckCommand extends Command
{
    /** @var string  */
    protected $signature = 'health:check {name?} {--s|silent}';

    /** @var string  */
    protected $description = 'Run the health check and get the result printed on the console';

    /** @var HealthCheckRunner  */
    private $healthCheckRunner;

    public function __construct(HealthCheckRunner $healthCheckRunner)
    {
        parent::__construct();

        $this->healthCheckRunner = $healthCheckRunner;
    }

    public function handle()
    {
        $isSilent = $this->option('silent');
        $name = $this->argument('name');
        if ($name) {
            $results = $this->healthCheckRunner->run(new HealthChecker($name, config('health-check.checkers.' . $name)));
        } else {
            $results = $this->healthCheckRunner->runAll();
        }

        $results = $results instanceof Collection ? $results : collect($results);

        if ($isSilent != true) {
            $this->displayResult($results);
        }
    }

    private function displayResult(Collection $results)
    {
        $columns = ['name', 'status', 'message'];
        $rows = $results->map( function (Result $result) {
            return collect($result->toArray())
                ->only(['checkerName', 'status', 'message'])
                ->toArray();
        });

        $styledRows = $rows->map( function (array $result) {
            $status = $result['status'];
            $bg = 'green';
            if ($status == Result::ERROR_STATUS) {
                $bg = 'red';
            } elseif ($status == Result::WARNING_STATUS) {
                $bg = 'yellow';
            }
            foreach ($result as &$item) {
                $item = '<fg='.$bg.';>'. $item.'</>';
            }

            return $result;
        });

        $table = new Table($this->output);
        $table->setHeaders($columns);
        foreach ($styledRows as $key => $row) {
            $table->addRow($row);

            if ($key < count($styledRows) -1) {
                $table->addRow(new TableSeparator());
            }
        }

        $table->render();
    }

}
