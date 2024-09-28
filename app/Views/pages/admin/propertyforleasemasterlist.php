<?=$this->include('templates/admin/header');?>
<style>
    .drop-zone {
        border: 2px dashed #ccc;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        background-color: #f9f9f9;
    }

    .drop-zone.dragover {
        background-color: #e9e9e9;
    }

    .preview-container {
        display: flex;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .preview-item {
        position: relative;
        margin-right: 10px;
        margin-bottom: 10px;
        width: 100px;
        height: 100px;
    }

    .preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border: 2px solid #ccc;
        border-radius: 4px;
    }

    .remove-btn {
        position: absolute;
        top: -5px;
        right: -5px;
        background: red;
        color: white;
        border-radius: 50%;
        cursor: pointer;
        font-size: 18px;
        line-height: 18px;
        width: 20px;
        height: 20px;
        text-align: center;
    }
</style>
<div class="app-container">
    <?=$this->include('templates/admin/sidebar');?>
    <div class="app-main" id="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 m-b-30">
                    <div class="d-block d-sm-flex flex-nowrap align-items-center">
                        <div class="page-title mb-2 mb-sm-0">
                            <h1><i class="fa fa-building"></i> Property For Lease Masterlist</h1>
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
                                    <li class="breadcrumb-item active text-primary" aria-current="page">Property For Lease Masterlist</li>
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
                                <h4 class="card-title"><i class="fa fa-building"></i> Property For Lease Masterlist</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="datatable-wrapper table-responsive">
                                <table id="propertyforleasemasterlist" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Property Name</th>
                                            <th>Anchor Tenant</th>
                                            <th>Space Use</th>
                                            <th>Listing Agent</th>
                                            <th>Rental Rate</th>
                                            <th>Publish Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="propertyForLeaseDetails" tabindex="-1" role="dialog" aria-labelledby="propertyDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="propertyTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="text-align: justify;">
                <div id="displayForLeaseDetails"></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addLeasingUnitsModal" tabindex="-1" role="dialog" aria-labelledby="addLeasingUnitsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLeasingUnitsModalLabel">Add Leasing Units</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addLeasingUnitsForm">
                    <div class="form-group">
                        <label for="property_id">Property ID</label>
                        <input type="text" class="form-control" id="property_id" name="property_id" readonly>
                    </div>
                    <div class="form-group">
                        <label for="unit_number">Unit Number</label>
                        <input type="text" class="form-control" id="unit_number" name="unit_number" required>
                    </div>
                    <div class="form-group">
                        <label for="cam">CAM</label>
                        <input type="text" class="form-control" id="cam" name="cam" required>
                    </div>
                    <div class="form-group">
                        <label for="leasing_rental_rate">Leasing Rental Rate</label>
                        <input type="number" class="form-control" id="leasing_rental_rate" name="leasing_rental_rate" required>
                    </div>
                    <div class="form-group">
                        <label for="space_available">Space Available</label>
                        <input type="text" class="form-control" id="space_available" name="space_available" required>
                    </div>
                    <div class="form-group">
                        <label for="space_use">Space Use</label>
                        <input type="text" class="form-control" id="space_use" name="space_use" required>
                    </div>
                    <div class="form-group">
                        <label for="site_plan_map">Site Plan Map</label>
                        <div id="drop-zone" class="drop-zone">
                            <p>Drag and drop files here or click to upload</p>
                            <input type="file" id="site_plan_map" name="site_plan_map[]" multiple hidden>
                            <div id="preview-container" class="preview-container">
                                <!-- Image previews will be displayed here -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveLeasingUnits">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editLeasingUnitsModal" tabindex="-1" role="dialog" aria-labelledby="editLeasingUnitsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLeasingUnitsModal">Edit Leasing Units</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editLeasingUnitsForm">
                    <div class="form-group">
                        <label for="leasing_unit_id">Leasing Unit ID</label>
                        <input type="text" class="form-control" id="leasing_unit_id" name="leasing_unit_id" readonly>
                    </div>
                    <div class="form-group">
                        <label for="property_id">Property ID</label>
                        <input type="text" class="form-control" id="edit_property_id" name="property_id" readonly>
                    </div>
                    <div class="form-group">
                        <label for="unit_number">Unit Number</label>
                        <input type="text" class="form-control" id="edit_unit_number" name="unit_number" required>
                    </div>
                    <div class="form-group">
                        <label for="cam">CAM</label>
                        <input type="text" class="form-control" id="edit_cam" name="cam" required>
                    </div>
                    <div class="form-group">
                        <label for="leasing_rental_rate">Leasing Rental Rate</label>
                        <input type="number" class="form-control" id="edit_leasing_rental_rate" name="leasing_rental_rate" required>
                    </div>
                    <div class="form-group">
                        <label for="space_available">Space Available</label>
                        <input type="text" class="form-control" id="edit_space_available" name="space_available" required>
                    </div>
                    <div class="form-group">
                        <label for="space_use">Space Use</label>
                        <input type="text" class="form-control" id="edit_space_use" name="space_use" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_site_plan_map">Site Plan Map</label>
                        <div id="edit_drop-zone" class="drop-zone">
                            <p>Drag and drop files here or click to upload</p>
                            <input type="file" id="edit_site_plan_map" name="site_plan_map[]" multiple hidden>
                            <div id="edit_preview-container" class="preview-container">
                                <!-- Image previews will be displayed here -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="editLeasingUnits">Save</button>
            </div>
        </div>
    </div>
</div>
<?=$this->include('templates/admin/footer');?>
<script src="<?=base_url();?>assets/js/admin/propertyforleasemasterlist.js"></script>