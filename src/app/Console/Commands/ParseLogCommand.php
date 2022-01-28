<?php

namespace App\Console\Commands;

use App\Models\Test;
use Illuminate\Console\Command;

class ParseLogCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:parse_log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Log parser';

    public function handle() {
        $this->insertLogData();
//        $baseMemory = memory_get_usage(false);
//        echo PHP_EOL . $baseMemory;
//// create your array
//
//        $a = 1000000; //array('A',1,'B',2);
//
//// how much memory are you using now the array is built
//        echo $finalMemory = memory_get_usage(false);
//        echo PHP_EOL . $finalMemory;
//// the difference is a pretty close approximation
//        echo $arrayMemory = $finalMemory - $baseMemory;
//        echo PHP_EOL . $arrayMemory;
//        debug_zval_dump($a);
//        die;
//        try {
//            $tests = Test::query()->whereBetween('id', [34, 76033])->get('id')->all();
//            var_dump($tests);die;
//        } catch (\Throwable $e) {
//            var_dump($e->getMessage());die;
//        }
    }

    public function insertLogData()
    {
        for ($i = 0; $i < 1; $i++) {
            $handle = @fopen("test.log", "r");
            if ($handle) {
                $data = [];
                $i = 0;
                while (($buffer = fgets($handle)) !== false) {
                    $data[] = $this->parseRow($buffer);
//                    $test = new Test($data);
//                    $test->save();
                    $i++;
                    if (count($data) >= 1000) {
                        Test::insert($data);
                        $data = [];
                        echo PHP_EOL . $i;
                    }
                }

                Test::insert($data);

                echo PHP_EOL . $i;

                if (!feof($handle)) {
                    echo "Ошибка: fgets() неожиданно потерпел неудачу\n";
                }
                fclose($handle);
            }
        }
    }

    /**
     * @param string $row
     * @return array
     */
    public function parseRow(string $row): array
    {
        $paramsRow = '';
        $json = '';

        for ($i = 0; $i < strlen($row); $i++) {
            if ($row[$i] === '"') {
                continue;
            }

            if ($row[$i] === '{') {
                $json = substr($row, $i, strlen($row) - $i);
                break;
            }

            $paramsRow .= $row[$i];
        }


        $params = explode(',', $paramsRow);
        $requestParams = json_decode($json, true);
        $responseContent = isset($requestParams['response']) ? (is_array($requestParams['response'])
            ? json_encode($requestParams['response'])
            : $requestParams['response']) : '';

        var_dump($params);
        return [
            'date' => $params[0],
            'type' => $params[1],
            'name' => $params[2],
            'method' => $params[3],
            'user_id' => $params[4],
            'request' => $requestParams['request'],
            'options' => json_encode($requestParams['options']),
            'status_code' => $requestParams['statusCode'] ?? 0,
            'response' => $responseContent,
        ];
    }
}
