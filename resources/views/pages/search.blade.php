@extends('welcome')
@section('content')
<title>Lịch sử</title>
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <!-- <h6 class="mb-4">Nhiệt độ - Độ ẩm - Độ sáng</h6> -->
                <div class="table-responsive">
                    <table class="table table-bordered" style="text-align:center;">
                        <thead>
                            <tr>
                                <th scope="col">Stt</th>
                                <th scope="col">Nhiệt độ (℃)</th>
                                <th scope="col">Độ ẩm (%)</th>
                                <th scope="col">Độ sáng (Lux)</th>
                                <th scope="col">Thời gian</th>
                                <th scope="col">Ngày</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tbody id="tableDHT"></tbody>
                    </table>
                    <div class="btn-group me-2" id="paginationButtonsDHT" role="group" aria-label="First group"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Trạng thái đèn</h6>
                <table class="table table-bordered" style="text-align:center;" id="dataTableLed">
                    <thead>
                        <tr>
                            <th scope="col">Stt</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Thời gian</th>
                            <th scope="col">Ngày</th>
                        </tr>
                    </thead>
                    <!-- <tbody id="tableLed">
                        @foreach($ledstatus as $status)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td style="color: green">Bật</td>
                                <td>{{ $status->time }}</td>
                                <td>{{ $status->day }}</td>
                            </tr>
                        @endforeach
                    </tbody> -->
                    <tbody id="tableBody"></tbody>
                </table>
                <div class="btn-group me-2" id="paginationButtons" role="group" aria-label="First group"></div>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Trạng thái quạt</h6>
                <table class="table table-bordered" style="text-align:center;" id="dataTableFan">
                    <thead>
                        <tr>
                            <th scope="col">Stt</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Thời gian</th>
                            <th scope="col">Ngày</th>
                        </tr>
                    </thead>
                    <!-- <tbody>
                        <tr>
                            <th scope="row">3</th>
                            <td>12:16:00</td>
                            <td style="color: green">Bật</td>
                        </tr>
                    </tbody> -->
                    <tbody id="tableFan"></tbody>
                </table>
                <div class="btn-group me-2" id="paginationButtonsFan" role="group" aria-label="First group"></div>
            </div>
        </div>
        
    </div>
<!-- Table End -->
<script>
const ledStatus = [
    @foreach($ledstatus as $status)
        {!! json_encode($status) !!}
        @if (!$loop->last)
            ,
        @endif
    @endforeach
];

const itemsPerPage = 7;
const totalItems = ledStatus.length;

