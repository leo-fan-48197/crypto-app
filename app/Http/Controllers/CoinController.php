<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CoinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // create curl resource
        $curl = curl_init();

        // set url
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'api.coincap.io/v2/assets',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
          ));
          
          $response = curl_exec($curl);
          
          curl_close($curl);

          $response = substr($response, 9);
          $position = strrpos($response, ']', -1);

          $response = substr($response, 0, $position);
        //   print_r($response);

          $coins_array = explode("},", $response);

          foreach($coins_array as $coin){
            $row = substr($coin, 1);

            $rank_position = strpos($row, "rank");
            $coin_rank = substr($row, ($rank_position + 7), 2);

            // print_r(($row));

            if($coin_rank <= 5 || $coin_rank == '5"' ){
                // echo $coin_rank ;
                $coin_arr =  explode(',', $row); print_r($coin_arr);

                foreach($coin_arr as $info){
                    if($this->startsWith($info, '"id":' )){
                        $coin_id = substr($info, 6); 
                        $coin_id = $this->removeQuotationMarks($coin_id);
                        echo $coin_id; echo "+++";
                    }elseif($this->startsWith($info, '"rank"' )){
                        $rank = substr($info, 8, 1); 
                        $rank = intval($rank, $base = 10);
                        echo(gettype($rank) ); 
                    }elseif($this->startsWith($info, '"symbol"' )){
                        $symbol = substr($info, 10);
                        $symbol = $this->removeQuotationMarks($symbol); 
                        echo $symbol; echo "+++";
                    }elseif($this->startsWith($info, '"name"' )){
                        $name = substr($info, 8); 
                        $name = $this->removeQuotationMarks($name); 
                        echo $name; echo "+++";
                    }elseif($this->startsWith($info, '"supply"' )){
                        $supply = substr($info, 10); 
                        $supply = $this->removeQuotationMarks($supply); 
                        echo $supply; echo "+++";
                    }elseif($this->startsWith($info, '"maxSupply"' )){
                        $maxSupply = substr($info, 13);
                        $maxSupply = $this->removeQuotationMarks($maxSupply);  
                        echo $maxSupply; echo "+++";
                    }elseif($this->startsWith($info, '"volumeUsd24Hr"' )){
                        $volumeUsd24Hr = substr($info, 17); 
                        $volumeUsd24Hr = $this->removeQuotationMarks($volumeUsd24Hr);  
                        echo $volumeUsd24Hr; echo "+++";
                    }elseif($this->startsWith($info, '"marketCapUsd"' )){
                        $marketCapUsd = substr($info, 16); 
                        $marketCapUsd = $this->removeQuotationMarks($marketCapUsd); 
                        echo $marketCapUsd; echo "+++";
                    }elseif($this->startsWith($info, '"priceUsd"' )){
                        $priceUsd = substr($info, 12); 
                        $priceUsd = $this->removeQuotationMarks($priceUsd); 
                        echo $priceUsd; echo "+++";
                    }elseif($this->startsWith($info, '"changePercent24Hr"' )){
                        $changePercent24Hr = substr($info, 21);
                        $changePercent24Hr = $this->removeQuotationMarks($changePercent24Hr);  
                        echo $changePercent24Hr; echo "+++";
                    }elseif($this->startsWith($info, '"vwap24Hr"' )){
                        $vwap24Hr = substr($info, 12);
                        $vwap24Hr = $this->removeQuotationMarks($vwap24Hr);  
                        echo $vwap24Hr; echo "+++";
                    }elseif($this->startsWith($info, '"explorer"' )){
                        $explorer = substr($info, 12); 
                        $explorer = $this->removeQuotationMarks($explorer); 
                        echo $explorer; echo "+++";
                    }

                }
            }else{
                continue;
            }
            
            DB::table('coins')->insert([
                        'coin_id'   =>  $coin_id,
                        'rank'      =>  $rank,
                        'symbol'    =>  $symbol,
                        'name'      =>  $name,

                        'supply'        => floatval($supply),
                        'maxSupply'     => floatval($maxSupply),
                        'marketCapUsd'  => floatval($marketCapUsd),
                        'volumeUsd24Hr' => floatval($volumeUsd24Hr),

                        'priceUsd'          => floatval($priceUsd),
                        'changePercent24Hr' => floatval($changePercent24Hr),
                        'vwap24Hr'          => floatval($vwap24Hr),
                    ]);
          }
        
        return view('welcome');

    }

    // Function to check string starting
    // with given substring
    function startsWith ($string, $startString)
    {
        $len = strlen($startString);
        return (substr($string, 0, $len) === $startString);
    }

    function removeQuotationMarks($str){
        $len = strlen($str);
        return (substr($str, 0, ($len-1)));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
