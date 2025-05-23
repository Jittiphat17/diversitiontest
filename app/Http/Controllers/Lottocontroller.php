<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LottoController extends Controller
{
    public function index()
    {
        return view('lotto', [
            'reward' => session('reward'),
            'result' => session('check_result'),
        ]);
    }

    public function draw()
    {
        $r1 = rand(0, 999);
        $near = [($r1 + 1) % 1000, ($r1 - 1 + 1000) % 1000];

        $r2 = [];
        while (count($r2) < 3) {
            $ran = rand(0, 999);
            if ($ran !== $r1 && !in_array($ran, $r2) && !in_array($ran, $near)) {
                $r2[] = $ran;
            }
        }

        $last2 = rand(0, 99);

        session([
            'reward' => [
                'r1' => $r1,
                'r2' => $r2,
                'near' => $near,
                'last2' => $last2
            ],
            'check_result' => null
        ]);

        return redirect()->route('lotto.index');
    }

    public function check(Request $request)
    {
        $input = str_pad($request->number, 3, '0', STR_PAD_LEFT);
        $num = intval($input);
        $last2 = substr($input, 1); 

        $reward = session('reward');
        $adds = [];

        if ($num === $reward['r1']) $adds[] = "เลข {$input} ถูกรางวัลที่ 1";
        if (in_array($num, $reward['r2'])) $adds[] = "เลข {$input} ถูกรางวัลที่ 2";
        if (in_array($num, $reward['near'])) $adds[] = "เลข {$input} ถูกรางวัลเลขข้างเคียง";
        if ($last2 === str_pad($reward['last2'], 2, '0', STR_PAD_LEFT)) $adds[] = "เลข {$input} ถูกรางวัลเลขท้าย 2 ตัว";

        session(['check_result' => $adds ?: ["เลข {$input} ไม่ถูกรางวัลใด ๆ"]]);

        return redirect()->route('lotto.index');
    }
}   