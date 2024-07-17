<?=$this->include('templates/admin/header');?>
<div class="app-container">
    <?=$this->include('templates/admin/sidebar');?>
    <div class="app-main" id="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 m-b-30">
                    <div class="d-block d-sm-flex flex-nowrap align-items-center">
                        <div class="page-title mb-2 mb-sm-0">
                            <h4><i class="fa fa-building-o"></i> Add City</h4>
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
                                    <li class="breadcrumb-item active text-primary" aria-current="page">Add City</li>
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
                                <h4 class="card-title"><i class="fa fa-map-o"></i> Add City</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="addcity" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="state_id">State Code</label>
                                    <select class="form-control chosen-select" name="state_id" id="state_id" data-placeholder="Choose a state...">
                                        <option hidden></option>
                                        <option disabled></option>
                                        <?php if($states) : ?>
                                        <?php foreach($states as $list) : ?>
                                        <option value="<?=$list['state_id'];?>"><?=$list['state_code'].' - '.$list['state_name'];?></option>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="cityname">City Name</label>
                                    <input type="text" name="cityname" id="cityname" class="form-control" placeholder="Enter City Name">
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
<script type="text/javascript" src="<?=base_url();?>assets/js/admin/addcity.js"></script>