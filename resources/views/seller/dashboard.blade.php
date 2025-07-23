@extends('layouts.seller.main')

@section('content')
<!--=== Start Status Area ===-->
<div class="status-area">
    <div class="row justify-content-center js-grid">
        <div class="col-xxl-3 col-sm-6">
            <div class="card status-card border-0 rounded-3 mb-24 cursor-move">
                <div class="card-body p-25 text-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="icon rounded-3">
                                <i data-feather="shopping-bag"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <span class="d-block mb-1">Total Sales</span>
                            <h3 class="fs-25">15,821</h3>
                            <p class="fw-medium fs-13">Increase by <span class="badge bg-success-transparent text-success mx-1"><i data-feather="trending-up" class="me-1"></i> 4.2%</span> this month</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <div class="card status-card border-0 rounded-3 mb-24 cursor-move">
                <div class="card-body p-25 text-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="icon rounded-3">
                                <i data-feather="dollar-sign"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <span class="d-block mb-1">Total Expenses</span>
                            <h3 class="fs-25"> $30,125.00 </h3>
                            <p class="fw-medium fs-13">Increase by <span class="badge bg-success-transparent text-success mx-1"><i data-feather="trending-up" class="me-1"></i> 12.0%</span> this month</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <div class="card status-card border-0 rounded-3 mb-24 cursor-move">
                <div class="card-body p-25 text-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="icon rounded-3">
                                <i data-feather="users"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <span class="d-block mb-1">Total Visitors</span>
                            <h3 class="fs-25"> 2,11,125 </h3>
                            <p class="fw-medium fs-13">Increase by <span class="badge bg-danger-transparent text-danger mx-1"> <i data-feather="trending-down" class="me-1"></i> 7.6%</span> this month</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <div class="card status-card border-0 rounded-3 mb-24 cursor-move">
                <div class="card-body p-25 text-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="icon rounded-3">
                                <i data-feather="shopping-cart"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <span class="d-block mb-1">Total Orders</span>
                            <h3 class="fs-25">40,952</h3>
                            <p class="fw-medium fs-13">Increase by <span class="badge bg-success-transparent text-success mx-1"> <i data-feather="trending-up" class="me-1"></i> 2.5%</span> this month</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--=== End Status Area ===-->

