<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetupController extends Controller
{
    public function initstaff(Request $request)
    {
        $create_table = 0;
        $insert_record = 0;
        if (!Schema::hasTable("staff")) {
            Schema::create("staff", function (Blueprint $table) {
                $table->id();
                $table->string("name");
                $table->string("email")->unique();
                $table->string("dept");
                $table->string("bran");
            });
            $create_table = 1;
        }
        if (Schema::hasTable("staff")) {
    $timestamp = time();
DB::insert('insert into staff (name,email,dept,bran) 
        values (?,?,?,?)',
        ['john'.'_'.$timestamp,'john@gmail.com'.'_'.$timestamp,'D1','D1B1']);
    $timestamp++;
    
DB::insert('insert into staff (name,email,dept,bran) 
        values (?,?,?,?)',
        ['nancy'.'_'.$timestamp,'nancygmail.com'.'_'.$timestamp,'D2','D2B2']);

            $insert_record = 2;
        }
        $json_data =
            '{"table":["staff"],"create table":"'.$create_table.'","insert record":"'.$insert_record.'"}';

        $response = json_decode($json_data);

        return response()->json($response, 200);
    } /*func initstaff*/



    public function initdept(Request $request)
    {
        $create_table = 0;
        $insert_record = 0;
        if (!Schema::hasTable("dept")) {
       Schema::create('dept', function (Blueprint $table) {
           $table->id();
           $table->string('code')->unique();  
           $table->string('name');            
       });
            $create_table = 1;
        }
        if (Schema::hasTable("dept")) {
    $timestamp = time();
        DB::insert('insert into dept (code,name) 
        values (?,?)', 
            ['D1_'.$timestamp++,
            'Department 1']);   
        DB::insert('insert into dept (code,name) 
        values (?,?)', 
            ['D2_'.$timestamp++,
            'Department 2']);   


            $insert_record = 2;
        }
        $json_data =
            '{"table":["dept"],"create table":"'.$create_table.'","insert record":"'.$insert_record.'"}';

        $response = json_decode($json_data);

        return response()->json($response, 200);
    } /*func initdept*/

    public function initbran(Request $request)
    {
        $create_table = 0;
        $insert_record = 0;
        if (!Schema::hasTable("bran")) {
       Schema::create('bran', function (Blueprint $table) {
           $table->id();
           $table->string('code')->unique();  
           $table->string('deptcode'); 
           $table->string('name');            
       });
            $create_table = 1;
        }
        if (Schema::hasTable("bran")) {
    $timestamp = time();
        DB::insert('insert into bran (deptcode,code,name) 
        values (?,?,?)', 
            ['D1',
            'D1B1_'.$timestamp++,'Branch 1 of D1']);   
        DB::insert('insert into bran (deptcode,code,name) 
        values (?,?,?)', 
            ['D1',
            'D1B2_'.$timestamp++,'Branch 2 of D1']);   
        DB::insert('insert into bran (deptcode,code,name) 
        values (?,?,?)', 
            ['D2',
            'D2B1_'.$timestamp++,'Branch 1 of D2']);   
        DB::insert('insert into bran (deptcode,code,name) 
        values (?,?,?)', 
            ['D2',
            'D2B2_'.$timestamp++,'Branch 2 of D2']);   

            $insert_record = 2;
        }
        $json_data =
            '{"table":["bran"],"create table":"'.$create_table.'","insert record":"'.$insert_record.'"}';

        $response = json_decode($json_data);

        return response()->json($response, 200);
    } /*func initdept*/


    public function show_tables(Request $request)
    {
        //$tables =  DB::select('SHOW TABLES');
        $tables = DB::select(
            "SELECT name FROM sqlite_master WHERE type='table' ORDER BY name;"
        );
        echo "tables:<br/>";
        foreach ($tables as $table) {
            $arry = (array) $table;
            foreach ($arry as $value) {
                echo $value . "<br/>";
            }
        }
    } /*method*/

    public function getall($e)
    {
        $entity = $e;
        $result = DB::select("select * from " . $entity);
        return response()->json($result, 200);
    }
} /*class*/