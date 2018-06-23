<link href="/assets/styles/messenger/addlead.css?1" rel="stylesheet"/>
<div class="container">
    <div class="row">
        <div class="col-md-3 col-lg-3"></div>
        <div class="col-md-6 col-lg-6">
            <form id="discovery_form"> 
                <div class="profile" id="profilemsg">
                    <div class="btnclose close" data-target="profilemsg">
                        &times;
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-1">
                            <div class="stararea">
                                <input type="hidden" name="leads[rate]" value="0" />
                                <span class='star' data-target='' data-value=''>&#9733;</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <a class='btn btn-default btn-select'>
                                <input type='hidden' class='btn-select-input' name="leads[grade]" value='Low' />
                                <span class='btn-select-value'>Select an Item</span>
                                <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                                <ul class='grade' data-target=''>
                                    <li data-value='Low'>Low</li>
                                    <li data-value='Medium'>Medium</li>
                                    <li data-value='High'>High</li>
                                    <li data-value='Nurture'>Nurture</li>
                                </ul>
                            </a>
                        </div>

                    
                    </div>                
                    <div class="profileitem">
                        <div class="row">
                            <div class="col-sm-4 col-md-4">
                                <label>PhoneNumber:</label>
                            </div>
                            <div class="col-sm-8 col-md-8">
                                <input name="leads[phone]"  id="sel_phone" class="required"/>
                            </div>
                        </div>           
                    </div>  
                    <div class="profileitem">
                        <div class="row">
                            <div class="col-sm-4 col-md-4">
                                <label>Name:</label>
                            </div>
                            <div class="col-sm-4 col-md-4">
                                <input type="hidden" id="firstname" name="leads[firstname]" />
                                <input type="hidden" id="lastname" name="leads[lastname]" />
                                <input type="hidden" id="name_success" class="required"/>
                                <input placeholder="Input Name 'FirstName LastName'" id="fullname"/>
                            </div>
                            <div class="col-sm-4 col-md-4">
                                <div class="tablewraper">
                                    <label>Owner State:</label><input name="leads[owner_state]" />
                                </div>
                            </div>
                        </div>           
                    </div>   
                    <div class="profileitem">
                        <div class="row">
                            <div class="col-sm-4 col-md-4">
                                <label>Contact:</label>
                            </div>
                            <div class="col-sm-8 col-md-8">
                                <input  name="leads[contact]" />
                            </div>              
                        </div>           
                    </div>
                    <div class="profileitem">
                        <div class="row">
                            <div class="col-sm-4 col-md-4">
                                <label>Email:</label>
                            </div>
                            <div class="col-sm-8 col-md-8">
                                <input  name="leads[email]" id="pemail" />
                            </div>             
                        </div>           
                    </div>        
                    <div class="profileitem">
                        <div class="row">
                            <div class="col-sm-4 col-md-4">
                                <label  class="showmap zillow" data-option="0" >Property Address:</label> 
                            </div>
                            <div class="col-sm-8 col-md-8">
                                <div>
                                    <input type="hidden" name= "leads[property-address-map]" class="property_val showaddr">
                                    <input type="hidden" id="laddress" name="leads[address]" value="" />  
                                    <input type="hidden" id="lcity" name="leads[city]" value="" />
                                    <input type="hidden" id="lstate" name="leads[state]" value="" />
                                    <input type="hidden" id="lzip" name="leads[zip]" value="" />
                                    <input type="hidden" id="address_success" value="" class="required" />
                                    <input class="fullwidth" id="fulladdr"/>
                                </div>
                                <div>
                                    <span><img data-option="1" src="/assets/images/google.jpg" class="showmap" style="width:30px;height: 30px;" /></span>
                                    <img data-option="1" src="/assets/images/zillow.jpeg" class="update_from_zillow" style="width:30px;height: 30px;" />
                                </div>  
                            </div>
                        </div>           
                    </div>                           
                    <div class="profileitem">
                        <div class="row">
                            <div class="col-sm-4 col-md-4">
                                <label>Lead Type:</label>
                            </div>
                            <div class="col-sm-4 col-md-4">
                                <a class='btn btn-default btn-select'>
                                    <input type='hidden' class='btn-select-input' name="leads[leadtype]" value='Cash Buyer' />
                                    <span class='btn-select-value'>Select an Item</span>
                                    <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                                    <ul class='grade' data-target=''>
                                        <li data-value='Cash Buyer'>Cash Buyer</li>
                                        <li data-value='Absentee'>Absentee</li>
                                        <li data-value='Absentee Ow'>Absentee Ow</li>
                                        <li data-value='Probate'>Probate</li>
                                    </ul>
                                </a>
                            </div>
                        </div>           
                    </div> 
                    <div class="profileitem">
                        <div class="row">
                            <div class="col-sm-4 col-md-4">
                                <label>Called:</label>
                            </div>
                            <div class="col-sm-8 col-md-8">
                                <input type="checkbox" value="1" name="leads[called]" />
                            </div>
                        </div>           
                    </div> 
                            
                    <div class="discovery_form">
                        <input type="hidden" id="podiopropertyitemid">
                        <input type="hidden" id="podiosellerid">
                        <input type="hidden" id="podiocashbuyerid">
                        <input type="hidden" id="realtor">
                        <div class="row">
                            <div class="col-sm-5 col-md-5">
                                <div class="row profileitem">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="tablewraper">
                                            <input type="hidden" name="leads[bed]" class="addaltervalue"/>
                                            <input name="leads[bedrooms]" class="smallitem property_val zilloworigin altervalue" type="text" data-target="bed" data-zillow="bedrooms"/> <label>Bed</label> 
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="tablewraper">
                                            <input type="hidden" name="leads[bath]" class="addaltervalue"/>
                                            <input type="text"  name="leads[bathrooms]" class="smallitem property_val zilloworigin altervalue" data-target="bath"  data-zillow="bathrooms"/> <label>Bath</label>              
                                        </div>
                                    </div>                                                                              
                                </div>
                            </div>
                            <div class="col-sm-1 col-md-1"></div>
                            <div class="col-sm-6 col-md-6">
                                <div class="row  text-right">
                                    <div class="tablewraper">
                                        <label>Zillow estimate:</label>
                                        <input type="hidden" name="leads[zillow_estimate]" class="addaltervalue"/>
                                        <input type="text"   name="leads[zestimate-2]" class="mediumitem property_val zillowval_search altervalue" data-target="zillow_estimate" data-zillow="zestimate" />
                                    </div>
                                </div>
                            </div>                
                        </div>
                        <div class="row profileitem">
                            <div class="col-sm-5 col-md-5">
                                <div class="row text-right" >
                                    <div class="tablewraper">               
                                        <input type="hidden" name="leads[year_built]" class="addaltervalue"/>                         
                                        <label>Year Built:</label> <input  name="leads[year-built]" type="text" class="mediumitem property_val zilloworigin altervalue" data-target="year_built"  data-zillow="yearBuilt"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-7 col-md-7">
                                <div class="row text-right">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="tablewraper">
                                            <input type="hidden" name="leads[owe]" class="addaltervalue"/>
                                            <label>Owes:</label><input  name="leads[mortgage-amount-2]" type="text" class="mediumitem property_val altervalue"  data-target="owe"/> </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="tablewraper">
                                            <input type="hidden" name="leads[offer]" class="addaltervalue"/>
                                            <label>Offer:</label><input  name="leads[our-offer]" type="text" class="mediumitem property_val altervalue" data-target="offer" /> </span>                        
                                            </div>
                                    </div>                                                
                                </div>
                            </div>
                        </div>
                        <div class="row profileitem">
                            <div class="col-sm-5 col-md-5">
                                <div class="row text-right">
                                    <input type="hidden" name="leads[sqft]" class="addaltervalue"/>
                                    <label>Sq Ft:</label> <input  name="leads[size-of-the-house-sf]" type="text" class="mediumitem property_val  zilloworigin altervalue"  data-target="sqft" data-zillow="finishedSqFt"/>
                                </div>
                            </div>
                            <div class="col-sm-7 col-md-7">
                                <div class="row text-right">
                                    <input type="hidden" name="leads[lot_size]" class="addaltervalue"/>
                                    <label>Lot size:</label>
                                    <input type="text"  name="leads[lot-size]" class="property_val zilloworigin altervalue"   data-target="lot_size" data-zillow="lotSizeSqFt"/>
                                </div>
                            </div>
                        </div>
                        <div class="row profileitem">
                            <div class="col-sm-6 col-md-6">
                                <div class="row">
                                    <div class="tablewraper">
                                        <input type="hidden" name="leads[ac_note]" class="addaltervalue"/>
                                        <label>Central AC:</label> 
                                        <input  name="leads[ac-notes]" type="text" class="property_val zillowval altervalue" data-target="central_ac"  data-zillow="coolingSystem"/>                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="row  text-right">
                                    <div class="tablewraper">
                                        <input type="hidden" name="" class="addaltervalue"/>
                                        <label>Asking Price:</label>
                                        <input  name="leads[asking-price]" type="text" class="property_val altervalue" data-target="asking-price"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row profileitem">
                            <div class="col-sm-6 col-md-6">
                                <div class="row">
                                    <div class="tablewraper">
                                        <input type="hidden" name="" class="addaltervalue"/> 
                                        <label>Roof:</label> 
                                        <input  name="leads[roof]" type="text" class="property_val zillowval altervalue" data-target="roof"   data-zillow="roof"/> 
                                    </div>        
                                </div>          
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="row">
                                    <div class="tablewraper">
                                        <label>Property Type:</label> 
                                        <div>
                                            <input type="hidden" name="leads[propertytype]" class="addaltervalue"/>
                                            <input  name="leads[type-of-property-3]" type="text" class="property_val zilloworigin altervalue" data-target="propertytype"  data-zillow="useCode" />
                                        </div>  
                                    </div>         
                                </div>          
                            </div>                               
                        </div>    
                        <div class="row profileitem">
                            <div class="col-sm-6 col-md-6">
                                <div class="row">
                                    <div class="tablewraper">
                                        <input type="hidden" name="leads[garage]" class="addaltervalue"/>                                        
                                        <label>Garage:</label> 
                                        <input  name="leads[garage-2]" type="text" class="property_val zillowval altervalue" data-target="garage" data-zillow="parkingType"/>
                                    </div>             
                                </div>          
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="row">
                                    <div class="tablewraper">
                                        <input type="hidden" name="leads[tax_assessment]" class="addaltervalue"/>                                        
                                        <label>Tax Assessment:</label> 
                                        <input  name="leads[tax-assesment-value]" type="text" class="property_val zilloworigin altervalue" data-target="tax_assessment"  data-zillow="taxAssessment" />
                                    </div>           
                                </div>          
                            </div>                  
                        
                        </div>  
                        <div class="row profileitem">
                            <div class="col-sm-6 col-md-6">
                                <div class="row">
                                    <div class="tablewraper">
                                        <input type="hidden" name="leads[pool]" class="addaltervalue"/>
                                        <label>Pool:</label> 
                                        <input  name="leads[pool-notes]" type="text" class="property_val altervalue" data-target="pool"/>
                                    </div>             
                                </div>          
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="row">
                                    <div class="tablewraper">    
                                        <input type="hidden" name="leads[lastsolddate]" class="addaltervalue"/>                                
                                        <label>Last Sold Date:</label> 
                                        <input  name="leads[last-sold-date]" type="text" class="property_val zilloworigin altervalue" data-target="lastsolddate"  data-zillow="lastSoldDate" />
                                    </div>           
                                </div>          
                            </div>                 
                        
                        </div>  
                        <div class="row profileitem">
                            <div class="col-sm-6 col-md-6">
                                <div class="row">
                                    <div class="tablewraper">
                                        <input type="hidden" name="" class="addaltervalue"/>                                        
                                        <label>Repairs:</label> 
                                        <input  name="leads[repairs]" type="text" class="property_val altervalue" data-target="repairs" />
                                    </div>             
                                </div>          
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="row">
                                    <div class="tablewraper">
                                        <input type="hidden" name="leads[lastsoldprice]" class="addaltervalue"/>                                        
                                        <label>Last Sold Price:</label> 
                                        <input  name="leads[last-sold-amount]" type="text" class="property_val zilloworigin altervalue" data-target="lastsoldprice"  data-zillow="lastSoldPrice" />
                                    </div>           
                                </div>          
                            </div>                  
                        
                        </div>                                                       

                        <div class="row profileitem">
                            <div class="col-sm-6 col-md-6">
                                <div class="row">
                                    <div class="tablewraper">                                    
                                        <label>Occupancy:</label> 
                                        <a class="btn btn-default btn-select large_select property_val selectbox" data-target="occupancy">
                                            <input type="hidden" name="leads[occupancy]" class="addaltervalue"/>
                                            <input  name="leads[vacant2]" type="hidden" class="btn-select-input  altervalue" id="number_entries_perpage" name="" value="-1" />
                                            <span class="btn-select-value">Select an Item</span>
                                            <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                                            <ul>
                                                <li data-value="1">Yes - Primary</li>
                                                <li data-value="2">Yes - 2nd Home</li>
                                                <li data-value="3" >Rented</li>
                                                <li data-value="0" class="selected">No</li>
                                            </ul>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="row">
                                    <div class="tablewraper">
                                        <input type="hidden" name="" class="addaltervalue"/>                                        
                                        <label>Rent:</label>
                                        <input  name="leads[rent]" type="text" class="property_val  altervalue" data-target="rent" />
                                    </div>
                                </div>
                            </div>
                        </div>    
                        <div class="row">
                            <div>
                                <label>Other Notes:</label> 
                            </div>
                            <div>
                                <input type="hidden" name="leads[note]" class="addaltervalue"/>
                                <textarea  name="leads[notes-2]"  class="property_val fullwidth  altervalue" data-target="note"></textarea> 
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col-md-4 col-lg-4 text-center">
                                <button class="uploadRealtor btn btn-primary" type="button">Realtor</button>
                            </div>
                            <div class="col-md-4 col-lg-4 text-center">
                                <button class="uploadPodio btn btn-primary" type="button">Upload To podio</button>
                            </div>
                            <div class="col-md-4 col-lg-4 text-center">
                                <button class="uploadCashbuyer btn btn-primary" type="button">Cash Buyer</button>
                            </div>                            
                        </div>      
                        <div class="row text-center buttongroup">
                            <button type="button" class="btn btn-primary btnaddlead">Add</button>
                        </div>                                     
                    </div>

                </div>
            </form>
        </div>    
    </div>
</div>
<div class="modal_area" id="errorbox">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel">Errors</h3>
            </div>
            <div class="modal-body" id="errorcontent"> 
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btnclose" data-target="errorbox">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal_area" id="successbox">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel">Information</h3>
            </div>
            <div class="modal-body"> 
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btncloseredirect" data-target="successbox">Go to Main Page</button>
            </div>
        </div>
    </div>
</div>
<script defer type="text/javascript" src="/assets/js/messenger/util.js?3"></script> 
<script defer type="text/javascript" src="/assets/js/messenger/showprofile.js?14"></script> 
<script defer type="text/javascript" src="/assets/js/messenger/addlead.js?1"></script> 