const firebaseConfig = {
    apiKey: "AIzaSyBC_a9vd6FsDZ9ilgq4NwnLOsLB9M-3xOk",
    authDomain: "slikreader.firebaseapp.com",
    databaseURL: "https://slikreader-default-rtdb.firebaseio.com",
    projectId: "slikreader",
    storageBucket: "slikreader.appspot.com",
    messagingSenderId: "326056442281",
    appId: "1:326056442281:web:95a9057a0fe01fb3a76cb8",
};

firebase.initializeApp(firebaseConfig);

var parentRef = firebase.database().ref();

var promises = [];
var i = 0;
parentRef.once("value", function (snapshot) {
    snapshot.forEach(function (childSnapshot) {
        var nodeName = childSnapshot.key;
        var chatsRef = firebase.database().ref(nodeName);

        var promise = new Promise(function (resolve, reject) {
            chatsRef.once("value", function (snapshot) {
                // Handle the snapshot data here
                snapshot.forEach(function (childSnapshot) {
                    var messageKey = childSnapshot.key;
                    var messageData = childSnapshot.val();

                    let recvId = nodeName.split("-")[1];
                    if (user.id == messageData.senderId) {
                        recvId = parseInt(recvId);
                    } else {
                        recvId = parseInt(user.id);
                    }
                    let message = {
                        id: i++,
                        sender: messageData.senderId,
                        body: messageData.text,
                        time: messageData.timestamp,
                        status: 2,
                        recvId: recvId,
                        recvIsGroup: false,
                        room: nodeName.split("-")[1],
                    };
                    messages.push(message);
                });

                resolve(); // Resolve the promise after the operation is completed
            });
        });

        promises.push(promise);

        chatsRef
            .orderByChild("timestamp")
            .startAt(Date.now())
            .on("child_added", function (snapshot) {
                var chatMessage = snapshot.val();
                let recvId = nodeName.split("-")[1];
                let msg = {
                    id: i++,
                    sender: chatMessage.senderId,
                    body: chatMessage.text,
                    time: chatMessage.timestamp,
                    status: 2,
                    recvId: user.id,
                    recvIsGroup: false,
                    room: recvId,
                };

                messages.push(msg);
                currentChatRoom = $("body").attr("data-current-chat");
                if (currentChatRoom == chatMessage.senderId) {
                    addMessageToMessageArea(msg);
                    $(`.chat-list-item[id-room="${msg.room}"] .last-message`).text(msg.body);
                    $(`.chat-list-item[id-room="${msg.room}"] .time`).text(mDate(msg.time).chatListFormat());
                } else {
                    $(`.chat-list-item[id-room="${msg.room}"] .last-message`).text(msg.body);
                    $(`.chat-list-item[id-room="${msg.room}"] .time`).text(mDate(msg.time).chatListFormat());
                    if (msg.sender != user.id) {
                        $(`.chat-list-item[id-room="${msg.room}"]`).css("background-color", "lime");
                    }
                }
            });
    });

    Promise.all(promises).then(function () {
        init();
    });
});
