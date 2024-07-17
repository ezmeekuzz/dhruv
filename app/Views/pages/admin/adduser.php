<?=$this->include('templates/admin/header');?>
<div class="app-container">
    <?=$this->include('templates/admin/sidebar');?>
    <div class="app-main" id="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 m-b-30">
                    <div class="d-block d-sm-flex flex-nowrap align-items-center">
                        <div class="page-title mb-2 mb-sm-0">
                            <h1><i class="ti ti-user"></i> Add User</h1>
                        </div>
                        <div class="ml-auto d-flex align-items-center">
                            <nav>
                                <ol class="breadcrumb p-0 m-b-0">
                                    <li class="breadcrumb-item">
                                        <a href="<?=base_url();?>admin/"><i class="ti ti-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        Dashboard
                                    </li>
                                    <li class="breadcrumb-item active text-primary" aria-current="page">Add User</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-statistics">
                        <div class="card-header">
                            <div class="card-heading">
                                <h4 class="card-title"><i class="ti ti-user"></i> Users</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="adduser">
                                <div class="form-group">
                                    <label for="firstname">First Name</label>
                                    <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Enter First Name">
                                </div>
                                <div class="form-group">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Enter Last Name">
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username">
                                </div>
                                <div class="form-group">
                                    <label for="emailaddress">Email Address</label>
                                    <input type="text" name="emailaddress" id="emailaddress" class="form-control" placeholder="Enter Email Address">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
                                </div>
                                <div class="form-group">
                                    <label for="usertype">Usertype</label>
                                    <select class="form-control chosen-select" data-placeholder = "Select a usertype" name="usertype" id="usertype">
                                        <option hidden></option>
                                        <option disabled></option>
                                        <option value="Administrator">Administrator</option>
                                        <option value="Regular User">Regular User</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-dark">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?=$this->include('templates/admin/footer');?>
<script src="<?=base_url();?>assets/js/admin/adduser.js"></script>