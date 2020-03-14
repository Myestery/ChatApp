<?php require($_SERVER['DOCUMENT_ROOT'].'/chatapp/includes/header.php')?>
<div id="main" class="container">
<div class='btn-group dropup'>
<button class='btn btn-secondary dropdown-toggle' type='button' id='elipse' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
Customer area
</button>
<ul class='dropdown-menu' aria-labelledby='elipse'>
<button class='dropdown-item btn btn-danger' >Delete for Me</button>
<button class='dropdown-item btn btn-danger'>Delete for everyone</button>
<button class='dropdown-item btn btn-info'>View Details</button>
</ul>
</div>
<button class="btn btn-success">Hi there</button>
<span class="glyphicon glyphicon-envelope"></span>
<span><i class="fa fa-coffee"></i></span>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Open modal</button>
<!-- The Modal -->
<div class="modal fade" id="myModal">
<div class="modal-dialog">
<div class="modal-content">
<!-- Modal Header -->
<div class="modal-header">
<h4 class="modal-title">Sent by you</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<!-- Modal body -->
<div class="modal-body">
on November 2019<br>
By 12:15pm<br>
Read by testuser on tuesday by 12pm
</div>
<!-- Modal footer -->
<div class="modal-footer">
<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
</div>
</div>
</div>

</div>
<div id="tobeclicked">click me</div>
</div>
<?php require($_SERVER['DOCUMENT_ROOT'].'/chatapp/includes/footer.php')?>
