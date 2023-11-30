@extends('welcome')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dữ liệu MQTT</div>

                <div class="card-body">
                    <div id="mqtt-data">
                        <!-- Dữ liệu MQTT sẽ được hiển thị ở đây -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Thêm một phần tử có ID để làm mới trang -->
<script>
    const refreshInterval = 5000; // Thời gian làm mới (5 giây)
    
    // Hàm tự động làm mới trang sau một khoảng thời gian
    function autoRefresh() {
        setTimeout(() => {
            location.reload();
        }, refreshInterval);
    }
    
    // Gọi hàm tự động làm mới
    autoRefresh();
</script>
@endsection