<!--=== Start Sales Overview Area ===-->
<div class="sales-overview-area">
    <div class="row justify-content-center">
        <div class="col-xxl-8 js-grid">
            <div class="card rounded-3 border-0 mb-24">
                <div class="card-body p-25">
                    <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color cursor-move">
                        <h4 class="mb-0">Sales Overview</h4>

                        <select class="form-select form-control" aria-label="Default select example">
                            <option selected>Today</option>
                            <option value="1">This Week</option>
                            <option value="2">This Month</option>
                            <option value="3">This Year</option>
                        </select>
                    </div>

                    <div id="sales_overview"></div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card rounded-3 border-0 revenue-status-card mb-24">
                        <div class="card-body p-25">
                            <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color cursor-move">
                                <h4 class="mb-0">Revenue Status</h4>

                                <select class="form-select form-control" aria-label="Default select example">
                                    <option selected>Today</option>
                                    <option value="1">This Week</option>
                                    <option value="2">This Month</option>
                                    <option value="3">This Year</option>
                                </select>
                            </div>

                            <div id="revenue_status"></div>
                        </div>
                    </div>

                    <div class="card rounded-3 border-0 total-summary-card mb-24">
                        <div class="card-body p-25">
                            <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color cursor-move">
                                <h4 class="mb-0">Total Summary</h4>

                                <select class="form-select form-control" aria-label="Default select example">
                                    <option selected>Today</option>
                                    <option value="1">This Week</option>
                                    <option value="2">This Month</option>
                                    <option value="3">This Year</option>
                                </select>
                            </div>

                            <ul class="total-summary ps-0 mb-0 list-unstyled o-sortable">
                                <li class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="icon">
                                            <i data-feather="credit-card"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <span class="fw-medium mb-2 d-block">Income</span>
                                        <div class="progress position-relative overflow-visible rounded-1 cursor-move bg-white1" role="progressbar" aria-label="Example with label" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar rounded-1 bg-success" style="width: 95%">
                                                <span class="count position-absolute fw-semibold">95%</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="icon bg-2">
                                            <i data-feather="credit-card"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <span class="fw-medium mb-2 d-block">Profit</span>
                                        <div class="progress position-relative overflow-visible rounded-1 cursor-move bg-white1" role="progressbar" aria-label="Example with label" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar rounded-1 bg-primary" style="width: 85%">
                                                <span class="count position-absolute fw-semibold">85%</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="icon bg-3">
                                            <i data-feather="credit-card"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <span class="fw-medium mb-2 d-block">Expenses</span>
                                        <div class="progress position-relative overflow-visible rounded-1 cursor-move bg-white1" role="progressbar" aria-label="Example with label" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar rounded-1 bg-warning" style="width: 75%">
                                                <span class="count position-absolute fw-semibold">75%</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card rounded-3 border-0 activity-status-card mb-24">
                        <div class="card-body text-body p-25">
                            <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color cursor-move">
                                <h4 class="mb-0">Activity</h4>

                                <select class="form-select form-control" aria-label="Default select example">
                                    <option selected>Today</option>
                                    <option value="1">This Week</option>
                                    <option value="2">This Month</option>
                                    <option value="3">This Year</option>
                                </select>
                            </div>

                            <ul class="list-unstyled ps-0 mb-0 activity-list h-550" data-simplebar>
                                <li class="mb-20">
                                    <a href="#" class="d-flex text-decoration-none text-body">
                                        <div class="flex-shrink-0">
                                            <div class="icon">
                                                <i data-feather="user"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="fw-semibold text-dark d-block mb-1 fs-15">Donald</span>
                                            <p>Updated the status of <span class="text-dark">Refund #1234</span> to awaiting customer response</p>
                                            <span class="fs-12">1 Min ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="mb-20">
                                    <a href="#" class="d-flex text-decoration-none text-body">
                                        <div class="flex-shrink-0">
                                            <div class="icon">
                                                <img src="/admin-assets/assets/images/user/user-1.jpg" class="rounded-circle" alt="user-1">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="fw-semibold text-dark d-block mb-1 fs-15">Lucy Peterson</span>
                                            <p>Was added to the group, group name is Overtake</p>
                                            <span class="fs-12">3 Min ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="mb-20">
                                    <a href="#" class="d-flex text-decoration-none text-body">
                                        <div class="flex-shrink-0">
                                            <div class="icon">
                                                <i data-feather="credit-card"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="fw-semibold text-dark d-block mb-1 fs-15">Joseph Rust</span>
                                            <p>Opened new showcase <span class="text-dark">Mannat #112233</span> with theme market</p>
                                            <span class="fs-12">6 Min ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="d-flex text-decoration-none text-body">
                                        <div class="flex-shrink-0">
                                            <div class="icon">
                                                <img src="/admin-assets/assets/images/user/user-2.jpg" class="rounded-circle" alt="user-2">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="fw-semibold text-dark d-block mb-1 fs-15">Juhon Dew</span>
                                            <p>Updated the status of <span class="text-dark">Refund #1234</span> to awaiting customer response</p>
                                            <span class="fs-12">7 Min ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="mb-20">
                                    <a href="#" class="d-flex text-decoration-none text-body">
                                        <div class="flex-shrink-0">
                                            <div class="icon">
                                                <i data-feather="alert-circle"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="fw-semibold text-dark d-block mb-1 fs-15">Warning</span>
                                            <p>Was added to the group, group name is <span class="text-dark">Overtake</span></p>
                                            <span class="fs-12">10 Min ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="mb-20">
                                    <a href="#" class="d-flex text-decoration-none text-body">
                                        <div class="flex-shrink-0">
                                            <div class="icon">
                                                <i data-feather="user"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="fw-semibold text-dark d-block mb-1 fs-15">Donald</span>
                                            <p>Updated the status of <span class="text-dark">Refund #1234</span> to awaiting customer response</p>
                                            <span class="fs-12">11 Min ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="mb-20">
                                    <a href="#" class="d-flex text-decoration-none text-body">
                                        <div class="flex-shrink-0">
                                            <div class="icon">
                                                <img src="/admin-assets/assets/images/user/user-1.jpg" class="rounded-circle" alt="user-1">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="fw-semibold text-dark d-block mb-1 fs-15">Lucy Peterson</span>
                                            <p>Was added to the group, group name is Overtake</p>
                                            <span class="fs-12">2 Hours ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="mb-20">
                                    <a href="#" class="d-flex text-decoration-none text-body">
                                        <div class="flex-shrink-0">
                                            <div class="icon">
                                                <i data-feather="credit-card"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="fw-semibold text-dark d-block mb-1 fs-15">Joseph Rust</span>
                                            <p>Opened new showcase <span class="text-dark">Mannat #112233</span> with theme market</p>
                                            <span class="fs-12">3 Hours ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="d-flex text-decoration-none text-body">
                                        <div class="flex-shrink-0">
                                            <div class="icon">
                                                <img src="/admin-assets/assets/images/user/user-2.jpg" class="rounded-circle" alt="user-2">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="fw-semibold text-dark d-block mb-1 fs-15">Juhon Dew</span>
                                            <p>Updated the status of <span class="text-dark">Refund #1234</span> to awaiting customer response</p>
                                            <span class="fs-12">10 Hours ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="d-flex text-decoration-none text-body">
                                        <div class="flex-shrink-0">
                                            <div class="icon">
                                                <i data-feather="alert-circle"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="fw-semibold text-dark d-block mb-1 fs-15">Warning</span>
                                            <p>Was added to the group, group name is <span class="text-dark">Overtake</span></p>
                                            <span class="fs-12">14 Hours ago</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-4 js-grid">
            <div class="card rounded-3 border-0 sales-by-locations-card mb-24">
                <div class="card-body text-body p-25">
                    <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color cursor-move">
                        <h4 class="mb-0">Sales by Locations</h4>

                        <select class="form-select form-control" aria-label="Default select example">
                            <option selected>Today</option>
                            <option value="1">This Week</option>
                            <option value="2">This Month</option>
                            <option value="3">This Year</option>
                        </select>
                    </div>

                    <div id="sales_by_locations" class="mb-15"></div>

                    <ul class="country-progress ps-0 mb-0 list-unstyled o-sortable">
                        <li>
                            <span class="fw-medium mb-2 d-block">United Kingdom</span>
                            <div class="progress position-relative overflow-visible rounded-1 cursor-move bg-white1" role="progressbar" aria-label="Example with label" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar rounded-1 bg-primary" style="width: 95%">
                                    <span class="count position-absolute fw-medium">95%</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="fw-medium mb-2 d-block">United States </span>
                            <div class="progress position-relative overflow-visible rounded-1 cursor-move bg-white1" role="progressbar" aria-label="Example with label" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar rounded-1 bg-primary" style="width: 85%">
                                    <span class="count position-absolute fw-medium">85%</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="fw-medium mb-2 d-block">Canada</span>
                            <div class="progress position-relative overflow-visible rounded-1 cursor-move bg-white1" role="progressbar" aria-label="Example with label" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar rounded-1 bg-primary" style="width: 75%">
                                    <span class="count position-absolute fw-medium">75%</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="fw-medium mb-2 d-block">Greenland</span>
                            <div class="progress position-relative overflow-visible rounded-1 cursor-move bg-white1" role="progressbar" aria-label="Example with label" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar rounded-1 bg-primary" style="width: 65%">
                                    <span class="count position-absolute fw-medium">65%</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="fw-medium mb-2 d-block">Russia</span>
                            <div class="progress position-relative overflow-visible rounded-1 cursor-move bg-white1" role="progressbar" aria-label="Example with label" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar rounded-1 bg-primary" style="width: 55%">
                                    <span class="count position-absolute fw-medium">55%</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card rounded-3 border-0 website-overview-card mb-24">
                <div class="card-body text-body p-25">
                    <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color cursor-move">
                        <h4 class="mb-0">Weekly Website Overview</h4>

                        <select class="form-select form-control" aria-label="Default select example">
                            <option selected>Today</option>
                            <option value="1">This Week</option>
                            <option value="2">This Month</option>
                            <option value="3">This Year</option>
                        </select>
                    </div>

                    <div id="website_overview"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--=== End Sales Overview Area ===-->

