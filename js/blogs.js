   // Email subscribe
   document.getElementById("subscribeForm").addEventListener("submit", function(event) {
        event.preventDefault();

        var email = document.getElementById("email").value;
        console.log("Email submitted: " + email);

        document.getElementById("email").value = "";

        alert("Thank you for subscribing!");
    });

    // Comment form
    document.getElementById("comment-form").addEventListener("submit", function(event) {
        event.preventDefault();
    
        var name = document.getElementById("commenter-name").value;
        var comment = document.getElementById("comment").value;

        console.log("Name:", name);
        console.log("Comment:", comment);
        
        document.getElementById("commenter-name").value = "";
        document.getElementById("comment").value = "";
    
        window.alert("Your comment has been submitted successfully!");
      });

      $(document).ready(function(){
        var lastScrollTop = 0;
        $(window).scroll(function(event){
          var st = $(this).scrollTop();
          if (st > lastScrollTop){
            $('#navbar').addClass('hidden');
          } else {
            $('#navbar').removeClass('hidden');
          }
          lastScrollTop = st;
      });
    });