<div class="page-header mt-5-7">
    <div class="page-leftheader">
      <h4 class="page-title mb-0">Agency</h4>
      <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item"><a href="<?= base_url('dashboard')  ?>"><i class="fa-solid fa-box-circle-check mr-2 fs-12"></i>Dashboard</a></li>
        
      </ol>
    </div>
    
  </div>
  <div style="margin-left: 84%;">
      <a href="#" class="btn btn-primary createBtn">Create User</a>
       
    </div>

    <div class="row content" style="width: 84% !important;">
      <!-- table start -->
            <div class="content mt-2">
            <div class="animated fadeIn">
                <div class="row">
            
        <div class="card col-lg-12 border-0" style="margin-left: 14% !important;">
            <div class="card-body pt-3">
          <div class="table-responsive">      
                       
                         
                         
                        <table class="table table-striped table-bordered" id="blog_table">
                              <thead>
                                <tr>
                                
                                  <th scope="col"clTabCtrl>Name</th>
                                  <th scope="col">Email</th>
                                  <th scope="col">Package</th>
                                  <th scope="col">Action</th>
                               </tr>
                              </thead>
    <tbody>
      <?php if(isset($users)) : ?>
          <?php foreach($users as $key => $image) : ?>

                                <tr>
                                    <td style="text-align: center;"><?= $image['name'] ?></td>
                                    <td style="text-align:center;">
                                      <?= $image['email'] ?>
                                    </td>
                                    <td style="text-align:center;">
                                      FE,
                                      <?php if(isset($image['oto_1']) && $image['oto_1'] != 0): ?>
                                       Unlimited
                                      <?php endif ?>
                                    </td>
                                  
                                    <td>
                                      <div style="display: inline-block;padding: 8px;background-color: #f5f5f5;">
                                        <a href="#" class="updateBtn" data-id="<?= $image['id'] ?>" data-name="<?= $image['name'] ?>" data-email="<?= $image['email'] ?>" data-oto1=""><i class="fa fa-edit" aria-hidden="true" style="color:blue"></i></a> 
                                      </div>
                                     <div style="display: inline-block;padding: 8px;background-color: #f5f5f5;cursor: pointer;">
                              <a href="javascript:void(0)" onclick="deleteSit('<?php echo base_url("dashboard/deleteAgency/".$image['id']) ?>')" id="delete-fomo<?= $image['id'] ?>" data-did="$image['id']"><i class="fa fa-trash" aria-hidden="true" style="color:red"></i></a>
                                    </div>
                                    </td>
                                    
                                </tr>
                             <?php endforeach; 
                            endif; ?>
    </tbody>
</table>
                         
                        
             </div>
           </div>

                     
         </div>   


            </div>
         
        </div>
      <!-- table end -->

            </div>
          </div>


          <!-- create user -->

           <div id="createBtn" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create User</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div style="width: 90%;margin-left: 18px;">
                      <form method="post" action="<?php echo base_url(); ?>dashboard/postAgency" enctype="multipart/form-data" autocomple="off">  
                      

                        <input type="hidden" name="uid" value="0">
                        <div class="form-group pt-2">
                            <label>Full Name<small class="text-danger">*</small></label>
                            <input type="text" class="form-control" name="user_name" id="name" placeholder="Full Name" required>
                           
                        </div>
                        <div class="form-group" style="padding-top: 8px;">
                            <label>Email Address<small class="text-danger">*</small></label>
                            <input type="email" class="form-control" name="user_send_mail" id="email" placeholder="Email" required>
                         </div>
                          
                         <div class="form-group" style="padding-top: 8px;">
                            <label>Password<small class="text-danger">*</small></label>
                            <input type="password" class="form-control" name="user_password" id="password" placeholder="Password" required>
                         </div>
                         

                         <div class="form-group" style="padding-top: 8px;">
                            <label>Plan</label><br>
                            <div class="ml-8 pt-2"><label>FE</label>
                              <input type="checkbox" name="fe" id="fe" value="1" checked>
                            </div>
                            <div class="ml-8 pt-2"><label>Unlimited</label>
                              <input type="checkbox" name="oto1" id="oto1" value="1">
                            </div><br>
                            
                         </div>
                         
                        
                        <div class="form-group pt-2 pb-3">
                        <button class="form-control big btn-primary text--light border-0 w-50 px-1 py-2 rounded" type="submit"  id="" style="margin-left: 25%;">Submit</button>
                    </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/sweetalert2.all.min.js"></script>
        <script type="text/javascript">
          $('.createBtn').on('click', function () {
            var modal = $('#createBtn');
           modal.modal('show');
        });

           function deleteSit(url){
            if(confirm("Are you sure to delete?")){
              const dbtn = "#delete-fomo"+$(this).data('did');
        let button = $(dbtn);
//                $.ajaxSetup({
//     headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
// });
   $.ajax({
    type: 'POST',
    url: url,
   beforeSend: function(){
        button.prop('disabled', true).addClass('ar-button-loading');
        button.html("deleting...");
      },
   success: function(data){
      Swal.fire('Agency', 'User Deleted successfully', 'success');
     
    },
    complete: function(){
        window.location.reload();
      }
    
  });
               
            }

        }
        </script>