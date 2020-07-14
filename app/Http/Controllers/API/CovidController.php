<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CovidView;
class CovidController extends Controller
{

    public function getAll (Request $requset) {

      CovidView::createViewLog($requset);

    	$result = $this->curl_get("https://coronavirus-monitor.p.rapidapi.com/coronavirus/cases_by_country.php");
      
      if($result->countries_stat) {
        $arr =[];

      foreach ($result->countries_stat as $data) {

        $data->id = array_search($data->country_name, CONTRY_CODE);
     
        // if(!$data->id){
        //   array_push($arr,$data);

        // }
      }
      // dd($arr);

    		return response()->json(
                    [
                        'status' => true,
                        'data' => $result,
                        'msg' => ""
                    ]
                );
	    }else {

	    	return response()->json(
                    [
                        'status' => false,
                        'data' => '',
                        'msg' => "No Data Found"
                    ]
                );

	    }
    }

    public function topFiveCases () {
       $result = $this->curl_get("https://coronavirus-monitor.p.rapidapi.com/coronavirus/cases_by_country.php");
       if($result->countries_stat) {


		   $top = [];
	       foreach ($result->countries_stat as $index => $r) {
	       	   if($r->country_name != ''){
            
	       			$top[$r->country_name] = $r->cases;
          }
	       	    
	       			
	       } 

         $rec = array_slice($top, 0, 5);   
    		return response()->json(
                    [
                        'status' => true,
                        'data' => $rec,
                        'msg' => ""
                    ]
            );
        } else {

        	return response()->json(
                    [
                        'status' => false,
                        'data' => '',
                        'msg' => "No Data Found"
                    ]
             );
        }
    } // end topFive

    public function topFiveArab () {
       $arabs = ["Bahrain","Saudi Arabia","Egypt","Iraq","Lebanon","Kuwait","UAE","Algeria","Jordan","Morocco","Tunisia","Oman","Palestine","Sudan","Somalia","Morocco","Syria","Yemen","Djibouti","Libya","Mauritania"] ; 


       $result = $this->curl_get("https://coronavirus-monitor.p.rapidapi.com/coronavirus/cases_by_country.php");
       if($result->countries_stat) {

           $top = [];
           foreach ($result->countries_stat as $index => $r) {
                
                    if(in_array($r->country_name, $arabs)){
                        $top[$r->country_name] = $r->cases;
                    
                    }
                    
           }   

           $rec = array_slice($top, 0, 5);    
            return response()->json(
                    [
                        'status' => true,
                        'data' => $rec,
                        'msg' => ""
                    ]
            );
        } else {

            return response()->json(
                    [
                        'status' => false,
                        'data' => '',
                        'msg' => "No Data Found"
                    ]
             );
        }
    } // end topFive Arabs

 public function topArabRecovered () {
       $arabs = ["Bahrain","Saudi Arabia","Egypt","Iraq","Lebanon","Kuwait","UAE","Algeria","Jordan","Morocco","Tunisia","Oman","Palestine","Sudan","Somalia","Morocco","Syria","Yemen","Djibouti","Libya","Mauritania"] ; 


       $result = $this->curl_get("https://coronavirus-monitor.p.rapidapi.com/coronavirus/cases_by_country.php");
       if($result->countries_stat) {

           $top = [];

           foreach ($result->countries_stat as $index => $r) {
                
                    if(in_array($r->country_name, $arabs)){
                        $top[$r->country_name] = str_replace(',', '', $r->total_recovered);

                    }
                    
           } 
           $final = collect($top)->sort()->reverse()->toArray();
           $rec = array_slice($final, 0, 5);  
            return response()->json(
                    [
                        'status' => true,
                        'data' => $rec,
                        'msg' => ""
                    ]
            );
        } else {

            return response()->json(
                    [
                        'status' => false,
                        'data' => '',
                        'msg' => "No Data Found"
                    ]
             );
        }
    } // end topArabRecovered

