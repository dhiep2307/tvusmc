<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }} | TVU Social Media Club</title>

    @include('admin.layouts.head')

</head>
@php

    $timeStart = date("H:i - d/m/Y", strtotime($job['time_start']));
    $time = date("H:i", strtotime($job['time_start']));
    $date = date("d/m/Y", strtotime($job['time_start']));
    $timeEnd = date("H:i - d/m/Y", strtotime($job['time_end']));

@endphp
<body>
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex mt-3 justify-content-between">
                       <div class="iq-header-title">
                          <h3 class="card-title">{{ $job['name'] }} <small>( Sự kiện: {{ str()->of($job['event_name'])->limit(100) }} )</small></h3>
                       </div>
                    </div>
                    <div class="iq-card-body">
                        <p class="h4">Thời gian bắt đầu: <span class="text-dark">{{ $timeStart }}</span></p>
                        <p class="h4">Thời gian kết thúc: <span class="text-dark">{{ $timeEnd }}</span></p>
                        <p class="h4">Địa điểm: <span class="text-dark">{{ $job['address'] }}</span></p>
                        <p class="h4">Mô tả / Nội dung chi tiết:</p>
                        <p class="h5"><span class="text-dark">{{ $job['description'] }}</span></p>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                       <div class="iq-header-title">
                          <h4 class="card-title">
                            Danh sách đăng ký
                            <span class="badge badge-success">
                                {{count($users)}}
                            </span>
                        </h4>
                       </div>
                    </div>
                    <div class="iq-card-body">
                        <a class="btn mb-3 btn-light rounded-pill mx-1" 
                        href="
                            {{ route('files.downoad.jobuser', [
                                'job_id' => $job['id'],
                                'c' => 'all',
                                'file' => 'word',
                                'title' => $job['name'] . ' ' . $job['event_name'],
                                'date_time' => $time . ' ngày ' . $date,
                                'address' => $job['address'],
                            ]) }}
                        ">
                            <i class="ri-file-word-line"></i>
                            Xuất DS Word
                        </a>
                        <a class="btn mb-3 btn-light rounded-pill mx-1" 
                        href="
                            {{ route('files.downoad.jobuser', [
                                'job_id' => $job['id'],
                                'c' => 'all',
                                'file' => 'pdf',
                                'title' => $job['name'] . ' ' . $job['event_name'],
                                'date_time' => $time . ' ngày ' . $date,
                                'address' => $job['address'],
                            ]) }}
                        ">
                            <i class="ri-file-word-line"></i>
                            Xuất DS PDF
                        </a>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Họ tên</th>
                                        <th scope="col">Lớp</th>
                                        <th scope="col">MSSV</th>
                                        <th scope="col">Năm sinh</th>
                                        <th scope="col">Giới tính</th>
                                        <th scope="col">Đăng ký lúc</th>
                                        <th scope="col">Minh chứng</th>
                                        <th scope="col">Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $index => $user)
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <h5 class="mb-0 font-weight-bold" title="{{$user['name']}}">{{
                                                        str()->title($user['name']) }}</h5>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{
                                                        $user['class']
                                                    }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{
                                                        $user['mssv']
                                                    }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{
                                                        $user['birthdate']
                                                    }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{
                                                        $user['sex']
                                                    }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{
                                                        date("H:i d/m/Y", strtotime($user['time_register']))
                                                    }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    Có
                                                </span>
                                            </td>
                                            <td>
                                                {{-- <button type="button" onclick="openPopup('{{ route('admin.jobs.preview', [ 'id' => $job['id'] ]) }}')" class="btn mb-3 btn-info rounded-pill"
                                                    onclick="">
                                                    <i class="ri-eye-line"></i> 
                                                    Xem
                                                </button>
                                                <button type="button" class="btn mb-3 btn-danger rounded-pill"
                                                    onclick="alertModalShow('Cảnh báo', 'Bạn chắc chắn muốn xóa công việc này! Sẽ không khôi phục lại được dữ liệu sau khi xóa!', '{{ route('admin.jobs.delete', ['id' => $job['id']]) }}');">
                                                    <i class="ri-delete-bin-line"></i>
                                                    Xóa
                                                </button>  --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($users) == 0)
                                        <tr>
                                            <td colspan="9" class="text-center">
                                                <i>Chưa có người đăng ký</i>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

    </div>

    @include('admin.layouts.js')

</body>
</html>