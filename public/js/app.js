const app = {

    displayMessage: function (messageText, label) {

        const messageSpace = document.querySelector("#messages");
        const messageTemplate = document.querySelector('#message');
        const newMessage = messageTemplate.content.cloneNode(true);
        let backgroundColor = null;
        switch (label) {
            case "success":
                backgroundColor = "#37C24A";
                break;
            case "danger":
                backgroundColor = "#E84922";
                break;

        }
        newMessage.querySelector('#flashMessage').style.backgroundColor = backgroundColor;
        newMessage.querySelector('#flashMessage').innerHTML = messageText;
        messageSpace.appendChild(newMessage);
        message = messageSpace.querySelector("#flashMessage")
        message.animate({
            opacity: ['0', '1']
        }, 1000).onfinish = function () {
            message.style.opacity = "1";
            window.setTimeout(app.hideMessage,2000);
        }
        
    },

    hideMessage: function(){
        const messageSpace = document.querySelector("#messages");
        const message = messageSpace.querySelector("#flashMessage")
        message.animate({
            opacity: ['1', '0']
        }, 800).onfinish = function () {
            message.remove();
        }
    },
}