@extends('admin.master')


@section('content')
    
    <div class="row">

        <div class="col-sm-12">

            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                   <div class="iq-header-title">
                      <h4 class="card-title">
                         Thành viên
                         <span class="badge badge-success ml-2">
                             {{ $users->total() }}
                         </span>
                     </h4>
                   </div>
                </div>
                <div class="iq-card-body">
                    <div class="table-responsive">
                        <div class="row justify-content-between">
                           <div class="col-sm-12 col-md-6">
                              <div id="user_list_datatable_info" class="dataTables_filter">
                                 <form class="mr-3 position-relative">
                                    <div class="form-group mb-0">
                                       <input type="search" class="form-control" id="exampleInputSearch" placeholder="Search" aria-controls="user-list-table">
                                    </div>
                                 </form>
                              </div>
                           </div>
                           <div class="col-sm-12 col-md-6">
                              <div class="user-list-files d-flex float-right">
                                 <a href="javascript:void();" class="chat-icon-video">
                                    Excel
                                  </a>
                                  <a href="javascript:void();" class="chat-icon-delete">
                                    Pdf
                                  </a>
                                </div>
                           </div>
                        </div>
                        <table id="user-list-table" class="table table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info">
                          <thead>
                              <tr>
                                 <th class="text-center">avatar</th>
                                 <th>Họ tên</th>
                                 <th>Mã số</th>
                                 <th>Email</th>
                                 <th class="text-center">Số ĐT</th>
                                 <th>Lớp</th>
                                 <th>Giới tính</th>
                                 <th>Địa chỉ</th>
                                 <th>Năm sinh</th>
                                 <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                            @foreach ($users as $index => $user)
                               
                                <tr>
                                    <td class="text-center">
                                        <img class="rounded-circle img-fluid avatar-40" src="{{ $user['avatar'] }}" alt="Avatar">
                                    </td>
                                    <td>
                                        {{ str()->title($user['name']) }}
                                    </td>
                                    <td>
                                        {{ $user['mssv'] }}
                                    </td>
                                    <td>
                                        {{ $user['email'] }}
                                    </td>
                                    <td class="text-center">
                                        {{ $user['phone'] }}
                                    </td>
                                    <td>
                                        {{ $user['class'] }}
                                    </td>
                                    <td>
                                        @switch($user['sex'])
                                            @case(1)
                                                <span class="badge iq-bg-success">Nam</span>
                                                @break
                                            @case(2)
                                                <span class="badge iq-bg-primary">Nữ</span>
                                                @break
                                            @default
                                                <span class="badge iq-bg-danger">Khác</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        {{ $user['address'] }}
                                    </td>
                                    <td>
                                        {{ date('d/m/Y', strtotime($user['birthday'])) }}
                                    </td>
                                    <td>
                                        {{-- <div class="flex align-items-center list-user-action">
                                            <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Add" href="#"><i class="ri-user-add-line"></i></a>
                                            <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="#"><i class="ri-pencil-line"></i></a>
                                            <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="#"><i class="ri-delete-bin-line"></i></a>
                                        </div> --}}
                                    </td>
                                </tr> 
                            @endforeach                             
                          </tbody>
                        </table>
                     </div>
                        
                     {{ view('admin.components.paginate', [
                        'items' => $users,
                     ]) }}
                </div>
             </div>

        </div>

        <div class="col-sm-12">

            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                   <div class="iq-header-title">
                      <h4 class="card-title">
                         Quản trị
                         <span class="badge badge-info ml-2">
                             {{ $usersAdmin->count() }}
                         </span>
                     </h4>
                   </div>
                </div>
                <div class="iq-card-body">
                    <div class="table-responsive">
                        <div class="row justify-content-between">
                           <div class="col-sm-12 col-md-6">
                           </div>
                           <div class="col-sm-12 col-md-6">
                              <div class="user-list-files d-flex float-right">
                                 <a href="javascript:void();" class="chat-icon-video">
                                    Excel
                                  </a>
                                  <a href="javascript:void();" class="chat-icon-delete">
                                    Pdf
                                  </a>
                                </div>
                           </div>
                        </div>
                        <table id="user-list-table" class="table table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info">
                          <thead>
                              <tr>
                                 <th class="text-center">avatar</th>
                                 <th>Họ tên</th>
                                 <th>Mã số</th>
                                 <th>Email</th>
                                 <th class="text-center">Số ĐT</th>
                                 <th>Lớp</th>
                                 <th>Giới tính</th>
                                 <th>Địa chỉ</th>
                                 <th>Năm sinh</th>
                                 <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                            @foreach ($usersAdmin as $index => $user)
                               
                                <tr>
                                    <td class="text-center">
                                        <img class="rounded-circle img-fluid avatar-40" src="{{ $user['avatar'] }}" alt="Avatar">
                                    </td>
                                    <td>
                                        {{ str()->title($user['name']) }}
                                    </td>
                                    <td>
                                        {{ $user['mssv'] }}
                                    </td>
                                    <td>
                                        {{ $user['email'] }}
                                    </td>
                                    <td class="text-center">
                                        {{ $user['phone'] }}
                                    </td>
                                    <td>
                                        {{ $user['class'] }}
                                    </td>
                                    <td>
                                        @switch($user['sex'])
                                            @case(1)
                                                <span class="badge iq-bg-success">Nam</span>
                                                @break
                                            @case(2)
                                                <span class="badge iq-bg-primary">Nữ</span>
                                                @break
                                            @default
                                                <span class="badge iq-bg-danger">Khác</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        {{ $user['address'] }}
                                    </td>
                                    <td>
                                        {{ date('d/m/Y', strtotime($user['birthday'])) }}
                                    </td>
                                    <td>
                                        {{-- <div class="flex align-items-center list-user-action">
                                            <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Add" href="#"><i class="ri-user-add-line"></i></a>
                                            <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="#"><i class="ri-pencil-line"></i></a>
                                            <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="#"><i class="ri-delete-bin-line"></i></a>
                                        </div> --}}
                                    </td>
                                </tr> 
                            @endforeach                             
                          </tbody>
                        </table>
                     </div>
                </div>
            </div>

        </div>

    </div>

@endsection