<!--=== Start Recent Orders Area ===-->
<div class="card rounded-3 border-0 recent-orders-card mb-24 table-edit-area">
    <div class="card-body text-body p-25">
        <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color cursor-move">
            <h4 class="mb-0">Recent Orders</h4>

            <select class="form-select form-control" aria-label="Default select example">
                <option selected>Today</option>
                <option value="1">This Week</option>
                <option value="2">This Month</option>
                <option value="3">This Year</option>
            </select>
        </div>

        <div class="table-wrapper">
            <div class="member">
                <div class="delete">
                    <div class="overplay"></div>
                    <div class="choice-delete">
                        <i class="fas fa-times"></i>
                        <h1>Do you delete?</h1>
                        <button type="button" name="cancel-delete" class="btn">Cancel</button>
                        <button type="button" name="yes-delete" class="btn">Delete</button>
                    </div>
                </div>

                <div class="global-table-area">
                    <div class="table-responsive overflow-auto h-540" data-simplebar> 
                        <table class="table align-middle table-bordered" >
                            <thead class="text-dark">
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Product ID</th>
                                    <th scope="col">Transaction ID</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Payment Method</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Sales</th>
                                    <th scope="col">Revenue</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-body o-sortable">
                                <tr>
                                    <td class="edit">01-07-23</td>
                                    <td>
                                        <a href="#" class="d-flex align-items-center text-decoration-none">
                                            <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-1.jpg" alt="product-1">
                                            <span class="fw-medium fs-15 ms-3 edit">Dark Green Jug</span>
                                        </a>
                                    </td>
                                    <td class="edit">#1734-9743</td>
                                    <td class="edit">#14008268610</td>
                                    <td class="edit">$199.99</td>
                                    <td class="edit">Online</td>
                                    <td>
                                        <span class="badge bg-success-transparent text-success fw-normal py-1 px-2 fs-12 rounded-1 edit">Available</span>
                                    </td>
                                    <td class="edit">3,903</td>
                                    <td class="edit">$57,899.24</td>
                                    <td>
                                        <button class="icon border-0 rounded-circle text-center bg-primary-transparent">
                                            <i data-feather="eye"></i>
                                        </button>
                                        <button name="edit" class="icon border-0 rounded-circle text-center edit bg-success-transparent edit-item">
                                            <i data-feather="edit"></i>
                                        </button>
                                        <button name="save" class="icon border-0 rounded-circle text-center edit bg-success-transparent save-item">
                                            <i data-feather="check"></i>
                                        </button>
                                        <button name="delete" class="icon border-0 rounded-circle text-center trash bg-danger-transparent delete-item">
                                            <i data-feather="trash-2"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="edit">02-07-23</td>
                                    <td>
                                        <a href="#" class="d-flex align-items-center text-decoration-none">
                                            <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-2.jpg" alt="product-2">
                                            <span class="fw-medium fs-15 ms-3 edit">Drinking Glasses</span>
                                        </a>
                                    </td>
                                    <td class="edit">#1234-4567</td>
                                    <td class="edit">#31408224782</td>
                                    <td class="edit">$1,299.99</td>
                                    <td class="edit">Cash On Delivery</td>
                                    <td>
                                        <span class="badge bg-success-transparent text-success fw-normal py-1 px-2 fs-12 rounded-1 edit">Available</span>
                                    </td>
                                    <td class="edit">12,435</td>
                                    <td class="edit">$3,24,781.92</td>
                                    <td>
                                        <button class="icon border-0 rounded-circle text-center bg-primary-transparent">
                                            <i data-feather="eye"></i>
                                        </button>
                                        <button name="edit" class="icon border-0 rounded-circle text-center edit bg-success-transparent edit-item">
                                            <i data-feather="edit"></i>
                                        </button>
                                        <button name="save" class="icon border-0 rounded-circle text-center edit bg-success-transparent save-item">
                                            <i data-feather="check"></i>
                                        </button>
                                        <button name="delete" class="icon border-0 rounded-circle text-center trash bg-danger-transparent delete-item">
                                            <i data-feather="trash-2"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="edit">03-05-23</td>
                                    <td>
                                        <a href="#" class="d-flex align-items-center text-decoration-none">
                                            <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-3.jpg" alt="product-3">
                                            <span class="fw-medium fs-15 ms-3 edit">Living Room Lights</span>
                                        </a>
                                    </td>
                                    <td class="edit">#1902-9883</td>
                                    <td class="edit">#92065567861</td>
                                    <td class="edit">$99.99</td>
                                    <td class="edit">Cash On Delivery</td>
                                    <td>
                                        <span class="badge bg-danger-transparent text-danger fw-normal py-1 px-2 fs-12 rounded-1 edit">Not Available</span>
                                    </td>
                                    <td class="edit">3,903</td>
                                    <td class="edit">$57,899.24</td>
                                    <td>
                                        <button class="icon border-0 rounded-circle text-center bg-primary-transparent">
                                            <i data-feather="eye"></i>
                                        </button>
                                        <button name="edit" class="icon border-0 rounded-circle text-center edit bg-success-transparent edit-item">
                                            <i data-feather="edit"></i>
                                        </button>
                                        <button name="save" class="icon border-0 rounded-circle text-center edit bg-success-transparent save-item">
                                            <i data-feather="check"></i>
                                        </button>
                                        <button name="delete" class="icon border-0 rounded-circle text-center trash bg-danger-transparent delete-item">
                                            <i data-feather="trash-2"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="edit">04-07-23</td>
                                    <td>
                                        <a href="#" class="d-flex align-items-center text-decoration-none">
                                            <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-4.jpg" alt="product-4">
                                            <span class="fw-medium fs-15 ms-3 edit">Simple Chair</span>
                                        </a>
                                    </td>
                                    <td class="edit">#8745-1232</td>
                                    <td class="edit">#31652851650</td>
                                    <td class="edit">$80.99</td>
                                    <td class="edit">Online</td>
                                    <td>
                                        <span class="badge bg-warning-transparent text-warning fw-normal py-1 px-2 fs-12 rounded-1 edit">Pending</span>
                                    </td>
                                    <td class="edit">5,903</td>
                                    <td class="edit">$68,899.24</td>
                                    <td>
                                        <button class="icon border-0 rounded-circle text-center bg-primary-transparent">
                                            <i data-feather="eye"></i>
                                        </button>
                                        <button name="edit" class="icon border-0 rounded-circle text-center edit bg-success-transparent edit-item">
                                            <i data-feather="edit"></i>
                                        </button>
                                        <button name="save" class="icon border-0 rounded-circle text-center edit bg-success-transparent save-item">
                                            <i data-feather="check"></i>
                                        </button>
                                        <button name="delete" class="icon border-0 rounded-circle text-center trash bg-danger-transparent delete-item">
                                            <i data-feather="trash-2"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="edit">05-07-23</td>
                                    <td>
                                        <a href="#" class="d-flex align-items-center text-decoration-none">
                                            <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-5.jpg" alt="product-5">
                                            <span class="fw-medium fs-15 ms-3 edit">Teapot with black tea</span>
                                        </a>
                                    </td>
                                    <td class="edit">#1962-9033</td>
                                    <td class="edit">#23518898764</td>
                                    <td class="edit">$299.99</td>
                                    <td class="edit">Bank Transfer</td>
                                    <td>
                                        <span class="badge bg-info-transparent text-info fw-normal py-1 px-2 fs-12 rounded-1 edit">Shipping</span>
                                    </td>
                                    <td class="edit">8,903</td>
                                    <td class="edit">$70,899.24</td>
                                    <td>
                                        <button class="icon border-0 rounded-circle text-center bg-primary-transparent">
                                            <i data-feather="eye"></i>
                                        </button>
                                        <button name="edit" class="icon border-0 rounded-circle text-center edit bg-success-transparent edit-item">
                                            <i data-feather="edit"></i>
                                        </button>
                                        <button name="save" class="icon border-0 rounded-circle text-center edit bg-success-transparent save-item">
                                            <i data-feather="check"></i>
                                        </button>
                                        <button name="delete" class="icon border-0 rounded-circle text-center trash bg-danger-transparent delete-item">
                                            <i data-feather="trash-2"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="edit">06-07-23</td>
                                    <td>
                                        <a href="#" class="d-flex align-items-center text-decoration-none">
                                            <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-6.jpg" alt="product-6">
                                            <span class="fw-medium fs-15 ms-3 edit">Wooden Box</span>
                                        </a>
                                    </td>
                                    <td class="edit">#1731-9742</td>
                                    <td class="edit">#14008268640</td>
                                    <td class="edit">$399.99</td>
                                    <td class="edit">Online</td>
                                    <td>
                                        <span class="badge bg-success-transparent text-success fw-normal py-1 px-2 fs-12 rounded-1 edit">Available</span>
                                    </td>
                                    <td class="edit">7,903</td>
                                    <td class="edit">$80,899.24</td>
                                    <td>
                                        <button class="icon border-0 rounded-circle text-center bg-primary-transparent">
                                            <i data-feather="eye"></i>
                                        </button>
                                        <button name="edit" class="icon border-0 rounded-circle text-center edit bg-success-transparent edit-item">
                                            <i data-feather="edit"></i>
                                        </button>
                                        <button name="save" class="icon border-0 rounded-circle text-center edit bg-success-transparent save-item">
                                            <i data-feather="check"></i>
                                        </button>
                                        <button name="delete" class="icon border-0 rounded-circle text-center trash bg-danger-transparent delete-item">
                                            <i data-feather="trash-2"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="edit">07-07-23</td>
                                    <td>
                                        <a href="#" class="d-flex align-items-center text-decoration-none">
                                            <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-7.jpg" alt="product-7">
                                            <span class="fw-medium fs-15 ms-3 edit">Wooden Cups</span>
                                            
                                        </a>
                                    </td>
                                    <td class="edit">#1714-9753</td>
                                    <td class="edit">#14000268610</td>
                                    <td class="edit">$299.99</td>
                                    <td class="edit">Cash On Delivery</td>
                                    <td>
                                        <span class="badge bg-success-transparent text-success fw-normal py-1 px-2 fs-12 rounded-1 edit">Available</span>
                                    </td>
                                    <td class="edit">4,903</td>
                                    <td class="edit">$17,899.24</td>
                                    <td>
                                        <button class="icon border-0 rounded-circle text-center bg-primary-transparent">
                                            <i data-feather="eye"></i>
                                        </button>
                                        <button name="edit" class="icon border-0 rounded-circle text-center edit bg-success-transparent edit-item">
                                            <i data-feather="edit"></i>
                                        </button>
                                        <button name="save" class="icon border-0 rounded-circle text-center edit bg-success-transparent save-item">
                                            <i data-feather="check"></i>
                                        </button>
                                        <button name="delete" class="icon border-0 rounded-circle text-center trash bg-danger-transparent delete-item">
                                            <i data-feather="trash-2"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="edit">08-07-23</td>
                                    <td>
                                        <a href="#" class="d-flex align-items-center text-decoration-none">
                                            <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-8.jpg" alt="product-8">
                                            <span class="fw-medium fs-15 ms-3 edit">Vase Of Flowers</span>
                                        </a>
                                    </td>
                                    <td class="edit">#1734-9743</td>
                                    <td class="edit">#10008268610</td>
                                    <td class="edit">$599.99</td>
                                    <td class="edit">Online</td>
                                    <td>
                                        <span class="badge bg-warning-transparent text-warning fw-normal py-1 px-2 fs-12 rounded-1 edit">Pending</span>
                                    </td>
                                    <td class="edit">2,903</td>
                                    <td class="edit">$37,899.24</td>
                                    <td>
                                        <button class="icon border-0 rounded-circle text-center bg-primary-transparent">
                                            <i data-feather="eye"></i>
                                        </button>
                                        <button name="edit" class="icon border-0 rounded-circle text-center edit bg-success-transparent edit-item">
                                            <i data-feather="edit"></i>
                                        </button>
                                        <button name="save" class="icon border-0 rounded-circle text-center edit bg-success-transparent save-item">
                                            <i data-feather="check"></i>
                                        </button>
                                        <button name="delete" class="icon border-0 rounded-circle text-center trash bg-danger-transparent delete-item">
                                            <i data-feather="trash-2"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--=== End Recent Orders Area ===-->

