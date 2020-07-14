<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CovidView extends Model
{
 protected $guarded =[];

 public static function createViewLog($post) {
            $covidView= CovidView::where('ip', request()->getClientIp())->first();
            if(!$covidView) {
                $covidView = new CovidView();
              	$covidView->ip = $post->getClientIp();
            	$covidView->agent = $post->header('User-Agent');
            	$covidView->country = ip_info($post->getClientIp(), "Country");
            	$covidView->state = ip_info($post->getClientIp(), "State");
            	$covidView->city = ip_info($post->getClientIp(), "City");
            	$covidView->address = ip_info($post->getClientIp(), "Address");
            	$covidView->save();
            }
           
    }
}
