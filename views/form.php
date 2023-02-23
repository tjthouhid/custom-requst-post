    <div class="request-form">
        <div class="container">
            <div class="row">
                <div class="col text-center fw-bold fs-4">
                    <span class="product_request__title">Can't find what your looking for</span>
                    <p>Why not leave us what you need and we can add you to our product wish list</p>
                </div>
            </div>
            
            <form id="gd_product_request_form" action="product_request_insert">
                <input type="hidden" name="action" value="product_request_insert">
                <div class="row">
                    <div class="col-md-12 col-12 mb-3">
                        <label for="gd_name" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="gd_name" name="gd_name" placeholder="">
                    </div>
                    <div class="col-md-6 col-12 mb-3">
                        <label for="gd_email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="gd_email" name="gd_email" placeholder="">
                    </div>
                    <div class="col-md-6 col-12 mb-3">
                        <label for="gd_phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="gd_phone" name="gd_phone" placeholder="">
                    </div>
                    <div class="col-md-6 col-12 mb-3">
                        <label for="gd_type" class="form-label">Type</label>
                        <select class="form-control" id="gd_type" name="gd_type">
                                <option value="">Any</option>
                                <?php 
                                $cat_args = array(
                                    
                                );
                                $product_categories = get_terms( 'product_cat', array(
                                    'orderby'    => 'name',
                                    'exclude'		=> 15,
                                    'order'      => 'asc',
                                    'hide_empty' => true,
                                ) );
                            
                                if( !empty($product_categories) ){
                                    foreach ($product_categories as $key => $category) { 
                                        echo '<option value="' . $category->slug . '">' . $category->name . '</option>';
                                    }
                                } ?>
                            </select>
                    </div>
                    <div class="col-md-6 col-12 mb-3">
                        <label for="gd_color" class="form-label">Colour</label>
                        <select class="form-control" id="gd_color" name="gd_color">
                                <option value="">Any Colour</option>
                                <?php
                                $colours = get_terms( 'pa_colour', array(
                                    'orderby'    => 'name',
                                    'order'      => 'asc',
                                    'hide_empty' => true,
                                ) );
                                
                                if( !empty($colours) ){
                                    foreach ($colours as $key => $category) { 
                                    
                                    echo '<option value="' . $category->slug . '">' . $category->name . '</option>';
                                    }
                                } ?>
                            </select>
                    </div>
                    <div class="col-md-12 col-12 mb-3">
                        <label for="gd_width" class="form-label">Width (CM)</label>
                        <input type="number" step="0.1" class="form-control" id="gd_width" name="gd_width" placeholder="0.00">
                        <div id="gd_widthHelpBlock" class="form-text fw-bold">Add a width range</div>
                    </div>
                    <div class="hide-gd-width">
                        <div class="row ">
                            <div class="col-md-6 col-12 mb-3">
                                <label for="gd_width_min" class="form-label">Min Width (CM)</label>
                                <input type="number" step="0.1" class="form-control" id="gd_width_min" name="gd_width_min" placeholder="0.00">
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="gd_width_max" class="form-label">Max Width (CM)</label>
                                <input type="number" step="0.1" class="form-control" id="gd_width_max" name="gd_width_max" placeholder="0.00">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 col-12 mb-3">
                        <label for="gd_height" class="form-label">Height (CM)</label>
                        <input type="number" step="0.1" class="form-control" id="gd_height" name="gd_height" placeholder="0.00">
                        <div id="gd_heightHelpBlock" class="form-text fw-bold">Add a Height range</div>
                    </div>
                    <div class="hide-gd-height">
                        <div class="row">
                            <div class="col-md-6 col-12 mb-3">
                                <label for="gd_height_min" class="form-label">Min Height (CM)</label>
                                <input type="number" step="0.1" class="form-control" id="gd_height_min" name="gd_height_min" placeholder="0.00">
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="gd_height_max" class="form-label">Max Height (CM)</label>
                                <input type="number" step="0.1" class="form-control" id="gd_height_max" name="gd_height_max" placeholder="0.00">
                            </div>
                        </div>
                    </div>
                    
                        

                    <div class="col-md-12 col-12 mb-3">
                        <button type="submit" class="btn btn-primary text-white" id="submit_request">Submit</button>
                    </div>
                    
                
                
                </div>
            </form>
        </div>
        <div class="error_gd_r_msg"></div>
        <div class="gd_request_thankyou p-3 text-success text-center">
            <span class="product_request__title text-center d-block">Request has been sent.</span>
            <span class="product_request__title text-center d-block"> We have now added your request to our automated list. Once an item comes online you will receive and email when something comes online. </span>
            <a class="btn btn-primary text-white another-request mt-2 clear-gd-form">Add another request</a><a class="btn btn-danger text-white mt-2 ms-2" data-bs-dismiss="modal">close</a>
        </div>
</div>