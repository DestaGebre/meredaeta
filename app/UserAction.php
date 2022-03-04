<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserAction extends Model
{
    //
    protected $fillable = [];
    
    public function user(){
         return $this->belongsTo('App\User','userid');
    }
    public static function storeAction($recordID, $table_, $genAct, $speAct, $data, $bulk, $bulkdata){
        $action = new UserAction;
        $action->userid = Auth::user()->id;
        $action->recordid = $recordID;
        $action->action = $genAct.'_'.$speAct;
        $action->tableName = $table_;
        $action->data = '';
        foreach ($data as $key => $value) {
            $action->data .= $key . '|'. $value . ';';
        }
        $action->data = rtrim($action->data, ';');
        $action->bulk = $bulk;
        $action->bulkdata = '';
        foreach ($bulkdata as $value) {
            $action->bulkdata .= $value . ';';
        }
        $action->bulkdata = rtrim($action->bulkdata, ';');
        $action->save();
    }
}