    public function topWorldRecovered () {
      
       $result = $this->curl_get("https://coronavirus-monitor.p.rapidapi.com/coronavirus/cases_by_country.php");
       if($result->countries_stat) {

           $top = [];

           foreach ($result->countries_stat as $index => $r) {
                
                  if( $r->country_name != '' && $r->total_recovered != '' && $r->total_recovered != 'N/A') {
              $top[$r->country_name] = str_replace(',', '', $r->total_recovered);
            }
                    
           } 
           $final = collect($top)->sort()->reverse()->toArray();
           $rec = array_slice($final, 0, 5);

            return response()->json(
                    [
                        'status' => true,
                        'data' => $rec,
                        'msg' => ""
                    ]
            );
        } else {

            return response()->json(
                    [
                        'status' => false,
                        'data' => '',
                        'msg' => "No Data Found"
                    ]
             );
        }
    } // end topworld Recovered

    public function arabStates () {
       $arabs = ["Bahrain","Saudi Arabia","Egypt","Iraq","Lebanon","Kuwait","UAE","Algeria","Jordan","Morocco","Tunisia","Oman","Palestine","Sudan","Somalia","Morocco","Syria","Yemen","Djibouti","Libya","Mauritania"] ; 


       $result = $this->curl_get("https://coronavirus-monitor.p.rapidapi.com/coronavirus/cases_by_country.php");
       if($result->countries_stat) {

           $total_cases = [];
           $total_deaths = [];
           $total_recovered = [];
           $new_cases = [];
           $new_deaths = [];

           foreach ($result->countries_stat as $index => $r) {
                
                    if(in_array($r->country_name, $arabs)){
                        $total_cases[] = $r->cases;
                        $total_deaths[] = $r->deaths;
                        $total_recovered[] = $r->total_recovered;
                        $new_cases[] = $r->new_cases;
                        $new_deaths[] = $r->new_deaths;
                    
                    }
                    
           } 

           $top = [
            "total_cases"=>array_sum($total_cases),
            "total_deaths"=>array_sum($total_deaths),
            "total_recovered"=>array_sum($total_recovered),
            "new_cases"=>array_sum($new_cases),
            "new_deaths"=>array_sum($new_deaths)
            ];
      
     
            return response()->json(
                    [
                        'status' => true,
                        'data' => $top,
                        'msg' => ""
                    ]
            );
        } else {

            return response()->json(
                    [
                        'status' => false,
                        'data' => '',
                        'msg' => "No Data Found"
                    ]
             );
        }
    } // end topFive

    public function getCountryByName (Request $requset) {

    	$country = explode(' ',trim($requset->country));

    	$result = $this->curl_get("https://coronavirus-monitor.p.rapidapi.com/coronavirus/latest_stat_by_country.php?country=".$country[0]);

      $data = $result->latest_stat_by_country[0];
      foreach ( CONTRY_CODE as $key => $country) {
        if($country == $data->country_name) {
          $data->id = $key ;
        }
      }

    	 if ( $result->latest_stat_by_country) {
    	 	return response()->json(
                    [
                        'status' => true,
                        'data' => (object)$data,
                        'msg' => ""
                    ]
                );
    	 } else {

    	 	return response()->json(
                    [
                        'status' => false,
                        'data' => '',
                        'msg' => "No Data Found"
                    ]
                );

    	 }
    			
    } // end getCountryByName

    public function getworldState () {
    	$result = $this->curl_get("https://coronavirus-monitor.p.rapidapi.com/coronavirus/worldstat.php");
    	return response()->json(
                    [
                        'status' => true,
                        'data' => $result,
                        'msg' => ""
                    ]
                );
    }

    public function affectedCountries () {
    	$result = $this->curl_get("https://coronavirus-monitor.p.rapidapi.com/coronavirus/affected.php");
    	return response()->json(
                    [
                        'status' => true,
                        'data' => $result,
                        'msg' => ""
                    ]
                );
    }
  

    public function curl_get( $url )
     {

            $curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"x-rapidapi-host: coronavirus-monitor.p.rapidapi.com",
					"x-rapidapi-key: 7379ac624cmsha23cca91d74fa4ap1b1c3cjsn1f39d3c7d77e"
				),
			));

			$response = curl_exec($curl);

			curl_close($curl);

			return json_decode($response);
			


     } // end curl get



}
