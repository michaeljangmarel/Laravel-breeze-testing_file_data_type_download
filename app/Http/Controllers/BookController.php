<?php

namespace App\Http\Controllers;

use App\Models\book;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    //

    public function book_create(Request $a){


        Validator::make($a->all() , [
            'name' => 'required',
            'price' => 'required',
            'doc' => 'required|mimes:pdf|file',

        ])->validate();

        $up = $this->funs($a);

        if($a->hasFile('doc')){

            $org = uniqid().$a->file('doc')->getClientOriginalName();
            $a->file('doc')->storeAs('pdfc' , $org);

            $up['doc'] = $org ;

        }

        book::create($up);

        return redirect()->route('ui_all');

     }

     public function all(){

        $data = book::orderBy('created_at' , 'desc')->get();
        return view('list' , compact('data'));
     }


     public function down($da){

        return response()->download(storage_path('app/pdfc/'.$da));

      }



    public function book_page(){
        return view('bookcreate.book');
    }



    private function funs($a){
        return [
            'name' => $a->name ,
            'price' => $a->price ,
         ];
    }


}
