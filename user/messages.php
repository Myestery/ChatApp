<?php require($_SERVER['DOCUMENT_ROOT'] . '/chatapp/includes/header.php'); ?>
<?php if (isset($_SESSION['chatemail'])) {
    echo "<script>$('.logo >b').text('Messages')</script>
<div id='main' class='container'>";
    // <div class='text-info'><button class='btn btn-large'><i class='fas fa-search'></i> Find friends to message</button>  </div>
    // <div class='input-group-text form-group '><input type='text' class='form-control'id='messagetext'></div>
    // <button class='btn btn-success message'>message johnpaul</button>
    // <span class='success'></span>
    // <span><i class='fas fa-coffee'></i></span>
    // 
    if (!(isset($_GET['friend'])) && !isset($_POST['messageto'])) {
        echoallmessages();
        echo "<ul class='pagination pagination-sm down'>
<li class='page-item'><a href='' class='page-link'>1</a></li>
<li class='page-item'><a href='' class='page-link'>2</a></li>
<li class='page-item'><a href='' class='page-link'>3</a></li>
</ul></div>";
        require($_SERVER['DOCUMENT_ROOT'] . '/chatapp/includes/footer.php');
    } else if (isset($_POST['messageto'])) {
        sendmessage();
    } else {
        echoconversation();
    }
} else {
    header('location:http://johnpaul/chatapp/login.php');
}
?>
