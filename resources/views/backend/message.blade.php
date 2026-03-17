@extends('backend/layouts/template')

@section('content')
    <div class="app-content">
        <div class="container-fluid">
            <div class="card border-0 shadow-sm">
                <div class="mt-3">
                    {{ $messages->links() }}
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th>ชื่อลูกค้า</th>
                                <th>เบอร์โทรติดต่อ</th>
                                <th>สาขาที่เข้าใช้บริการ</th>
                                <th>วันที่ / เวลา</th>
                                <th>รายละเอียด</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $message => $value)
                                @php
                                    $shop = DB::table('shops')->where('id', $value->shop_id)->value('shop_name');
                                    $branch = DB::table('shops')->where('id', $value->shop_id)->value('branch_name');
                                @endphp
                                <tr>
                                    <td>
                                        <div class="text-dark">{{ $value->name }}</div>
                                    </td>
                                    <td>
                                        <div class="text-dark">{{ $value->tel }}</div>
                                    </td>
                                    <td>
                                        <div class="text-dark">{{ $shop }} {{ $branch }}</div>
                                    </td>
                                    <td>
                                        <div class="text-dark">{{ $value->created_at }}</div>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal"
                                            data-bs-target="#message{{ $value->id }}">เปิดอ่านข้อความ</button>
                                    </td>
                                </tr>
                                <div class="modal fade" data-bs-backdrop="static" id="message{{ $value->id }}"
                                    tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-dark">
                                                    <i class="fa-solid fa-triangle-exclamation"></i> ข้อความติดต่อ
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                {{ $value->comment }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $messages->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
