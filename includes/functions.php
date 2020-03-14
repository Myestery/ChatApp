<?php
require('connection.php');
session_start();
Database::initialize();
function navbar()
{
    if (isset($_SESSION['userid'])) {
        echo ('<ul>
        <li><a href="\/johnpaul/chatapp/user/dashboard.php">Home</a></li>
        <li><a href="\/johnpaul/chatapp/user/profile.php">Profile</a></li>
        <li><a href="\/johnpaul/chatapp/user/messages.php">Messages</a></li>
        <li><a href="\/johnpaul/chatapp/user/friends.php">Friends</a></li>
        <li><a href="\/johnpaul/chatapp/user/settings.php">Settings</a></li>
        <li><a href="\/johnpaul/chatapp/process.php?logout=1">Logout</a></li>
        </ul>');
    } else {
        echo ('<ul id="navul">
        <li><a href="\/johnpaul/chatapp/index.php">Home</a></li>
        <li><a href="\/johnpaul/chatapp/index.php">Contact Us</a></li>
        <li><a href="\/johnpaul/chatapp/login.php">Sign Up/ Login</a></li>
        <li><a href="\/johnpaul/chatapp/index.php">Terms</a></li>
        <li><a href="\/johnpaul/chatapp/index.php">Logout</a></li>
        </ul>');
    }
}
function echoallmessages()
{
    $bigmessagearray = array();
    $idclue = "%" . $_SESSION['userid'] . "%";
    $emailclue = "%" . $_SESSION['chatemail'] . "%";
    $query = "SELECT * FROM messages WHERE convId LIKE '$idclue' AND participants LIKE '$emailclue' ORDER BY recentTime DESC";
    $result = mysqli_query(Database::$conn, $query);
    while ($row = mysqli_fetch_array($result)) {
        array_push($bigmessagearray, $row);
    };
    if (is_array($bigmessagearray) && count($bigmessagearray) > 0) {
        foreach ($bigmessagearray as $a_row) {
            $convId = $a_row['convId'];
            $convId = str_replace($_SESSION['userid'], "", $convId);
            $sendername = mysqli_fetch_array(mysqli_query(Database::$conn, "SELECT DisplayName FROM userinfo WHERE Id='$convId'"))['DisplayName'];
            $recenttime = $a_row['recentTime'];
            $messagearray = json_decode($a_row['messagearray']);
            // echo (($messagearray)[0]->text);
            $text = substr($messagearray[count($messagearray) - 1]->text, 0, 10);
            if (strlen($messagearray[count($messagearray) - 1]->text) > 10) {
                $text = $text . "...";
            }
            $date = date('Y-m-d h:i:s', time());
            switch (true) {
                case (substr($date, 0, 4) != substr($recenttime, 0, 4)):
                    $ago = abs(substr($recenttime, 0, 4) - substr($date, 0, 4));
                    if ($ago == 1) {
                        $ago = "last year";
                    } else {
                        $suffix = "s";
                        $ago = $ago . ' year' . $suffix . ' ago';
                    }

                    break;
                case (substr($date, 0, 4) == substr($recenttime, 0, 4) && substr($date, 5, 2) != substr($recenttime, 5, 2)):
                    $ago = abs(substr($recenttime, 5, 2) - substr($date, 5, 2));

                    if ($ago == 1) {
                        $ago = "last month";
                    } else {
                        $suffix = "s";
                        $ago = $ago . ' month' . $suffix . ' ago:';
                    }
                    break;
                case (substr($date, 0, 4) == substr($recenttime, 0, 4) && substr($date, 5, 2) == substr($recenttime, 5, 2) && substr($date, 8, 2) != substr($recenttime, 8, 2)):
                    $ago = abs(substr($recenttime, 8, 2) - substr($date, 8, 2));
                    if ($ago == 1) {
                        $ago = "yesterday";
                    } else {
                        $suffix = "s";
                        $ago = $ago . ' day' . $suffix . ' ago:';
                    }
                    break;
                case (substr($date, 0, 4) == substr($recenttime, 0, 4) && substr($date, 5, 2) == substr($recenttime, 5, 2) && substr($date, 8, 2) == substr($recenttime, 8, 2) && substr($date, 11, 2) != substr($recenttime, 11, 2)):
                    $ago = abs(substr($recenttime, 11, 2) - substr($date, 11, 2));
                    if ($ago == 1) {
                        $suffix = "";
                    } else {
                        $suffix = "s";
                    }
                    $ago = $ago . ' hour' . $suffix . ' ago';
                    break;
                case (substr($date, 0, 4) == substr($recenttime, 0, 4) && substr($date, 5, 2) == substr($recenttime, 5, 2) && substr($date, 8, 2) == substr($recenttime, 8, 2) && substr($date, 11, 2) == substr($recenttime, 11, 2) && substr($date, 14, 2) != substr($recenttime, 14, 2)):
                    $ago = abs(substr($recenttime, 14, 2) - substr($date, 14, 2));
                    if ($ago == 1) {
                        $suffix = "";
                    } else {
                        $suffix = "s";
                    }
                    $ago = $ago . ' minute' . $suffix . ' ago';
                    break;
                case (substr($date, 0, 4) == substr($recenttime, 0, 4) && substr($date, 5, 2) == substr($recenttime, 5, 2) && substr($date, 8, 2) == substr($recenttime, 8, 2) && substr($date, 11, 2) == substr($recenttime, 11, 2) && substr($date, 14, 2) == substr($recenttime, 14, 2) && substr($date, 17, 2) != substr($recenttime, 17, 2)):
                    $ago = abs(substr($recenttime, 17, 2) - substr($date, 17, 2));
                    if ($ago == 1) {
                        $suffix = "";
                    } else {
                        $suffix = "s";
                    }
                    $ago = $ago . ' second' . $suffix . ' ago';
                    break;
                default:
                    $ago = 'just now';
                    break;
            }
            $unread = 0;
            for ($i = count($messagearray) - 1; $i > -1; $i--) {
                if (($messagearray[$i]->read) == "false" && $messagearray[$i]->receiver == $_SESSION['userid']) {
                    $unread++;
                }
            }
            if ($unread == 0) {
                $unread = "";
            }
            echo "<a href='http://johnpaul/chatapp/user/messages?friend=" . $convId . "'><div class='messagebox input-group-text'><span class='badge text-danger'>" . $unread . "</span><strong class='friend'>" . $sendername . "</strong> <br><small class='messagetime '><i>" . $ago . "</i></small><small class='messagehint text-info'>" . $text . "</small>
        </div></a>";
        }
    } else {
        echo 'no messages yet';
    }
}
function echoconversation()
{
    $receiver = mysqli_real_escape_string(Database::$conn, stripcslashes(stripslashes($_GET['friend'])));
    $sender = $_SESSION['userid'];
    $one = $sender . $receiver;
    $two = $receiver . $sender;
    $result = mysqli_query(Database::$conn, "SELECT * FROM messages WHERE convId ='$one' OR  convId ='$two'");
    $row = mysqli_fetch_array($result);
    if (is_array($row)) {
        $convId = $row['convId'];
        $friendId = str_replace($_SESSION['userid'], "", $convId);
    } else {
        $friendId = $receiver;
    }
    $friendname = mysqli_fetch_array(mysqli_query(Database::$conn, "SELECT * FROM userinfo WHERE Id ='$receiver' limit 1"))['DisplayName'];
    echo "<header>
<div class='logo'><b><a href='http://johnpaul/chatapp/user/messages.php' class='fa fa-arrow-circle-left' aria-hidden='true'></a>  " . $friendname . "</b></div>
<div class='menu-toggle'>&#9776;</div>
<nav id='mobile'>
</nav>
</header>
<script>
  $(document).ready(function () {
    if (window.location.href.includes(
        'http://johnpaul/chatapp/user/messages?friend'
      )
    ) {
        
        window.scrollTo(0,document.documentElement.scrollHeight)
      setInterval(function() {
        $.get(
          'http://johnpaul/chatapp/includes/functions.php',
          {
            friendtoupdate: $('small.friendId').html(),
            updatemessage: true,
            lastindex: $('#lastindex').html()
          },
          function(result) {
            if (result.length > 22) {
              $('#lastindex').remove();
              $('#main').append(result);
              window.scrollTo(0,document.documentElement.scrollHeight)
            }
          }
        );
      }, 1000); 
    }
    $('#message').focus();
});
</script>";
    if (is_array($row) && count($row) > 0) {
        $messagearray = json_decode($row['messagearray']);
        for ($i = 0; $i < count($messagearray); $i++) {
            if ($messagearray[$i]->sender == $_SESSION['userid'] && !(isset($messagearray[$i]->hide) && $messagearray[$i]->hide == $_SESSION['userid'])) {
                $text = stripslashes($messagearray[$i]->text);
                $date = $messagearray[$i]->datetime;
                $read = $messagearray[$i]->read;
                if ($read != "read") {
                    $readinfo = "unread";
                    $messagearray[$i]->read = "read";
                    $messagearray[$i]->readtime = date('Y-d-m h:i:s', time());
                } else {
                    $readtime = $messagearray[$i]->readtime;
                    if (date('h:i', strtotime($readtime)) > 12) {
                        $am = "pm";
                    } else {
                        $am = "am";
                    }
                    $readinfo = "Read by " . " " . $friendname . " on " . date('l', strtotime($readtime)) . " " . date('d', strtotime($readtime)) . " " . date('M', strtotime($readtime)) . " " . date('Y', strtotime($date)) . " by " . date('h:i', strtotime($date)) . $am;
                }
                $presentdate = date('Y-m-d h:i:s', time());
                switch (true) {
                    case (substr($presentdate, 0, 4) != substr($date, 0, 4)):
                        $ago = abs(substr($presentdate, 0, 4) - substr($date, 0, 4));
                        if ($ago == 1) {
                            $suffix = "";
                        } else {
                            $suffix = "s";
                        }
                        $ago = $ago . ' year' . $suffix . ' ago';
                        break;
                    case (substr($presentdate, 0, 4) == substr($date, 0, 4) && substr($presentdate, 5, 2) != substr($date, 5, 2)):
                        $ago = abs(substr($presentdate, 5, 2) - substr($date, 5, 2));
                        if ($ago == 1) {
                            $suffix = "";
                        } else {
                            $suffix = "s";
                        }
                        $ago = $ago . ' day' . $suffix . ' ago:';
                        break;
                    case (substr($presentdate, 0, 4) == substr($date, 0, 4) && substr($presentdate, 5, 2) == substr($date, 5, 2) && substr($presentdate, 8, 2) != substr($date, 8, 2)):
                        $ago = abs(substr($presentdate, 8, 2) - substr($date, 8, 2));
                        if ($ago == 1) {
                            $suffix = "";
                        } else {
                            $suffix = "s";
                        }
                        $ago = $ago . ' month' . $suffix . ' ago:';
                        break;
                    case (substr($presentdate, 0, 4) == substr($date, 0, 4) && substr($presentdate, 5, 2) == substr($date, 5, 2) && substr($presentdate, 8, 2) == substr($date, 8, 2) && substr($presentdate, 11, 2) != substr($date, 11, 2)):
                        $ago = abs(substr($presentdate, 11, 2) - substr($date, 11, 2));
                        if ($ago == 1) {
                            $suffix = "";
                        } else {
                            $suffix = "s";
                        }
                        $ago = $ago . ' hour' . $suffix . ' ago';
                        break;
                    case (substr($presentdate, 0, 4) == substr($date, 0, 4) && substr($presentdate, 5, 2) == substr($date, 5, 2) && substr($presentdate, 8, 2) == substr($date, 8, 2) && substr($presentdate, 11, 2) == substr($date, 11, 2) && substr($presentdate, 14, 2) != substr($date, 14, 2)):
                        $ago = abs(substr($presentdate, 14, 2) - substr($date, 14, 2));
                        if ($ago == 1) {
                            $suffix = "";
                        } else {
                            $suffix = "s";
                        }
                        $ago = $ago . ' minute' . $suffix . ' ago';
                        break;
                    case (substr($presentdate, 0, 4) == substr($date, 0, 4) && substr($presentdate, 5, 2) == substr($date, 5, 2) && substr($presentdate, 8, 2) == substr($date, 8, 2) && substr($presentdate, 11, 2) == substr($date, 11, 2) && substr($presentdate, 14, 2) == substr($date, 14, 2) && substr($presentdate, 17, 2) != substr($date, 17, 2)):
                        $ago = abs(substr($presentdate, 17, 2) - substr($date, 17, 2));
                        if ($ago == 1) {
                            $suffix = "";
                        } else {
                            $suffix = "s";
                        }
                        $ago = $ago . ' second' . $suffix . ' ago';
                        break;
                    default:
                        $ago = 'just now';
                        break;
                }
                $day = date('l', strtotime($date));
                $daynum = date('d', strtotime($date));
                $month = date('M', strtotime($date));
                $year = date('Y', strtotime($date));
                $time = date('h:i', strtotime($date));
                if (date('h:i', strtotime($date)) > 12) {
                    $pm = "pm";
                } else {
                    $pm = "am";
                }
                echo "<div class='conversation-field sent'>
    <div class='text'>" . $text . "
    </div><div class='btn-group dropleft elipse'>
    <button class='btn dropdown-toggle' type='button' id='elipse' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
    </button>
    <ul class='dropdown-menu' aria-labelledby='elipse'>
    <button class='dropdown-item btn btn-danger delforme' >Delete for Me</button>
    <button class='dropdown-item btn btn-danger delforall'>Delete for everyone</button>
    <button class='dropdown-item btn btn-info data' data-toggle='modal' data-target='#Modal" . $i . "'>View Details</button>
    </ul>
    </div>
    </div><br><br><br>
    <div class='modal fade' id='Modal" . $i . "'>
<div class='modal-dialog'>
<div class='modal-content'>
<!-- Modal Header -->
<div class='modal-header'>
<h4 class='modal-title'>Sent by you</h4>
<button type='button' class='close' data-dismiss='modal'>&times;</button>
</div>
<!-- Modal body -->
<div class='modal-body'>
on " . $day . " " . $daynum . " " . $month . " " . $year . "<br>
By " . $time . $pm . "<br>" . $readinfo . "
</div>
<!-- Modal footer -->
<div class='modal-footer'>
<button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
</div>
</div>
</div>
</div>";
            } else if (!(isset($messagearray[$i]->hide) && $messagearray[$i]->hide == $_SESSION['userid'])) {
                $text = stripslashes($messagearray[$i]->text);
                $date = $messagearray[$i]->datetime;
                $read = $messagearray[$i]->read;
                $presentdate = date('Y-m-d h:i:s', time());
                switch (true) {
                    case (substr($presentdate, 0, 4) != substr($date, 0, 4)):
                        $ago = abs(substr($presentdate, 0, 4) - substr($date, 0, 4));
                        if ($ago == 1) {
                            $suffix = "";
                        } else {
                            $suffix = "s";
                        }
                        $ago = $ago . ' year' . $suffix . ' ago';
                        break;
                    case (substr($presentdate, 0, 4) == substr($date, 0, 4) && substr($presentdate, 5, 2) != substr($date, 5, 2)):
                        $ago = abs(substr($presentdate, 5, 2) - substr($date, 5, 2));
                        if ($ago == 1) {
                            $suffix = "";
                        } else {
                            $suffix = "s";
                        }
                        $ago = $ago . ' day' . $suffix . ' ago:';
                        break;
                    case (substr($presentdate, 0, 4) == substr($date, 0, 4) && substr($presentdate, 5, 2) == substr($date, 5, 2) && substr($presentdate, 8, 2) != substr($date, 8, 2)):
                        $ago = abs(substr($presentdate, 8, 2) - substr($date, 8, 2));
                        if ($ago == 1) {
                            $suffix = "";
                        } else {
                            $suffix = "s";
                        }
                        $ago = $ago . ' month' . $suffix . ' ago:';
                        break;
                    case (substr($presentdate, 0, 4) == substr($date, 0, 4) && substr($presentdate, 5, 2) == substr($date, 5, 2) && substr($presentdate, 8, 2) == substr($date, 8, 2) && substr($presentdate, 11, 2) != substr($date, 11, 2)):
                        $ago = abs(substr($presentdate, 11, 2) - substr($date, 11, 2));
                        if ($ago == 1) {
                            $suffix = "";
                        } else {
                            $suffix = "s";
                        }
                        $ago = $ago . ' hour' . $suffix . ' ago';
                        break;
                    case (substr($presentdate, 0, 4) == substr($date, 0, 4) && substr($presentdate, 5, 2) == substr($date, 5, 2) && substr($presentdate, 8, 2) == substr($date, 8, 2) && substr($presentdate, 11, 2) == substr($date, 11, 2) && substr($presentdate, 14, 2) != substr($date, 14, 2)):
                        $ago = abs(substr($presentdate, 14, 2) - substr($date, 14, 2));
                        if ($ago == 1) {
                            $suffix = "";
                        } else {
                            $suffix = "s";
                        }
                        $ago = $ago . ' minute' . $suffix . ' ago';
                        break;
                    case (substr($presentdate, 0, 4) == substr($date, 0, 4) && substr($presentdate, 5, 2) == substr($date, 5, 2) && substr($presentdate, 8, 2) == substr($date, 8, 2) && substr($presentdate, 11, 2) == substr($date, 11, 2) && substr($presentdate, 14, 2) == substr($date, 14, 2) && substr($presentdate, 17, 2) != substr($date, 17, 2)):
                        $ago = abs(substr($presentdate, 17, 2) - substr($date, 17, 2));
                        if ($ago == 1) {
                            $suffix = "";
                        } else {
                            $suffix = "s";
                        }
                        $ago = $ago . ' second' . $suffix . ' ago';
                        break;
                    default:
                        $ago = 'just now';
                        break;
                }
                $day = date('l', strtotime($date));
                $daynum = date('d', strtotime($date));
                $month = date('M', strtotime($date));
                $year = date('Y', strtotime($date));
                $time = date('h:i', strtotime($date));
                if (date('h:i', strtotime($date)) > 12) {
                    $pm = "pm";
                } else {
                    $pm = "am";
                }

                if ($read != "read") {
                    $messagearray[$i]->read = "read";
                    $messagearray[$i]->readtime = $presentdate;
                }
                $readtime = $messagearray[$i]->readtime;
                if (date('h:i', strtotime($readtime)) > 12) {
                    $am = "pm";
                } else {
                    $am = "am";
                }
                echo "<div class='conversation-field received'><div class='text'>" . $text . "
</div><div class='btn-group dropleft elipse'>
<button class='btn dropdown-toggle' type='button' id='elipse' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
</button>
<ul class='dropdown-menu' aria-labelledby='elipse'>
<button class='dropdown-item btn btn-danger delforme' >Delete for Me</button>
<button class='dropdown-item btn btn-info data' data-toggle='modal' data-target='#Modal" . $i . "'>View Details</button>
</ul>
</div></div>
<div class='modal fade' id='Modal" . $i . "'>
<div class='modal-dialog'>
<div class='modal-content'>
<!-- Modal Header -->
<div class='modal-header'>
<h4 class='modal-title'>Sent by " . $friendname . "</h4>
<button type='button' class='close' data-dismiss='modal'>&times;</button>
</div>
<!-- Modal body -->
<div class='modal-body'>
on " . $day . " " . $daynum . " " . $month . " " . $year . "<br>
By " . $time . $pm . "<br>Seen by you on " . date('l', strtotime($readtime)) . " " . date('d', strtotime($readtime)) . " " . date('M', strtotime($readtime)) . " " . date('Y', strtotime($readtime)) . " by " . date('h:i', strtotime($readtime)) . $am . "
</div>
<!-- Modal footer -->
<div class='modal-footer'>
<button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
</div>
</div>
</div>
</div>";
            }
        }
        $lastindex = count($messagearray) - 1;
        $messagearray = addslashes(json_encode($messagearray));
        $query = "UPDATE messages SET messagearray='$messagearray' WHERE convId='$convId'";
        mysqli_query(Database::$conn, $query);
        echo '<small class="none" id="lastindex">' . $lastindex . '</small>';
    } else if ($_GET['friend'] != $_SESSION['userid']) {
        echo '<p id="firstconv">you can start your conversation</p>
        <small class="none" id="lastindex">' . -1 . '</small>';
    } else {
        echo '<p id="firstconv">it is wrong to try messaging yourself</p>';
    }
    echo '<script src="\/johnpaul/chatapp/js/jquery.cookie.js"></script>
    
<script src="\/johnpaul/chatapp/js/jquery-3.2.1.min.js"></script>
<script src="\/johnpaul/chatapp/libs/bootstrap-4.3.1-dist/js/bootstrap.bundle.js"></script>
<script src="\/johnpaul/chatapp/libs/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>';
    echo '</div></div><div class="footer-conversation form-group"><small class="none friendId">' . $friendId . '</small>
<textarea name="comments" class="form-control" id="message" rows="4" placeholder="Enter your message">
</textarea><span class="elipse"><button class="fa fa-send sendbtn btn btn-success" id="sendbtn"></button></i></span></div>
</html>';
    if (isset(Database::$conn)) {
        mysqli_close(Database::$conn);
    }
}
function sendmessage()
{
    $sender = $_SESSION['userid'];
    $receiver = mysqli_real_escape_string(Database::$conn, stripcslashes(stripslashes($_POST['messageto'])));
    $message = mysqli_real_escape_string(Database::$conn, stripcslashes(stripslashes($_POST['message'])));
    $one = $sender . $receiver;
    $two = $receiver . $sender;
    $checkfirsttime = "SELECT * FROM messages WHERE convId ='$one' OR  convId ='$two'";
    $result = mysqli_query(Database::$conn, $checkfirsttime);
    $row = mysqli_fetch_array($result);
    if (is_array($row) && count($row) > 0) {
        $messagearray = json_decode($row['messagearray']);
        $convId = $row['convId'];
        $recenttime = date('Y-m-d h:i:s', time());
        $messagetoappend = array('sender' => $sender, 'receiver' => $receiver, "datetime" => $recenttime, 'read' => 'false', 'text' => $message);
        array_push($messagearray, $messagetoappend);
        $messagearray = addslashes(json_encode($messagearray));
        $query = "UPDATE messages SET recentTime = '$recenttime', messagearray='$messagearray' WHERE convId = '$convId' ";
        mysqli_query(Database::$conn, $query);
        if (mysqli_affected_rows(Database::$conn) > 0) {
            echo 'message sent';
        }
    } else {
        $receiveremailaray = mysqli_fetch_array(mysqli_query(Database::$conn, "SELECT chatemail FROM userinfo WHERE id='$receiver' "));
        $receiveremail = $receiveremailaray['chatemail'];
        $participants = $_SESSION['chatemail'] . $receiveremail;
        $convId = $sender . $receiver;
        $recenttime = date('Y-m-d h:i:s', time());
        $messagearray = array(array('sender' => $sender, 'receiver' => $receiver, "datetime" => $recenttime, 'read' => 'false', 'text' => $message));
        $messagearray = json_encode($messagearray);
        $configfirsttime = "INSERT INTO messages(convId,recentTime,participants,messagearray)VALUES('$convId','$recenttime','$participants','$messagearray')";
        mysqli_query(Database::$conn, $configfirsttime);
        if (mysqli_affected_rows(Database::$conn) > 0) {
            echo 'message sent';
        }
    }
}
function showallfriends()
{
    $query = "SELECT id,DisplayName FROM userinfo";
    $result = mysqli_query(Database::$conn, $query);
    $bigmessagearray = array();
    while ($row = mysqli_fetch_array($result)) {
        array_push($bigmessagearray, $row);
    };
    foreach ($bigmessagearray as $friend) {
        if (!($friend['id'] == $_SESSION['userid'])) {
            echo "<a href='http://johnpaul/chatapp/user/messages?friend=" . $friend['id'] . "'><div class='messagebox input-group-text'><strong class='friend'>" . $friend['DisplayName'] . "</strong>
        </div></a>";
        }
    }
}
function updatemessage()
{
    $receiver = mysqli_real_escape_string(Database::$conn, stripcslashes(stripslashes($_GET['friendtoupdate'])));
    $sender = $_SESSION['userid'];
    $one = $sender . $receiver;
    $two = $receiver . $sender;
    $result = mysqli_query(Database::$conn, "SELECT * FROM messages WHERE convId ='$one' OR  convId ='$two'");
    $row = mysqli_fetch_array($result);
    if (is_array($row)) {
        $convId = $row['convId'];
        $friendId = str_replace($_SESSION['userid'], "", $convId);
    } else {
        $friendId = $receiver;
    }
    $friendname = mysqli_fetch_array(mysqli_query(Database::$conn, "SELECT * FROM userinfo WHERE Id ='$receiver' limit 1"))['DisplayName'];
    if (is_array($row) && count($row) > 0) {
        $messagearray = json_decode($row['messagearray']);
        for ($i = ($_GET['lastindex'] + 1); $i < count($messagearray); $i++) {
            if ($messagearray[$i]->sender == $_SESSION['userid']) {
                $text = stripslashes($messagearray[$i]->text);
                $date = $messagearray[$i]->datetime;
                $read = $messagearray[$i]->read;
                if ($read != "read") {
                    $read = "unread";
                    $readinfo = "";
                    $readinfo = "unread";
                } else {
                    $read = "read";
                    $readtime = $messagearray[$i]->readtime;
                    if (date('h:i', strtotime($readtime)) > 12) {
                        $am = "pm";
                    } else {
                        $am = "am";
                    }
                    $readinfo = "Read by " . " " . $friendname . " on " . date('l', strtotime($readtime)) . " " . date('d', strtotime($readtime)) . " " . date('M', strtotime($readtime)) . " " . date('Y', strtotime($date)) . " by " . date('h:i', strtotime($date)) . $am;
                }
                $presentdate = date('Y-m-d h:i:s', time());
                switch (true) {
                    case (substr($presentdate, 0, 4) != substr($date, 0, 4)):
                        $ago = abs(substr($presentdate, 0, 4) - substr($date, 0, 4));
                        if ($ago == 1) {
                            $suffix = "";
                        } else {
                            $suffix = "s";
                        }
                        $ago = $ago . ' year' . $suffix . ' ago';
                        break;
                    case (substr($presentdate, 0, 4) == substr($date, 0, 4) && substr($presentdate, 5, 2) != substr($date, 5, 2)):
                        $ago = abs(substr($presentdate, 5, 2) - substr($date, 5, 2));
                        if ($ago == 1) {
                            $suffix = "";
                        } else {
                            $suffix = "s";
                        }
                        $ago = $ago . ' day' . $suffix . ' ago:';
                        break;
                    case (substr($presentdate, 0, 4) == substr($date, 0, 4) && substr($presentdate, 5, 2) == substr($date, 5, 2) && substr($presentdate, 8, 2) != substr($date, 8, 2)):
                        $ago = abs(substr($presentdate, 8, 2) - substr($date, 8, 2));
                        if ($ago == 1) {
                            $suffix = "";
                        } else {
                            $suffix = "s";
                        }
                        $ago = $ago . ' month' . $suffix . ' ago:';
                        break;
                    case (substr($presentdate, 0, 4) == substr($date, 0, 4) && substr($presentdate, 5, 2) == substr($date, 5, 2) && substr($presentdate, 8, 2) == substr($date, 8, 2) && substr($presentdate, 11, 2) != substr($date, 11, 2)):
                        $ago = abs(substr($presentdate, 11, 2) - substr($date, 11, 2));
                        if ($ago == 1) {
                            $suffix = "";
                        } else {
                            $suffix = "s";
                        }
                        $ago = $ago . ' hour' . $suffix . ' ago';
                        break;
                    case (substr($presentdate, 0, 4) == substr($date, 0, 4) && substr($presentdate, 5, 2) == substr($date, 5, 2) && substr($presentdate, 8, 2) == substr($date, 8, 2) && substr($presentdate, 11, 2) == substr($date, 11, 2) && substr($presentdate, 14, 2) != substr($date, 14, 2)):
                        $ago = abs(substr($presentdate, 14, 2) - substr($date, 14, 2));
                        if ($ago == 1) {
                            $suffix = "";
                        } else {
                            $suffix = "s";
                        }
                        $ago = $ago . ' minute' . $suffix . ' ago';
                        break;
                    case (substr($presentdate, 0, 4) == substr($date, 0, 4) && substr($presentdate, 5, 2) == substr($date, 5, 2) && substr($presentdate, 8, 2) == substr($date, 8, 2) && substr($presentdate, 11, 2) == substr($date, 11, 2) && substr($presentdate, 14, 2) == substr($date, 14, 2) && substr($presentdate, 17, 2) != substr($date, 17, 2)):
                        $ago = abs(substr($presentdate, 17, 2) - substr($date, 17, 2));
                        if ($ago == 1) {
                            $suffix = "";
                        } else {
                            $suffix = "s";
                        }
                        $ago = $ago . ' second' . $suffix . ' ago';
                        break;
                    default:
                        $ago = 'just now';
                        break;
                }
                $day = date('l', strtotime($date));
                $daynum = date('d', strtotime($date));
                $month = date('M', strtotime($date));
                $year = date('Y', strtotime($date));
                $time = date('h:i', strtotime($date));
                if (date('h:i', strtotime($date)) > 12) {
                    $pm = "pm";
                } else {
                    $pm = "am";
                }
                echo "<div class='conversation-field sent'>
    <div class='text'>" . $text . "
    </div><div class='btn-group dropleft elipse'>
    <button class='btn dropdown-toggle' type='button' id='elipse' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
    </button>
    <ul class='dropdown-menu' aria-labelledby='elipse'>
    <button class='delforme dropdown-item btn-danger'>Delete for Me</button>
    <button class='delforall dropdown-item btn-danger'>Delete for everyone</button>
    <button class='dropdown-item btn-info data' data-toggle='modal' data-target='#Modal" . $i . "'>View Details</button>
    </ul>
    </div>
    </div><br><br><br>
    <div class='modal fade' id='Modal" . $i . "'>
<div class='modal-dialog'>
<div class='modal-content'>
<!-- Modal Header -->
<div class='modal-header'>
<h4 class='modal-title'>Sent by you</h4>
<button type='button' class='close' data-dismiss='modal'>&times;</button>
</div>
<!-- Modal body -->
<div class='modal-body'>
on " . $day . " " . $daynum . " " . $month . " " . $year . "<br>
By " . $time . $pm . "<br>" . $readinfo . "
</div>
<!-- Modal footer -->
<div class='modal-footer'>
<button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
</div>
</div>
</div>
</div><small class='none' id='lastindex'>" . (count($messagearray) - 1) . "</small>";
            } else {
                $text = stripslashes($messagearray[$i]->text);
                $date = $messagearray[$i]->datetime;
                $read = $messagearray[$i]->read;
                $presentdate = date('Y-m-d h:i:s', time());
                switch (true) {
                    case (substr($presentdate, 0, 4) != substr($date, 0, 4)):
                        $ago = abs(substr($presentdate, 0, 4) - substr($date, 0, 4));
                        if ($ago == 1) {
                            $suffix = "";
                        } else {
                            $suffix = "s";
                        }
                        $ago = $ago . ' year' . $suffix . ' ago';
                        break;
                    case (substr($presentdate, 0, 4) == substr($date, 0, 4) && substr($presentdate, 5, 2) != substr($date, 5, 2)):
                        $ago = abs(substr($presentdate, 5, 2) - substr($date, 5, 2));
                        if ($ago == 1) {
                            $suffix = "";
                        } else {
                            $suffix = "s";
                        }
                        $ago = $ago . ' day' . $suffix . ' ago:';
                        break;
                    case (substr($presentdate, 0, 4) == substr($date, 0, 4) && substr($presentdate, 5, 2) == substr($date, 5, 2) && substr($presentdate, 8, 2) != substr($date, 8, 2)):
                        $ago = abs(substr($presentdate, 8, 2) - substr($date, 8, 2));
                        if ($ago == 1) {
                            $suffix = "";
                        } else {
                            $suffix = "s";
                        }
                        $ago = $ago . ' month' . $suffix . ' ago:';
                        break;
                    case (substr($presentdate, 0, 4) == substr($date, 0, 4) && substr($presentdate, 5, 2) == substr($date, 5, 2) && substr($presentdate, 8, 2) == substr($date, 8, 2) && substr($presentdate, 11, 2) != substr($date, 11, 2)):
                        $ago = abs(substr($presentdate, 11, 2) - substr($date, 11, 2));
                        if ($ago == 1) {
                            $suffix = "";
                        } else {
                            $suffix = "s";
                        }
                        $ago = $ago . ' hour' . $suffix . ' ago';
                        break;
                    case (substr($presentdate, 0, 4) == substr($date, 0, 4) && substr($presentdate, 5, 2) == substr($date, 5, 2) && substr($presentdate, 8, 2) == substr($date, 8, 2) && substr($presentdate, 11, 2) == substr($date, 11, 2) && substr($presentdate, 14, 2) != substr($date, 14, 2)):
                        $ago = abs(substr($presentdate, 14, 2) - substr($date, 14, 2));
                        if ($ago == 1) {
                            $suffix = "";
                        } else {
                            $suffix = "s";
                        }
                        $ago = $ago . ' minute' . $suffix . ' ago';
                        break;
                    case (substr($presentdate, 0, 4) == substr($date, 0, 4) && substr($presentdate, 5, 2) == substr($date, 5, 2) && substr($presentdate, 8, 2) == substr($date, 8, 2) && substr($presentdate, 11, 2) == substr($date, 11, 2) && substr($presentdate, 14, 2) == substr($date, 14, 2) && substr($presentdate, 17, 2) != substr($date, 17, 2)):
                        $ago = abs(substr($presentdate, 17, 2) - substr($date, 17, 2));
                        if ($ago == 1) {
                            $suffix = "";
                        } else {
                            $suffix = "s";
                        }
                        $ago = $ago . ' second' . $suffix . ' ago';
                        break;
                    default:
                        $ago = 'just now';
                        break;
                }
                $day = date('l', strtotime($date));
                $daynum = date('d', strtotime($date));
                $month = date('M', strtotime($date));
                $year = date('Y', strtotime($date));
                $time = date('h:i', strtotime($date));
                if (date('h:i', strtotime($date)) > 12) {
                    $pm = "pm";
                } else {
                    $pm = "am";
                }

                if ($read != "read") {
                    $messagearray[$i]->read = "read";
                    $messagearray[$i]->readtime = $presentdate;
                    $read = "read";
                }
                $readtime = $messagearray[$i]->readtime;
                if (date('h:i', strtotime($readtime)) > 12) {
                    $am = "pm";
                } else {
                    $am = "am";
                }
                echo "<div class='conversation-field received'><div class='text'>" . $text . "
</div><div class='btn-group dropleft elipse'>
<button class='btn dropdown-toggle' type='button' id='elipse' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
</button>
<ul class='dropdown-menu' aria-labelledby='elipse'>
<button class='delforme dropdown-item btn-danger' >Delete for Me</button>
<button class='dropdown-item btn btn-info data' data-toggle='modal' data-target='#Modal" . $i . "'>View Details</button>
</ul>
</div></div>
<div class='modal fade' id='Modal" . $i . "'>
<div class='modal-dialog'>
<div class='modal-content'>
<!-- Modal Header -->
<div class='modal-header'>
<h4 class='modal-title'>Sent by " . $friendname . "</h4>
<button type='button' class='close' data-dismiss='modal'>&times;</button>
</div>
<!-- Modal body -->
<div class='modal-body'>
on " . $day . " " . $daynum . " " . $month . " " . $year . "<br>
By " . $time . $pm . "<br>Seen by you on " . date('l', strtotime($readtime)) . " " . date('d', strtotime($readtime)) . " " . date('M', strtotime($readtime)) . " " . date('Y', strtotime($readtime)) . " by " . date('h:i', strtotime($readtime)) . $am . "
</div>
<!-- Modal footer -->
<div class='modal-footer'>
<button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
</div>
</div>
</div>
</div><small class='none' id='lastindex'>" . (count($messagearray) - 1) . "</small>";
            }
        }
    }
}
function deletemessage()
{
    $indextodelete = $_POST['delete'];
    $type = mysqli_real_escape_string(Database::$conn, stripcslashes(stripslashes($_POST['type'])));;
    $sender = $_SESSION['userid'];
    $friend = mysqli_real_escape_string(Database::$conn, stripcslashes(stripslashes($_POST['friend'])));
    $one = $sender . $friend;
    $two = $friend . $sender;
    $row = mysqli_fetch_array(mysqli_query(Database::$conn, "SELECT convId,messagearray FROM messages WHERE convId ='$one' OR  convId ='$two'"));
    $messagearray = json_decode($row['messagearray']);
    $convId = $row['convId'];
    switch ($type) {
        case 'forme':
            $messagearray[$indextodelete]->hide = $_SESSION['userid'];
            break;
        case 'forall':
            if ($indextodelete > 0) {
                array_splice($messagearray, $indextodelete, $indextodelete);
            } else {
                array_shift($messagearray);
            }
            echo 'delforall';
            break;
    }
    $messagearray = addslashes(json_encode($messagearray));
    $query = "UPDATE messages SET messagearray='$messagearray' WHERE convId = '$convId' ";
    mysqli_query(Database::$conn, $query);
}
if (isset($_POST['messageto'])) {
    sendmessage();
}
if (isset($_GET['updatemessage'])) {
    updatemessage();
}
if (isset($_POST['delete'])) {
    deletemessage();
}
function echoer(){
echo 'hi';
}