function displayTable(page) {
    const startIndex = (page - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const displayItems = ledStatus.slice(startIndex, endIndex);

    const tableBody = document.getElementById('tableBody');
    tableBody.innerHTML = '';

    displayItems.forEach((status, index) => {
        let statusColor = '';
        let statusText = '';

        if (status.status == 1) {
            statusColor = 'green';
            statusText = 'Bật';
        } else {
            statusColor = 'red';
            statusText = 'Tắt';
        }

        const row = `
            <tr>
                <td>${startIndex + index + 1}</td>
                <td style="color: ${statusColor}">${statusText}</td>
                <td>${status.time}</td>
                <td>${status.day}</td>
            </tr>
        `;

        tableBody.innerHTML += row;
    });

    renderButtons(page);
}

function renderButtons(currentPage) {
    const pageCount = Math.ceil(totalItems / itemsPerPage);

    const paginationButtons = document.getElementById('paginationButtons');
    paginationButtons.innerHTML = ''; // Xóa nút phân trang cũ

    const maxButtonsToShow = 10; // Số lượng nút phân trang tối đa cần hiển thị

    let startPage = 1;
    let endPage = pageCount;

    if (pageCount > maxButtonsToShow) {
        const middleButtonOffset = Math.floor(maxButtonsToShow / 2);
        startPage = Math.max(currentPage - middleButtonOffset, 1);
        endPage = startPage + maxButtonsToShow - 1;

        if (endPage > pageCount) {
            endPage = pageCount;
            startPage = Math.max(endPage - maxButtonsToShow + 1, 1);
        }
    }

    for (let i = startPage; i <= endPage; i++) {
        const button = document.createElement('button');
        button.textContent = i;
        button.type = 'button'; // Thêm thuộc tính type
        button.classList.add('btn', 'btn-primary'); // Thêm class
        button.addEventListener('click', () => {
            displayTable(i);
        });

        if (i === currentPage) {
            button.classList.add('active');
        }

        paginationButtons.appendChild(button);
    }
}

// Hiển thị trang đầu tiên khi trang được load
displayTable(1);
</script>

<!-- ----------------------------------------------------- -->

<script>
const fanStatus = [
    @foreach($fanstatus as $status)
        {!! json_encode($status) !!}
        @if (!$loop->last)
            ,
        @endif
    @endforeach
];

const itemsPerPageFan = 7;
const totalItemsFan = fanStatus.length;

function displayFanTable(page) {
    const startIndex = (page - 1) * itemsPerPageFan;
    const endIndex = startIndex + itemsPerPageFan;
    const displayItemsFan = fanStatus.slice(startIndex, endIndex);

    const tableBodyFan = document.getElementById('tableFan');
    tableBodyFan.innerHTML = '';

    displayItemsFan.forEach((status, index) => {
        let statusColor = '';
        let statusText = '';

        if (status.status == 1) {
            statusColor = 'green';
            statusText = 'Bật';
        } else {
            statusColor = 'red';
            statusText = 'Tắt';
        }

        const row = `
            <tr>
                <td>${startIndex + index + 1}</td>
                <td style="color: ${statusColor}">${statusText}</td>
                <td>${status.time}</td>
                <td>${status.day}</td>
            </tr>
        `;

        tableBodyFan.innerHTML += row;
    });

    renderFanButtons(page);
}

function renderFanButtons(currentPage) {
    const pageCount = Math.ceil(totalItemsFan / itemsPerPageFan);

    const paginationButtonsFan = document.getElementById('paginationButtonsFan');
    paginationButtonsFan.innerHTML = ''; // Xóa nút phân trang cũ

    const maxButtonsToShowFan = 10; // Số lượng nút phân trang tối đa cần hiển thị

    let startPageFan = 1;
    let endPageFan = pageCount;

    if (pageCount > maxButtonsToShowFan) {
        const middleButtonOffsetFan = Math.floor(maxButtonsToShowFan / 2);
        startPageFan = Math.max(currentPage - middleButtonOffsetFan, 1);
        endPageFan = startPageFan + maxButtonsToShowFan - 1;

        if (endPageFan > pageCount) {
            endPageFan = pageCount;
            startPageFan = Math.max(endPageFan - maxButtonsToShowFan + 1, 1);
        }
    }

    for (let i = startPageFan; i <= endPageFan; i++) {
        const buttonFan = document.createElement('button');
        buttonFan.textContent = i;
        buttonFan.type = 'button'; // Thêm thuộc tính type
        buttonFan.classList.add('btn', 'btn-primary'); // Thêm class
        buttonFan.addEventListener('click', () => {
            displayFanTable(i);
        });

        if (i === currentPage) {
            buttonFan.classList.add('active');
        }

        paginationButtonsFan.appendChild(buttonFan);
    }
}

// Hiển thị trang đầu tiên khi trang được load
displayFanTable(1);
</script>




<script>
    <?php 
        use App\Models\datadht;
        $datadht = datadht::where('day', $datax)->get();
    ?>
const datadht = [
    @foreach($datadht as $data)
        {!! json_encode($data) !!}
        @if (!$loop->last)
            ,
        @endif
    @endforeach
];

const itemsPerPageDHT = 7;
const totalItemsDHT = datadht.length;

function displayDHTTable(page) {
    const startIndex = (page - 1) * itemsPerPageDHT;
    const endIndex = startIndex + itemsPerPageDHT;
    const displayItemsDHT = datadht.slice(startIndex, endIndex);

    const tableBodyDHT = document.getElementById('tableDHT');
    tableBodyDHT.innerHTML = '';

    displayItemsDHT.forEach((data, index) => {
        const row = `
            <tr>
                <td>${startIndex + index + 1}</td>
                <td>${data.temperature}</td>
                <td>${data.humidity}</td>
                <td>${data.light}</td>
                <td>${data.time}</td>
                <td>${data.day}</td>
            </tr>
        `;

        tableBodyDHT.innerHTML += row;
    });

    renderDHTButtons(page);
}

function renderDHTButtons(currentPage) {
    const pageCount = Math.ceil(totalItemsDHT / itemsPerPageDHT);

    const paginationButtonsDHT = document.getElementById('paginationButtonsDHT');
    paginationButtonsDHT.innerHTML = ''; // Xóa nút phân trang cũ

    const maxButtonsToShowDHT = 10; // Số lượng nút phân trang tối đa cần hiển thị

    let startPageDHT = 1;
    let endPageDHT = pageCount;

    if (pageCount > maxButtonsToShowDHT) {
        const middleButtonOffsetDHT = Math.floor(maxButtonsToShowDHT / 2);
        startPageDHT = Math.max(currentPage - middleButtonOffsetDHT, 1);
        endPageDHT = startPageDHT + maxButtonsToShowDHT - 1;

        if (endPageDHT > pageCount) {
            endPageDHT = pageCount;
            startPageDHT = Math.max(endPageDHT - maxButtonsToShowDHT + 1, 1);
        }
    }

    for (let i = startPageDHT; i <= endPageDHT; i++) {
        const buttonDHT = document.createElement('button');
        buttonDHT.textContent = i;
        buttonDHT.type = 'button'; // Thêm thuộc tính type
        buttonDHT.classList.add('btn', 'btn-primary'); // Thêm class
        buttonDHT.addEventListener('click', () => {
            displayDHTTable(i);
        });

        if (i === currentPage) {
            buttonDHT.classList.add('active');
        }

        paginationButtonsDHT.appendChild(buttonDHT);
    }
}

// Hiển thị trang đầu tiên khi trang được load
displayDHTTable(1);
</script>
@endsection