<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>Diversiton Lotto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link href="{{ asset('css/lotto.css') }}" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-dark bg-dark shadow-sm mb-4">
        <div class="container-fluid justify-content-center">
            <span class="navbar-brand h1 mb-0"> Diversition Lotto </span>
        </div>
    </nav>

    <div class="container d-flex flex-column align-items-center p-4">

        <div class="card p-4 w-100 mb-4" style="max-width: 1000px;">

            <table class="table table-bordered text-center table-hover">
                <h3 class="text-center text-bg-warning">ผลการออกรางวัล</h3>
                <tr>
                    <th class="table-warning">รางวัลที่ 1 (1 รางวัล)</th>
                    <td>{{ $reward['r1'] ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="table-warning">รางวัลที่ 2 (3 รางวัล)</th>
                    <td>
                        {{ isset($reward['r2']) ? implode(', ', array_map(fn($n) => str_pad($n, 3, '0', STR_PAD_LEFT), $reward['r2'])) : '-' }}
                    </td>
                </tr>
                <tr>
                    <th class="table-warning">เลขข้างเคียง (2 รางวัล)</th>
                    <td>
                        {{ isset($reward['near']) ? implode(', ', array_map(fn($n) => str_pad($n, 3, '0', STR_PAD_LEFT), $reward['near'])) : '-' }}
                    </td>
                </tr>
                <tr>
                    <th class="table-warning">เลขท้าย 2 ตัว (10 รางวัล)</th>
                    <td>{{ isset($reward['last2']) ? str_pad($reward['last2'], 2, '0', STR_PAD_LEFT) : '-' }}</td>
                </tr>
            </table>
            <form method="POST" action="{{ route('lotto.draw') }}" class="mb-40 text-center">
                @csrf
                <button class="btn btn-warning pt-10">ดำเนินการสุ่มรางวัล</button>
            </form>

        </div>

        <div class="card p-4 w-100" style="max-width: 1000px;">
            <form method="POST" action="{{ route('lotto.check') }}">
                @csrf
                <div class="input-group mb-3">
                    <input type="number" name="number" class="form-control form-control-lg" min="0"
                        max="999" placeholder="กรอกเลข 2 หรือ 3 หลัก" required>

                    <button class="btn btn-success btn-lg">ตรวจรางวัล</button>
                </div>
            </form>

            @if ($result)
                <div class="alert alert-{{ Str::contains($result[0], 'ไม่') ? 'danger' : 'success' }}">
                    {!! implode('<br>', $result) !!}
                </div>
            @endif
        </div>

    </div>

</body>

</html>
