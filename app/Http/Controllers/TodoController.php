<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todos;

class TodoController extends Controller
{
    //统一定义接口返回类型
    protected function rep($code = 200, $data = [])
    {
        $errStr = [
            '100' => '服务器错误',
            '101' => '缺少参数',
            '102' => '请求内容不存在',
            '103' => '任务已完成'
        ];
        if ($code == 200) {
            if (empty($data)) {
                return response()->json(['code' => $code, 'msg' => 'success'], 200);
            } else {
                return response()->json(['code' => $code, 'msg' => 'success', 'data' => $data], 200);
            }
        } else {
            return response()->json(['code' => $code, 'err' => $errStr[$code]], 200);
        }
    }

//    得到TODO的列表
    public function getTodoList()
    {
        $todoModel = new Todos();
        $ret = $todoModel->where('status', '<', 2)->get();

        return $this->rep(200, $ret);
    }

//    新增TODO 或 修改TODO
    public function setTodo(Request $request)
    {
        $validatedData = $request->validate([
            'id' => '',
            'content' => 'required'
        ]);

        try {
            $todoModel = new Todos();
            if (isset($validatedData['id'])) {
                $item = $todoModel->find($validatedData['id']);
                if ($item) {
                    $item->content = $validatedData['content'];
                    $item->save();
                } else {
                    return $this->rep(102);
                }
            } else {
                $todoModel->content = $validatedData['content'];
                $todoModel->save();
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return $this->rep(100);
        }
        return $this->rep();
    }

//    完成一个TODO
    public function endTodo(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required'
        ]);

        $todoModel = new Todos();
        $item = $todoModel->where('status', '<', '2')->find($validatedData['id']);
        if ($item) {
            if ($item->status == 1) {
                return $this->rep(103);
            } else {
                $item->status = 1;
                $item->save();
            }
        } else {
            return $this->rep(102);
        }
        return $this->rep();
    }

//    删除一个TODO
    public function delTodo(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required',
        ]);

        $todoModel = new Todos();
        $item = $todoModel->where('status', '<', '2')->find($validatedData['id']);
        if ($item) {
            $item->status = 2;
            $item->save();
        } else {
            return $this->rep(102);
        }
        return $this->rep();
    }
}
