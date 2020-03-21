var userdata = [
  {
    surname: "",
    firstname: "",
    middlename: "",
    email: "",
    phone: "",
    dateofbirth: "",
    nickname: "",
    password: ""
  }
];
var numbers = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
var sendstate = true;
const surnamePattern = /^[a-z][a-z0-9]{1,29}$/i;
const middlenamePattern = /^[a-z]?[a-z0-9]{0,29}$/i;
const phonePattern=/^([+][0-9]{3})+([-][0-9]{1,12})$/i;
const emailPattern=/^([a-z0-9]{1,44})+([.]?)+([a-z]{1,9})$/i;//+(@[a-z0-9][.]?{0,3}[.][a-z])/i;
//const trial="customerservive.ict.unn@unn.edu.ng";
const trial="test@test.com";
console.log(emailPattern.test(trial));
$(document).ready(function() {
  $("#surname").on("input", function() {
    if (surnamePattern.test(this.value)) {
      $("#surname").removeClass("is-invalid");
      $("#surname").addClass("is-valid");
    } else {
      $("#surname").addClass("is-invalid");
      $("#surname").removeClass("is-valid");
    }
  });
  $("#firstname").on("input", function() {
    if (surnamePattern.test(this.value)) {
      $("#firstname").removeClass("is-invalid");
      $("#firstname").addClass("is-valid");
    } else {
      $("#firstname").addClass("is-invalid");
      $("#firstname").removeClass("is-valid");
    }
  });
  $("#middlename").on("input", function() {
    if (middlenamePattern.test(this.value)) {
      $("#middlename").removeClass("is-invalid");
      $("#middlename").addClass("is-valid");
    } else {
      $("#middlename").addClass("is-invalid");
      $("#middlename").removeClass("is-valid");
    }
  });
  $("#phone").on("input", function() {
    if (phonePattern.test(this.value)) {
      $("#phone").removeClass("is-invalid");
      $("#phone").addClass("is-valid");
    } else {
      $("#phone").addClass("is-invalid");
      $("#phone").removeClass("is-valid");
    }
  });
  $("#email").on("input", function() {
    if (emailPattern.test(this.value)) {
      $("#email").removeClass("is-invalid");
      $("#email").addClass("is-valid");
    } else {
      $("#email").addClass("is-invalid");
      $("#email").removeClass("is-valid");
    }
  });
  $(".menu-toggle").on("click", function() {
    $("#mobile").toggleClass("active");
  });
  $("#showlogin").on("click", function() {
    $("#signup").addClass("nnone");
    $("#login").removeClass("nnone");
    $("body").css({
      "background-image": "url(images/12.jpeg)",
      "background-repeat": "no-repeat",
      "backgroung-origin": "content-box"
    });
  });
  $("#showsignup").on("click", function() {
    $("#login").addClass("nnone");
    $("#signup").removeClass("nnone");
    $("body").css("background-color", "cornsilk");
  });
  var symbols = [
    "!",
    "@",
    "$",
    "#",
    "%",
    "^",
    "&",
    "*",
    "(",
    ")",
    "+",
    "=",
    "{",
    "}",
    "?",
    "<",
    ">",
    "/",
    "|",
    ".",
    ","
  ];
  $("#signform").on("submit", function(sub) {
    sub.preventDefault();
    // clear the errors from last try
    sendstate = true;
    var surnamestate = "okay";
    var middlenamestate = "okay";
    var firstnamestate = "okay";
    var nicknamestate = "okay";
    var passwordstate = "okay";
    var emailstate = "okay";
    var phonestate = "okay";
    $("#surname").removeClass("is-invalid");
    $("#firstname").removeClass("is-invalid");
    $("#middlename").removeClass("is-invalid");
    $("#email").removeClass("is-invalid");
    $("#password1").removeClass("is-invalid");
    $("#phone").removeClass("is-invalid");
    $("#date").removeClass("is-invalid");
    $("#nickname").removeClass("is-invalid");
    $("#password2").removeClass("is-invalid");
    $("#accept-terms").removeClass("is-invalid");
    $("#country").removeClass("is-invalid");
    $("#status").addClass("none");

    let surname = $("#surname").val();
    let middlename = $("#middlename").val();
    let firstname = $("#firstname").val();
    let nickname = $("#nickname").val();
    let dateofbirth = $("#date").val();

    // check if any name contains symbols
    for (let symbol of symbols) {
      if (surname.includes(symbol)) {
        surnamestate = "symbol";
      }
      if (firstname.includes(symbol)) {
        firstnamestate = "symbol";
      }
      if (middlename.includes(symbol)) {
        middlenamestate = "symbol";
      }
      if (nickname.includes(symbol)) {
        nicknamestate = "symbol";
      }
    }

    // check if any input is white space
    if (surname.includes(" ")) {
      surnamestate = "space";
    }
    if (middlename.includes(" ")) {
      middlenamestate = "space";
    }
    if (firstname.includes(" ")) {
      firstnamestate = "space";
    }
    if (nickname.includes(" ")) {
      nicknamestate = "space";
    }
    if (
      $("#phone")
        .val()
        .includes(" ")
    ) {
      phonestate = "space";
    }
    if (
      $("#email")
        .val()
        .includes(" ")
    ) {
      emailstate = "space";
    }

    //check if required fields are empty
    if ($("#surname").val() == "") {
      surnamestate = "empty";
    }
    if ($("#firstname").val() == "") {
      firstnamestate = "empty";
    }
    if ($("#email").val() == "") {
      emailstate = "empty";
    }
    if ($("#phone").val() == "") {
      phonestate = "empty";
    }
    if ($("#nickname").val() == "") {
      nicknamestate = "empty";
    }
    if ($("#country").val() == "") {
      sendstate = false;
      $("#country").addClass("is-invalid");
      sendstate = false;
    }
    if (!$("#accept-terms").is(":checked")) {
      sendstate = false;
      $("#accept-terms").addClass("is-invalid");
      sendstate = false;
    }

    //check for length of names
    if ($("#surname").val().length > 16) {
      surnamestate = "tooLong";
    }
    if ($("#firstname").val().length > 16) {
      firstnamestate = "tooLong";
    }
    if ($("#middlename").val().length > 16) {
      middlenamestate = "tooLong";
    }
    if ($("#nickname").val().length > 16) {
      nicknamestate = "tooLong";
    }

    //check password strength
    for (let symbol of symbols) {
      if (
        $("#password1")
          .val()
          .includes(symbol)
      ) {
        passwordstate = "good";
      }
    }
    if (passwordstate == "good") {
      for (let number of numbers) {
        if (
          $("#password1")
            .val()
            .includes(number)
        ) {
          passwordstate = "better";
        }
      }
    } else {
      passwordstate = "poor";
    }

    // check if password matches or its empty
    if ($("#password2").val() != $("#password1").val()) {
      passwordstate = "matcherror";
      $("#password2").addClass("is-invalid");
      sendstate = false;
    }
    if ($("#password1").val() == "" || $("#password2").val() == "") {
      passwordstate = "nothing";
    }

    // check length of password
    if ($("#password1").val().length < 6) {
      $("#password1").addClass("is-invalid");
    }

    // display the necessary messages
    switch (surnamestate) {
      case "okay":
        sendstate = true;
        break;
      default:
        $("#surname").addClass("is-invalid");
        sendstate = false;
    }
    switch (middlenamestate) {
      case "okay":
        sendstate = true;
        break;
      default:
        $("#middlename").addClass("is-invalid");
        sendstate = false;
    }
    switch (firstnamestate) {
      case "okay":
        sendstate = true;
        break;
      default:
        $("#firstname").addClass("is-invalid");
        sendstate = false;
    }
    switch (passwordstate) {
      case "better":
        sendstate = true;
        break;
      case "poor":
        $("#password1").addClass("is-invalid");
        sendstate = false;
        break;
      default:
        $("#password1").addClass("is-invalid");
        sendstate = false;
    }
    switch (nicknamestate) {
      case "okay":
        sendstate = true;
        break;
      default:
        $("#nickname").addClass("is-invalid");
        sendstate = false;
    }
    switch (emailstate) {
      case "okay":
        sendstate = true;
        break;
      default:
        $("#email").addClass("is-invalid");
        sendstate = false;
    }
    switch (phonestate) {
      case "okay":
        sendstate = true;
        break;
      default:
        $("#phone").addClass("is-invalid");
        sendstate = false;
    }

    if (sendstate) {
      $("#spin").removeClass("none");
      $.post(
        "process.php",
        {
          surname: surname,
          firstname: firstname,
          middlename: middlename,
          nickname: nickname,
          dateofbirth: dateofbirth,
          email: $("#email").val(),
          phone: $("#phone").val(),
          password1: $("#password1").val(),
          password2: $("#password2").val(),
          country: $("#country").val()
        },
        function(params) {
          $("#status").removeClass("none");
          $("#status").html(params);
          $("#spin").addClass("none");
          if (params == "signup successfull") {
            window.location.href = "signsuccess.php";
            $.cookie("newuser", "newuser", {
              expires: 1,
              path: "/"
            });
          }
        }
      );
    }
  });
  $("#logform").on("submit", function(login) {
    $("#spinlog").removeClass("none");
    login.preventDefault();
    $.post(
      "process.php",
      {
        useremail: $("#useremail").val(),
        userpassword: $("#userpassword").val()
      },
      function(params) {
        $("#logstatus").removeClass("none");
        $("#logstatus").html(params);
        $("#spinlog").addClass("none");
        if (params == "login successful") {
          window.location.href = "http://johnpaul/chatapp/user/dashboard.php";
        }
      }
    );
  });
  $(".infocontainer").on("click", function() {
    $(this).toggleClass("none");
  });
  // $(".messagebox").each(function (index) {
  //     $(this).on("click", function () {
  //         $.post(
  //             "http://johnpaul/chatapp/user/messages.php", {
  //                 friend: $(".friendid").eq(index).val()
  //             },
  //             function (params) {
  //               $("body").html(params);
  //             }
  //         );
  //     });
  // });
  $("#sendbtn").on("click", function() {
    $("#firstconv").remove();
    $.post(
      "http://johnpaul/chatapp/includes/functions.php",
      {
        message: $("#message").val(),
        messageto: $(".friendId").text()
      },
      function(params) {
        $("#message").val(" ");
        window.scrollTo(0, document.documentElement.scrollHeight);
        $.get(
          "http://johnpaul/chatapp/includes/functions.php",
          {
            friendtoupdate: $("small.friendId").html(),
            updatemessage: true,
            lastindex: $("#lastindex").html()
          },
          function(result) {
            if (result.length > 22) {
              $("#lastindex").remove();
              $("#main").append(result);
              window.scrollTo(0, document.documentElement.scrollHeight);
              deletemessage();
            }
          }
        );
      }
    );
  });
  // $('#tobeclicked').on('click',function(){
  //     $('#very').click();
  // })
  $(".delforme").each(function(index) {
    $(this).on("click", function() {
      // console.log($('.data').eq(index)[0].attributes['data-target'].value.substring(6,this.length))
      $.post(
        "http://johnpaul/chatapp/includes/functions.php",
        {
          delete: $(".data")
            .eq(index)[0]
            .attributes["data-target"].value.substring(6, this.length),
          type: "forme",
          friend: $("small.friendId").html()
        },
        function(params) {
          $(".conversation-field")
            .eq(index)
            .remove();
        }
      );
    });
  });

  function deletemessage() {
    $(".delforall").each(function(index) {
      $(this).on("click", function() {
        // console.log($('.data').eq(index)[0].attributes['data-target'].value.substring(6,this.length))
        $.post(
          "http://johnpaul/chatapp/includes/functions.php",
          {
            delete: $(".data")
              .eq(index)[0]
              .attributes["data-target"].value.substring(6, this.length),
            type: "forall",
            friend: $("small.friendId").html()
          },
          function(params) {
            $(".conversation-field")
              .eq(index)
              .remove();
            $(".data").each(function(index1, element) {
              if (
                $(".data")
                  .eq(index1)
                  .attr("data-target")
                  .substring(6, this.length) > index
              ) {
                // let number = ($('this').attr('data-target').substring(6, this.length) - 1);
                // number = number.toString().length == 1 ? '0' + number.toString() : number;
                // $('#Modal'+number+'').remove();
                // $('this').attr('data-target') = $('this').attr('data-target').substring(0, 6) + number.toString();
                console.log("hi");
              }
            });
          }
        );
      });
    });
  }
  deletemessage();
});

/*
surname done!
firstname done!
email done!
phone number  
password
confirm password
country
terms and condition
*/