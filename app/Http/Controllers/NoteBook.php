<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NoteBook extends Controller
{
    //笔记的添加和修改
    public function setNote()
    {
        return 'set';
    }

    //笔记的删除
    public function delNote()
    {
        return 'del';
    }
}
