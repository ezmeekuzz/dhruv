
                <!-- begin app-nabar -->
                <aside class="app-navbar">
                    <!-- begin sidebar-nav -->
                    <div class="sidebar-nav scrollbar scroll_dark">
                        <ul class="metismenu " id="sidebarNav">
                            <li class="nav-static-title">Dashboard Panel</li>
                            <li class="<?php if($currentpage === 'dashboard') { echo 'active'; } ?>"><a href="/admin/dashboard" aria-expanded="false"><i class="nav-icon ti ti-dashboard"></i><span class="nav-title">Dashboard</span></a> </li>
                            <li class="<?php if($currentpage === 'adduser' || $currentpage === 'usermasterlist') { echo 'active'; } ?>">
                                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                                    <i class="nav-icon fa fa-users"></i>
                                    <span class="nav-title">Users</span>
                                </a>
                                <ul aria-expanded="false">
                                    <li class="<?php if($currentpage === 'adduser') { echo 'active'; } ?>"><a href='/admin/add-user'>Add User</a></li>
                                    <li class="<?php if($currentpage === 'usermasterlist') { echo 'active'; } ?>"> <a href='/admin/user-masterlist'>User Masterlist</a></li>
                                </ul>
                            </li>
                            <li class="<?php if($currentpage === 'addlistingagent' || $currentpage === 'listingagentmasterlist') { echo 'active'; } ?>">
                                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                                    <i class="nav-icon fa fa-users"></i>
                                    <span class="nav-title">Listing Agents</span>
                                </a>
                                <ul aria-expanded="false">
                                    <li class="<?php if($currentpage === 'addlistingagent') { echo 'active'; } ?>"><a href='/admin/add-listing-agent'>Add Listing Agent</a></li>
                                    <li class="<?php if($currentpage === 'listingagentmasterlist') { echo 'active'; } ?>"> <a href='/admin/listing-agent-masterlist'>Listing Agent Masterlist</a></li>
                                </ul>
                            </li>
                            <li class="<?php if($currentpage === 'addstate' || $currentpage === 'statemasterlist') { echo 'active'; } ?>">
                                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                                    <i class="nav-icon fa fa-map-o"></i>
                                    <span class="nav-title">States</span>
                                </a>
                                <ul aria-expanded="false">
                                    <li class="<?php if($currentpage === 'addstate') { echo 'active'; } ?>"><a href='/admin/add-state'>Add State</a></li>
                                    <li class="<?php if($currentpage === 'statemasterlist') { echo 'active'; } ?>"> <a href='/admin/state-masterlist'>State Masterlist</a></li>
                                </ul>
                            </li>
                            <li class="<?php if($currentpage === 'addcity' || $currentpage === 'citymasterlist') { echo 'active'; } ?>">
                                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                                    <i class="nav-icon fa fa-map-o"></i>
                                    <span class="nav-title">Cities</span>
                                </a>
                                <ul aria-expanded="false">
                                    <li class="<?php if($currentpage === 'addcity') { echo 'active'; } ?>"><a href='/admin/add-city'>Add City</a></li>
                                    <li class="<?php if($currentpage === 'citymasterlist') { echo 'active'; } ?>"> <a href='/admin/city-masterlist'>City Masterlist</a></li>
                                </ul>
                            </li>
                            <li class="<?php if($currentpage === 'addpropertytype' || $currentpage === 'propertytypemasterlist') { echo 'active'; } ?>">
                                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                                    <i class="nav-icon fa fa-building"></i>
                                    <span class="nav-title">Property Types</span>
                                </a>
                                <ul aria-expanded="false">
                                    <li class="<?php if($currentpage === 'addpropertytype') { echo 'active'; } ?>"><a href='/admin/add-property-type'>Add Property Type</a></li>
                                    <li class="<?php if($currentpage === 'propertytypemasterlist') { echo 'active'; } ?>"> <a href='/admin/property-type-masterlist'>Property Type Masterlist</a></li>
                                </ul>
                            </li>
                            <li class="<?php if($currentpage === 'addspace' || $currentpage === 'spacemasterlist') { echo 'active'; } ?>">
                                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                                    <i class="nav-icon fa fa-building"></i>
                                    <span class="nav-title">Spaces</span>
                                </a>
                                <ul aria-expanded="false">
                                    <li class="<?php if($currentpage === 'addspace') { echo 'active'; } ?>"><a href='/admin/add-space'>Add Space</a></li>
                                    <li class="<?php if($currentpage === 'spacemasterlist') { echo 'active'; } ?>"> <a href='/admin/space-masterlist'>Space Masterlist</a></li>
                                </ul>
                            </li>
                            <li class="<?php if($currentpage === 'addproperty' || $currentpage === 'propertymasterlist' || $currentpage === 'propertyforleasemasterlist' || $currentpage === 'addpropertyforlease') { echo 'active'; } ?>">
                                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                                    <i class="nav-icon fa fa-building-o"></i>
                                    <span class="nav-title">Properties</span>
                                </a>
                                <ul aria-expanded="false">
                                    <li class="<?php if($currentpage === 'addproperty') { echo 'active'; } ?>"><a href='/admin/add-property'>Add Property</a></li>
                                    <li class="<?php if($currentpage === 'propertymasterlist') { echo 'active'; } ?>"> <a href='/admin/property-masterlist'>Property Masterlist</a></li>
                                    <li class="<?php if($currentpage === 'addpropertyforlease') { echo 'active'; } ?>"><a href='/admin/add-property-for-lease'>Add Property For Lease</a></li>
                                    <li class="<?php if($currentpage === 'propertyforleasemasterlist') { echo 'active'; } ?>"> <a href='/admin/property-for-lease-masterlist'>Property For Lease Masterlist</a></li>
                                </ul>
                            </li>
                            <li class="<?php if($currentpage === 'messages') { echo 'active'; } ?>"><a href="/admin/messages"><i class="nav-icon ti ti-envelope"></i><span class="nav-title">Messages</span></a> </li>
                            <li class="<?php if($currentpage === 'offeringmemorandumconsent') { echo 'active'; } ?>"><a href="/admin/offering-memorandum-consent"><i class="nav-icon fa fa-file-pdf-o"></i><span class="nav-title">Offering Memorandum Consent</span></a> </li>
                            <li class="<?php if($currentpage === 'subscribers') { echo 'active'; } ?>"><a href="/admin/subscribers"><i class="nav-icon ti ti-user"></i><span class="nav-title">Subscribers</span></a> </li>
                            <li>
                                <a href="<?=base_url()?>admin/logout" aria-expanded="false">
                                    <i class="nav-icon ti ti-power-off"></i>
                                    <span class="nav-title">Logout</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </aside>