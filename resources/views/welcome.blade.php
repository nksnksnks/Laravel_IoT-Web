<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/png" href="{{('public/front-end/img/icon.png')}}"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{('public/front-end/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{('public/front-end/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css')}}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{('public/front-end/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{('public/front-end/css/style.css')}}" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Sidebar Start -->
        <style>
            .hover:hover{
                color: red;
            }
        </style>
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="{{URL::to('/')}}" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>IoT-NKS</h3>
                </a>
                <div class="navbar-nav w-100">
                    <a href="{{URL::to('/')}}" class="nav-item nav-link active hover"><i class="fa fa-tachometer-alt me-2"></i>Trang chủ</a>
                    <a href="{{URL::to('/thong-tin-ca-nhan')}}" class="nav-item nav-link hover"><i class="bi bi-person-circle"></i>  Thông tin cá nhân</a>
                    <a href="{{URL::to('/lich-su')}}" class="nav-item nav-link hover"><i class="bi bi-table"></i>  Lịch sử</a>
                </div>
                <div id="dataContainer">
                    <?php echo Session::get('doAmmmm')?>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="{{URL::to('/')}}" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-1" style="width:600px;" action="{{URL::to('/search')}}" method='POST'>
                    {{ csrf_field() }}
                    <input class="form-control bg-dark border-0" type="date" placeholder="Search" style="padding: -10px 0 -10px 10px;height: 40px;margin:7px 0px 0 30px;"
                    name="daysearch">
                    <button class="btn btn-outline-primary w-100 m-2" type="submit" >Tìm kiếm</button>
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="{{('public/front-end/img/user.jpg')}}" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex">SownNK</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="{{URL::to('/')}}" class="dropdown-item">Trang chủ</a>
                            <a href="{{URL::to('/thong-tin-ca-nhan')}}" class="dropdown-item">Thông tin cá nhân</a>
                            <a href="{{URL::to('/lich-su')}}" class="dropdown-item">Lịch sử</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            @yield('content')  
            
        </div>

    <!-- JavaScript Libraries -->
    <script>
        let toggle1 = document.querySelector('#toggle1');
        let bulbcontainer = document.querySelector('#bulbcontainer');
        let audio = document.querySelector('#audio');
        toggle1.addEventListener('change', function() {
            if (toggle1.checked) {
                audio.play();
                bulbcontainer.classList.add('on');
                    $.ajax({
                    type: 'POST',
                    url: 'send-mqtt-command',
                    data: {_token: '{{ csrf_token() }}'},
                    success: function (data) {
                        $.ajax({
                            type: 'GET',
                            url: 'on-off-times',
                            success: function (response) {
                                const onTimesLed = document.getElementById('onTimesLed');
                                onTimesLed.textContent = response.ledStatusOn;
                            },
                            error: function (data) {
                                console.log('Error:', data);
                            }
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            } else {
                audio.play();
                bulbcontainer.classList.remove('on');
                    $.ajax({
                    type: 'POST',
                    url: '{{route("send-mqtt-commandoff")}}',
                    data: {_token: '{{ csrf_token() }}'},
                    success: function (data) {
                        console.log(data);
                        $.ajax({
                            type: 'GET',
                            url: 'on-off-times',
                            success: function (response) {
                                const offTimesLed = document.getElementById('offTimesLed');
                                offTimesLed.textContent = response.ledStatusOff;
                            },
                            error: function (data) {
                                // Xử lý lỗi nếu cần
                                console.log('Error:', data);
                            }
                        });
                    },
                    error: function (data) {
                        // Xử lý lỗi nếu cần
                        console.log('Error:', data);
                    }
                });
            }
        });
        // Lấy phần tử input có id là toggle1
        var checkbox = document.getElementById("toggle1");
    </script>
    <script>
        
        let toggle2 = document.querySelector('#toggle2'); 
        let fancontainer = document.querySelector('#fanContainer');
        let audio2 = document.querySelector('#audio2');
        toggle2.addEventListener('change', function() {
            if (toggle2.checked){
                audio2.play();
                fanContainer.classList.add('on2');
                $.ajax({
                    type: 'POST',
                    url: 'send-mqtt-command2',
                    data: {_token: '{{ csrf_token() }}'},
                    success: function (data) {
                        console.log(data);
                        $.ajax({
                            type: 'GET',
                            url: 'on-off-times',
                            success: function (response) {
                                const onTimesFan = document.getElementById('onTimesFan');
                                onTimesFan.textContent = response.fanStatusOn;
                            },
                            error: function (data) {
                                // Xử lý lỗi nếu cần
                                console.log('Error:', data);
                            }
                        });
                    },
                    error: function (data) {
                        // Xử lý lỗi nếu cần
                        console.log('Error:', data);
                    }
                });
            } else {
                audio2.play();
                fanContainer.classList.remove('on2');
                $.ajax({
                    type: 'POST',
                    url: 'send-mqtt-commandoff2',
                    data: {_token: '{{ csrf_token() }}'},
                    success: function (data) {
                        // Xử lý kết quả nếu cần
                        console.log(data);
                        $.ajax({
                            type: 'GET',
                            url: 'on-off-times',
                            success: function (response) {
                                const offTimesFan = document.getElementById('offTimesFan');
                                offTimesFan.textContent = response.fanStatusOff;
                            },
                            error: function (data) {
                                // Xử lý lỗi nếu cần
                                console.log('Error:', data);
                            }
                        });
                    },
                    error: function (data) {
                        // Xử lý lỗi nếu cần
                        console.log('Error:', data);
                    }
                });
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{('public/front-end/lib/chart/chart.min.js')}}"></script>
    <script src="{{('public/front-end/lib/easing/easing.min.js')}}"></script>
    <script src="{{('public/front-end/lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{('public/front-end/lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{('public/front-end/lib/tempusdominus/js/moment.min.js')}}"></script>
    <script src="{{('public/front-end/lib/tempusdominus/js/moment-timezone.min.js')}}"></script>
    <script src="{{('public/front-end/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js')}}"></script>

    <!-- Template Javascript -->
    <script src="{{('public/front-end/js/main.js')}}"></script>
    <script>
        var ctx2 = $("#temperature-humidity-lightIntensity").get(0).getContext("2d");
        var myChart2 = new Chart(ctx2, {
            type: "line",
            data: {
                labels: ["0", "0", "0", "0", "0", "0", "0", "0", "0"],
                datasets: [{
                        label: "Nhiệt độ",
                        yAxisID: 'A',
                        data: [0, 0, 0, 0, 0, 0, 0, 0, 0], 
                        backgroundColor: "rgba(235, 22, 22, .7)",
                        borderColor: "rgb(0,0,0)",

                        fill: true,
                    },
                    {
                        label: "Độ ẩm",
                        yAxisID: 'A',
                        data: [0, 0, 0, 0, 0, 0, 0, 0, 0],
                        backgroundColor: "rgba(82, 193, 245, .6)",
                        borderColor: "rgb(0,0,0)",
                        fill: true,
                    }, 
                    {
                        label: "Độ sáng",
                        yAxisID: 'B',
                        data: [0, 0, 0, 0, 0, 0, 0, 0, 0],
                        backgroundColor: "rgba(255, 250, 87, .5)",
                        borderColor: "rgb(0,0,0)",
                        fill: true,
                    }
                ]
                },
                options: {
                    responsive: true,
                    scales: {
                    A: {
                        type: 'linear',
                        position: 'left',
                        ticks: { beginAtZero: true, color: 'rgba(89, 94, 121)' },
                        // Hide grid lines, otherwise you have separate grid lines for the 2 y axes
                        grid: { display: false }
                    },
                    B: {
                        type: 'linear',
                        position: 'right',
                        ticks: { beginAtZero: true, color: 'rgba(89, 94, 121)' },
                        grid: { display: false }
                    },
                    x: { ticks: { beginAtZero: true } }
                    }
                }
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var Temperature, Humidity, Light;
        function fetchData0() {
            $.ajax({
                type: 'GET',
                url: 'subscribe',
                success: function (response) {
                    x = response.temperature;
                    Temperature = x.toFixed(1);
                    Humidity = response.humidity;
                    Light = response.light;
                    
                },
                error: function (data) {
                    // Xử lý lỗi nếu cần
                }
            });
        }
        setInterval(fetchData0, 5000);
        // fetchData0(); 
    </script>
    
    <!-- Temperature -->
    <script>
        function getIconForTemperature(temperature) {
            if (temperature < 10) {
                return "bi bi-thermometer";
            } else if (temperature >= 10 && temperature < 20) {
                return "bi bi-thermometer-low";
            } else if (temperature >= 20 && temperature < 35) {
                return "bi bi-thermometer-half";
            } else {
                return "bi bi-thermometer-high";
            }
        }
    
        function temperatureToColor(temperature) {
            if(temperature<=45 && temperature>30){
                const red = 255;
                const green = 255-((temperature-30)/15)*255;
                const blue = 0;
                return `rgb(${red}, ${green}, ${blue})`;
            }else if(temperature<=30 && temperature>15){
                const red = 0;
                const green = 255;
                const blue = 170+((temperature-15)/15)*185;
                return `rgb(${red}, ${green}, ${blue})`;
            }else{
                const red = 0;
                const green = (temperature/45)*200;
                const blue = 255;
                return `rgb(${red}, ${green}, ${blue})`;
            }
        }
        const temperatureData = [0, 0, 0, 0, 0, 0, 0, 0, 0];
        const timeUpdate = ["0", "0", "0", "0", "0", "0", "0", "0", "0"]; 
        function updateTemperature() {
            const temperatureElement = document.getElementById('temperature');
            const temperatureContainer = document.getElementById('temperatureContainer');
            const randomTemperature = Temperature;
            const temperatureWarning = document.getElementById('temperatureWarning');
            const temperatureWarningHot = document.getElementById('temperatureWarningHot');
            const temperatureWarningCold = document.getElementById('temperatureWarningCold');
            const temperatureIcon = document.getElementById('temperatureIcon');
            temperatureElement.textContent = randomTemperature + '℃';
            const bgColor = temperatureToColor(randomTemperature);
            const textColor = temperatureToColor(randomTemperature);
            temperatureContainer.style.color = textColor;
            temperatureIcon.className = "fa fa-3x " + getIconForTemperature(randomTemperature);
            temperatureIcon.style.color = textColor;
            temperatureElement.style.color = textColor;
            temperatureWarningCold.style.color = textColor;
            temperatureWarningHot.style.color = textColor;
            temperatureWarningHot.classList.toggle('d-none', randomTemperature <= 35);
            temperatureWarningCold.classList.toggle('d-none', randomTemperature >= 10);

            function getCurrentTime() {
                const now = new Date();
                const hours = now.getHours().toString().padStart(2, '0');
                const minutes = now.getMinutes().toString().padStart(2, '0');
                const seconds = now.getSeconds().toString().padStart(2, '0');
                
                return `${hours}:${minutes}:${seconds}`;
            }
            timeUpdate.shift();
            timeUpdate.push(getCurrentTime());
            myChart2.data.labels = timeUpdate;

            temperatureData.shift();
            temperatureData.push(randomTemperature);
            myChart2.data.datasets[0].data = temperatureData;

            myChart2.update();
            setTimeout(updateTemperature, 5000);
            
        }
    
        document.addEventListener('DOMContentLoaded', function () {
            updateTemperature();
        });
    </script>


    <!-- Humidity -->

    <script>
        function getIconForDroplet(droplet) {
            if (droplet < 40) {
                return "bi bi-droplet";
            } else if (droplet >= 40 && droplet < 65) {
                return "bi bi-droplet-half";
            } else {
                return "bi bi-droplet-fill";
            }
        }
    
        function dropletToColor(droplet) {
            const red = 199-(droplet/100)*199;
            const green = 216-(droplet/100)*(216-76);
            const blue = 255;
            return `rgb(${red}, ${green}, ${blue})`;
        }
        const dropletData = [0, 0, 0, 0, 0, 0, 0, 0, 0];
        function updateDroplet() {
            const dropletElement = document.getElementById('droplet');
            const dropletContainer = document.getElementById('dropletContainer');
            const randomDroplet = Humidity;
            const dropletWarning1 = document.getElementById('dropletWarning1');
            const dropletWarning2 = document.getElementById('dropletWarning2');
            const dropletIcon = document.getElementById('dropletIcon');
            dropletElement.textContent = randomDroplet + '%';
            const bgColor = dropletToColor(randomDroplet);
            const textColor = dropletToColor(randomDroplet);
            dropletContainer.style.color = textColor;
            dropletIcon.style.color = textColor;
            dropletWarning1.style.color = textColor;
            dropletWarning2.style.color = textColor;
            dropletIcon.className = "fa fa-3x " + getIconForDroplet(randomDroplet);
            dropletIcon.style.color = textColor;
            dropletElement.style.color = textColor;
            dropletWarning1.classList.toggle('d-none', randomDroplet <= 70);
            dropletWarning2.classList.toggle('d-none', randomDroplet >= 10);
            
            dropletData.shift();

            dropletData.push(randomDroplet);

            myChart2.data.datasets[1].data = dropletData;

            myChart2.update();
            setTimeout(updateDroplet, 5000);
            
        }
    
        document.addEventListener('DOMContentLoaded', function () {
            updateDroplet();
        });
    </script>


    <!-- Light -->
    <script>
        function getIconForLight(light) {
            if (light < 100) {
                return "bi bi-lightbulb";
            } else {
                return "bi bi-lightbulb-fill";
            }
        }
    
        function lightToColor(light) {
            if(light < 150){
                const red = (light/150)*255;
                const green = (light/150)*200;
                const blue = 0;
                return `rgb(${red}, ${green}, ${blue})`;
            }else{
                const red = 255;
                const green = 255;
                const blue = ((light-150)/350)*255;
                return `rgb(${red}, ${green}, ${blue})`;
            }
        }
        const lightData = [0, 0, 0, 0, 0, 0, 0, 0, 0];
        function updateLight() {
            const lightElement = document.getElementById('light');
            const lightContainer = document.getElementById('lightContainer');
            const randomLight = Light;
            const lightWarning1 = document.getElementById('lightWarning1');
            const lightWarning2 = document.getElementById('lightWarning2');
            const lightIcon = document.getElementById('lightIcon');
            lightElement.textContent = randomLight + ' Lux';
            const bgColor = lightToColor(randomLight);
            const textColor = lightToColor(randomLight);
            lightContainer.style.color = textColor;
            lightIcon.style.color = textColor;
            lightWarning1.style.color = textColor;
            lightWarning2.style.color = textColor;
            lightIcon.className = "fa fa-3x " + getIconForLight(randomLight);
            lightIcon.style.color = textColor;
            lightElement.style.color = textColor;
            lightWarning1.classList.toggle('d-none', randomLight <= 1200);
            lightWarning2.classList.toggle('d-none', randomLight >= 1000);
            lightData.shift();

            lightData.push(randomLight);

            myChart2.data.datasets[2].data = lightData;

            myChart2.update();
            setTimeout(updateLight, 5000);
            
        }
    
        document.addEventListener('DOMContentLoaded', function () {
            updateLight();
        });
    </script>
    <!-- <script>
        document.getElementById("toggle").addEventListener("change",function() {
        this.setAttribute("aria-checked",this.checked);
        });
    </script> -->
</body>

</html>