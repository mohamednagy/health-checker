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

    /** @var CheckService  */
    private $checkService;

    public function __construct(CheckService $checkService)
    {
        parent::__construct();

        $this->checkService = $checkService;
    }

    public function handle()
    {
        $isSilent = $this->option('silent');
        $name = $this->argument('name');
        if ($name) {
            $results = collect([$this->checkService->run($name)]);
        } else{
            $results = $this->checkService->runAll();
        }

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
