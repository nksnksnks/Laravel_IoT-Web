@extends('welcome')
@section('content')
<title>Thông tin cá nhân</title>
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-4" style="margin:auto; margin-top:50px;">
            <div class="bg-secondary rounded h-100 p-4">
                <img class="rounded-circle me-lg-2" src="{{('public/front-end/img/user.jpg')}}" alt="" style="width: 100%; height: 100%;">
            </div>
        </div>
        <div class="col-sm-12 col-xl-8" style="margin:auto; margin-top:50px;">
            <div class="bg-secondary rounded h-100 p-4">
                <form action="{{URL::to('/update')}}" method='POST'>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Họ tên</label>
                        <input class="form-control" id="exampleInputEmail1" name="name"
                            aria-describedby="emailHelp" value="Nguyễn Khắc Sơn" type="text" style="margin:0 0 15px 0; padding:10px;font-size:19px;">
                        <label for="exampleInputEmail1" class="form-label" >Mã sinh viên</label>
                        <input class="form-control" id="exampleInputEmail1" name="msv"
                            aria-describedby="emailHelp" value="B20DCCN580" style="margin:0 0 15px 0;padding:10px;font-size:19px;">
                            <label for="exampleInputEmail1" class="form-label" >Ngày sinh</label>
                            <input class="form-control" id="exampleInputEmail1" name="date"
                                aria-describedby="emailHelp" value="2002-05-28" type="date" style="margin:0 0 15px 0;padding:10px;font-size:19px;">
                        <label for="exampleInputEmail1" class="form-label" >Email</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="email"
                            aria-describedby="emailHelp" value="nguyenkhacsonnn@gmail.com" style="margin:0 0 15px 0;padding:10px;font-size:19px;">
                        <label for="exampleInputEmail1" class="form-label" >Số điện thoại</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="sdt"
                            aria-describedby="emailHelp" value="0848173289" style="margin:0 0 15px 0;padding:10px;font-size:19px;">
                    </div>
                    <!-- <div>
                        <button class="btn btn-outline-primary w-50" type="button" style="margin: 1% 25% 0.5% 25%;font-size: 20px;" type="submit">Lưu thông tin</button>
                    </div> -->
                </form>
            </div>
        </div>
    </div>
</div>
@endsection