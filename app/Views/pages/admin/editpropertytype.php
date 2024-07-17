<?=$this->include('templates/admin/header');?>
<div class="app-container">
    <?=$this->include('templates/admin/sidebar');?>
    <div class="app-main" id="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 m-b-30">
                    <div class="d-block d-sm-flex flex-nowrap align-items-center">
                        <div class="page-title mb-2 mb-sm-0">
                            <h4><i class="fa fa-building-o"></i> Edit Property Type</h4>
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
                                    <li class="breadcrumb-item active text-primary" aria-current="page">Edit Property Type</li>
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
                                <h4 class="card-title"><i class="fa fa-building-o"></i> Edit Property Type</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="editpropertytype" enctype="multipart/form-data">
                                <div class="form-group" hidden>
                                    <label for="property_type_id">Property Type ID</label>
                                    <input type="text" value="<?=$details['property_type_id'];?>" name="property_type_id" id="property_type_id" class="form-control" placeholder="Enter Property Type ID">
                                </div>
                                <div class="form-group">
                                    <label for="property_type">Property Type</label>
                                    <input type="text" value="<?=$details['property_type'];?>" name="property_type" id="property_type" class="form-control" placeholder="Enter Property Type">
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
<script type="text/javascript" src="<?=base_url();?>assets/js/admin/editpropertytype.js"></script>