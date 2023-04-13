<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
    public function insert(Request $request)
    {    
    $payload = json_decode($request->getContent(), true);
    try {
      $response = [
        'e' => $payload['e'],
        'reco' => $payload['reco']
      ];
      switch ($response['e']){
        case "staff":
        DB::insert('insert into staff (name,email,dept,bran) 
        values (?,?,?,?)', 
            [
            $response['reco']['name'],
            $response['reco']['email'],
            $response['reco']['dept'],
            $response['reco']['bran']
            ]);   
        break; 

        case "department":
        DB::insert('insert into department (code,name) 
        values (?,?)', 
            [
            $response['reco']['code'],
            $response['reco']['name']
            ]);  
        break; 

        case "branch":
        DB::insert('insert into branch (deptcode,code,name) 
        values (?,?,?)', 
            [
            $response['reco']['deptcode'],
            $response['reco']['code'],
            $response['reco']['name']
            ]);  
        break; 
      }
    }catch (\GuzzleHttp\Exception\BadResponseException $e) {
      $errorResJson = $e
        ->getResponse()
        ->getBody()
        ->getContents();
      $errorRes = json_decode(stripslashes($errorResJson), true);
      // Return error
      return response()->json(
        [
          'message' => 'error',
          'data' => '$errorRes'
        ],
        $errorRes['response']['code']
      );
    }
    return response()->json(
      [
        'status' => '200',
        'data' => $response['reco'],
        'message' => 'success'
      ],
      200
    );
}/* func insert */


    public function update(Request $request)
  {
    $payload = json_decode($request->getContent(), true);
    try {
      $response = [
        'e' => $payload['e'],
        'reco' => $payload['reco']
      ];

      switch ($response['e']){
        case "staff":
        $affected = DB::update(
            'update staff set 
            name = ?, 
            email=? 
            where id = ?',
            [
                $response['reco']['name'],
                $response['reco']['email'],
                $response['reco']['id']
            ]);   
        
        break; 

        case "dept":
        $affected = DB::update(
            'update dept set 
            code = ?, 
            name=? 
            where id = ?',
            [
                $response['reco']['code'],
                $response['reco']['name'],
                $response['reco']['id']
            ]);  
  
        break; 

        case "bran":
        $affected = DB::update(
            'update bran set 
            deptcode = ?,             
            code = ?, 
            name=? 
            where id = ?',
            [
                $response['reco']['deptcode'],
                $response['reco']['code'],
                $response['reco']['name'],
                $response['reco']['id']
            ]);  
 
        break; 
      }

    }catch(e){

    }
    return response()->json(
      [
        'status' => '200',
        'data' => $response['reco'],
        'message' => 'success'
      ],
      200
    );

  }/* func update */

    public function delete(Request $request)
  {
    $payload = json_decode($request->getContent(), true);
    try {
      $response = [
        'e' => $payload['e'],
        'id' => $payload['id']
      ];

      switch ($response['e']){
        case "staff":
        $deleted = DB::delete('delete from staff where id = ?', 
        [$response['id']]);  
        
        break; 

        case "dept":
        $deleted = DB::delete('delete from dept where id = ?', 
        [$response['id']]);  
  
        break; 

        case "bran":
        $deleted = DB::delete('delete from bran where id = ?', 
        [$response['id']]);   
 
        break; 
      }

    }catch(e){

    }
    return response()->json(
      [
        'status' => '200',
        'data' => $deleted,
        'message' => 'success'
      ],
      200
    );

  }/* func delete */

public function getw($entity,$field,$value){
    $result = DB::select('select * from '.$entity.' where '.$field.' = ?', [$value]);
    return response()->json($result, 200);
} /* func getw */


}/* clas */