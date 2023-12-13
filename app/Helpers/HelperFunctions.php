<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use DateTime;

class HelperFunctions
{
    public static function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('', 'K', 'M', 'G', 'T');

        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    }

    public static function deleteFile($disk, $folder, $filePath)
    {
        $file = collect(explode('/', $filePath));
        Storage::disk($disk)->delete($folder.'/'.$file->last());
    }

    public static function checkOrderInspectionIsComplete(Order $order): DateTime|bool
    {
        $last_inspection_report_date = $order->updated_at;
        foreach ($order->orderItems as $item) {
            if (!$item->inspectionReport()->exists()) {
                return false;
            }

            if ($last_inspection_report_date > $item->inspectionReport->updated_at) {
                $last_inspection_report_date = $item->inspectionReport->updated_at;
            } else {
                $last_inspection_report_date = $item->inspectionReport->updated_at;
            }
        }

        return $last_inspection_report_date;
    }
}
