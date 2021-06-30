<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Orders</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Orders</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <div class="row">
      <?php foreach ($categories as $k => $v): ?>
      <div class="col-md-3 col-lg-3 col-sm-12 p-2 ">
        <a href="#" class="cat" id="<?php echo $v['id'];?>">
          <div class="card" style="width: 18rem; cursor:pointer;">
            <div class="card-body">
              <h5 class="card-title"><?php echo $v['category_name']; ?></h5>
            </div>
          </div>
        </a>

      </div><br>
      <?php endforeach ?>

    </div>

    <br>


    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

        <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
              aria-hidden="true">&times;</span></button>
          <?php echo $this->session->flashdata('success'); ?>
        </div>
        <?php elseif($this->session->flashdata('error')): ?>
        <div class="alert alert-error alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
              aria-hidden="true">&times;</span></button>
          <?php echo $this->session->flashdata('error'); ?>
        </div>
        <?php endif; ?>


        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Items</h3>
          </div>
          <!-- /.box-header -->
            <div class="box-body">

              <?php echo validation_errors(); ?>


        <div class="row">
          <div class="col-md-12 card p-1">

            <span id="items">
              <div class="row items-list">

              </div>

            </span>

          </div>

          <div class="col-md-12 col-lg-4">


              <div class="card">
              <form role="form" action="<?php base_url('orders/create');?>" method="post" class="form-horizontal">

                <!-- <form id="add_order" class="form-horizontal"> -->

                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-12 control-label">Date: <?php echo date('Y-m-d') ?></label>
                  </div>
                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-12 control-label">Time: <?php echo date('h:i a') ?></label>
                  </div>
              
                <span id="cart">
                  <table class="table" id="product_info_table">
                    <thead>
                      <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Price</th>
                      </tr>
                    </thead>

                    <tbody>
                    

                    </tbody>
                  </table>
                </span>
              </div> <!-- card.// -->

              <div class="box">
                <dl class="dlist-align">
                  <dt>Total: </dt>
                  <dd class="text-right h4 b">

                    <input type="text" class="form-control" id="net_amount" name="net_amount" disabled
                      autocomplete="off">
                    <input type="hidden" class="form-control" id="net_amount_value" name="net_amount_value"
                      autocomplete="off">
                  </dd>
                </dl>
                <div class="row">
                  <div class="col-md-6">
                    <a href="<?php echo base_url('orders/') ?>" class="btn  btn-default btn-error btn-lg btn-block"><i
                        class="fa fa-times-circle "></i> Cancel </a>
                  </div>
                  <div class="col-md-6">
                    <button type="submit" class="btn  btn-primary btn-lg btn-block"><i class="fa fa-shopping-bag"></i>
                      Charge </button>
                  </div>
                </div>
              </div> <!-- box.// -->

          </form>
              
            </div>
            
          </div>
        
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
    


  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
  var base_url = "<?php echo base_url(); ?>";

  // $(document).on('submit', '#add_order', function(event){
	// 	event.preventDefault();
	// 	alert();
	// 	$.ajax({
	// 		url:base_url + '/orders/add_order',
	// 		method:'POST',
	// 		data:new FormData(this),
	// 		contentType:false,
	// 		processData:false,
	// 		success:function(data)
	// 		{
	// 			alert(data);
	// 			if(data.match('success'))
	// 			{
	// 				location.reload();
	// 			}
	// 		}
	// 	});
	// });

  $('.cat').click(function (e) {
    e.preventDefault();

    var table = $("#product_info_table");

          var count_table_tbody_tr = $("#product_info_table tbody tr").length;

          var row_id = count_table_tbody_tr + 1;

    var category_id = $(this).attr("id");
    //alert(event_id);
    $.ajax({
      url: base_url + '/orders/getCategoryProduct/',
      method: "post",
      data: {
        category_id: category_id
      },
      success: function (result) {

  

        $('.items-list').html(result);

        $('.add-cart').click(function (e) {
          e.preventDefault();
          var table = $("#product_info_table");

          var count_table_tbody_tr = $("#product_info_table tbody tr").length;

          var row_id = count_table_tbody_tr + 1;
          // alert(JSON.stringify(row_id));
          var product_id = $(this).attr("id");
          //lert(item_id);
          $.ajax({
            url: base_url + '/orders/getProductById/',
            method: "post",
            dataType:"json",
            data: {
              row_id: row_id,
              product_id: product_id
            },
            success: function (response) {

              // alert(JSON.stringify(response));

                   var html = '<tr id="row_'+row_id+'">'+
                   '<td>'+response.name+'<input type="hidden" name="product[]" id="product_'+row_id+'" class="form-control" value="'+response.p_id+'"></td>'+
                    '<td><input type="number" min="1" name="qty[]" id="qty_'+row_id+'" class="form-control" value="1" onchange="getTotal('+row_id+')"></td>'+
                    '<td><input type="text" name="amount[]" id="amount_'+row_id+'" value="'+response.price+'" class="form-control"><input type="hidden" name="amount_value[]" id="amount_value_'+row_id+'" value="'+response.price+'" class="form-control"></td>'+
                    '<td><button type="button" class="btn btn-default" onclick="removeRow(\''+row_id+'\')"><i class="fa fa-close"></i></button></td>'+
                    '</tr>';

              if (count_table_tbody_tr >= 1) {
                $("#product_info_table tbody tr:last").after(html);
              } else {
                $("#product_info_table tbody").html(html);
              }

              $(".product").select2();
              $("input[type='number']").inputSpinner();
              //alert();
              subAmount();



            }
          });
        });


      }
    });
  });



  $(document).ready(function () {



    $(".select_group").select2();
    // $("#description").wysihtml5();

    $("#mainOrdersNav").addClass('active');
    $("#addOrderNav").addClass('active');

    var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' +
      'onclick="alert(\'Call your custom code here.\')">' +
      '<i class="glyphicon glyphicon-tag"></i>' +
      '</button>';

    // Add new row in the table 
    // $(".add-cart").unbind('click').bind('click', function() {
    //   //alert();
    //   var table = $("#product_info_table");
    //   var count_table_tbody_tr = $("#product_info_table tbody tr").length;
    //   var row_id = count_table_tbody_tr + 1;

    //   $.ajax({
    //       url: base_url + '/orders/getTableProductRow/',
    //       type: 'post',
    //       dataType: 'json',
    //       success:function(response) {

    //           // console.log(reponse.x);
    //            var html = '<tr id="row_'+row_id+'">'+
    //                '<td>'+ 
    //                 '<select class="form-control select_group product" data-row-id="'+row_id+'" id="product_'+row_id+'" name="product[]" style="width:100%;" onchange="getProductData('+row_id+')">'+
    //                     '<option value=""></option>';
    //                     $.each(response, function(index, value) {
    //                       html += '<option value="'+value.p_id+'">'+value.name+'</option>';             
    //                     });

    //                   html += '</select>'+
    //                 '</td>'+ 
    //                 '<td><input type="number" min="1" max="" name="qty[]" id="qty_'+row_id+'" class="form-control" onkeyup="getTotal('+row_id+')"></td>'+
    //                 '<td><input type="text" name="rate[]" id="rate_'+row_id+'" class="form-control" disabled><input type="hidden" name="rate_value[]" id="rate_value_'+row_id+'" class="form-control"></td>'+
    //                 '<td><input type="text" name="amount[]" id="amount_'+row_id+'" class="form-control" disabled><input type="hidden" name="amount_value[]" id="amount_value_'+row_id+'" class="form-control"></td>'+
    //                 '<td><button type="button" class="btn btn-default" onclick="removeRow(\''+row_id+'\')"><i class="fa fa-close"></i></button></td>'+
    //                 '</tr>';

    //             if(count_table_tbody_tr >= 1) {
    //             $("#product_info_table tbody tr:last").after(html);

    //             //subAmount();
    //           }
    //           else {
    //             $("#product_info_table tbody").html(html);

    //             //subAmount();
    //           }

    //           $(".product").select2();

    //       }
    //     });

    //   return false;
    // });

  }); // /document

  function getTotal(row = null) {


    if (row) {
      // var total = Number($("#rate_value_"+row).val()) * Number($("#qty_"+row).val());
      var total = Number($("#amount_value" + row).val()) * Number($("#qty_" + row).val());
      //alert(total);
      total = total.toFixed(2);
      $("#amount_" + row).val(total);
      //$("#amount_value_"+row).val(total);

      subAmount();

    } else {
      alert('no row !! please refresh the page');
    }
  }



  // calculate the total amount of the order
  function subAmount() {

    // var vat_charge = <?php //echo ($company_data['vat_charge_value'] > 0) ? $company_data['vat_charge_value']:0; ?>;

    var tableProductLength = $("#product_info_table tbody tr").length;


    var totalSubAmount = 0;
    for (x = 0; x < tableProductLength; x++) {
      var tr = $("#product_info_table tbody tr")[x];
      var count = $(tr).attr('id');
      count = count.substring(4);

      totalSubAmount = Number(totalSubAmount) + Number($("#amount_" + count).val());
    } // /for

    totalSubAmount = totalSubAmount.toFixed(2);
    //alert(totalSubAmount);

    // sub total
    // $("#gross_amount").val(totalSubAmount);
    // $("#gross_amount_value").val(totalSubAmount);

    // vat
    // var vat = (Number($("#gross_amount").val())/100) * vat_charge;
    // vat = vat.toFixed(2);
    // $("#vat_charge").val(vat);
    // $("#vat_charge_value").val(vat);



    // total amount
    var totalAmount = Number(totalSubAmount);
    totalAmount = totalAmount.toFixed(2);
    // $("#net_amount").val(totalAmount);
    // $("#totalAmountValue").val(totalAmount);

    //alert(totalAmount);

    var discount = $("#discount").val();
    if (discount) {
      var grandTotal = Number(totalAmount) - Number(discount);
      grandTotal = grandTotal.toFixed(2);
      $("#net_amount").val(grandTotal);
      $("#net_amount_value").val(grandTotal);
    } else {
      $("#net_amount").val(totalAmount);
      $("#net_amount_value").val(totalAmount);

    } // /else discount 

  } // /sub total amount

  function removeRow(tr_id) {
    $("#product_info_table tbody tr#row_" + tr_id).remove();
    subAmount();
  }
</script>

<script src="<?php echo base_url('assets/ui/js/OverlayScrollbars.js');?>" type="text/javascript"></script>
<script>
  $(function () {
    //The passed argument has to be at least a empty object or a object with your desired options
    //$("body").overlayScrollbars({ });
    $("#items").height(552);
    $("#items").overlayScrollbars({
      overflowBehavior: {
        x: "hidden",
        y: "scroll"
      }
    });
    $("#cart").height(445);
    $("#cart").overlayScrollbars({});

  });
</script>
