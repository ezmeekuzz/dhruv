<?=$this->include('templates/admin/header');?>
<div class="app-container">
    <?=$this->include('templates/admin/sidebar');?>
    <div class="app-main" id="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 m-b-30">
                    <div class="d-block d-sm-flex flex-nowrap align-items-center">
                        <div class="page-title mb-2 mb-sm-0">
                            <h4><i class="fa fa-users"></i> Add Listing Agent</h4>
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
                                    <li class="breadcrumb-item active text-primary" aria-current="page">Add Listing Agent</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row select-wrapper">
                <div class="col-lg-12 selects-contant">
                    <div class="card card-statistics">
                        <div class="card-header">
                            <div class="card-heading">
                                <h4 class="card-title"><i class="fa fa-users"></i> Add Listing Agent</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="addlistingagent" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="fullname">Full Name</label>
                                    <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Enter Full Name">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Enter Email">
                                </div>
                                <div class="form-group">
                                    <label for="licenseno">License Number</label>
                                    <input type="text" name="licenseno" id="licenseno" class="form-control" placeholder="Enter License Number">
                                </div>
                                <div class="form-group">
                                    <label for="phonenumber">Phone Number</label>
                                    <input type="text" name="phonenumber" id="phonenumber" class="form-control" placeholder="Enter Phone Number">
                                </div>
                                <div class="form-group">
                                    <label for="mobilenumber">Mobile Number</label>
                                    <input type="text" name="mobilenumber" id="mobilenumber" class="form-control" placeholder="Enter Mobile Number">
                                </div>
                                <div class="form-group">
                                    <label for="position">Position</label>
                                    <input type="text" name="position" id="position" class="form-control" placeholder="Enter Position">
                                </div>
                                <div class="form-group">
                                    <label for="profileimage">Profile Image</label>
                                    <div class="custom-file">
                                        <label class="custom-file-label" for="profileimage">Choose file</label>
                                        <input type="file" class="custom-file-input" id="profileimage" name="profileimage" accept="image/png, image/gif, image/jpeg, image/webp">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="url">URL</label>
                                    <input type="text" name="url" id="url" class="form-control" placeholder="Enter URL">
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?=$this->include('templates/admin/footer');?>
<script type="text/javascript" src="<?=base_url();?>assets/js/admin/addlistingagent.js"></script>