<!--=== Start Orders Area ===-->
<div class="order-area">
    <div class="row js-grid">
        <div class="col-xxl-5">
            <div class="card rounded-3 border-0 recent-orders-card mb-24 table-edit-area">
                <div class="card-body text-body p-25">
                    <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color cursor-move">
                        <h4 class="mb-0">Orders</h4>

                        <ul class="nav nav-tabs global-tab border-0" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-dark rounded-3 fw-medium active" id="active-tab" data-bs-toggle="tab" data-bs-target="#active-tab-pane" type="button" role="tab" aria-controls="active-tab-pane" aria-selected="true">Active</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-dark rounded-3 fw-medium completed" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed-tab-pane" type="button" role="tab" aria-controls="completed-tab-pane" aria-selected="false">Completed</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-dark rounded-3 fw-medium cancelled" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled-tab-pane" type="button" role="tab" aria-controls="cancelled-tab-pane" aria-selected="false">Cancelled</button>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="active-tab-pane" role="tabpanel" aria-labelledby="active-tab" tabindex="0">
                            <div class="global-table-area">
                                <div class="table-responsive overflow-auto h-458" data-simplebar>
                                    <table class="table align-middle table-bordered" >
                                        <thead class="text-dark">
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Delivery Date</th>
                                                <th scope="col">Product</th>
                                                <th scope="col">Details</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-body o-sortable">
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-1.jpg" alt="user-1">
                                                        <span class="fw-medium fs-15 ms-3">Alex Smith</span>
                                                    </a>
                                                </td>
                                                <td>$199.99</td>
                                                <td>25 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-1.jpg" alt="product-1">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-2.jpg" alt="user-2">
                                                        <span class="fw-medium fs-15 ms-3">Luke Ivory</span>
                                                    </a>
                                                </td>
                                                <td>$299.99</td>
                                                <td>26 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-2.jpg" alt="product-2">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-3.jpg" alt="user-3">
                                                        <span class="fw-medium fs-15 ms-3">Andy King</span>
                                                    </a>
                                                </td>
                                                <td>$399.99</td>
                                                <td>27 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-3.jpg" alt="product-3">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-4.jpg" alt="user-4">
                                                        <span class="fw-medium fs-15 ms-3">Laurie Fox</span>
                                                    </a>
                                                </td>
                                                <td>$400.99</td>
                                                <td>28 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-4.jpg" alt="product-4">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-5.jpg" alt="user-5">
                                                        <span class="fw-medium fs-15 ms-3">Ryan Collins</span>
                                                    </a>
                                                </td>
                                                <td>$999.99</td>
                                                <td>29 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-5.jpg" alt="product-5">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-1.jpg" alt="user-1">
                                                        <span class="fw-medium fs-15 ms-3">Alex Smith</span>
                                                    </a>
                                                </td>
                                                <td>$199.99</td>
                                                <td>25 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-1.jpg" alt="product-1">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-2.jpg" alt="user-2">
                                                        <span class="fw-medium fs-15 ms-3">Luke Ivory</span>
                                                    </a>
                                                </td>
                                                <td>$299.99</td>
                                                <td>26 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-2.jpg" alt="product-2">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-3.jpg" alt="user-3">
                                                        <span class="fw-medium fs-15 ms-3">Andy King</span>
                                                    </a>
                                                </td>
                                                <td>$399.99</td>
                                                <td>27 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-3.jpg" alt="product-3">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-4.jpg" alt="user-4">
                                                        <span class="fw-medium fs-15 ms-3">Laurie Fox</span>
                                                    </a>
                                                </td>
                                                <td>$400.99</td>
                                                <td>28 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-4.jpg" alt="product-4">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-5.jpg" alt="user-5">
                                                        <span class="fw-medium fs-15 ms-3">Ryan Collins</span>
                                                    </a>
                                                </td>
                                                <td>$999.99</td>
                                                <td>29 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-5.jpg" alt="product-5">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="completed-tab-pane" role="tabpanel" aria-labelledby="completed-tab" tabindex="0">
                            <div class="global-table-area">
                                <div class="table-responsive overflow-auto h-458" data-simplebar>
                                    <table class="table align-middle table-bordered" >
                                        <thead class="text-dark">
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Delivery Date</th>
                                                <th scope="col">Product</th>
                                                <th scope="col">Details</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-body o-sortable">
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-1.jpg" alt="user-1">
                                                        <span class="fw-medium fs-15 ms-3">Alex Smith</span>
                                                    </a>
                                                </td>
                                                <td>$199.99</td>
                                                <td>25 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-1.jpg" alt="product-1">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-2.jpg" alt="user-2">
                                                        <span class="fw-medium fs-15 ms-3">Luke Ivory</span>
                                                    </a>
                                                </td>
                                                <td>$299.99</td>
                                                <td>26 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-2.jpg" alt="product-2">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-3.jpg" alt="user-3">
                                                        <span class="fw-medium fs-15 ms-3">Andy King</span>
                                                    </a>
                                                </td>
                                                <td>$399.99</td>
                                                <td>27 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-3.jpg" alt="product-3">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-4.jpg" alt="user-4">
                                                        <span class="fw-medium fs-15 ms-3">Laurie Fox</span>
                                                    </a>
                                                </td>
                                                <td>$400.99</td>
                                                <td>28 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-4.jpg" alt="product-4">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-5.jpg" alt="user-5">
                                                        <span class="fw-medium fs-15 ms-3">Ryan Collins</span>
                                                    </a>
                                                </td>
                                                <td>$999.99</td>
                                                <td>29 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-5.jpg" alt="product-5">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-1.jpg" alt="user-1">
                                                        <span class="fw-medium fs-15 ms-3">Alex Smith</span>
                                                    </a>
                                                </td>
                                                <td>$199.99</td>
                                                <td>25 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-1.jpg" alt="product-1">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-2.jpg" alt="user-2">
                                                        <span class="fw-medium fs-15 ms-3">Luke Ivory</span>
                                                    </a>
                                                </td>
                                                <td>$299.99</td>
                                                <td>26 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-2.jpg" alt="product-2">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-3.jpg" alt="user-3">
                                                        <span class="fw-medium fs-15 ms-3">Andy King</span>
                                                    </a>
                                                </td>
                                                <td>$399.99</td>
                                                <td>27 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-3.jpg" alt="product-3">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-4.jpg" alt="user-4">
                                                        <span class="fw-medium fs-15 ms-3">Laurie Fox</span>
                                                    </a>
                                                </td>
                                                <td>$400.99</td>
                                                <td>28 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-4.jpg" alt="product-4">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-5.jpg" alt="user-5">
                                                        <span class="fw-medium fs-15 ms-3">Ryan Collins</span>
                                                    </a>
                                                </td>
                                                <td>$999.99</td>
                                                <td>29 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-5.jpg" alt="product-5">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="cancelled-tab-pane" role="tabpanel" aria-labelledby="cancelled-tab" tabindex="0">
                            <div class="global-table-area">
                                <div class="table-responsive overflow-auto h-458" data-simplebar>
                                    <table class="table align-middle table-bordered" >
                                        <thead class="text-dark">
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Delivery Date</th>
                                                <th scope="col">Product</th>
                                                <th scope="col">Details</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-body o-sortable">
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-1.jpg" alt="user-1">
                                                        <span class="fw-medium fs-15 ms-3">Alex Smith</span>
                                                    </a>
                                                </td>
                                                <td>$199.99</td>
                                                <td>25 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-1.jpg" alt="product-1">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-2.jpg" alt="user-2">
                                                        <span class="fw-medium fs-15 ms-3">Luke Ivory</span>
                                                    </a>
                                                </td>
                                                <td>$299.99</td>
                                                <td>26 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-2.jpg" alt="product-2">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-3.jpg" alt="user-3">
                                                        <span class="fw-medium fs-15 ms-3">Andy King</span>
                                                    </a>
                                                </td>
                                                <td>$399.99</td>
                                                <td>27 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-3.jpg" alt="product-3">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-4.jpg" alt="user-4">
                                                        <span class="fw-medium fs-15 ms-3">Laurie Fox</span>
                                                    </a>
                                                </td>
                                                <td>$400.99</td>
                                                <td>28 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-4.jpg" alt="product-4">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-5.jpg" alt="user-5">
                                                        <span class="fw-medium fs-15 ms-3">Ryan Collins</span>
                                                    </a>
                                                </td>
                                                <td>$999.99</td>
                                                <td>29 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-5.jpg" alt="product-5">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-1.jpg" alt="user-1">
                                                        <span class="fw-medium fs-15 ms-3">Alex Smith</span>
                                                    </a>
                                                </td>
                                                <td>$199.99</td>
                                                <td>25 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-1.jpg" alt="product-1">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-2.jpg" alt="user-2">
                                                        <span class="fw-medium fs-15 ms-3">Luke Ivory</span>
                                                    </a>
                                                </td>
                                                <td>$299.99</td>
                                                <td>26 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-2.jpg" alt="product-2">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-3.jpg" alt="user-3">
                                                        <span class="fw-medium fs-15 ms-3">Andy King</span>
                                                    </a>
                                                </td>
                                                <td>$399.99</td>
                                                <td>27 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-3.jpg" alt="product-3">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-4.jpg" alt="user-4">
                                                        <span class="fw-medium fs-15 ms-3">Laurie Fox</span>
                                                    </a>
                                                </td>
                                                <td>$400.99</td>
                                                <td>28 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-4.jpg" alt="product-4">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-5.jpg" alt="user-5">
                                                        <span class="fw-medium fs-15 ms-3">Ryan Collins</span>
                                                    </a>
                                                </td>
                                                <td>$999.99</td>
                                                <td>29 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-5.jpg" alt="product-5">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-7">
            <div class="row">
                <div class="col-lg-7">
                    <div class="card rounded-3 border-0 recent-orders-card mb-24 table-edit-area">
                        <div class="card-body text-body p-25">
                            <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color cursor-move">
                                <h4 class="mb-0">Top Selling Products</h4>
    
                                <select class="form-select form-control" aria-label="Default select example">
                                    <option selected>Today</option>
                                    <option value="1">This Week</option>
                                    <option value="2">This Month</option>
                                    <option value="3">This Year</option>
                                </select>
                            </div>
    
                            <div class="global-table-area">
                                <div class="table-responsive overflow-auto h-452" data-simplebar>
                                    <table class="table align-middle table-bordered" >
                                        <thead class="text-dark">
                                            <tr>
                                                <th scope="col">Product</th>
                                                <th scope="col">Stock</th>
                                                <th scope="col">Total Sales</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-body o-sortable">
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-1.jpg" alt="product-1">
                                                        <span class="fw-medium fs-15 ms-3">Dark Green Jug</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success-transparent text-success fw-normal py-1 px-2 fs-12 rounded-1 edit">In Stock</span>
                                                </td>
                                                <td>5,093</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-2.jpg" alt="product-2">
                                                        <span class="fw-medium fs-15 ms-3">Drinking Glasses</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="badge bg-danger-transparent text-danger fw-normal py-1 px-2 fs-12 rounded-1 edit">Out Of Stock</span>
                                                </td>
                                                <td>8,093</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-3.jpg" alt="product-3">
                                                        <span class="fw-medium fs-15 ms-3">Bomber Jacket</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success-transparent text-success fw-normal py-1 px-2 fs-12 rounded-1 edit">In Stock</span>
                                                </td>
                                                <td>10,093</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-4.jpg" alt="product-4">
                                                        <span class="fw-medium fs-15 ms-3">Simple Chair</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="badge bg-danger-transparent text-danger fw-normal py-1 px-2 fs-12 rounded-1 edit">Out Of Stock</span>
                                                </td>
                                                <td>7,093</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-5.jpg" alt="product-5">
                                                        <span class="fw-medium fs-15 ms-3">Smart Watch</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success-transparent text-success fw-normal py-1 px-2 fs-12 rounded-1 edit">In Stock</span>
                                                </td>
                                                <td>11,093</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-1.jpg" alt="product-1">
                                                        <span class="fw-medium fs-15 ms-3">Dark Green Jug</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success-transparent text-success fw-normal py-1 px-2 fs-12 rounded-1 edit">In Stock</span>
                                                </td>
                                                <td>5,093</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-2.jpg" alt="product-2">
                                                        <span class="fw-medium fs-15 ms-3">Drinking Glasses</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="badge bg-danger-transparent text-danger fw-normal py-1 px-2 fs-12 rounded-1 edit">Out Of Stock</span>
                                                </td>
                                                <td>8,093</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-3.jpg" alt="product-3">
                                                        <span class="fw-medium fs-15 ms-3">Bomber Jacket</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success-transparent text-success fw-normal py-1 px-2 fs-12 rounded-1 edit">In Stock</span>
                                                </td>
                                                <td>10,093</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-4.jpg" alt="product-4">
                                                        <span class="fw-medium fs-15 ms-3">Simple Chair</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="badge bg-danger-transparent text-danger fw-normal py-1 px-2 fs-12 rounded-1 edit">Out Of Stock</span>
                                                </td>
                                                <td>7,093</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-5.jpg" alt="product-5">
                                                        <span class="fw-medium fs-15 ms-3">Smart Watch</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success-transparent text-success fw-normal py-1 px-2 fs-12 rounded-1 edit">In Stock</span>
                                                </td>
                                                <td>11,093</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card rounded-3 border-0 recent-orders-card mb-24 table-edit-area">
                        <div class="card-body text-body p-25">
                            <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color cursor-move">
                                <h4 class="mb-0">Top Customers</h4>
    
                                <select class="form-select form-control" aria-label="Default select example">
                                    <option selected>Today</option>
                                    <option value="1">This Week</option>
                                    <option value="2">This Month</option>
                                    <option value="3">This Year</option>
                                </select>
                            </div>
    
                            <div class="global-table-area">
                                <div class="table-responsive overflow-auto h-452" data-simplebar>
                                    <table class="table align-middle table-bordered" >
                                        <thead class="text-dark">
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Purchase</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-body o-sortable">
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-1.jpg" alt="user-1">
                                                        <div class="ms-3">
                                                            <span class="fw-medium fs-15 text-dark d-block">Alex Smith</span>
                                                            <span class="text-body fs-12">35 Purchases <i class="fa-solid fa-badge-check text-primary"></i></span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>$55,093</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-2.jpg" alt="user-2">
                                                        <div class="ms-3">
                                                            <span class="fw-medium fs-15 text-dark d-block">Luke Ivory</span>
                                                            <span class="text-body fs-12">20 Purchases <i class="fa-solid fa-badge-check text-primary"></i></span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>$70,093</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-3.jpg" alt="user-3">
                                                        <div class="ms-3">
                                                            <span class="fw-medium fs-15 text-dark d-block">Andy King</span>
                                                            <span class="text-body fs-12">30 Purchases <i class="fa-solid fa-badge-check text-primary"></i></span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>$75,093</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-4.jpg" alt="user-4">
                                                        <div class="ms-3">
                                                            <span class="fw-medium fs-15 text-dark d-block">Laurie Fox</span>
                                                            <span class="text-body fs-12">45 Purchases <i class="fa-solid fa-badge-check text-primary"></i></span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>$85,093</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-5.jpg" alt="user-5">
                                                        <div class="ms-3">
                                                            <span class="fw-medium fs-15 text-dark d-block">Ryan Collins</span>
                                                            <span class="text-body fs-12">60 Purchases <i class="fa-solid fa-badge-check text-primary"></i></span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>$99,093</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-1.jpg" alt="user-1">
                                                        <div class="ms-3">
                                                            <span class="fw-medium fs-15 text-dark d-block">Alex Smith</span>
                                                            <span class="text-body fs-12">35 Purchases <i class="fa-solid fa-badge-check text-primary"></i></span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>$55,093</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-2.jpg" alt="user-2">
                                                        <div class="ms-3">
                                                            <span class="fw-medium fs-15 text-dark d-block">Luke Ivory</span>
                                                            <span class="text-body fs-12">20 Purchases <i class="fa-solid fa-badge-check text-primary"></i></span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>$70,093</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-3.jpg" alt="user-3">
                                                        <div class="ms-3">
                                                            <span class="fw-medium fs-15 text-dark d-block">Andy King</span>
                                                            <span class="text-body fs-12">30 Purchases <i class="fa-solid fa-badge-check text-primary"></i></span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>$75,093</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-4.jpg" alt="user-4">
                                                        <div class="ms-3">
                                                            <span class="fw-medium fs-15 text-dark d-block">Laurie Fox</span>
                                                            <span class="text-body fs-12">45 Purchases <i class="fa-solid fa-badge-check text-primary"></i></span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>$85,093</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-5.jpg" alt="user-5">
                                                        <div class="ms-3">
                                                            <span class="fw-medium fs-15 text-dark d-block">Ryan Collins</span>
                                                            <span class="text-body fs-12">60 Purchases <i class="fa-solid fa-badge-check text-primary"></i></span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>$99,093</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--=== End Orders Area ===-->
@endsection