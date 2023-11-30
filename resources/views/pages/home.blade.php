@extends('welcome')
@section('content')
<title>Trang chủ</title>
<!-- Sale & Revenue Start -->
<div class="container-fluid pt-4 px-4"> 
    <div class="row g-3">
        <div class="col-sm-6 col-xl-4 fontsize" style="margin-top:70px;">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p5">
                <i class="fa fa-chart-line fa-3x bi bi-thermometer-half" 
                id="temperatureIcon"></i>
                <p id="temperatureWarningHot" 
                    class=" mb-2 d-none blinking"><i class="bi bi-exclamation-triangle-fill"></i> Cảnh báo quá nóng!</p>
                <p id="temperatureWarningCold" 
                    class=" mb-2 d-none blinking"><i class="bi bi-exclamation-triangle-fill"></i> Cảnh báo quá lạnh!</p>
                <div id="temperatureContainer" class="ms-3">
                    <!-- thermometer -->
                    <p class="mb-2">Nhiệt độ</p>
                    <!-- <php echo Session::get('light') ?> -->
                    <!-- <div id="mqttData"></div> -->
                    <h6 id="temperature" class="mb-0 number" id="temperatureElement"><?php echo Session::get('nhietDo') ?></h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4 fontsize" style="margin-top:70px;">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p5">
                <i class="fa fa-chart-line fa-3x bi bi-droplet-half" 
                id="dropletIcon"></i>
                <p id="dropletWarning1" 
                    class="mb-2 d-none blinking"><i class="bi bi-exclamation-triangle-fill warning"></i> Cảnh báo độ ẩm cao!</p>
                <p id="dropletWarning2" 
                    class="mb-2 d-none blinking"><i class="bi bi-exclamation-triangle-fill warning"></i> Cảnh báo độ ẩm thấp!</p>
                <div id="dropletContainer" class="ms-3">
                    <!-- droplet -->
                    <p class="mb-2">Độ ẩm </p>
                    <h6 id="droplet" class="mb-0 number" id="dropletElement"></h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4 fontsize" style="margin-top:70px;">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p5">
                <i class="fa fa-chart-line fa-3x bi bi-lightbulb" 
                id="lightIcon"></i>
                <p id="lightWarning1" 
                    class=" mb-2 d-none blinking"><i class="bi bi-exclamation-triangle-fill warning"></i> Cảnh báo độ sáng mạnh!</p>
                <p id="lightWarning2" 
                    class=" mb-2 d-none blinking"><i class="bi bi-exclamation-triangle-fill warning"></i> Cảnh báo độ sáng thấp!</p>
                <div id="lightContainer" class="ms-3">
                    <!-- thermometer -->
                    <p class="mb-2">Độ sáng</p>
                    <h6 id="light" class="mb-0 number2" id="lightElement"></h6>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Sale & Revenue End -->
<!-- Sales Chart Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-8">
            <div class="bg-secondary text-center rounded p52">
                <canvas id="temperature-humidity-lightIntensity"></canvas>
            </div>
        </div>
        <div class="col-sm-12 col-xl-4">
            <div class="bg-secondary text-center rounded p51 fanContainer {{ session::get('led') ? 'on' : '' }}" style="margin-bottom:1.25rem;" id="bulbcontainer">
                <div class="bulb-container">
                    <div class="light">
                        <div class="wire"></div>
                        <div class="bulb">
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
                <form id="checkboxForm" method="post">
                    {{ csrf_field() }}
                    <div class="onoff ">
                        <input id="toggle1" class="toggle checkbox" 
                        {{ session::get('led') ? 'checked' : '' }}
                        type="checkbox" role="switch" name="toggle" value="on" aria-checked="true">
                        <audio src="{{('public/front-end/img/Sound.mp4')}}" id="audio" autostart="false"></audio>
                        <label for="toggle1" class="slot" style="width:50px;">
                            <span class="slot__label">FF</span>
                            <span class="slot__label">N </span>
                        </label>
                        <div class="curtain"></div>
                    </div>
                    <br>
                    <h5 style=" position: absolute;color:green;top:330px;">Số lần bật: <span style="color: green;" id='onTimesLed'>{{$ledStatusOn}}</span></h5>
                    <h5 style=" position: absolute;color:red;top:370px;">Số lần tắt: <span style="color: red;" id='offTimesLed'>{{$ledStatusOff}}</span></h5>
                </form>
            </div>
            <div class="bg-secondary text-center rounded p51 fanContainer">
                <div class="fan">
                    <div class="base"></div>
                    <label for="btn" class="labell {{ session::get('fan') ? 'on2' : '' }}" id="fanContainer">
                        <span></span>
                        <span></span>
                        <span></span>
                    </label>
                    <form id="checkboxForm" method="post" action="{{URL::to('/update-checkbox2')}}">
                         <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="onoff on-off2">
                        </td>
                            <input id="toggle2" class="toggle checkbox checkboxfan" type="checkbox"
                            {{ session::get('fan') ? 'checked' : '' }}>
                            <audio src="{{ asset('public/front-end/img/Sound.mp4') }}" id="audio2" autostart="false"></audio>
                            <label for="toggle2" class="slot" style="width:50px;">
                                <span class="slot__label">FF</span>
                                <span class="slot__label">N</span>
                            </label>
                            <div class="curtain"></div>
                        </div>
                    <h5 style=" position: absolute;color:green;top:50px;left:-160px;">Số lần bật: <span style="color: green;" id='onTimesFan'>{{$fanStatusOn}}</span></h5>
                    <h5 style=" position: absolute;color:red;top:90px;left:-160px;">Số lần tắt: <span style="color: red;" id='offTimesFan'>{{$fanStatusOff}}</span></h5>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

@endsection