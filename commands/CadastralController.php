<?php


namespace alhimik1986\bftcadastral\commands;

use Exception;
use app\modules\cadastral\services\CadastralMap;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\console\widgets\Table;

class CadastralController extends Controller
{
    /**
     * @param string $cadastralNumbers
     * @return int
     * @throws Exception
     */
    public function actionIndex($cadastralNumbers)
    {
        $cadMap = new CadastralMap();
        $cadastralData = $cadMap->getDataByCadNumbers($cadastralNumbers);
        $rows = [];
        foreach($cadastralData as $cadastral) {
            $rows[] = [
                $cadastral->cadastral_number,
                $cadastral->address,
                $cadastral->price,
                $cadastral->area,
            ];
        }
        $rows = empty($rows) ? [['', '', '', '']] : $rows;
        echo Table::widget([
            'headers' => ['Cadastral Number', 'Address', 'Price', 'Area'],
            'rows' => $rows,
        ]);

        return ExitCode::OK;
    }
}