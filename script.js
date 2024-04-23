$(document).ready(function () {
    // Function to handle sending messages
    $("#submitmsg").click(function () {
        var clientmsg = $("#usermsg").val().trim(); // Trim whitespace
        if (clientmsg !== "") { // Check if message is not empty
            $.post("post.php", { text: clientmsg }); // Send message to server
            $("#usermsg").val(""); // Clear input field
        } else {
            alert("Please type a message before sending."); // Alert if message is empty
        }
        return false; // Prevent default form submission
    });

    // Function to load chat log
    function loadLog() {
        var $chatbox = $("#chatbox");
        var oldscrollHeight = $chatbox[0].scrollHeight - 20; // Calculate old scroll height
        $.ajax({
            url: "log.html",
            cache: false,
            success: function (html) {
                $chatbox.html(html); // Update chatbox with new messages
                var newscrollHeight = $chatbox[0].scrollHeight - 20; // Calculate new scroll height
                if (newscrollHeight > oldscrollHeight) {
                    $chatbox.animate({ scrollTop: newscrollHeight }, 'normal'); // Scroll to bottom if new messages added
                }
            }
        });
    }

    // Call loadLog function at regular intervals
    setInterval(loadLog, 2500);

    // Handle exit button click
    $("#exit").click(function () {
        var exit = confirm("Are you sure you want to end the session?");
        if (exit) { // No need to compare with true explicitly
            window.location = "index.php?logout=true";
        }
    });

    // Handle delete button click
    $("#delete").click(function () {
        if (confirm("Are you sure you want to delete all chats?")) {
            $.ajax({
                url: "delete_chats.php",
                success: function () {
                    $("#chatbox").empty(); // Clear chatbox content
                }
            });
        }
    });
});
