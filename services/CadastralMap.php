<?php


namespace alhimik1986\bftcadastral\services;

use alhimik1986\bftcadastral\models\Cadastral;
use Exception;

class CadastralMap
{
    private $url = 'https://pkk5.rosreestr.ru/api/features/1/';

    /**
     * @param string $cadNumbers Список кадастровых номеров через запятую
     * @param bool $asArray
     * @return Cadastral[]
     * @throws Exception
     */
    public function getDataByCadNumbers(string $cadNumbers, bool $asArray=false): array
    {
        $arrCadNumbers = explode(',', $cadNumbers);
        $result = [];
        foreach($arrCadNumbers as $dirtyCadNumber) {
            $cadNumber = trim($dirtyCadNumber);
            $data = $this->getDataByCadNumber($cadNumber, $asArray);
            if ($data) {
                $result[$cadNumber] = $data;
            }
        }

        return $result;
    }

    /**
     * @param string $cadNumber
     * @param bool $asArray
     * @return Cadastral|array|null
     * @throws Exception
     */
    public function getDataByCadNumber(string $cadNumber, bool $asArray=false)
    {
        $puredCadNumber = $this->pureCadNumber($cadNumber);
        $result = Cadastral::find()->where(['cadastral_number' => $puredCadNumber])->asArray($asArray)->one();
        if ( ! $result) {
            $data = $this->getFromApi(($puredCadNumber));
            if ($data) {
                $model = new Cadastral();
                $model->attributes = $data;
                $model->save();
                $result = $model;
            }
        }

        return $result;
    }

    /**
     * @param string $cadNumber
     * @return array|null
     * @throws Exception
     */
    public function getFromApi(string $cadNumber): ?array
    {
    	$puredCadNumber = $this->pureCadNumber($cadNumber);
        $result = $this->makeRequest($this->url, $puredCadNumber);
        if ($result['error_number'] OR $result['response_info']['http_code'] > 399) {
            throw new Exception(
                'Unable get cadastral data. Error message: '.
                $result['error_msg'].' Response: '.$result['response']
            );
        }

        $response = json_decode($result['response'], true);

        $cadData = null;
        if ($response['feature']) {
            $attrs = $response['feature']['attrs'];
            $cadData = [
                'cadastral_number' => $puredCadNumber,
                'address' => $attrs['address'],
                'price' => $attrs['cad_cost'],
                'area' => $attrs['area_value'],
            ];
        }

        return $cadData;
    }

    /**
     * @param string $cadNumber
     * @return string
     */
    private function pureCadNumber(string $cadNumber): string
    {
        $result = [];
        $numbers = explode(':', $cadNumber);
        foreach($numbers as $number) {
            $result[] = (int)$number;
        }
        return implode(':', $result);
    }

    /**
     * @param string $url
     * @param string $cadNumber
     * @return array
     */
    private function makeRequest(string $url, string $cadNumber): array
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url.$cadNumber);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            ':authority: pkk5.rosreestr.ru',
            ':method: GET',
            ':path: /api/features/1/'.$cadNumber,
            ':scheme: https',
            'accept: text/javascript, application/javascript, application/ecmascript, application/x-ecmascript, */*; q=0.01',
            'sec-fetch-mode: cors',
            'sec-fetch-site: same-origin',
            'x-requested-with: XMLHttpRequest',
            'referer: https://pkk5.rosreestr.ru/',
        ]);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_VERBOSE, !empty(YII_ENV_DEV));

        $response = curl_exec($ch);
        $response_info = curl_getinfo($ch);
        $error_msg = null;
        $error_number = curl_errno($ch);
        $error_msg = curl_error($ch);

        curl_close($ch);

        return [
            'response' => $response,
            'response_info' => $response_info,
            'error_number' => $error_number,
            'error_msg' => $error_msg,
        ];
    }
}