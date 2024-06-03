<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;

class CurrencyController extends Controller
{
    function getSellUSD()
    {
        $url = 'https://portal.vietcombank.com.vn/Usercontrols/TVPortal.TyGia/pXML.aspx';
        $response = file_get_contents($url);
        if ($response !== false) {
            $xml = simplexml_load_string($response);
            $usd_exchange_rate = null;
            foreach ($xml->Exrate as $exrate) {
                if ($exrate['CurrencyCode'] == 'USD') {
                    $usd_exchange_rate = (string) $exrate['Sell'];
                    break;
                }
            }
            if ($usd_exchange_rate !== null) {
                $formatNumber = number_format((float) str_replace(',', '', $usd_exchange_rate), 0, '', '');
                $config = Config::query()->where("key", "USD")->first();
                $config->update(["value" => $formatNumber]);
                $config->save();
                return back()->with("notif", "Cập nhật thành công");
            }
        } else {
            return back()->with("notif", "Cập nhật không thành công");
        }
    }
}
