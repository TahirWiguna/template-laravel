<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
  <title>Whatsapp</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" />
  <link rel="stylesheet" href="{{ asset('assets/whatsapp/style.css') }}">
</head>

<body>
  <div class="container-fluid" id="main-container">
    <div class="row h-100">
      <div class="col-12 col-sm-5 col-md-4 d-flex flex-column" id="chat-list-area" style="position: relative">
        <!-- Navbar -->
        <div class="row d-flex flex-row align-items-center p-2" id="navbar">
          <div class="text-white font-weight-bold" id="username"></div>
          <div class="nav-item dropdown ml-auto">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v text-white"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="{{ url('/logout') }}">Log Out</a>
            </div>
          </div>
        </div>

        <!-- Chat List -->
        <div class="row" id="chat-list" style="overflow: auto"></div>

        <!-- Profile Settings -->
        <div class="d-flex flex-column w-100 h-100" id="profile-settings">
          <div class="row d-flex flex-row align-items-center p-2 m-0" style="background: #009688; min-height: 65px">
            <i class="fas fa-arrow-left p-2 mx-3 my-1 text-white" style="font-size: 1.5rem; cursor: pointer" onclick="hideProfileSettings()"></i>
            <div class="text-white font-weight-bold">Profile</div>
          </div>
          <div class="d-flex flex-column" style="overflow: auto">
            <img alt="Profile Photo" class="img-fluid rounded-circle my-5 justify-self-center mx-auto" id="profile-pic" />
            <input type="file" id="profile-pic-input" class="d-none" />
            <div class="bg-white px-3 py-2">
              <div class="text-muted mb-2">
                <label for="input-name">Your Name</label>
              </div>
              <input type="text" name="name" id="input-name" class="w-100 border-0 py-2 profile-input" />
            </div>
            <div class="text-muted p-3 small">
              This is not your username or pin. This name will be visible to
              your WhatsApp contacts.
            </div>
            <div class="bg-white px-3 py-2">
              <div class="text-muted mb-2">
                <label for="input-about">About</label>
              </div>
              <input type="text" name="name" id="input-about" value="" class="w-100 border-0 py-2 profile-input" />
            </div>
          </div>
        </div>
      </div>

      <!-- Message Area -->
      <div class="d-none d-sm-flex flex-column col-12 col-sm-7 col-md-8 p-0 h-100" id="message-area">
        <div class="w-100 h-100 overlay"></div>

        <!-- Navbar -->
        <div class="row d-flex flex-row align-items-center p-2 m-0 w-100" id="navbar">
          <div class="d-block d-sm-none">
            <i class="fas fa-arrow-left p-2 mr-2 text-white" style="font-size: 1.5rem; cursor: pointer" onclick="showChatList()"></i>
          </div>
          <a href="#"><img src="https://via.placeholder.com/400x400" alt="Profile Photo" class="img-fluid rounded-circle mr-2" style="height: 50px" id="pic" /></a>
          <div class="d-flex flex-column">
            <div class="text-white font-weight-bold" id="name"></div>
            <div class="text-white small" id="details"></div>
          </div>
          <div class="d-flex flex-row align-items-center ml-auto">
          </div>
        </div>

        <!-- Messages -->
        <div class="d-flex flex-column" id="messages"></div>

        <!-- Input -->
        <div class="d-none justify-self-end align-items-center flex-row" id="input-area">
          <a href="#"><i class="far fa-smile text-muted px-3" style="font-size: 1.5rem"></i></a>
          <input type="text" name="message" id="input" placeholder="Type a message" class="flex-grow-1 border-0 px-3 py-2 my-3 rounded shadow-sm" />
          <i class="fas fa-paper-plane text-muted px-3" style="cursor: pointer" onclick="sendMessage()"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Firebase App (the core Firebase SDK) -->
  <script src="https://www.gstatic.com/firebasejs/8.7.1/firebase-app.js"></script>
  <!-- Firebase Realtime Database -->
  <script src="https://www.gstatic.com/firebasejs/8.7.1/firebase-database.js"></script>
  <!-- Firebase Cloud Messaging -->
  <script src="https://www.gstatic.com/firebasejs/8.7.1/firebase-messaging.js"></script>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

  <script>
    let user = JSON.parse('{!! addslashes($current_user) !!}');

    let contactList = JSON.parse('{!! addslashes($user) !!}');

    let groupList = [];

    // message status - 0:sent, 1:delivered, 2:read

    let messages = [];

    let MessageUtils = {
      getByGroupId: (groupId) => {
        return messages.filter(
          (msg) => msg.recvIsGroup && msg.recvId === groupId
        );
      },
      getByContactId: (contactId) => {
        return messages.filter((msg) => {
          return (
            !msg.recvIsGroup &&
            ((msg.sender === user.id && msg.recvId === contactId) ||
              (msg.sender === contactId && msg.recvId === user.id))
          );
        });
      },
      getMessages: () => {
        return messages;
      },
      changeStatusById: (options) => {
        messages = messages.map((msg) => {
          if (options.isGroup) {
            if (msg.recvIsGroup && msg.recvId === options.id)
              msg.status = 2;
          } else {
            if (
              !msg.recvIsGroup &&
              msg.sender === options.id &&
              msg.recvId === user.id
            )
              msg.status = 2;
          }
          return msg;
        });
      },
      addMessage: (msg) => {
        msg.id = messages.length + 1;
        messages.push(msg);
      },
    };

    $('[name="message"]').on('keypress', function(event) {
      if (event.keyCode === 13) {
        event.preventDefault();
        sendMessage()
      }
    });
  </script>

  <script src="{{ asset('assets/whatsapp/date-utils.js') }}"></script>
  <script>
    let getById = (id, parent) => (parent ? parent.getElementById(id) : getById(id, document));
    let getByClass = (className, parent) => (parent ? parent.getElementsByClassName(className) : getByClass(className, document));

    const DOM = {
      chatListArea: getById("chat-list-area"),
      messageArea: getById("message-area"),
      inputArea: getById("input-area"),
      chatList: getById("chat-list"),
      messages: getById("messages"),
      chatListItem: getByClass("chat-list-item"),
      messageAreaName: getById("name", this.messageArea),
      messageAreaPic: getById("pic", this.messageArea),
      messageAreaNavbar: getById("navbar", this.messageArea),
      messageAreaDetails: getById("details", this.messageAreaNavbar),
      messageAreaOverlay: getByClass("overlay", this.messageArea)[0],
      messageInput: getById("input"),
      profileSettings: getById("profile-settings"),
      profilePic: getById("profile-pic"),
      profilePicInput: getById("profile-pic-input"),
      inputName: getById("input-name"),
      username: getById("username"),
    };

    let mClassList = (element) => {
      return {
        add: (className) => {
          element.classList.add(className);
          return mClassList(element);
        },
        remove: (className) => {
          element.classList.remove(className);
          return mClassList(element);
        },
        contains: (className, callback) => {
          if (element.classList.contains(className)) callback(mClassList(element));
        },
      };
    };

    // 'areaSwapped' is used to keep track of the swapping
    // of the main area between chatListArea and messageArea
    // in mobile-view
    let areaSwapped = false;

    // 'chat' is used to store the current chat
    // which is being opened in the message area
    let chat = null;

    // this will contain all the chats that is to be viewed
    // in the chatListArea
    let chatList = [];

    // this will be used to store the date of the last message
    // in the message area
    let lastDate = "";

    // 'populateChatList' will generate the chat list
    // based on the 'messages' in the datastore
    let populateChatList = () => {
      chatList = [];

      // 'present' will keep track of the chats
      // that are already included in chatList
      // in short, 'present' is a Map DS
      let present = {};

      MessageUtils.getMessages()
        .sort((a, b) => mDate(a.time).subtract(b.time))
        .forEach((msg) => {
          let chat = {};

          chat.isGroup = msg.recvIsGroup;
          chat.msg = msg;

          if (msg.recvIsGroup) {
            chat.group = groupList.find((group) => group.id === msg.recvId);
            chat.name = chat.group.name;
          } else {
            chat.contact = contactList.find((contact) => (msg.sender !== user.id ? contact.id === msg.sender : contact.id === msg.recvId));
            chat.name = chat.contact.name;
          }

          chat.unread = msg.sender !== user.id && msg.status < 2 ? 1 : 0;
          if (present[chat.name] !== undefined) {
            chatList[present[chat.name]].msg = msg;
            chatList[present[chat.name]].unread += chat.unread;
          } else {
            present[chat.name] = chatList.length;
            chatList.push(chat);
          }
        });
    };

    let viewChatList = () => {
      DOM.chatList.innerHTML = "";
      chatList
        .sort((a, b) => mDate(b.msg.time).subtract(a.msg.time))
        .forEach((elem, index) => {
          let statusClass = elem.msg.status < 2 ? "far" : "fas";
          let unreadClass = elem.unread ? "unread" : "";
          DOM.chatList.innerHTML += `
		<div class="chat-list-item d-flex flex-row w-100 p-2 border-bottom ${unreadClass}" id-room="${elem.msg.room}" onclick="generateMessageArea(this, ${index})">
			
			<div class="w-50">
				<div class="name">${elem.name}</div>
				<div class="small last-message">${elem.isGroup ? contactList.find((contact) => contact.id === elem.msg.sender).number + ": " : ""}${
                elem.msg.sender === user.id ? '<i class="' + statusClass + ' fa-check-circle mr-1"></i>' : ""
            } ${elem.msg.body}</div>
			</div>
			<div class="flex-grow-1 text-right">
				<div class="small time">${mDate(elem.msg.time).chatListFormat()}</div>
				${elem.unread ? '<div class="badge badge-success badge-pill small" id="unread-count">' + elem.unread + "</div>" : ""}
			</div>
		</div>
		`;
        });
    };

    let generateChatList = () => {
      populateChatList();
      viewChatList();
    };

    let addDateToMessageArea = (date) => {
      DOM.messages.innerHTML += `
	<div class="mx-auto my-2 bg-primary text-white small py-1 px-2 rounded">
		${date}
	</div>
	`;
    };

    let addMessageToMessageArea = (msg) => {
      let msgDate = mDate(msg.time).getDate();
      if (lastDate != msgDate) {
        addDateToMessageArea(msgDate);
        lastDate = msgDate;
      }

      let htmlForGroup = `
	<div class="small font-weight-bold text-primary">
		${contactList.find((contact) => contact.id === msg.sender).number}
	</div>
	`;

      let sendStatus = `<i class="${msg.status < 2 ? "far" : "fas"} fa-check-circle"></i>`;

      DOM.messages.innerHTML += `
	<div class="align-self-${msg.sender === user.id ? "end self" : "start"} p-1 my-1 mx-3 rounded bg-white shadow-sm message-item">
		<div class="options">
			<a href="#"><i class="fas fa-angle-down text-muted px-2"></i></a>
		</div>
		${chat.isGroup ? htmlForGroup : ""}
		<div class="d-flex flex-row">
			<div class="body m-1 mr-2">${msg.body}</div>
			<div class="time ml-auto small text-right flex-shrink-0 align-self-end text-muted" style="width:75px;">
				${mDate(msg.time).getTime()}
				${msg.sender === user.id ? sendStatus : ""}
			</div>
		</div>
	</div>
	`;

      DOM.messages.scrollTo(0, DOM.messages.scrollHeight);
    };

    let generateMessageArea = (elem, chatIndex) => {
      $(elem).css("background-color", "white");

      chat = chatList[chatIndex];

      mClassList(DOM.inputArea).contains("d-none", (elem) => elem.remove("d-none").add("d-flex"));
      mClassList(DOM.messageAreaOverlay).add("d-none");

      [...DOM.chatListItem].forEach((elem) => mClassList(elem).remove("active"));

      mClassList(elem).contains("unread", () => {
        MessageUtils.changeStatusById({
          isGroup: chat.isGroup,
          id: chat.isGroup ? chat.group.id : chat.contact.id,
        });
        mClassList(elem).remove("unread");
        mClassList(elem.querySelector("#unread-count")).add("d-none");
      });

      if (window.innerWidth <= 575) {
        mClassList(DOM.chatListArea).remove("d-flex").add("d-none");
        mClassList(DOM.messageArea).remove("d-none").add("d-flex");
        areaSwapped = true;
      } else {
        mClassList(elem).add("active");
      }

      DOM.messageAreaName.innerHTML = chat.name;
      // DOM.messageAreaPic.src = chat.isGroup ? chat.group.pic : chat.contact.pic;
      DOM.messageAreaPic.src = "{{ url('/img/default-avatar.png') }}";

      // Message Area details ("last seen ..." for contacts / "..names.." for groups)
      if (chat.isGroup) {
        let groupMembers = groupList.find((group) => group.id === chat.group.id).members;
        let memberNames = contactList
          .filter((contact) => groupMembers.indexOf(contact.id) !== -1)
          .map((contact) => (contact.id === user.id ? "You" : contact.name))
          .join(", ");

        DOM.messageAreaDetails.innerHTML = `${memberNames}`;
      } else {
        DOM.messageAreaDetails.innerHTML = `last seen ${mDate(chat.contact.lastSeen).lastSeenFormat()}`;
      }

      let msgs = chat.isGroup ? MessageUtils.getByGroupId(chat.group.id) : MessageUtils.getByContactId(chat.contact.id);

      DOM.messages.innerHTML = "";

      lastDate = "";
      msgs.sort((a, b) => mDate(a.time).subtract(b.time)).forEach((msg) => addMessageToMessageArea(msg));

      $("body").attr("data-current-chat", chat.contact.id);
    };

    let showChatList = () => {
      if (areaSwapped) {
        mClassList(DOM.chatListArea).remove("d-none").add("d-flex");
        mClassList(DOM.messageArea).remove("d-flex").add("d-none");
        areaSwapped = false;
      }
    };

    let sendMessage = () => {
      let value = DOM.messageInput.value;
      DOM.messageInput.value = "";
      if (value === "") return;

      let msg = {
        sender: user.id,
        body: value,
        time: mDate().toString(),
        status: 1,
        recvId: chat.isGroup ? chat.group.id : chat.contact.id,
        recvIsGroup: chat.isGroup,
      };

      var messageSend = {
        sender: user.name,
        senderId: user.id,
        senderRole: null,
        text: value,
        timestamp: Date.now(),
      };
      firebase
        .database()
        .ref("messages-" + chat.contact.id)
        .push(messageSend)
        .then(function() {
          console.log("Message sent successfully!");

          // Retrieve the recipient's FCM token from the contact object
          var recipientFCMToken = contactList.find((contact) => contact.id === chat.contact.id).token;
          if (recipientFCMToken) {
            // Construct the notification payload
            var payload = {
              priority: "high",
              data: {
                title: "Admin",
                body: value
              },
            };
            messages.push(msg)
            // Send the push notification using the recipient's FCM token
            fetch("https://fcm.googleapis.com/fcm/send", {
                method: "POST",
                headers: {
                  "Content-Type": "application/json",
                  "Authorization": "key=AAAAS-p6eak:APA91bG90nPm9HPFZB4Y0gTkX40MZXtrpWpGslH3uKjUOeCV6hgeoG4Y8mEAQvsSdgqF5DQNncoH6ej_7neznV8LL0kLlLcJnAIRV4yVNnZbVhAqz5lHivZan90ExqhR9hlrJ2m0FcTX"
                },
                body: JSON.stringify({
                  to: recipientFCMToken,
                  ...payload
                })
              })
              .then(function(response) {
                console.log("Push notification sent successfully!");
              })
              .catch(function(error) {
                console.error("Error sending push notification:", error);
              });
          } else {
            console.log("No token for this user");
          }

        })
        .catch(function(error) {
          alert("Error while sending msg.");
          console.error("Error sending message:", error);
        });

      addMessageToMessageArea(msg);
      // MessageUtils.addMessage(msg);
      // generateChatList();
    };

    let showProfileSettings = () => {
      DOM.profileSettings.style.left = 0;
      DOM.profilePic.src = user.pic;
      DOM.inputName.value = user.name;
    };

    let hideProfileSettings = () => {
      DOM.profileSettings.style.left = "-110%";
      DOM.username.innerHTML = user.name;
    };

    window.addEventListener("resize", (e) => {
      if (window.innerWidth > 575) showChatList();
    });

    let init = () => {
      DOM.username.innerHTML = user.name;
      DOM.profilePic.stc = user.pic;
      DOM.profilePic.addEventListener("click", () => DOM.profilePicInput.click());
      DOM.profilePicInput.addEventListener("change", () => console.log(DOM.profilePicInput.files[0]));
      DOM.inputName.addEventListener("blur", (e) => (user.name = e.target.value));
      generateChatList();

      console.log("Click the Image at top-left to open settings.");
    };
  </script>
  <script src="{{ asset('assets/whatsapp/firebase.js') }}"></script>

</body>

</html>
