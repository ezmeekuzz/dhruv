<?=$this->include('templates/admin/header');?>
<div class="app-container">
    <?=$this->include('templates/admin/sidebar');?>
    <div class="app-main" id="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 m-b-30">
                    <div class="d-block d-sm-flex flex-nowrap align-items-center">
                        <div class="page-title mb-2 mb-sm-0">
                            <h4><i class="fa fa-building"></i> Edit Property</h4>
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
                                    <li class="breadcrumb-item active text-primary" aria-current="page">Edit Property</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <form id="editpropertyforlease" enctype="multipart/form-data">
                <input type="hidden" name="property_id" value="<?=$property['property_id'];?>">

                <div class="row">
                    <div class="col-lg-6">
                        <div class="card card-statistics">
                            <div class="card-header">
                                <div class="card-heading">
                                    <h4 class="card-title float-left"><i class="ti ti-map"></i> Real Estate Details</h4>
                                    <div class="float-right">
                                        <div class="form-group">
                                            <div class="checkbox checbox-switch switch-success">
                                                <label>
                                                    <input type="checkbox" value="Yes" name="publishstatus" <?php if ($property['publishstatus'] == 'Published') echo 'checked'; ?> />
                                                    <span></span>
                                                    Publish
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="propertyname">Property Name</label>
                                    <input type="text" name="propertyname" id="propertyname" class="form-control" placeholder="Enter Property Name" value="<?=$property['property_name'];?>">
                                </div>
                                <div class="form-group">
                                    <label for="anchor_tenant">Real Estate Type</label>
                                    <select class="form-control chosen-select" name="anchor_tenant" id="anchor_tenant" data-placeholder="Choose a Real Estate Type...">
                                        <option hidden></option>
                                        <option disabled></option>
                                        <option value="Public" <?php if ($property['anchor_tenant'] == 'Public') echo 'selected'; ?>>Public</option>
                                        <option value="Private" <?php if ($property['anchor_tenant'] == 'Private') echo 'selected'; ?>>Private</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="space_id">Space Use</label>
                                    <select class="form-control chosen-select" name="space_id" id="space_id" data-placeholder="Choose a Space Use...">
                                        <option hidden></option>
                                        <option disabled></option>
                                        <?php if($spacesList) : ?>
                                            <?php foreach($spacesList as $list) : ?>
                                                <option value="<?=$list['space_id'];?>" <?php if ($list['space_id'] == $property['space_id']) echo 'selected'; ?>><?=$list['spacetype'];?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="listing_agent_id">Listing Agent</label>
                                    <select class="form-control chosen-select" name="listing_agent_id" id="listing_agent_id" data-placeholder="Choose a Listing Agents...">
                                        <option hidden></option>
                                        <option disabled></option>
                                        <?php if($listinAgentList) : ?>
                                            <?php foreach($listinAgentList as $list) : ?>
                                                <option value="<?=$list['listing_agent_id'];?>" <?php if ($list['listing_agent_id'] == $property['listing_agent_id']) echo 'selected'; ?>><?=$list['fullname'].' - '.$list['position'];?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="state_id">States</label>
                                    <select class="form-control chosen-select" name="state_id" id="state_id" data-placeholder="Choose a states...">
                                        <option hidden></option>
                                        <option disabled></option>
                                        <?php if($stateList) : ?>
                                            <?php foreach($stateList as $list) : ?>
                                                <option value="<?=$list['state_id'];?>" <?php if ($list['state_id'] == $property['state_id']) echo 'selected'; ?>><?=$list['state_name'];?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="city_id">City</label>
                                    <select class="form-control chosen-select" name="city_id" id="city_id" data-placeholder="Choose a city...">
                                        <option hidden></option>
                                        <option disabled></option>
                                        <?php if($cityList) : ?>
                                            <?php foreach($cityList as $list) : ?>
                                                <?php if($list['state_id'] == $property['state_id']) : ?>
                                                    <option value="<?=$list['city_id'];?>" <?php if ($list['city_id'] == $property['city_id']) echo 'selected'; ?>><?=$list['cityname'];?></option>
                                                <?php endif; ?>       
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="zipcode">Zip Code</label>
                                    <input type="text" name="zipcode" id="zipcode" class="form-control" placeholder="Enter Zip Code" value="<?=$property['zipcode'];?>">
                                </div>
                                <div class="form-group">
                                    <label for="buildingsize">Building Size</label>
                                    <input type="text" name="buildingsize" id="buildingsize" class="form-control" placeholder="Enter Building Size" value="<?=$property['buildingsize'];?>">
                                </div>
                                <div class="form-group">
                                    <label for="yearbuilt">Year Built</label>
                                    <input type="text" name="yearbuilt" id="yearbuilt" class="form-control" placeholder="Enter Year Built" value="<?=$property['yearbuilt'];?>">
                                </div>
                                <div class="form-group">
                                    <label for="location">Location</label>
                                    <input type="text" name="location" id="location" class="form-control" placeholder="Enter Location" value="<?=$property['location'];?>">
                                </div>
                                <div class="form-group">
                                    <label for="leasestructure">Lease Structure</label>
                                    <input type="text" name="leasestructure" id="leasestructure" class="form-control" placeholder="Enter Lease Structure" value="<?=$property['leasestructure'];?>">
                                </div>
                                <div class="form-group">
                                    <label for="rental_rate">Rental Rate</label>
                                    <input type="text" name="rental_rate" id="rental_rate" class="form-control" placeholder="Enter Rental Rate" value="<?=$property['rental_rate'];?>">
                                </div>
                                <div class="form-group">
                                    <label for="size_sf">Size SF</label>
                                    <input type="text" name="size_sf" id="size_sf" class="form-control" placeholder="Enter Size SF" value="<?=$property['size_sf'];?>">
                                </div>
                                <div class="form-group">
                                    <label for="addt">ADDT</label>
                                    <input type="text" name="addt" id="addt" class="form-control" placeholder="Enter ADDT" value="<?=$property['addt'];?>">
                                </div>
                                <div class="form-group">
                                    <label for="starting_sf_yr">Starting SF Year</label>
                                    <input type="text" name="starting_sf_yr" id="starting_sf_yr" class="form-control" placeholder="Enter Starting SF Year" value="<?=$property['starting_sf_yr'];?>">
                                </div>
                                <div class="form-group">
                                    <label for="ending_sf_yr">Ending SF Year</label>
                                    <input type="text" name="ending_sf_yr" id="ending_sf_yr" class="form-control" placeholder="Enter Ending SF Year" value="<?=$property['ending_sf_yr'];?>">
                                </div>
                                <div class="form-group">
                                    <label for="backgroundimage">Background Image</label>
                                    <div class="custom-file">
                                        <label class="custom-file-label" for="backgroundimage">Choose file</label>
                                        <input type="file" class="custom-file-input" id="backgroundimage" name="backgroundimage" accept="image/png, image/gif, image/jpeg, image/webp">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="leasing_flyer">Leasing Flyer</label>
                                    <div class="custom-file">
                                        <label class="custom-file-label" for="leasing_flyer">Choose file</label>
                                        <input type="file" class="custom-file-input" id="leasing_flyer" name="leasing_flyer" accept="application/pdf">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="invoicefile">Drop Files</label>
                                    <div class="upload-area" id="uploadArea">
                                        <h2>Drag & Drop Images</h2>
                                        <p>or</p>
                                        <button type="button" id="fileSelectBtn">Select Files</button>
                                        <div id="fileList">
                                            
                                        </div>
                                        <div id="sequence"></div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card card-statistics">
                            <div class="card-header">
                                <div class="card-heading">
                                    <h4 class="card-title"><i class="fa fa-building"></i> Additional Information</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Search Listing Agent</label>
                                    <input type="text" id="searchlistingagent" name="searchlistingagent" class="form-control" placeholder="Enter Title">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="categorylist"> Listing Agent List</label>
                                    <div class="listingAgentList" style="max-height: 220px !important; overflow: auto;">
                                        <ul class="list-group" id="agentlist">
                                            <?php if(COUNT($listinAgentList)) : ?>
                                            <?php foreach($listinAgentList as $list) : ?>
                                            <li class="list-group-item">
                                                <div class="form-group form-check">
                                                    <input type="checkbox" class="form-check-input" id="additional_listing_agent_id<?=$list['listing_agent_id'];?>" value="<?=$list['listing_agent_id'];?>" name="additional_listing_agent_id[]" <?php if(in_array($list['listing_agent_id'], array_column($additionalListingAgents, 'listing_agent_id'))) echo 'checked'; ?>>
                                                    <label class="form-check-label" for="additional_listing_agent_id<?=$list['listing_agent_id'];?>"><?=$list['fullname'].' - '.$list['position'];?></label>
                                                </div>
                                            </li>
                                            <?php endforeach; ?>
                                            <?php else: ?>
                                            <li class="list-group-item">
                                                <label>No Listing Agent Found</label>
                                            </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="investmenthighlights">
                                    <?php if($investmentHighlights) : ?>
                                    <?php foreach($investmentHighlights as $list) : ?>
                                    <div class="InvestmentHighlightLists">
                                        <div class="form-group">
                                            <label for="content" style="float: left;">Investment Highlight</label>
                                            <div style="float: right;">
                                                <a href="javascript:void(0);" onclick="addinvestmenthighlight();" title="Add Investment Highlight"><i class="fa fa-plus-circle" style="font-size: 18px; color: blue;"></i></a>
                                                <a href="javascript:void(0);" style="color: red; font-size: 18px;" class="remove-investment-highlight"><i class="fa fa-trash"></i></a>
                                            </div>
                                            <input type="text" name="title[]" id="title" class="form-control mb-3" placeholder="Enter Title" value="<?=$list['title'];?>">
                                            <textarea class="form-control" id="content" name="content[]" placeholder="Content" style="resize: none; min-height: 80px;"><?=$list['content'];?></textarea>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                    <?php else : ?>
                                <div class="form-group">
                                    <label for="content" style="float: left;">Investment Highlight</label>
                                    <div style="float: right;">
                                        <a href="javascript:void(0);" onclick="addinvestmenthighlight();" title="Add Investment Highlight"><i class="fa fa-plus-circle" style="font-size: 18px; color: blue;"></i></a>
                                    </div>
                                    <input type="text" name="title[]" id="title" class="form-control mb-3" placeholder="Enter Title">
                                    <textarea class="form-control" id="content" name="content[]" placeholder="Content" style="resize: none; min-height: 80px;"></textarea>
                                </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?=$this->include('templates/admin/footer');?>
<script>
    let propertyId = <?=$propertyId;?>;
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALqBsjd6GtBlG1JSn_Ux4c8t5QSTBf-0A&libraries=places"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/admin/editpropertyforlease.js"></script>