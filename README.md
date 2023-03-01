
# Custom Product Request

Here User can request for product and it will ssend email when product available

For Adding to modal 



```diff
************** Woocomerce is Required.
```
```html
<div class="modal fade" id="request_Modal" tabindex="-1" aria-labelledby="request_Modal" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <?php echo do_shortcode("[gd-request-form]");?>
      </div>
    </div>
  </div>
</div>
```

This is for trigger the modal
```html
data-bs-toggle="modal" data-bs-target="#request_Modal" 
```

And For Corn

```php
gd_check_request_product
```


## License

[Tj Thouhid](https://github.com/tjthouhid/custom-requst-post/)


