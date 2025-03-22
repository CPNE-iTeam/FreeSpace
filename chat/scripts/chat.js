fetch("../api/me_user.php").then(async r => {
    let response = await r.json()
    console.log(response);

    if (!response.logged) {
        document.location.href = "/login.html"
    }
});

var chat_user_id = null;
var last_message_id = null;

function send() {
    let message = document.getElementById("message").value;
    let formData = new FormData();
    formData.append("message", message);
    formData.append("to", chat_user_id);

    fetch("../api/chat/send_message.php", {
        method: "POST",
        body: formData
    }).then(async r => {
        let response = await r.json()
        console.log(response);
        if (!response.success) {
            alert(response.error);
        } else {
            document.getElementById("message").value = "";
        }
        loadMessages(chat_user_id);
    });
}

function loadMessages(user_id) {
    let formData = new FormData();
    formData.append("contact", user_id);
    fetch("../api/chat/conversation.php", {
        method: "POST",
        body: formData
    }).then(async r => {
        let response = await r.json()
        console.log(response);
        let messages = response.messages;

        console.log(messages[messages.length - 1])
        if (messages[messages.length - 1].id != last_message_id) {


            let html = "";
            for (let message of messages) {
                html += `<div><b>${message.from_user.username}</b>: ${message.message}</div><br>`;
            }

            last_message_id = messages[messages.length - 1].id;


            document.getElementById("messages").innerHTML = html;

        }
    });
}





function loadChat(user_id) {
    document.getElementById("chat").style.display = "block";

    let formData = new FormData();
    formData.append("id", user_id);

    fetch("../api/user.php", {
        method: "POST",
        body: formData
    }).then(async r => {
        let response = await r.json()
        console.log(response);
        if (!response.success) {
            alert(response.error);
        } else {
            document.getElementById("chatUsername").innerText = response.user.username;
        }
    });


    chat_user_id = user_id;
    loadMessages(chat_user_id);

    setInterval(() => {
        console.log("loading messages");
        loadMessages(chat_user_id);
    }, 1000);
}